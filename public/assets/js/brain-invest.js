/**
 * Brain Invest - Professional Interactive JavaScript Features
 */

class BrainInvestApp {
    constructor() {
        this.charts = {};
        this.counters = {};
        this.isDemoActive = false;
        this.init();
    }

    init() {
        this.setupScrollAnimations();
        this.setupCounters();
        this.setupCharts();
        this.setupDemoInterface();
        this.setupInteractiveElements();
        this.startRealTimeUpdates();
        this.setupPerformanceOptimizations();
    }

    // Scroll Animations with Performance Optimization
    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = parseInt(entry.target.dataset.delay) || 0;
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) translateX(0)';
                    }, delay);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe animated elements
        document.querySelectorAll('.animate-fade-up, .animate-slide-up, .animate-slide-left, .animate-slide-right').forEach(el => {
            observer.observe(el);
        });
    }

    // Enhanced Animated Counters
    setupCounters() {
        const counterElements = document.querySelectorAll('.stat-number[data-target]');
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counterElements.forEach(el => {
            counterObserver.observe(el);
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

    // Neural Network Background Animation
    setupNeuralNetwork() {
        const canvas = document.getElementById('brain-invest-canvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const connections = [];
        const particleCount = 50;

        // Create particles
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5,
                size: Math.random() * 2 + 1,
                opacity: Math.random() * 0.5 + 0.2
            });
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Update and draw particles
            particles.forEach(particle => {
                particle.x += particle.vx;
                particle.y += particle.vy;
                
                // Wrap around edges
                if (particle.x < 0) particle.x = canvas.width;
                if (particle.x > canvas.width) particle.x = 0;
                if (particle.y < 0) particle.y = canvas.height;
                if (particle.y > canvas.height) particle.y = 0;
                
                // Draw particle
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${particle.opacity})`;
                ctx.fill();
            });
            
            // Draw connections
            particles.forEach((particle, i) => {
                particles.slice(i + 1).forEach(otherParticle => {
                    const distance = Math.sqrt(
                        Math.pow(particle.x - otherParticle.x, 2) + 
                        Math.pow(particle.y - otherParticle.y, 2)
                    );
                    
                    if (distance < 150) {
                        ctx.beginPath();
                        ctx.moveTo(particle.x, particle.y);
                        ctx.lineTo(otherParticle.x, otherParticle.y);
                        ctx.strokeStyle = `rgba(99, 102, 241, ${0.1 * (1 - distance / 150)})`;
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                });
            });
            
            requestAnimationFrame(animate);
        }
        
        animate();
        
        // Handle resize
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    }

    // Professional Chart Setup
    setupCharts() {
        this.setupHeroChart();
        this.setupPerformanceChart();
        this.setupAllocationChart();
    }

    setupHeroChart() {
        const canvas = document.getElementById('hero-chart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const data = this.generateFinancialData(30);
        
        this.charts.hero = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Portfolio Value',
                    data: data.values,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#6366f1',
                    pointHoverBorderColor: '#ffffff',
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `$${context.parsed.y.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    setupPerformanceChart() {
        const canvas = document.getElementById('performance-chart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const data = this.generatePerformanceData(7);

        this.charts.performance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Daily Performance',
                    data: data.values,
                    backgroundColor: data.values.map(v => v >= 0 ? '#10b981' : '#ef4444'),
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return `${value > 0 ? '+' : ''}${value.toFixed(2)}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    setupAllocationChart() {
        const canvas = document.getElementById('allocation-chart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');

        this.charts.allocation = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Stocks', 'Crypto', 'Bonds'],
                datasets: [{
                    data: [45, 25, 30],
                    backgroundColor: ['#6366f1', '#8b5cf6', '#06b6d4'],
                    borderWidth: 0,
                    cutout: '60%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed}%`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Enhanced Demo Interface
    setupDemoInterface() {
        const navItems = document.querySelectorAll('.nav-item');
        const tabContents = document.querySelectorAll('.tab-content');

        navItems.forEach(item => {
            item.addEventListener('click', () => {
                const target = item.dataset.bsTarget || item.getAttribute('data-tab');
                if (!target) return;

                // Remove active class from all nav items and tabs
                navItems.forEach(nav => nav.classList.remove('active'));
                tabContents.forEach(tab => tab.classList.remove('active'));

                // Add active class to clicked nav and corresponding tab
                item.classList.add('active');
                const targetTab = document.getElementById(`${target.replace('#', '')}-tab`);
                if (targetTab) {
                    targetTab.classList.add('active');
                }
            });
        });
    }

    // Professional Interactive Elements
    setupInteractiveElements() {
        this.setupPricingCards();
        this.setupFeatureCards();
        this.setupButtonEffects();
        this.setupHoverEffects();
    }

    setupPricingCards() {
        const pricingCards = document.querySelectorAll('.pricing-card');
        
        pricingCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = card.classList.contains('featured') 
                    ? 'scale(1.05) translateY(-10px)' 
                    : 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = card.classList.contains('featured') 
                    ? 'scale(1.05)' 
                    : 'none';
            });
        });
    }

    setupFeatureCards() {
        const featureCards = document.querySelectorAll('.feature-card');
        
        featureCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const glow = card.querySelector('.card-glow');
                if (glow) {
                    glow.style.opacity = '0.15';
                }
            });
            
            card.addEventListener('mouseleave', () => {
                const glow = card.querySelector('.card-glow');
                if (glow) {
                    glow.style.opacity = '0';
                }
            });
        });
    }

    setupButtonEffects() {
        const primaryButtons = document.querySelectorAll('.btn-primary-invest, .btn-cta-primary');
        
        primaryButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                const glow = button.querySelector('.btn-glow');
                if (glow) {
                    glow.style.transform = 'translateX(0%)';
                }
            });
            
            button.addEventListener('mouseleave', () => {
                const glow = button.querySelector('.btn-glow');
                if (glow) {
                    glow.style.transform = 'translateX(-100%)';
                }
            });
        });
    }

    setupHoverEffects() {
        // Add smooth hover effects to all interactive elements
        const interactiveElements = document.querySelectorAll('.btn-secondary-invest, .btn-cta-secondary, .demo-feature, .feature-item');
        
        interactiveElements.forEach(element => {
            element.addEventListener('mouseenter', () => {
                element.style.transform = 'translateY(-2px)';
            });
            
            element.addEventListener('mouseleave', () => {
                element.style.transform = 'translateY(0)';
            });
        });
    }

    // Real-time Updates with Performance Optimization
    startRealTimeUpdates() {
        // Update portfolio metrics every 5 seconds
        setInterval(() => {
            this.updatePortfolioMetrics();
        }, 5000);

        // Update market positions every 3 seconds
        setInterval(() => {
            this.updateMarketPositions();
        }, 3000);
    }

    updatePortfolioMetrics() {
        const portfolioValue = document.querySelector('.metric-value');
        const changeElement = document.querySelector('.metric-change');
        
        if (portfolioValue && changeElement) {
            // Simulate realistic portfolio changes
            const currentValue = parseInt(portfolioValue.textContent.replace(/[$,]/g, ''));
            const change = (Math.random() - 0.48) * 0.02; // Slight upward bias
            const newValue = Math.floor(currentValue * (1 + change));
            const changePercent = (change * 100).toFixed(2);
            
            portfolioValue.textContent = `$${newValue.toLocaleString()}`;
            changeElement.textContent = `${change > 0 ? '+' : ''}${changePercent}%`;
            changeElement.className = `metric-change ${change > 0 ? 'positive' : 'negative'}`;
        }
    }

    updateMarketPositions() {
        const positions = document.querySelectorAll('.position-item .change');
        
        positions.forEach(position => {
            // Simulate realistic market changes
            const change = (Math.random() - 0.48) * 0.1; // Slight upward bias
            const changePercent = (change * 100).toFixed(2);
            
            position.textContent = `${change > 0 ? '+' : ''}${changePercent}%`;
            position.className = `change ${change > 0 ? 'positive' : 'negative'}`;
        });
    }

    // Performance Optimizations
    setupPerformanceOptimizations() {
        // Debounce scroll events
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(() => {
                this.handleScrollOptimization();
            }, 16);
        });

        // Optimize animations for reduced motion preference
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.disableAnimations();
        }
    }

    handleScrollOptimization() {
        // Optimize scroll-based animations
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-elements .element');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.2);
            element.style.transform = `translateY(${scrolled * speed * -0.5}px) rotate(${scrolled * 0.1}deg)`;
        });
    }

    disableAnimations() {
        // Disable animations for users who prefer reduced motion
        const animatedElements = document.querySelectorAll('.animate-fade-up, .animate-slide-up, .animate-slide-left, .animate-slide-right');
        animatedElements.forEach(el => {
            el.style.animation = 'none';
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
    }

    // Data Generation Helpers
    generateFinancialData(days) {
        const labels = [];
        const values = [];
        let currentValue = 2500000; // Starting value: $2.5M
        
        for (let i = 0; i < days; i++) {
            const date = new Date();
            date.setDate(date.getDate() - (days - i));
            labels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
            
            // Generate realistic market movement
            const change = (Math.random() - 0.48) * 0.03; // Slight upward bias
            currentValue = Math.max(currentValue * (1 + change), currentValue * 0.95);
            values.push(Math.floor(currentValue));
        }
        
        return { labels, values };
    }

    generatePerformanceData(days) {
        const labels = [];
        const values = [];
        
        const dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        
        for (let i = 0; i < days; i++) {
            const date = new Date();
            date.setDate(date.getDate() - (days - i));
            labels.push(dayNames[date.getDay()]);
            
            // Generate realistic daily performance
            const performance = (Math.random() - 0.45) * 4; // -2% to +2% with slight positive bias
            values.push(parseFloat(performance.toFixed(2)));
        }
        
        return { labels, values };
    }
}

// Professional Demo Functions
function startDemo() {
    if (window.brainInvestApp && window.brainInvestApp.isDemoActive) {
        return; // Prevent multiple demo starts
    }

    // Add visual feedback
    const button = event.target.closest('.btn-demo-start');
    if (button) {
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 150);
    }
    
    // Animate demo interface
    const demoInterface = document.querySelector('.demo-interface');
    if (demoInterface) {
        demoInterface.style.transform = 'scale(1.02)';
        demoInterface.style.boxShadow = '0 25px 50px rgba(99, 102, 241, 0.3)';
        
        setTimeout(() => {
            demoInterface.style.transform = 'scale(1)';
            demoInterface.style.boxShadow = '';
        }, 500);
    }
    
    // Show success message
    showNotification('Demo launched successfully! Explore the interface on the right.', 'success');
    
    // Mark demo as active
    if (window.brainInvestApp) {
        window.brainInvestApp.isDemoActive = true;
    }
}

// Professional Utility Functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <svg class="notification-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                ${type === 'success' 
                    ? '<polyline points="20,6 9,17 4,12"/>' 
                    : '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'
                }
            </svg>
            <span class="notification-message">${message}</span>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: ${type === 'success' ? '#10b981' : '#6366f1'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Enhanced Scroll Effects
function setupParallax() {
    const parallaxElements = document.querySelectorAll('.floating-elements .element');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.2);
            element.style.transform = `translateY(${rate * speed}px) rotate(${scrolled * 0.1}deg)`;
        });
    });
}

// Smooth Scrolling for Anchor Links
function setupSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Professional Loading Animation
function setupLoadingAnimation() {
    window.addEventListener('load', () => {
        document.body.classList.add('loaded');
        
        // Trigger hero animations
        setTimeout(() => {
            document.querySelectorAll('.hero-content .animate-fade-up').forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        }, 500);
    });
}

// Initialize Everything
document.addEventListener('DOMContentLoaded', () => {
    // Initialize main app
    window.brainInvestApp = new BrainInvestApp();
    
    // Setup additional features
    setupParallax();
    setupSmoothScrolling();
    setupLoadingAnimation();
    
    // Add custom styles for notifications
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: currentColor;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease;
        }
        
        .notification-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        body.loaded .hero-brain-invest {
            animation: fadeIn 1s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    `;
    document.head.appendChild(style);
});

// Export for global access
window.BrainInvestApp = BrainInvestApp;
window.startDemo = startDemo;