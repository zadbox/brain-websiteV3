/**
 * =============================================================================
 * BRAIN AI - WORLD-CLASS HOMEPAGE JAVASCRIPT
 * Professional AI & Technology Solutions Interface
 * =============================================================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // =============================================================================
    // PERFORMANCE & ANIMATION INITIALIZATION
    // =============================================================================
    
    const config = {
        animationDuration: 300,
        neuralNetwork: {
            nodeCount: Math.floor((window.innerWidth * window.innerHeight) / 8000) + 40,
            connectionDistance: 200,
            speed: 0.6,
            colors: [
                { r: 59, g: 130, b: 246 },   // Blue
                { r: 99, g: 102, b: 241 },   // Indigo  
                { r: 139, g: 92, b: 246 },   // Purple
                { r: 0, g: 186, b: 255 },    // Bright Blue
                { r: 124, g: 58, b: 237 }    // Deep Purple
            ]
        }
    };

    // Performance optimization based on device capabilities
    const isLowPowerDevice = () => {
        return window.navigator.hardwareConcurrency <= 4 || 
               window.innerWidth < 768 ||
               window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    };

    if (isLowPowerDevice()) {
        config.neuralNetwork.nodeCount = Math.min(config.neuralNetwork.nodeCount, 8);
        config.neuralNetwork.speed = 0.1;
        config.animationDuration = 150;
    }

    // =============================================================================
    // NEURAL NETWORK BACKGROUND
    // =============================================================================
    
    function initNeuralNetwork() {
        const canvas = document.getElementById('neural-canvas');
        if (!canvas) {
            console.warn('Neural canvas not found');
            return;
        }

        console.log('Initializing neural network...');
        const ctx = canvas.getContext('2d');
        let width = window.innerWidth;
        let height = window.innerHeight;
        
        canvas.width = width;
        canvas.height = height;
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';

        const nodes = [];
        
        // Initialize nodes
        console.log(`Creating ${config.neuralNetwork.nodeCount} neural nodes...`);
        for (let i = 0; i < config.neuralNetwork.nodeCount; i++) {
            const colorIndex = Math.floor(Math.random() * config.neuralNetwork.colors.length);
            nodes.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * config.neuralNetwork.speed,
                vy: (Math.random() - 0.5) * config.neuralNetwork.speed,
                r: 1 + Math.random() * 2,
                color: config.neuralNetwork.colors[colorIndex],
                pulse: Math.random() * Math.PI * 2
            });
        }

        let animationId;
        
        function animate() {
            ctx.clearRect(0, 0, width, height);
            
            // Update and draw nodes
            nodes.forEach((node, i) => {
                // Move nodes
                node.x += node.vx;
                node.y += node.vy;
                
                // Bounce off edges
                if (node.x < 0 || node.x > width) node.vx *= -1;
                if (node.y < 0 || node.y > height) node.vy *= -1;
                
                // Draw connections to nearby nodes
                for (let j = i + 1; j < nodes.length; j++) {
                    const other = nodes[j];
                    const dx = node.x - other.x;
                    const dy = node.y - other.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < config.neuralNetwork.connectionDistance) {
                        const alpha = 0.6 * (1 - distance / config.neuralNetwork.connectionDistance);
                        
                        ctx.save();
                        ctx.globalAlpha = alpha;
                        ctx.strokeStyle = `rgba(${node.color.r}, ${node.color.g}, ${node.color.b}, 1)`;
                        ctx.lineWidth = 2;
                        ctx.beginPath();
                        ctx.moveTo(node.x, node.y);
                        ctx.lineTo(other.x, other.y);
                        ctx.stroke();
                        ctx.restore();
                    }
                }
                
                // Draw node with enhanced visibility
                node.pulse += 0.02;
                const pulseSize = node.r * (1 + Math.sin(node.pulse) * 0.4);
                const pulseAlpha = 0.9 + Math.sin(node.pulse) * 0.1;
                
                ctx.save();
                ctx.globalAlpha = pulseAlpha;
                ctx.fillStyle = `rgba(${node.color.r}, ${node.color.g}, ${node.color.b}, 1)`;
                ctx.shadowColor = `rgba(${node.color.r}, ${node.color.g}, ${node.color.b}, 1)`;
                ctx.shadowBlur = 15;
                ctx.beginPath();
                ctx.arc(node.x, node.y, pulseSize, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            });
            
            animationId = requestAnimationFrame(animate);
        }
        
        animate();
        
        // Handle resize
        function handleResize() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
        }
        
        window.addEventListener('resize', throttle(handleResize, 250));
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (animationId) {
                cancelAnimationFrame(animationId);
            }
        });
    }

    // =============================================================================
    // CHART.JS DASHBOARD INITIALIZATION
    // =============================================================================
    
    function initHeroDashboard() {
        const canvas = document.getElementById('hero-chart');
        if (!canvas || typeof Chart === 'undefined') return;

        const ctx = canvas.getContext('2d');
        
        // Neural data generation
        const generateNeuralData = () => {
            const data = [];
            const baseValue = 75;
            for (let i = 0; i < 12; i++) {
                const variance = Math.sin(i * 0.8) * 15 + Math.random() * 8;
                data.push(Math.max(20, Math.min(100, baseValue + variance)));
            }
            return data;
        };

        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradient.addColorStop(0.5, 'rgba(99, 102, 241, 0.2)');
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0.1)');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({length: 12}, (_, i) => `T${i + 1}`),
                datasets: [{
                    label: 'AI Performance',
                    data: generateNeuralData(),
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: '#ffffff',
                    pointHoverBorderColor: '#3b82f6',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: {
                    x: {
                        display: false,
                        grid: { display: false }
                    },
                    y: {
                        display: false,
                        grid: { display: false },
                        min: 0,
                        max: 100
                    }
                },
                elements: {
                    point: { radius: 0 }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Update chart data periodically
        setInterval(() => {
            chart.data.datasets[0].data = generateNeuralData();
            chart.update('none');
        }, 4000);
    }

    // =============================================================================
    // COUNTER ANIMATIONS
    // =============================================================================
    
    function initCounterAnimations() {
        const counters = document.querySelectorAll('.stat-number[data-target]');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseFloat(counter.getAttribute('data-target'));
                    animateCounter(counter, target);
                    observer.unobserve(counter);
                }
            });
        }, { 
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        });

        counters.forEach(counter => observer.observe(counter));
    }

    function animateCounter(element, targetValue) {
        const duration = 2000;
        const startTime = performance.now();
        const startValue = 0;
        const isPercentage = element.textContent.includes('%');
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Smooth easing function
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const currentValue = startValue + (targetValue - startValue) * easeOutQuart;
            
            if (isPercentage) {
                element.textContent = currentValue.toFixed(1) + '%';
            } else {
                element.textContent = Math.floor(currentValue);
            }

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            }
        }

        requestAnimationFrame(updateCounter);
    }

    // =============================================================================
    // SCROLL REVEAL ANIMATIONS
    // =============================================================================
    
    function initScrollReveal() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Apply to cards and sections
        const revealElements = document.querySelectorAll(
            '.feature-card, .solution-card, .testimonial-card, .section-header'
        );
        
        revealElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(element);
        });
    }

    // =============================================================================
    // INTERACTIVE ENHANCEMENTS
    // =============================================================================
    
    function initInteractiveElements() {
        // Enhanced button interactions
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Ripple effect
                const ripple = document.createElement('div');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Card hover enhancements
        const cards = document.querySelectorAll('.feature-card, .solution-card, .testimonial-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // =============================================================================
    // PERFORMANCE MONITORING
    // =============================================================================
    
    function initPerformanceMonitoring() {
        // Monitor frame rate
        let frameCount = 0;
        let lastTime = performance.now();
        
        function measureFPS() {
            frameCount++;
            const currentTime = performance.now();
            
            if (currentTime - lastTime >= 1000) {
                const fps = Math.round((frameCount * 1000) / (currentTime - lastTime));
                
                // Adjust neural network complexity based on performance
                if (fps < 30 && config.neuralNetwork.nodeCount > 8) {
                    config.neuralNetwork.nodeCount = Math.max(8, config.neuralNetwork.nodeCount - 2);
                    config.neuralNetwork.speed *= 0.8;
                }
                
                frameCount = 0;
                lastTime = currentTime;
            }
            
            requestAnimationFrame(measureFPS);
        }
        
        if (!isLowPowerDevice()) {
            requestAnimationFrame(measureFPS);
        }
    }

    // =============================================================================
    // ACCESSIBILITY ENHANCEMENTS
    // =============================================================================
    
    function initAccessibility() {
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });

        // Reduced motion preference
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.style.setProperty('--duration-fast', '0.01ms');
            document.documentElement.style.setProperty('--duration-normal', '0.01ms');
            document.documentElement.style.setProperty('--duration-slow', '0.01ms');
        }

        // High contrast mode
        if (window.matchMedia('(prefers-contrast: high)').matches) {
            document.documentElement.style.setProperty('--neutral-300', '#ffffff');
            document.documentElement.style.setProperty('--glass-border', 'rgba(255, 255, 255, 0.5)');
        }
    }

    // =============================================================================
    // UTILITY FUNCTIONS
    // =============================================================================
    
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // =============================================================================
    // INITIALIZATION SEQUENCE
    // =============================================================================
    
    // Initialize all components
    try {
        initNeuralNetwork();
        initHeroDashboard();
        initCounterAnimations();
        initScrollReveal();
        initInteractiveElements();
        initPerformanceMonitoring();
        initAccessibility();
        
        console.log('🧠 BRAIN AI Homepage - Initialized successfully');
        
        // Dispatch custom event
        document.dispatchEvent(new CustomEvent('brainHomepageReady', {
            detail: {
                timestamp: new Date().toISOString(),
                version: '2.0.0',
                features: [
                    'neural-network',
                    'dashboard-charts',
                    'counter-animations',
                    'scroll-reveal',
                    'interactive-elements',
                    'performance-monitoring',
                    'accessibility'
                ]
            }
        }));
        
    } catch (error) {
        console.error('Error initializing BRAIN Homepage:', error);
    }

    // =============================================================================
    // CLEANUP AND ERROR HANDLING
    // =============================================================================
    
    window.addEventListener('beforeunload', function() {
        // Clean up any running animations or intervals
        const canvas = document.getElementById('neural-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    });

    // Global error handler
    window.addEventListener('error', function(e) {
        console.error('BRAIN Homepage Error:', e.error);
    });

    // Handle orientation change
    window.addEventListener('orientationchange', debounce(() => {
        location.reload();
    }, 500));

});

// =============================================================================
// CSS ANIMATION DEFINITIONS (dynamically injected)
// =============================================================================

// Inject ripple animation
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    @keyframes ripple {
        from {
            transform: scale(0);
            opacity: 1;
        }
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    .keyboard-navigation *:focus {
        outline: 2px solid var(--primary-blue) !important;
        outline-offset: 2px !important;
    }
`;
document.head.appendChild(rippleStyle);

// =============================================================================
// GLOBAL UTILITIES
// =============================================================================

// Make utilities available globally
window.BrainAI = {
    version: '2.0.0',
    
    // Scroll to element utility
    scrollTo: function(selector, offset = 0) {
        const element = document.querySelector(selector);
        if (element) {
            const elementPosition = element.offsetTop - offset;
            window.scrollTo({
                top: elementPosition,
                behavior: 'smooth'
            });
        }
    },
    
    // Show notification utility
    showNotification: function(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            z-index: 9999;
            max-width: 300px;
            animation: slideIn 0.3s ease-out;
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        `;
        
        // Set colors based on type
        const colors = {
            info: 'rgba(59, 130, 246, 0.9)',
            success: 'rgba(16, 185, 129, 0.9)',
            warning: 'rgba(245, 158, 11, 0.9)',
            error: 'rgba(239, 68, 68, 0.9)'
        };
        
        notification.style.background = colors[type] || colors.info;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out reverse';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, duration);
    }
};

// Slide animations for notifications
const notificationStyle = document.createElement('style');
notificationStyle.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(notificationStyle);