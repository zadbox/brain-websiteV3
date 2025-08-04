/**
 * =============================================================================
 * DEMO PAGE - BRAIN TECHNOLOGY
 * Mind-Blowing Interactive Experience with Cutting-Edge JavaScript
 * =============================================================================
 */

class DemoExperience {
    constructor() {
        this.isInitialized = false;
        this.canvas = null;
        this.ctx = null;
        this.particles = [];
        this.animationId = null;
        this.isDemoActive = false;
        this.currentTab = 'processing';
        this.workflowStep = 1;
        this.metrics = {
            accuracy: 98.7,
            responseTime: 2.3,
            processed: 1247
        };
        
        this.init();
    }

    init() {
        this.setupCanvas();
        this.setupEventListeners();
        this.setupAnimations();
        this.setupInteractiveElements();
        this.setupPerformanceOptimizations();
        this.isInitialized = true;
        
        console.log('🚀 Demo Experience Initialized - Prepare to be amazed!');
    }

    setupCanvas() {
        this.canvas = document.getElementById('demo-canvas');
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        this.resizeCanvas();
        
        // Create neural network particles
        this.createParticles();
        
        // Start animation loop
        this.animate();
        
        window.addEventListener('resize', () => {
            this.resizeCanvas();
            this.createParticles();
            
            // Recreate analysis chart on resize
            if (this.currentTab === 'analysis') {
                this.createAnalysisChart();
            }
        });
    }

    resizeCanvas() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    createParticles() {
        this.particles = [];
        const particleCount = Math.min(100, Math.floor((window.innerWidth * window.innerHeight) / 10000));
        
        for (let i = 0; i < particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5,
                size: Math.random() * 2 + 1,
                opacity: Math.random() * 0.5 + 0.2,
                color: this.getRandomColor(),
                connections: []
            });
        }
    }

    getRandomColor() {
        const colors = [
            '#6366f1', // Primary indigo
            '#06b6d4', // Accent cyan
            '#8b5cf6', // Primary purple
            '#3b82f6', // Primary blue
            '#7c3aed'  // Accent violet
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        // Update and draw particles
        this.particles.forEach((particle, index) => {
            // Update position
            particle.x += particle.vx;
            particle.y += particle.vy;
            
            // Bounce off edges
            if (particle.x <= 0 || particle.x >= this.canvas.width) particle.vx *= -1;
            if (particle.y <= 0 || particle.y >= this.canvas.height) particle.vy *= -1;
            
            // Draw particle
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color;
            this.ctx.globalAlpha = particle.opacity;
            this.ctx.fill();
            
            // Draw connections
            this.particles.forEach((otherParticle, otherIndex) => {
                if (index !== otherIndex) {
                    const distance = Math.sqrt(
                        Math.pow(particle.x - otherParticle.x, 2) + 
                        Math.pow(particle.y - otherParticle.y, 2)
                    );
                    
                    if (distance < 150) {
                        this.ctx.beginPath();
                        this.ctx.moveTo(particle.x, particle.y);
                        this.ctx.lineTo(otherParticle.x, otherParticle.y);
                        this.ctx.strokeStyle = particle.color;
                        this.ctx.globalAlpha = (150 - distance) / 150 * 0.3;
                        this.ctx.lineWidth = 1;
                        this.ctx.stroke();
                    }
                }
            });
        });
        
        this.ctx.globalAlpha = 1;
        this.animationId = requestAnimationFrame(() => this.animate());
    }

    setupEventListeners() {
        // Start demo button
        const startDemoBtn = document.querySelector('.start-demo-btn');
        if (startDemoBtn) {
            startDemoBtn.addEventListener('click', () => {
                this.startInteractiveDemo();
            });
        }

        // Learn more button
        const learnMoreBtn = document.querySelector('.learn-more-btn');
        if (learnMoreBtn) {
            learnMoreBtn.addEventListener('click', () => {
                this.scrollToSection('interactive-demo');
            });
        }

        // Tab switching
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.switchTab(e.target.dataset.tab);
            });
        });

        // Control panel interactions
        this.setupControlPanel();
        
        // Scroll animations
        this.setupScrollAnimations();
        
        // Counter animations
        this.setupCounterAnimations();
    }

    setupControlPanel() {
        // Speed slider
        const speedSlider = document.getElementById('speed-slider');
        const speedValue = document.querySelector('.slider-value');
        
        if (speedSlider && speedValue) {
            speedSlider.addEventListener('input', (e) => {
                const value = e.target.value;
                speedValue.textContent = `${value}x`;
                this.updateProcessingSpeed(parseInt(value));
            });
        }

        // AI toggle
        const aiToggle = document.getElementById('ai-toggle');
        if (aiToggle) {
            aiToggle.addEventListener('change', (e) => {
                this.toggleAI(e.target.checked);
            });
        }

        // Data stream buttons
        const streamBtns = document.querySelectorAll('[data-stream]');
        streamBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.switchDataStream(e.target.dataset.stream);
            });
        });

        // Reset button
        const resetBtn = document.getElementById('reset-btn');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                this.resetDemo();
            });
        }

        // Fullscreen button
        const fullscreenBtn = document.getElementById('fullscreen-btn');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', () => {
                this.toggleFullscreen();
            });
        }
    }

    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        const animateElements = document.querySelectorAll('.feature-card, .data-node, .metric-card, .workflow-step');
        animateElements.forEach(el => {
            observer.observe(el);
        });
    }

    setupCounterAnimations() {
        const counters = document.querySelectorAll('.stat-number');
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    animateCounter(element) {
        const target = parseInt(element.dataset.target);
        const duration = 2000;
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);
    }

    setupAnimations() {
        // Floating particles animation
        this.animateFloatingParticles();
        
        // AI brain animation
        this.animateAIBrain();
        
        // Data flow animation
        this.animateDataFlow();
        
        // Workflow progression
        this.animateWorkflow();
    }

    animateFloatingParticles() {
        const particles = document.querySelectorAll('.floating-particles .particle');
        particles.forEach((particle, index) => {
            const speed = parseFloat(particle.dataset.speed);
            const delay = index * 0.5;
            
            particle.style.animationDelay = `${delay}s`;
            particle.style.animationDuration = `${20 / speed}s`;
        });
    }

    animateAIBrain() {
        // The logo animations are handled by CSS animations
        // No additional JavaScript needed for the new logo-based design
        console.log('🎨 BRAIN Technology Logo Animation Active!');
    }

    animateDataFlow() {
        const flowParticles = document.querySelectorAll('.flow-particle');
        flowParticles.forEach((particle, index) => {
            particle.style.animationDelay = `${index * 1.5}s`;
        });
    }

    animateWorkflow() {
        setInterval(() => {
            this.progressWorkflow();
        }, 3000);
    }

    setupInteractiveElements() {
        // Hover effects for cards
        this.setupHoverEffects();
        
        // Button ripple effects
        this.setupRippleEffects();
        
        // Smooth scrolling
        this.setupSmoothScrolling();
    }

    setupHoverEffects() {
        const cards = document.querySelectorAll('.feature-card, .data-node, .metric-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                this.createHoverEffect(card);
            });
            
            card.addEventListener('mouseleave', () => {
                this.removeHoverEffect(card);
            });
        });
    }

    createHoverEffect(element) {
        const glow = document.createElement('div');
        glow.className = 'hover-glow';
        glow.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
            border-radius: inherit;
            pointer-events: none;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;
        
        element.appendChild(glow);
        
        setTimeout(() => {
            glow.style.opacity = '1';
        }, 10);
    }

    removeHoverEffect(element) {
        const glow = element.querySelector('.hover-glow');
        if (glow) {
            glow.style.opacity = '0';
            setTimeout(() => {
                glow.remove();
            }, 300);
        }
    }

    setupRippleEffects() {
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .control-btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.createRipple(e, button);
            });
        });
    }

    createRipple(event, element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    setupSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    setupPerformanceOptimizations() {
        // Throttle scroll events
        let ticking = false;
        
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    this.handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        // Preload critical resources
        this.preloadResources();
        
        // Optimize animations for performance
        this.optimizeAnimations();
    }

    handleScroll() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-particles .particle');
        
        parallaxElements.forEach((element, index) => {
            const speed = parseFloat(element.dataset.speed);
            const yPos = -(scrolled * speed * 0.1);
            element.style.transform = `translateY(${yPos}px)`;
        });
    }

    preloadResources() {
        const criticalImages = [
            // Add any critical images here
        ];
        
        criticalImages.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    }

    optimizeAnimations() {
        // Use transform instead of top/left for better performance
        const animatedElements = document.querySelectorAll('.particle, .neuron, .data-particle');
        
        animatedElements.forEach(element => {
            element.style.willChange = 'transform';
        });
    }

    // Interactive Demo Methods
    startInteractiveDemo() {
        this.isDemoActive = true;
        this.scrollToSection('interactive-demo');
        
        // Add active class to demo interface
        const demoInterface = document.querySelector('.demo-interface');
        if (demoInterface) {
            demoInterface.classList.add('demo-active');
        }
        
        // Start processing simulation
        this.startProcessingSimulation();
        
        console.log('🎯 Interactive Demo Started!');
    }

    switchTab(tabName) {
        // Remove active class from all tabs and content
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        // Add active class to selected tab and content
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        document.getElementById(`${tabName}-tab`).classList.add('active');
        
        this.currentTab = tabName;
        
        // Trigger tab-specific animations
        this.animateTabContent(tabName);
        
        // Initialize chart if analysis tab
        if (tabName === 'analysis') {
            setTimeout(() => {
                this.createAnalysisChart();
            }, 100);
        }
    }

    animateTabContent(tabName) {
        switch(tabName) {
            case 'processing':
                this.animateProcessingTab();
                break;
            case 'analysis':
                this.animateAnalysisTab();
                break;
            case 'automation':
                this.animateAutomationTab();
                break;
        }
    }

    animateProcessingTab() {
        const nodes = document.querySelectorAll('.data-node');
        nodes.forEach((node, index) => {
            setTimeout(() => {
                node.classList.add('processing-active');
            }, index * 500);
        });
    }

    animateAnalysisTab() {
        const metrics = document.querySelectorAll('.metric-value');
        metrics.forEach((metric, index) => {
            setTimeout(() => {
                this.animateMetric(metric);
            }, index * 300);
        });
        
        // Create and animate the analysis chart
        this.createAnalysisChart();
    }

    animateAutomationTab() {
        this.progressWorkflow();
    }

    animateMetric(element) {
        element.style.transform = 'scale(1.1)';
        element.style.color = '#10b981';
        
        setTimeout(() => {
            element.style.transform = 'scale(1)';
            element.style.color = '#ffffff';
        }, 300);
    }

    updateProcessingSpeed(speed) {
        // Update animation speeds based on slider value
        const flowParticles = document.querySelectorAll('.flow-particle');
        const duration = 6 - (speed * 0.5); // Faster speed = shorter duration
        
        flowParticles.forEach(particle => {
            particle.style.animationDuration = `${duration}s`;
        });
    }

    toggleAI(enabled) {
        const statusIndicator = document.querySelector('.status-indicator');
        const statusDot = document.querySelector('.status-dot');
        const statusText = statusIndicator.querySelector('span');
        
        if (enabled) {
            statusDot.style.background = '#10b981';
            statusText.textContent = 'Active';
            statusText.style.color = '#10b981';
        } else {
            statusDot.style.background = '#ef4444';
            statusText.textContent = 'Inactive';
            statusText.style.color = '#ef4444';
        }
    }

    switchDataStream(streamType) {
        // Remove active class from all stream buttons
        document.querySelectorAll('[data-stream]').forEach(btn => btn.classList.remove('active'));
        
        // Add active class to selected button
        document.querySelector(`[data-stream="${streamType}"]`).classList.add('active');
        
        // Update node labels based on stream type
        this.updateNodeLabels(streamType);
    }

    updateNodeLabels(streamType) {
        const nodeLabels = document.querySelectorAll('.node-label');
        const nodeStatuses = document.querySelectorAll('.node-status');
        
        const labels = {
            emails: ['Email Input', 'Email Processing', 'Email Output'],
            documents: ['Document Input', 'Document Processing', 'Document Output'],
            analytics: ['Data Input', 'Analytics Processing', 'Analytics Output']
        };
        
        const statuses = {
            emails: ['Receiving emails...', 'Analyzing content...', 'Email processed'],
            documents: ['Scanning documents...', 'Extracting data...', 'Document processed'],
            analytics: ['Collecting data...', 'Running analytics...', 'Analytics complete']
        };
        
        nodeLabels.forEach((label, index) => {
            label.textContent = labels[streamType][index];
        });
        
        nodeStatuses.forEach((status, index) => {
            status.textContent = statuses[streamType][index];
        });
    }

    progressWorkflow() {
        const steps = document.querySelectorAll('.workflow-step');
        
        steps.forEach((step, index) => {
            step.classList.remove('active');
        });
        
        if (this.workflowStep <= steps.length) {
            steps[this.workflowStep - 1].classList.add('active');
            this.workflowStep = this.workflowStep >= steps.length ? 1 : this.workflowStep + 1;
        }
    }

    startProcessingSimulation() {
        // Simulate real-time processing
        setInterval(() => {
            this.updateMetrics();
        }, 2000);
    }

    updateMetrics() {
        // Update accuracy with small random variations
        this.metrics.accuracy = Math.max(95, Math.min(100, this.metrics.accuracy + (Math.random() - 0.5) * 2));
        
        // Update response time
        this.metrics.responseTime = Math.max(1, Math.min(5, this.metrics.responseTime + (Math.random() - 0.5) * 0.5));
        
        // Increment processed count
        this.metrics.processed += Math.floor(Math.random() * 10) + 1;
        
        // Update display
        this.updateMetricsDisplay();
    }

    updateMetricsDisplay() {
        const accuracyEl = document.querySelector('.metric-card:nth-child(1) .metric-value');
        const responseTimeEl = document.querySelector('.metric-card:nth-child(2) .metric-value');
        const processedEl = document.querySelector('.metric-card:nth-child(3) .metric-value');
        
        if (accuracyEl) accuracyEl.textContent = `${this.metrics.accuracy.toFixed(1)}%`;
        if (responseTimeEl) responseTimeEl.textContent = `${this.metrics.responseTime.toFixed(1)}s`;
        if (processedEl) processedEl.textContent = this.metrics.processed.toLocaleString();
    }

    resetDemo() {
        // Reset all states
        this.workflowStep = 1;
        this.metrics = {
            accuracy: 98.7,
            responseTime: 2.3,
            processed: 1247
        };
        
        // Reset UI
        document.querySelectorAll('.workflow-step').forEach(step => step.classList.remove('active'));
        document.querySelectorAll('.data-node').forEach(node => node.classList.remove('processing-active'));
        
        // Reset to first tab
        this.switchTab('processing');
        
        // Update metrics display
        this.updateMetricsDisplay();
        
        console.log('🔄 Demo Reset!');
    }

    toggleFullscreen() {
        const demoInterface = document.querySelector('.demo-interface');
        
        if (!document.fullscreenElement) {
            demoInterface.requestFullscreen().catch(err => {
                console.log('Fullscreen request failed:', err);
            });
        } else {
            document.exitFullscreen();
        }
    }

    scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Utility Methods
    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Analysis Chart Methods
    createAnalysisChart() {
        const canvas = document.getElementById('analysis-chart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        
        // Set canvas size
        const container = canvas.parentElement;
        canvas.width = container.clientWidth;
        canvas.height = container.clientHeight;
        
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Create animated chart
        this.drawAnimatedChart(ctx, canvas.width, canvas.height);
    }

    drawAnimatedChart(ctx, width, height) {
        const data = [
            { label: 'Accuracy', value: 98.7, color: '#10b981' },
            { label: 'Speed', value: 95.2, color: '#3b82f6' },
            { label: 'Efficiency', value: 92.8, color: '#8b5cf6' },
            { label: 'Reliability', value: 99.1, color: '#06b6d4' },
            { label: 'Scalability', value: 89.5, color: '#f59e0b' }
        ];

        const centerX = width / 2;
        const centerY = height / 2;
        const radius = Math.min(width, height) * 0.3;
        
        // Draw radar chart
        this.drawRadarChart(ctx, centerX, centerY, radius, data);
        
        // Animate the chart
        this.animateChart(ctx, centerX, centerY, radius, data);
    }

    drawRadarChart(ctx, centerX, centerY, radius, data) {
        const segments = data.length;
        const angleStep = (Math.PI * 2) / segments;
        
        // Draw grid lines
        ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
        ctx.lineWidth = 1;
        
        for (let i = 0; i < 5; i++) {
            const currentRadius = (radius * (i + 1)) / 5;
            ctx.beginPath();
            for (let j = 0; j < segments; j++) {
                const angle = j * angleStep - Math.PI / 2;
                const x = centerX + Math.cos(angle) * currentRadius;
                const y = centerY + Math.sin(angle) * currentRadius;
                
                if (j === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            }
            ctx.closePath();
            ctx.stroke();
        }
        
        // Draw axis lines
        ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
        ctx.lineWidth = 2;
        
        for (let i = 0; i < segments; i++) {
            const angle = i * angleStep - Math.PI / 2;
            const x = centerX + Math.cos(angle) * radius;
            const y = centerY + Math.sin(angle) * radius;
            
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.lineTo(x, y);
            ctx.stroke();
        }
    }

    animateChart(ctx, centerX, centerY, radius, data) {
        const segments = data.length;
        const angleStep = (Math.PI * 2) / segments;
        
        // Animate data points
        data.forEach((item, index) => {
            const angle = index * angleStep - Math.PI / 2;
            const valueRadius = (radius * item.value) / 100;
            const x = centerX + Math.cos(angle) * valueRadius;
            const y = centerY + Math.sin(angle) * valueRadius;
            
            // Draw data point
            ctx.beginPath();
            ctx.arc(x, y, 6, 0, Math.PI * 2);
            ctx.fillStyle = item.color;
            ctx.fill();
            
            // Draw glow effect
            ctx.beginPath();
            ctx.arc(x, y, 12, 0, Math.PI * 2);
            ctx.fillStyle = item.color;
            ctx.globalAlpha = 0.3;
            ctx.fill();
            ctx.globalAlpha = 1;
            
            // Draw label
            ctx.fillStyle = '#ffffff';
            ctx.font = '12px Inter';
            ctx.textAlign = 'center';
            const labelX = centerX + Math.cos(angle) * (radius + 30);
            const labelY = centerY + Math.sin(angle) * (radius + 30);
            ctx.fillText(item.label, labelX, labelY);
        });
        
        // Draw connecting lines
        ctx.strokeStyle = '#6366f1';
        ctx.lineWidth = 3;
        ctx.globalAlpha = 0.8;
        ctx.beginPath();
        
        data.forEach((item, index) => {
            const angle = index * angleStep - Math.PI / 2;
            const valueRadius = (radius * item.value) / 100;
            const x = centerX + Math.cos(angle) * valueRadius;
            const y = centerY + Math.sin(angle) * valueRadius;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.closePath();
        ctx.stroke();
        ctx.globalAlpha = 1;
    }

    // Logo Animation Methods
    startAIBrainAnimation() {
        // Logo animations are handled by CSS
        console.log('🎨 BRAIN Technology Logo Animation Started!');
    }
}

// Initialize the demo experience when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .demo-active {
            animation: demoActivate 0.5s ease forwards;
        }
        
        @keyframes demoActivate {
            from {
                transform: scale(0.95);
                opacity: 0.8;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .processing-active {
            animation: processingPulse 1s ease infinite;
        }
        
        @keyframes processingPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
            }
        }
    `;
    document.head.appendChild(style);
    
    // Initialize the demo experience
    window.demoExperience = new DemoExperience();
});

// Export for potential external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DemoExperience;
} 