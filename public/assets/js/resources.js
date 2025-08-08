/**
 * =============================================================================
 * RESOURCES PAGE - BRAIN TECHNOLOGY
 * Interactive JavaScript for Knowledge Hub
 * =============================================================================
 */

class ResourcesApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupNeuralNetwork();
        this.setupAnimations();
        this.setupScrollEffects();
        this.setupCounters();
        this.setupInteractiveElements();
        this.setupPerformanceOptimizations();
    }

    // =============================================================================
    // NEURAL NETWORK BACKGROUND ANIMATION
    // =============================================================================

    setupNeuralNetwork() {
        const canvas = document.getElementById('resources-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let animationId;
        let particles = [];
        let connections = [];

        const resizeCanvas = () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.size = Math.random() * 2 + 1;
                this.color = this.getRandomColor();
                this.opacity = Math.random() * 0.5 + 0.3;
            }

            getRandomColor() {
                const colors = [
                    '#6366f1', // primary-indigo
                    '#3b82f6', // primary-blue
                    '#8b5cf6', // primary-purple
                    '#06b6d4', // accent-cyan
                    '#7c3aed'  // accent-violet
                ];
                return colors[Math.floor(Math.random() * colors.length)];
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }

            draw() {
                ctx.save();
                ctx.globalAlpha = this.opacity;
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        }

        const createParticles = () => {
            particles = [];
            const particleCount = Math.min(50, Math.floor(canvas.width * canvas.height / 20000));
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        };

        const createConnections = () => {
            connections = [];
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const distance = Math.sqrt(
                        Math.pow(particles[i].x - particles[j].x, 2) +
                        Math.pow(particles[i].y - particles[j].y, 2)
                    );
                    if (distance < 150) {
                        connections.push({
                            from: particles[i],
                            to: particles[j],
                            opacity: 1 - (distance / 150)
                        });
                    }
                }
            }
        };

        const animate = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            createConnections();
            connections.forEach(connection => {
                ctx.save();
                ctx.globalAlpha = connection.opacity * 0.3;
                ctx.strokeStyle = '#6366f1';
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(connection.from.x, connection.from.y);
                ctx.lineTo(connection.to.x, connection.to.y);
                ctx.stroke();
                ctx.restore();
            });

            animationId = requestAnimationFrame(animate);
        };

        resizeCanvas();
        createParticles();
        animate();

        window.addEventListener('resize', () => {
            resizeCanvas();
            createParticles();
        });

        window.addEventListener('beforeunload', () => {
            if (animationId) {
                cancelAnimationFrame(animationId);
            }
        });
    }

    // =============================================================================
    // SCROLL ANIMATIONS
    // =============================================================================

    setupAnimations() {
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

        const animateElements = document.querySelectorAll(`
            .hero-badge, .hero-title, .hero-description, .hero-stats, .hero-actions, .hero-visual,
            .category-card, .whitepaper-card, .case-study-card, .tool-card,
            .newsletter-content, .cta-content
        `);

        animateElements.forEach(el => {
            el.classList.add('fade-in-element');
            observer.observe(el);
        });
    }

    // =============================================================================
    // SCROLL EFFECTS
    // =============================================================================

    setupScrollEffects() {
        const sections = document.querySelectorAll('section');
        
        const handleScroll = () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            
            sections.forEach(section => {
                const speed = section.dataset.speed || 0.5;
                section.style.transform = `translateY(${rate * speed}px)`;
            });
        };

        window.addEventListener('scroll', this.throttle(handleScroll, 16));
    }

    // =============================================================================
    // COUNTER ANIMATIONS
    // =============================================================================

    setupCounters() {
        const counters = document.querySelectorAll('.stat-number[data-target]');
        
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    // =============================================================================
    // INTERACTIVE ELEMENTS
    // =============================================================================

    setupInteractiveElements() {
        // Category card hover effects
        const categoryCards = document.querySelectorAll('.category-card');
        categoryCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Whitepaper card interactions
        const whitepaperCards = document.querySelectorAll('.whitepaper-card');
        whitepaperCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.boxShadow = '0 20px 40px rgba(99, 102, 241, 0.2)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '';
            });
        });

        // Case study card interactions
        const caseStudyCards = document.querySelectorAll('.case-study-card');
        caseStudyCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const overlay = card.querySelector('.case-study-overlay');
                if (overlay) {
                    overlay.style.opacity = '1';
                }
            });
            
            card.addEventListener('mouseleave', () => {
                const overlay = card.querySelector('.case-study-overlay');
                if (overlay) {
                    overlay.style.opacity = '0';
                }
            });
        });

        // Tool card interactions
        const toolCards = document.querySelectorAll('.tool-card');
        toolCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Button ripple effects
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .download-btn');
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
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

        // Smooth scrolling for anchor links
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });



        // Download button interactions
        const downloadButtons = document.querySelectorAll('.download-btn');
        downloadButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                showNotification('Download started! Check your downloads folder.', 'info');
            });
        });
    }

    // =============================================================================
    // PERFORMANCE OPTIMIZATIONS
    // =============================================================================

    setupPerformanceOptimizations() {
        // Throttle scroll events
        let ticking = false;
        const handleScrollOptimized = () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    // Scroll-based animations here
                    ticking = false;
                });
                ticking = true;
            }
        };

        window.addEventListener('scroll', handleScrollOptimized, { passive: true });

        // Debounce resize events
        let resizeTimeout;
        const handleResizeOptimized = () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Resize-based updates here
            }, 250);
        };

        window.addEventListener('resize', handleResizeOptimized, { passive: true });

        // Preload critical images
        this.preloadImages([
            'images/ai-image/gallery/a.jpg',
            'images/ai-image/gallery/b.jpg',
            'images/ai-image/gallery/c.jpg'
        ]);

        // Intersection Observer for lazy loading
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // =============================================================================
    // UTILITY FUNCTIONS
    // =============================================================================

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
        };
    }

    preloadImages(imageUrls) {
        imageUrls.forEach(url => {
            const img = new Image();
            img.src = url;
        });
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
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);

    // Close button
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    });
}

// =============================================================================
// INITIALIZATION
// =============================================================================

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ResourcesApp();
    });
} else {
    new ResourcesApp();
}

// =============================================================================
// STYLES FOR DYNAMIC ELEMENTS
// =============================================================================

const style = document.createElement('style');
style.textContent = `
    .fade-in-element {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-element.animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--glass-bg);
        backdrop-filter: var(--blur-medium);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: var(--space-md) var(--space-lg);
        color: var(--white);
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 400px;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        border-color: var(--success-green);
    }
    
    .notification-info {
        border-color: var(--primary-indigo);
    }
    
    .notification-error {
        border-color: var(--error-red);
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-md);
    }
    
    .notification-close {
        background: none;
        border: none;
        color: var(--neutral-400);
        font-size: 20px;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }
    
    .notification-close:hover {
        color: var(--white);
    }
    
    .lazy {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .lazy.loaded {
        opacity: 1;
    }
`;

document.head.appendChild(style);

// =============================================================================
// EXPORT FOR GLOBAL ACCESS
// =============================================================================

window.ResourcesApp = ResourcesApp;
window.showNotification = showNotification; 