/**
 * =============================================================================
 * ABOUT PAGE - BRAIN TECHNOLOGY
 * Interactive JavaScript for Company Story & Mission
 * =============================================================================
 */

class AboutApp {
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
        const canvas = document.getElementById('about-canvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let animationId;
        let particles = [];
        let connections = [];

        // Set canvas size
        const resizeCanvas = () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        // Particle class
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.3;
                this.vy = (Math.random() - 0.5) * 0.3;
                this.size = Math.random() * 2 + 1;
                this.opacity = Math.random() * 0.5 + 0.3;
                this.type = Math.floor(Math.random() * 4); // 4 types for different colors
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                // Bounce off edges
                if (this.x <= 0 || this.x >= canvas.width) this.vx *= -1;
                if (this.y <= 0 || this.y >= canvas.height) this.vy *= -1;

                // Keep particles within bounds
                this.x = Math.max(0, Math.min(canvas.width, this.x));
                this.y = Math.max(0, Math.min(canvas.height, this.y));
            }

            draw() {
                const colors = [
                    '#3b82f6', // Blue
                    '#6366f1', // Indigo
                    '#8b5cf6', // Purple
                    '#06b6d4'  // Cyan
                ];

                ctx.save();
                ctx.globalAlpha = this.opacity;
                ctx.fillStyle = colors[this.type];
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        }

        // Create particles
        const createParticles = () => {
            particles = [];
            const particleCount = Math.min(80, Math.floor(canvas.width * canvas.height / 12000));
            
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        };

        // Create connections between nearby particles
        const createConnections = () => {
            connections = [];
            const maxDistance = 120;

            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < maxDistance) {
                        connections.push({
                            from: particles[i],
                            to: particles[j],
                            opacity: 1 - (distance / maxDistance)
                        });
                    }
                }
            }
        };

        // Animation loop
        const animate = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Update and draw particles
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            // Create and draw connections
            createConnections();
            connections.forEach(connection => {
                ctx.save();
                ctx.globalAlpha = connection.opacity * 0.2;
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

        // Initialize
        createParticles();
        animate();

        // Cleanup on page unload
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

        // Observe elements for animation
        const animateElements = document.querySelectorAll(`
            .hero-badge,
            .hero-title,
            .hero-description,
            .hero-stats,
            .hero-actions,
            .hero-visual,
            .content-text,
            .content-visual,
            .timeline-item,
            .value-card,
            .testimonial-card,
            .partner-item
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
        const parallaxElements = document.querySelectorAll('.hero-section, .about-content-section, .story-section, .values-section');
        
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.3;

            parallaxElements.forEach((element, index) => {
                const speed = 0.05 + (index * 0.02);
                element.style.transform = `translateY(${rate * speed}px)`;
            });
        });
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
        // Timeline items hover effects
        const timelineItems = document.querySelectorAll('.timeline-item');
        timelineItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                const year = item.querySelector('.timeline-year');
                if (year) {
                    year.style.transform = 'scale(1.1)';
                }
            });

            item.addEventListener('mouseleave', () => {
                const year = item.querySelector('.timeline-year');
                if (year) {
                    year.style.transform = 'scale(1)';
                }
            });
        });

        // Value cards hover effects
        const valueCards = document.querySelectorAll('.value-card');
        valueCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Testimonial cards hover effects
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        testimonialCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px) scale(1.01)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Partner items hover effects
        const partnerItems = document.querySelectorAll('.partner-item');
        partnerItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-4px) scale(1.05)';
            });

            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Button ripple effects
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
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

        // Company info items hover effects
        const infoItems = document.querySelectorAll('.info-item');
        infoItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-2px) scale(1.02)';
            });

            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Image hover effects
        const images = document.querySelectorAll('.about-image, .timeline-image img');
        images.forEach(img => {
            img.addEventListener('mouseenter', () => {
                img.style.transform = 'scale(1.05)';
            });

            img.addEventListener('mouseleave', () => {
                img.style.transform = 'scale(1)';
            });
        });
    }

    // =============================================================================
    // PERFORMANCE OPTIMIZATIONS
    // =============================================================================

    setupPerformanceOptimizations() {
        // Throttle scroll events
        let ticking = false;
        const scrollHandler = () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    // Handle scroll-based animations here
                    ticking = false;
                });
                ticking = true;
            }
        };

        window.addEventListener('scroll', scrollHandler, { passive: true });

        // Debounce resize events
        let resizeTimeout;
        const resizeHandler = () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Handle resize-based updates here
            }, 250);
        };

        window.addEventListener('resize', resizeHandler, { passive: true });

        // Preload critical images
        const preloadImages = () => {
            const imageUrls = [
                'images/about.webp',
                'images/first.webp',
                'images/blockchain.webp',
                'images/idee.webp',
                'images/lancement.webp',
                'images/valeurs/agile.png',
                'images/valeurs/inovation ecosystem.png',
                'images/valeurs/Big data and analytic.png',
                'images/valeurs/Design thinking.png',
                'images/avatar/author/sm-q.jpg',
                'images/avatar/author/sm-r.jpg',
                'images/avatar/author/sm-s.jpg'
            ];

            imageUrls.forEach(url => {
                const img = new Image();
                img.src = url;
            });
        };

        // Preload images when page loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', preloadImages);
        } else {
            preloadImages();
        }
    }
}

// =============================================================================
// UTILITY FUNCTIONS
// =============================================================================

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;

    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--glass-bg);
        backdrop-filter: var(--blur-medium);
        border: 1px solid var(--glass-border);
        border-radius: 8px;
        padding: 12px 16px;
        color: var(--white);
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Close button functionality
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

// Initialize the app when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new AboutApp();
    });
} else {
    new AboutApp();
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .fade-in-element {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
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

    .notification-close {
        background: none;
        border: none;
        color: var(--white);
        font-size: 18px;
        cursor: pointer;
        margin-left: 8px;
        padding: 0;
        line-height: 1;
    }

    .notification-close:hover {
        opacity: 0.7;
    }

    .notification-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
`;
document.head.appendChild(style);

// Export for potential use in other modules
window.AboutApp = AboutApp;
window.showNotification = showNotification; 