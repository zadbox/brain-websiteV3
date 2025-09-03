/**
 * =============================================================================
 * BRAIN ASSISTANT - ADVANCED JAVASCRIPT FUNCTIONALITY
 * AI-Powered Virtual Assistant & Automation Solution
 * =============================================================================
 */

(function() {
    'use strict';

    // =============================================================================
    // INITIALIZATION
    // =============================================================================

    document.addEventListener('DOMContentLoaded', function() {
        initializeBrainAssistant();
    });

    // Fallback initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeBrainAssistant);
    } else {
        initializeBrainAssistant();
    }

    function initializeBrainAssistant() {
        console.log('Initializing Brain Assistant...');
        
        try {
            // Ensure proper section isolation first
            ensureSectionIsolation();
            
            // Initialize all components
            initAIParticles();
            initAnimations();
            initDemoTabs();
            initCharts();
            initCounters();
            initFeatureCards();
            initTestimonials();
            initScrollEffects();
            initInteractiveElements();
            initChatSimulation();
            
            console.log('Brain Assistant initialization complete');
        } catch (error) {
            console.error('Error during Brain Assistant initialization:', error);
        }
    }

    function ensureSectionIsolation() {
        // Ensure features section is properly isolated
        const featuresSection = document.querySelector('.features-section');
        if (featuresSection) {
            featuresSection.style.position = 'relative';
            featuresSection.style.zIndex = '5';
            featuresSection.style.isolation = 'isolate';
        }

        // Ensure demo section is properly isolated
        const demoSection = document.querySelector('.demo-section');
        if (demoSection) {
            demoSection.style.position = 'relative';
            demoSection.style.zIndex = '5';
            demoSection.style.isolation = 'isolate';
        }

        // Prevent any global scroll interference
        document.body.style.overflowX = 'hidden';
    }

    // =============================================================================
    // AI PARTICLES BACKGROUND
    // =============================================================================

    function initAIParticles() {
        const canvas = document.getElementById('brain-assistant-canvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let animationId;
        let particles = [];
        let connections = [];

        // Set canvas size
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        // AI Particle class
        class AIParticle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.8;
                this.vy = (Math.random() - 0.5) * 0.8;
                this.size = Math.random() * 3 + 1;
                this.opacity = Math.random() * 0.6 + 0.2;
                this.connectionDistance = 120;
                this.pulsePhase = Math.random() * Math.PI * 2;
                this.pulseSpeed = 0.02 + Math.random() * 0.03;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                // Bounce off edges with AI-like behavior
                if (this.x < 0 || this.x > canvas.width) {
                    this.vx *= -1;
                    this.x = Math.max(0, Math.min(canvas.width, this.x));
                }
                if (this.y < 0 || this.y > canvas.height) {
                    this.vy *= -1;
                    this.y = Math.max(0, Math.min(canvas.height, this.y));
                }

                // Keep particles in bounds
                this.x = Math.max(0, Math.min(canvas.width, this.x));
                this.y = Math.max(0, Math.min(canvas.height, this.y));

                // Update pulse phase
                this.pulsePhase += this.pulseSpeed;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size * (0.8 + 0.2 * Math.sin(this.pulsePhase)), 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${this.opacity * (0.7 + 0.3 * Math.sin(this.pulsePhase))})`;
                ctx.fill();

                // Add glow effect
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size * 2, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${this.opacity * 0.1 * Math.sin(this.pulsePhase)})`;
                ctx.fill();
            }
        }

        function drawConnections() {
            connections = [];
            
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < particles[i].connectionDistance) {
                        const opacity = (1 - distance / particles[i].connectionDistance) * 0.3;
                        connections.push({
                            x1: particles[i].x,
                            y1: particles[i].y,
                            x2: particles[j].x,
                            y2: particles[j].y,
                            opacity: opacity
                        });
                    }
                }
            }

            connections.forEach(connection => {
                ctx.beginPath();
                ctx.moveTo(connection.x1, connection.y1);
                ctx.lineTo(connection.x2, connection.y2);
                ctx.strokeStyle = `rgba(99, 102, 241, ${connection.opacity})`;
                ctx.lineWidth = 1;
                ctx.stroke();
            });
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Update and draw particles
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            // Draw connections
            drawConnections();

            animationId = requestAnimationFrame(animate);
        }

        // Initialize particles
        for (let i = 0; i < 50; i++) {
            particles.push(new AIParticle());
        }

        animate();
    }

    // =============================================================================
    // ANIMATIONS & SCROLL EFFECTS
    // =============================================================================

    function initAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px' // Increased margin to prevent premature triggering
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation - separate observers for different sections
        const featureCards = document.querySelectorAll('.feature-card');
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        const demoContainer = document.querySelector('.demo-container');
        
        // Observe feature cards
        featureCards.forEach(el => observer.observe(el));
        
        // Observe testimonial cards
        testimonialCards.forEach(el => observer.observe(el));
        
        // Observe demo container separately
        if (demoContainer) {
            observer.observe(demoContainer);
        }
    }

    function initScrollEffects() {
        let ticking = false;

        function updateScrollEffects() {
            const scrolled = window.pageYOffset;
            // Only apply parallax to hero section, not demo section
            const parallaxElements = document.querySelectorAll('.hero-section');

            parallaxElements.forEach(element => {
                const speed = 0.3; // Reduced speed for smoother effect
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });

            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateScrollEffects);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick);
    }

    // =============================================================================
    // INTERACTIVE DEMO TABS
    // =============================================================================

    function initDemoTabs() {
        const tabs = document.querySelectorAll('.demo-tab');
        const panels = document.querySelectorAll('.demo-panel');

        if (tabs.length === 0 || panels.length === 0) {
            console.warn('Demo tabs or panels not found');
            return;
        }

        // Ensure demo section is properly isolated
        const demoSection = document.querySelector('.demo-section');
        if (demoSection) {
            demoSection.style.position = 'relative';
            demoSection.style.zIndex = '5';
            demoSection.style.isolation = 'isolate';
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation(); // Prevent event bubbling
                const targetPanel = tab.getAttribute('data-tab');

                // Remove active class from all tabs and panels
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                panels.forEach(p => p.classList.remove('active'));

                // Add active class to clicked tab and corresponding panel
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');
                
                const activePanel = document.querySelector(`[data-panel="${targetPanel}"]`);
                if (activePanel) {
                    activePanel.classList.add('active');
                    
                    // Initialize charts for the active panel
                    setTimeout(() => {
                        initCharts();
                    }, 300);
                } else {
                    console.warn(`Panel with data-panel="${targetPanel}" not found`);
                }
            });
        });

        // Set initial active state
        const activeTab = document.querySelector('.demo-tab.active');
        if (activeTab) {
            activeTab.setAttribute('aria-selected', 'true');
        }
    }

    // =============================================================================
    // CHARTS & DATA VISUALIZATION
    // =============================================================================

    function initCharts() {
        try {
            // Performance Chart
            const performanceChart = document.getElementById('performance-chart');
            if (performanceChart && !performanceChart.chartInitialized) {
                drawPerformanceChart(performanceChart);
                performanceChart.chartInitialized = true;
            }
        } catch (error) {
            console.error('Error initializing charts:', error);
        }
    }

    function drawPerformanceChart(canvas) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;

        // Clear canvas
        ctx.clearRect(0, 0, width, height);

        // Create gradient background
        const gradient = ctx.createLinearGradient(0, 0, 0, height);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.1)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

        // Sample data
        const data = [65, 78, 82, 89, 94, 91, 87, 92, 96, 89, 94, 98];
        const maxValue = Math.max(...data);
        const minValue = Math.min(...data);
        const range = maxValue - minValue;

        // Calculate points
        const points = data.map((value, index) => {
            const x = (index / (data.length - 1)) * width;
            const y = height - ((value - minValue) / range) * height * 0.8;
            return { x, y };
        });

        // Draw area
        ctx.beginPath();
        ctx.moveTo(0, height);
        points.forEach(point => {
            ctx.lineTo(point.x, point.y);
        });
        ctx.lineTo(width, height);
        ctx.closePath();
        ctx.fillStyle = gradient;
        ctx.fill();

        // Draw line
        ctx.beginPath();
        ctx.moveTo(points[0].x, points[0].y);
        points.forEach(point => {
            ctx.lineTo(point.x, point.y);
        });
        ctx.strokeStyle = '#6366f1';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Draw points
        points.forEach(point => {
            ctx.beginPath();
            ctx.arc(point.x, point.y, 3, 0, Math.PI * 2);
            ctx.fillStyle = '#6366f1';
            ctx.fill();
        });
    }

    // =============================================================================
    // COUNTER ANIMATIONS
    // =============================================================================

    function initCounters() {
        const counters = document.querySelectorAll('.stat-number[data-target]');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    animateCounter(entry.target);
                    entry.target.classList.add('counted');
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => observer.observe(counter));
    }

    function animateCounter(element) {
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
    }

    // =============================================================================
    // FEATURE CARDS INTERACTIONS
    // =============================================================================

    function initFeatureCards() {
        const featureCards = document.querySelectorAll('.feature-card');

        featureCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });

            card.addEventListener('click', () => {
                // Add click effect
                card.style.transform = 'translateY(-4px) scale(0.98)';
                setTimeout(() => {
                    card.style.transform = 'translateY(-8px) scale(1.02)';
                }, 150);
            });
        });
    }

    // =============================================================================
    // TESTIMONIALS INTERACTIONS
    // =============================================================================

    function initTestimonials() {
        const testimonialCards = document.querySelectorAll('.testimonial-card');

        testimonialCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    }

    // =============================================================================
    // INTERACTIVE ELEMENTS
    // =============================================================================

    function initInteractiveElements() {
        // Quick action button interactions
        const quickActions = document.querySelectorAll('.quick-action');
        quickActions.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Add click effect
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 150);

                // Show success message
                showNotification('Action completed successfully!', 'success');
            });
        });

        // Send button interactions
        const sendButtons = document.querySelectorAll('.send-button, .send-button-demo');
        sendButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Add click effect
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 150);

                // Show sending message
                showNotification('Message sent!', 'info');
            });
        });

        // Message input interactions
        const messageInputs = document.querySelectorAll('.message-input, .message-input-demo');
        messageInputs.forEach(input => {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const sendButton = input.parentElement.querySelector('.send-button, .send-button-demo');
                    if (sendButton) {
                        sendButton.click();
                    }
                }
            });
        });
    }

    // =============================================================================
    // CHAT SIMULATION
    // =============================================================================

    function initChatSimulation() {
        const chatMessages = document.querySelectorAll('.chat-messages, .chat-messages-demo');
        
        chatMessages.forEach(container => {
            // Add typing indicator
            setTimeout(() => {
                addTypingIndicator(container);
            }, 3000);

            // Simulate AI responses
            setTimeout(() => {
                removeTypingIndicator(container);
                addAIMessage(container, "I'm analyzing your request and will provide a comprehensive response shortly.");
            }, 5000);
        });
    }

    function addTypingIndicator(container) {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message assistant typing-indicator';
        typingDiv.innerHTML = `
            <div class="message-avatar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <div class="message-content">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        container.appendChild(typingDiv);
        container.scrollTop = container.scrollHeight;
    }

    function removeTypingIndicator(container) {
        const typingIndicator = container.querySelector('.typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    function addAIMessage(container, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message assistant';
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <div class="message-content">
                <p>${message}</p>
            </div>
        `;
        container.appendChild(messageDiv);
        container.scrollTop = container.scrollHeight;
    }

    // =============================================================================
    // UTILITY FUNCTIONS
    // =============================================================================

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#6366f1'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        `;
        notification.textContent = message;

        // Add to page
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

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

    function debounce(func, wait, immediate) {
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

    // =============================================================================
    // ACCESSIBILITY ENHANCEMENTS
    // =============================================================================

    // Add keyboard navigation for demo tabs
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            const activeTab = document.querySelector('.demo-tab.active');
            if (activeTab) {
                activeTab.setAttribute('tabindex', '0');
            }
        }
    });

    // Add ARIA labels for better accessibility
    const demoTabs = document.querySelectorAll('.demo-tab');
    demoTabs.forEach((tab, index) => {
        tab.setAttribute('aria-label', `Demo tab ${index + 1}`);
        tab.setAttribute('role', 'tab');
    });

    // =============================================================================
    // ERROR HANDLING
    // =============================================================================

    window.addEventListener('error', (e) => {
        console.error('JavaScript error:', e.error);
    });

    window.addEventListener('unhandledrejection', (e) => {
        console.error('Unhandled promise rejection:', e.reason);
    });

})();
