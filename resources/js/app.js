// Neural Network Background Animation
class NeuralNetwork {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        
        this.ctx = this.canvas.getContext('2d');
        this.nodes = [];
        this.mouse = { x: 0, y: 0 };
        
        this.config = {
            nodeCount: window.innerWidth < 768 ? 25 : 40,
            connectionDistance: 120,
            nodeSpeed: 0.3,
            nodeSize: 2,
            connectionOpacity: 0.15,
            nodeColor: 'rgba(99, 102, 241, 0.8)',
            connectionColor: 'rgba(99, 102, 241, 0.3)',
            pulseSpeed: 0.002,
            // Interactive repulsion ("void") config
            repulsionRadius: 160,
            repulsionStrength: 0.9,
            // Magnetic mode (attraction toward cursor)
            magneticMode: true,
            magnetStrength: 0.6,
            swirlStrength: 0.08,
            maxSpeed: 1.2,
            friction: 0.995,
            // runtime state (updated on hover/move)
            mouseActive: false,
            mouseX: 0,
            mouseY: 0,
            currentRepulsionRadius: 0,
            holeEffect: false // do not create visible void for now
        };
        
        this.init();
    }
    
    init() {
        this.resizeCanvas();
        this.createNodes();
        this.bindEvents();
        
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.animate();
        }
    }
    
    resizeCanvas() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }
    
    createNodes() {
        this.nodes = [];
        for (let i = 0; i < this.config.nodeCount; i++) {
            this.nodes.push(new Node(this.canvas, this.config));
        }
    }
    
    bindEvents() {
        window.addEventListener('resize', () => {
            this.resizeCanvas();
            this.createNodes();
        });
        
        document.addEventListener('mousemove', (e) => {
            this.mouse.x = e.clientX;
            this.mouse.y = e.clientY;
            // expose to nodes via config for simpler access
            this.config.mouseX = e.clientX;
            this.config.mouseY = e.clientY;
        });

        // Enable/disable repulsion when hovering canvas
        if (this.canvas) {
            this.canvas.addEventListener('mouseenter', () => {
                this.config.mouseActive = true;
                this.config.repulsionTarget = this.config.repulsionRadius;
            });
            this.canvas.addEventListener('mouseleave', () => {
                this.config.mouseActive = false;
                this.config.repulsionTarget = 0;
            });
        }
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        // Smoothly animate the repulsion radius toward target
        const target = this.config.repulsionTarget ?? 0;
        this.config.currentRepulsionRadius = this.lerp(
            this.config.currentRepulsionRadius,
            target,
            0.1
        );
        
        // Update and draw nodes
        this.nodes.forEach(node => {
            node.update();
            node.draw(this.ctx);
        });
        
        // Draw connections
        this.drawConnections();
        
        requestAnimationFrame(() => this.animate());
    }

    // simple linear interpolation helper
    lerp(a, b, t) { return a + (b - a) * t; }
    
    drawConnections() {
        for (let i = 0; i < this.nodes.length; i++) {
            for (let j = i + 1; j < this.nodes.length; j++) {
                const distance = this.getDistance(this.nodes[i], this.nodes[j]);
                
                if (distance < this.config.connectionDistance) {
                    const opacity = this.config.connectionOpacity * (1 - distance / this.config.connectionDistance);
                    
                    // Optional: skip connections inside the "hole" (disabled by default)
                    if (this.config.holeEffect && this.config.currentRepulsionRadius > 1) {
                        const mx = this.config.mouseX;
                        const my = this.config.mouseY;
                        // use the midpoint as a heuristic for proximity to the hole
                        const midX = (this.nodes[i].x + this.nodes[j].x) / 2;
                        const midY = (this.nodes[i].y + this.nodes[j].y) / 2;
                        const mdx = midX - mx;
                        const mdy = midY - my;
                        const md = Math.sqrt(mdx * mdx + mdy * mdy);
                        if (md < this.config.currentRepulsionRadius * 0.95) {
                            continue; // skip drawing this connection inside the hole
                        }
                    }

                    // Draw connection line
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.nodes[i].x, this.nodes[i].y);
                    this.ctx.lineTo(this.nodes[j].x, this.nodes[j].y);
                    this.ctx.strokeStyle = `rgba(99, 102, 241, ${opacity})`;
                    this.ctx.lineWidth = 0.5;
                    this.ctx.stroke();
                    
                    // Animated pulse along connection
                    const pulsePosition = (Date.now() * 0.001) % 1;
                    const pulseX = this.nodes[i].x + (this.nodes[j].x - this.nodes[i].x) * pulsePosition;
                    const pulseY = this.nodes[i].y + (this.nodes[j].y - this.nodes[i].y) * pulsePosition;
                    
                    this.ctx.beginPath();
                    this.ctx.arc(pulseX, pulseY, 1, 0, Math.PI * 2);
                    this.ctx.fillStyle = `rgba(99, 102, 241, ${opacity * 2})`;
                    this.ctx.fill();
                }
            }
        }
    }
    
    getDistance(node1, node2) {
        const dx = node1.x - node2.x;
        const dy = node1.y - node2.y;
        return Math.sqrt(dx * dx + dy * dy);
    }
}

class Node {
    constructor(canvas, config) {
        this.canvas = canvas;
        this.config = config;
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.vx = (Math.random() - 0.5) * config.nodeSpeed;
        this.vy = (Math.random() - 0.5) * config.nodeSpeed;
        this.size = config.nodeSize + Math.random() * 2;
        this.pulse = Math.random() * Math.PI * 2;
    }
    
    update() {
        // Apply cursor-driven interaction
        const r = this.config.currentRepulsionRadius;
        if (r > 0.5) {
            const dx = this.x - this.config.mouseX;
            const dy = this.y - this.config.mouseY;
            const dist = Math.sqrt(dx * dx + dy * dy) || 0.0001;
            if (dist < r) {
                // normalize
                const nx = dx / dist; // points outward from mouse
                const ny = dy / dist;
                if (this.config.magneticMode) {
                    // Attraction toward cursor (magnetic), with subtle swirl
                    const attract = (1 - dist / r) * this.config.magnetStrength;
                    // toward mouse => subtract outward normal
                    this.vx -= nx * attract;
                    this.vy -= ny * attract;
                    // tangential component for a gentle orbiting effect
                    const tx = -ny;
                    const ty = nx;
                    this.vx += tx * this.config.swirlStrength * attract;
                    this.vy += ty * this.config.swirlStrength * attract;
                } else {
                    // Repulsion (previous behavior)
                    const force = (1 - dist / r) * this.config.repulsionStrength; // stronger near center
                    this.vx += nx * force;
                    this.vy += ny * force;
                }
            }
        }

        this.x += this.vx;
        this.y += this.vy;
        
        // Friction and speed cap for stability
        this.vx *= this.config.friction;
        this.vy *= this.config.friction;
        const speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
        if (speed > this.config.maxSpeed) {
            const scale = this.config.maxSpeed / speed;
            this.vx *= scale;
            this.vy *= scale;
        }

        // Bounce off edges
        if (this.x < 0 || this.x > this.canvas.width) this.vx = -this.vx;
        if (this.y < 0 || this.y > this.canvas.height) this.vy = -this.vy;
        
        // Update pulse
        this.pulse += this.config.pulseSpeed;
    }
    
    draw(ctx) {
        // Main node
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = this.config.nodeColor;
        ctx.fill();
        
        // Pulsing effect
        const pulseIntensity = Math.sin(this.pulse) * 0.5 + 0.5;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size + pulseIntensity, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(99, 102, 241, ${0.1 * pulseIntensity})`;
        ctx.fill();
    }
}

// Intersection Observer for animations
class AnimationObserver {
    constructor() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
        );
        
        this.init();
    }
    
    init() {
        document.querySelectorAll('.animate-item').forEach(item => {
            this.observer.observe(item);
        });
    }
}

// Counter Animation
class CounterAnimation {
    constructor() {
        this.counters = document.querySelectorAll('.counter');
        this.speed = 200;
        this.init();
    }
    
    init() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                }
            });
        }, { threshold: 1.0 });
        
        this.counters.forEach(counter => {
            observer.observe(counter);
        });
    }
    
    animateCounter(counter) {
        const target = +counter.getAttribute('data-target');
        const increment = target / this.speed;
        let current = 0;
        
        const updateCount = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCount, 10);
            } else {
                counter.textContent = target;
            }
        };
        
        counter.textContent = '0';
        updateCount();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize neural network background
    new NeuralNetwork('neural-network-canvas');
    
    // Initialize animations
    new AnimationObserver();
    new CounterAnimation();
    
    // Tab functionality
    initializeTabs();
});

// Tab Functionality
function initializeTabs() {
    const tabButtons = document.querySelectorAll('[data-bs-target]');
    const tabPanels = document.querySelectorAll('.tab-panel');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-bs-target').replace('#', '');
            
            // Remove active classes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanels.forEach(panel => {
                panel.classList.remove('active', 'show');
            });
            
            // Add active classes
            button.classList.add('active');
            document.getElementById(targetId)?.classList.add('active', 'show');
        });
    });
}

export { NeuralNetwork, AnimationObserver, CounterAnimation };
