/**
 * =============================================================================
 * TECHNOLOGY PAGE - BRAIN TECHNOLOGY
 * Advanced Interactive Features & Neural Network Animations
 * =============================================================================
 */

class TechnologyApp {
    constructor() {
        this.counters = {};
        this.isInitialized = false;
        this.init();
    }

    init() {
        if (this.isInitialized) return;
        
        this.setupNeuralNetwork();
        this.setupAnimations();
        this.setupScrollEffects();
        this.setupCounters();
        this.setupInteractiveElements();
        this.setupPerformanceOptimizations();
        
        this.isInitialized = true;
    }

    // =============================================================================
    // NEURAL NETWORK BACKGROUND ANIMATION
    // =============================================================================

    setupNeuralNetwork() {
        const canvas = document.getElementById('technology-canvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const connections = [];
        const particleCount = 60;

        // Create particles
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5) * 0.3,
                vy: (Math.random() - 0.5) * 0.3,
                size: Math.random() * 2 + 1,
                opacity: Math.random() * 0.6 + 0.2,
                pulse: Math.random() * Math.PI * 2
            });
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Update and draw particles
            particles.forEach(particle => {
                particle.x += particle.vx;
                particle.y += particle.vy;
                particle.pulse += 0.02;
                
                // Wrap around edges
                if (particle.x < 0) particle.x = canvas.width;
                if (particle.x > canvas.width) particle.x = 0;
                if (particle.y < 0) particle.y = canvas.height;
                if (particle.y > canvas.height) particle.y = 0;
                
                // Pulsing effect
                const pulseSize = particle.size + Math.sin(particle.pulse) * 0.5;
                
                // Draw particle
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, pulseSize, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${particle.opacity})`;
                ctx.fill();
                
                // Glow effect
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, pulseSize + 2, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${particle.opacity * 0.3})`;
                ctx.fill();
            });
            
            // Draw connections
            particles.forEach((particle, i) => {
                particles.slice(i + 1).forEach(otherParticle => {
                    const distance = Math.sqrt(
                        Math.pow(particle.x - otherParticle.x, 2) + 
                        Math.pow(particle.y - otherParticle.y, 2)
                    );
                    
                    if (distance < 120) {
                        const opacity = 0.15 * (1 - distance / 120);
                        ctx.beginPath();
                        ctx.moveTo(particle.x, particle.y);
                        ctx.lineTo(otherParticle.x, otherParticle.y);
                        ctx.strokeStyle = `rgba(99, 102, 241, ${opacity})`;
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

    // =============================================================================
    // SCROLL ANIMATIONS & INTERSECTION OBSERVER
    // =============================================================================

    setupAnimations() {
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

        // Observe tech items for staggered animation
        const techItems = document.querySelectorAll('.tech-item');
        techItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.dataset.delay = index * 100;
            observer.observe(item);
        });

        // Observe capability cards
        const capabilityCards = document.querySelectorAll('.capability-card');
        capabilityCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.dataset.delay = index * 150;
            observer.observe(card);
        });

        // Observe process steps
        const processSteps = document.querySelectorAll('.process-step');
        processSteps.forEach((step, index) => {
            step.style.opacity = '0';
            step.style.transform = 'translateX(-30px)';
            step.dataset.delay = index * 200;
            observer.observe(step);
        });
    }

    // =============================================================================
    // SCROLL EFFECTS & PARALLAX
    // =============================================================================

    setupScrollEffects() {
        let ticking = false;

        function updateParallax() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.hero-section, .tech-interface');
            
            parallaxElements.forEach(element => {
                const speed = 0.3;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
            
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick);
    }

    // =============================================================================
    // ANIMATED COUNTERS
    // =============================================================================

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

    // =============================================================================
    // INTERACTIVE ELEMENTS
    // =============================================================================

    setupInteractiveElements() {
        this.setupTechItemHovers();
        this.setupCapabilityCardHovers();
        this.setupProcessStepHovers();
        this.setupButtonEffects();
        this.setupSmoothScrolling();
    }

    setupTechItemHovers() {
        const techItems = document.querySelectorAll('.tech-item');
        
        techItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-4px) scale(1.02)';
                item.style.boxShadow = '0 20px 40px rgba(99, 102, 241, 0.2)';
            });
            
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateY(0) scale(1)';
                item.style.boxShadow = 'none';
            });
        });
    }

    setupCapabilityCardHovers() {
        const capabilityCards = document.querySelectorAll('.capability-card');
        
        capabilityCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-6px) scale(1.02)';
                card.style.boxShadow = '0 25px 50px rgba(99, 102, 241, 0.3)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = 'none';
            });
        });
    }

    setupProcessStepHovers() {
        const processSteps = document.querySelectorAll('.process-step');
        
        processSteps.forEach(step => {
            step.addEventListener('mouseenter', () => {
                const stepNumber = step.querySelector('.step-number');
                const stepContent = step.querySelector('.step-content');
                
                stepNumber.style.transform = 'scale(1.1)';
                stepContent.style.transform = 'translateY(-4px)';
                stepContent.style.boxShadow = '0 15px 30px rgba(99, 102, 241, 0.2)';
            });
            
            step.addEventListener('mouseleave', () => {
                const stepNumber = step.querySelector('.step-number');
                const stepContent = step.querySelector('.step-content');
                
                stepNumber.style.transform = 'scale(1)';
                stepContent.style.transform = 'translateY(0)';
                stepContent.style.boxShadow = 'none';
            });
        });
    }

    setupButtonEffects() {
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0) scale(1)';
            });
            
            button.addEventListener('click', (e) => {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                button.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }

    setupSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                const targetId = link.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 100;
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // =============================================================================
    // PERFORMANCE OPTIMIZATIONS
    // =============================================================================

    setupPerformanceOptimizations() {
        this.handleScrollOptimization();
        this.setupThrottling();
    }

    handleScrollOptimization() {
        let scrollTimeout;
        
        window.addEventListener('scroll', () => {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            
            scrollTimeout = setTimeout(() => {
                // Optimize scroll performance
                document.body.classList.add('scrolling');
                
                setTimeout(() => {
                    document.body.classList.remove('scrolling');
                }, 100);
            }, 10);
        });
    }

    setupThrottling() {
        // Throttle function for performance
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
            }
        }

        // Apply throttling to scroll events
        window.addEventListener('scroll', throttle(() => {
            // Scroll-based optimizations
        }, 16));
    }
}

// =============================================================================
// UTILITY FUNCTIONS
// =============================================================================

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(99, 102, 241, 0.9);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Close button
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }, 5000);
}

// =============================================================================
// INITIALIZATION
// =============================================================================

let technologyApp;

function initializeTechnology() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            technologyApp = new TechnologyApp();
        });
    } else {
        technologyApp = new TechnologyApp();
    }
}

// Initialize when DOM is ready
initializeTechnology();

// Export for global access
window.TechnologyApp = TechnologyApp;
window.showNotification = showNotification; 