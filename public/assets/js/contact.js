/**
 * =============================================================================
 * CONTACT PAGE - BRAIN TECHNOLOGY
 * Magical Interactive JavaScript with Neural Network Background
 * =============================================================================
 */

class ContactApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupNeuralNetwork();
        this.setupAnimations();
        this.setupScrollEffects();
        this.setupCounters();
        this.setupInteractiveElements();
        this.setupFormHandling();
        this.setupPerformanceOptimizations();
    }

    // =============================================================================
    // NEURAL NETWORK BACKGROUND ANIMATION
    // =============================================================================

    setupNeuralNetwork() {
        const canvas = document.getElementById('contact-canvas');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        let animationId;
        let particles = [];
        let connections = [];
        let mouse = { x: 0, y: 0 };

        const resizeCanvas = () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };

        class Particle {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.size = Math.random() * 2 + 1;
                this.opacity = Math.random() * 0.5 + 0.3;
                this.originalX = x;
                this.originalY = y;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                // Bounce off edges
                if (this.x <= 0 || this.x >= canvas.width) this.vx *= -1;
                if (this.y <= 0 || this.y >= canvas.height) this.vy *= -1;

                // Return to original position gradually
                const dx = this.originalX - this.x;
                const dy = this.originalY - this.y;
                this.x += dx * 0.001;
                this.y += dy * 0.001;

                // Mouse interaction
                const mouseDistance = Math.sqrt(
                    Math.pow(mouse.x - this.x, 2) + Math.pow(mouse.y - this.y, 2)
                );
                if (mouseDistance < 100) {
                    const angle = Math.atan2(mouse.y - this.y, mouse.x - this.x);
                    this.x -= Math.cos(angle) * 0.5;
                    this.y -= Math.sin(angle) * 0.5;
                }
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${this.opacity})`;
                ctx.fill();
            }
        }

        const createParticles = () => {
            particles = [];
            const particleCount = Math.min(100, Math.floor((canvas.width * canvas.height) / 10000));
            
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle(
                    Math.random() * canvas.width,
                    Math.random() * canvas.height
                ));
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

            // Update and draw particles
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            // Create and draw connections
            createConnections();
            connections.forEach(connection => {
                ctx.beginPath();
                ctx.moveTo(connection.from.x, connection.from.y);
                ctx.lineTo(connection.to.x, connection.to.y);
                ctx.strokeStyle = `rgba(99, 102, 241, ${connection.opacity * 0.3})`;
                ctx.lineWidth = 1;
                ctx.stroke();
            });

            animationId = requestAnimationFrame(animate);
        };

        // Mouse tracking
        const handleMouseMove = (e) => {
            const rect = canvas.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        };

        resizeCanvas();
        createParticles();
        animate();

        window.addEventListener('resize', () => {
            resizeCanvas();
            createParticles();
        });

        canvas.addEventListener('mousemove', handleMouseMove);

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
        const animateElements = document.querySelectorAll(
            '.contact-method-card, .form-card, .map-card, .cta-content'
        );
        animateElements.forEach(el => {
            el.classList.add('fade-in-element');
            observer.observe(el);
        });
    }

    // =============================================================================
    // SCROLL EFFECTS
    // =============================================================================

    setupScrollEffects() {
        const handleScroll = this.throttle(() => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.hero-content, .hero-visual');
            
            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        }, 16);

        window.addEventListener('scroll', handleScroll);
    }

    // =============================================================================
    // COUNTER ANIMATIONS
    // =============================================================================

    setupCounters() {
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const counters = document.querySelectorAll('.stat-number[data-target]');
        counters.forEach(counter => observer.observe(counter));
    }

    animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);

        // Add animation class
        element.style.animation = 'countUp 0.6s ease-out';
        setTimeout(() => {
            element.style.animation = '';
        }, 600);
    }

    // =============================================================================
    // INTERACTIVE ELEMENTS
    // =============================================================================

    setupInteractiveElements() {
        // Contact method cards hover effects
        const contactCards = document.querySelectorAll('.contact-method-card');
        contactCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Form input focus effects
        const formInputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('focused');
            });
        });

        // Button ripple effects
        const buttons = document.querySelectorAll('.submit-btn, .btn-primary, .btn-secondary');
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.createRipple(e, button);
            });
        });

        // Method links hover effects
        const methodLinks = document.querySelectorAll('.method-link');
        methodLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                link.style.transform = 'translateX(8px)';
            });

            link.addEventListener('mouseleave', () => {
                link.style.transform = 'translateX(0)';
            });
        });
    }

    // =============================================================================
    // FORM HANDLING
    // =============================================================================

    setupFormHandling() {
        const form = document.querySelector('.contact-form');
        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = form.querySelector('.submit-btn');
            const originalText = submitBtn.querySelector('.btn-text').textContent;
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });

                if (response.ok) {
                    // Success animation
                    this.showSuccessAnimation(submitBtn);
                    showNotification('Message sent successfully! We\'ll get back to you soon.', 'success');
                    form.reset();
                } else {
                    throw new Error('Failed to send message');
                }
            } catch (error) {
                console.error('Form submission error:', error);
                showNotification('Failed to send message. Please try again.', 'error');
            } finally {
                // Reset button state
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                    submitBtn.querySelector('.btn-text').textContent = originalText;
                }, 2000);
            }
        });

        // Real-time form validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                this.validateField(input);
            });

            input.addEventListener('blur', () => {
                this.validateField(input);
            });
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const fieldGroup = field.closest('.form-group');
        
        // Remove existing validation classes
        fieldGroup.classList.remove('valid', 'invalid');
        
        if (!value) {
            if (field.hasAttribute('required')) {
                fieldGroup.classList.add('invalid');
            }
            return;
        }

        // Email validation
        if (field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                fieldGroup.classList.add('invalid');
                return;
            }
        }

        // Name validation
        if (field.name === 'user-name') {
            if (value.length < 2) {
                fieldGroup.classList.add('invalid');
                return;
            }
        }

        // Message validation
        if (field.name === 'user-message') {
            if (value.length < 10) {
                fieldGroup.classList.add('invalid');
                return;
            }
        }

        fieldGroup.classList.add('valid');
    }

    showSuccessAnimation(button) {
        const checkmark = document.createElement('div');
        checkmark.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
            </svg>
        `;
        checkmark.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            z-index: 2;
        `;
        
        button.appendChild(checkmark);
        
        // Animate checkmark
        checkmark.style.animation = 'countUp 0.6s ease-out';
        
        // Update button text
        button.querySelector('.btn-text').textContent = 'Message Sent!';
    }

    // =============================================================================
    // UTILITY FUNCTIONS
    // =============================================================================

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
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        `;

        element.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

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

    // =============================================================================
    // PERFORMANCE OPTIMIZATIONS
    // =============================================================================

    setupPerformanceOptimizations() {
        // Lazy load images
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));

        // Preload critical resources
        this.preloadResources();
    }

    preloadResources() {
        const criticalResources = [
            '/assets/css/contact.css',
            '/assets/js/contact.js'
        ];

        criticalResources.forEach(resource => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = resource;
            link.as = resource.endsWith('.css') ? 'style' : 'script';
            document.head.appendChild(link);
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
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
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
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// =============================================================================
// INITIALIZATION
// =============================================================================

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ContactApp();
    });
} else {
    new ContactApp();
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
        padding: var(--space-lg);
        box-shadow: var(--shadow-xl);
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 400px;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        border-left: 4px solid var(--success-green);
    }
    
    .notification-info {
        border-left: 4px solid var(--primary-indigo);
    }
    
    .notification-error {
        border-left: 4px solid var(--error-red);
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-md);
        color: var(--white);
    }
    
    .notification-close {
        background: none;
        border: none;
        color: var(--neutral-400);
        cursor: pointer;
        padding: var(--space-xs);
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .notification-close:hover {
        color: var(--white);
        background: rgba(255, 255, 255, 0.1);
    }
    
    .lazy {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .lazy.loaded {
        opacity: 1;
    }
    
    .form-group.focused .input-icon {
        color: var(--primary-indigo);
    }
    
    .form-group.valid .form-input,
    .form-group.valid .form-select,
    .form-group.valid .form-textarea {
        border-color: var(--success-green);
    }
    
    .form-group.invalid .form-input,
    .form-group.invalid .form-select,
    .form-group.invalid .form-textarea {
        border-color: var(--error-red);
    }
    
    .form-group.valid::after {
        content: '✓';
        position: absolute;
        right: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--success-green);
        font-weight: bold;
    }
    
    .form-group.invalid::after {
        content: '✗';
        position: absolute;
        right: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--error-red);
        font-weight: bold;
    }
`;

document.head.appendChild(style);

// =============================================================================
// EXPORT FOR GLOBAL ACCESS
// =============================================================================

window.ContactApp = ContactApp;
window.showNotification = showNotification; 