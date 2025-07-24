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
            pulseSpeed: 0.002
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
        });
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        // Update and draw nodes
        this.nodes.forEach(node => {
            node.update();
            node.draw(this.ctx);
        });
        
        // Draw connections
        this.drawConnections();
        
        requestAnimationFrame(() => this.animate());
    }
    
    drawConnections() {
        for (let i = 0; i < this.nodes.length; i++) {
            for (let j = i + 1; j < this.nodes.length; j++) {
                const distance = this.getDistance(this.nodes[i], this.nodes[j]);
                
                if (distance < this.config.connectionDistance) {
                    const opacity = this.config.connectionOpacity * (1 - distance / this.config.connectionDistance);
                    
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
        this.x += this.vx;
        this.y += this.vy;
        
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
