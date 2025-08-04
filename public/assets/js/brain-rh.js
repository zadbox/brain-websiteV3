/**
 * =============================================================================
 * BRAIN RH - INTERACTIVE FUNCTIONALITY
 * Advanced JavaScript for AI-Powered HR Management Solution
 * =============================================================================
 */

(function() {
    'use strict';

    // =============================================================================
    // INITIALIZATION
    // =============================================================================

    document.addEventListener('DOMContentLoaded', function() {
        initializeBrainRH();
    });

    // Fallback initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeBrainRH);
    } else {
        initializeBrainRH();
    }

    function initializeBrainRH() {
        console.log('Initializing Brain RH...');
        
        try {
            // Ensure proper section isolation first
            ensureSectionIsolation();
            
            // Initialize all components
            initNeuralNetwork();
            initAnimations();
            initDemoTabs();
            initCharts();
            initCounters();
            initFeatureCards();
            initTestimonials();
            initScrollEffects();
            initInteractiveElements();
            
            console.log('Brain RH initialization complete');
        } catch (error) {
            console.error('Error during Brain RH initialization:', error);
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
    // NEURAL NETWORK BACKGROUND
    // =============================================================================

    function initNeuralNetwork() {
        const canvas = document.getElementById('brain-rh-canvas');
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

        // Particle class
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.size = Math.random() * 2 + 1;
                this.opacity = Math.random() * 0.5 + 0.2;
                this.connectionDistance = 150;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                // Bounce off edges
                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;

                // Keep particles in bounds
                this.x = Math.max(0, Math.min(canvas.width, this.x));
                this.y = Math.max(0, Math.min(canvas.height, this.y));
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(99, 102, 241, ${this.opacity})`;
                ctx.fill();
            }
        }

        // Create particles
        for (let i = 0; i < 50; i++) {
            particles.push(new Particle());
        }

        // Draw connections between nearby particles
        function drawConnections() {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < particles[i].connectionDistance) {
                        const opacity = 1 - (distance / particles[i].connectionDistance);
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(99, 102, 241, ${opacity * 0.3})`;
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                }
            }
        }

        // Animation loop
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

        animate();

        // Pause animation when tab is not visible
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                cancelAnimationFrame(animationId);
            } else {
                animate();
            }
        });
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
            // HR Chart (Hero Section)
            const hrChart = document.getElementById('hr-chart');
            if (hrChart && !hrChart.chartInitialized) {
                drawHRChart(hrChart);
                hrChart.chartInitialized = true;
            }

            // Team Performance Chart
            const teamChart = document.getElementById('team-chart');
            if (teamChart && !teamChart.chartInitialized) {
                drawTeamChart(teamChart);
                teamChart.chartInitialized = true;
            }

            // Retention Chart
            const retentionChart = document.getElementById('retention-chart');
            if (retentionChart && !retentionChart.chartInitialized) {
                drawRetentionChart(retentionChart);
                retentionChart.chartInitialized = true;
            }
        } catch (error) {
            console.error('Error initializing charts:', error);
        }
    }

    function drawHRChart(canvas) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;

        // Clear canvas
        ctx.clearRect(0, 0, width, height);

        // Draw gradient background
        const gradient = ctx.createLinearGradient(0, 0, width, height);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.1)');
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0.1)');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, height);

        // Sample data
        const data = [65, 78, 85, 92, 88, 95, 89, 94];
        const stepX = width / (data.length - 1);
        const maxValue = Math.max(...data);
        const stepY = height / maxValue;

        // Draw line
        ctx.beginPath();
        ctx.strokeStyle = '#6366f1';
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        data.forEach((value, index) => {
            const x = index * stepX;
            const y = height - (value * stepY);
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.stroke();

        // Draw points
        data.forEach((value, index) => {
            const x = index * stepX;
            const y = height - (value * stepY);
            
            ctx.beginPath();
            ctx.arc(x, y, 4, 0, Math.PI * 2);
            ctx.fillStyle = '#6366f1';
            ctx.fill();
        });
    }

    function drawTeamChart(canvas) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;

        ctx.clearRect(0, 0, width, height);

        // Draw circular progress
        const centerX = width / 2;
        const centerY = height / 2;
        const radius = Math.min(width, height) / 2 - 10;
        const progress = 0.94; // 94%

        // Background circle
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
        ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
        ctx.lineWidth = 8;
        ctx.stroke();

        // Progress circle
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, -Math.PI / 2, (-Math.PI / 2) + (2 * Math.PI * progress));
        ctx.strokeStyle = '#10b981';
        ctx.lineWidth = 8;
        ctx.stroke();

        // Center text
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 16px Inter';
        ctx.textAlign = 'center';
        ctx.fillText('94%', centerX, centerY + 5);
    }

    function drawRetentionChart(canvas) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;

        ctx.clearRect(0, 0, width, height);

        // Bar chart data
        const data = [
            { month: 'Jan', value: 85 },
            { month: 'Feb', value: 87 },
            { month: 'Mar', value: 89 },
            { month: 'Apr', value: 91 },
            { month: 'May', value: 88 },
            { month: 'Jun', value: 92 }
        ];

        const barWidth = width / data.length - 10;
        const maxValue = Math.max(...data.map(d => d.value));
        const barHeight = height - 40;

        data.forEach((item, index) => {
            const x = index * (barWidth + 10) + 5;
            const barH = (item.value / maxValue) * barHeight;
            const y = height - barH - 20;

            // Bar
            const gradient = ctx.createLinearGradient(x, y, x, y + barH);
            gradient.addColorStop(0, '#6366f1');
            gradient.addColorStop(1, '#8b5cf6');
            
            ctx.fillStyle = gradient;
            ctx.fillRect(x, y, barWidth, barH);

            // Value text
            ctx.fillStyle = '#ffffff';
            ctx.font = '12px Inter';
            ctx.textAlign = 'center';
            ctx.fillText(item.value + '%', x + barWidth / 2, y - 5);

            // Month label
            ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
            ctx.font = '10px Inter';
            ctx.fillText(item.month, x + barWidth / 2, height - 5);
        });
    }

    // =============================================================================
    // COUNTER ANIMATIONS
    // =============================================================================

    function initCounters() {
        const counters = document.querySelectorAll('.stat-number');
        
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.animated) {
                    animateCounter(entry.target);
                    entry.target.animated = true;
                }
            });
        }, observerOptions);

        counters.forEach(counter => counterObserver.observe(counter));
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
        // Candidate item interactions
        const candidateItems = document.querySelectorAll('.candidate-item');
        candidateItems.forEach(item => {
            item.addEventListener('click', () => {
                // Add selection effect
                candidateItems.forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
            });
        });

        // Action button interactions
        const actionButtons = document.querySelectorAll('.btn-action');
        actionButtons.forEach(button => {
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

        // Goal item interactions
        const goalItems = document.querySelectorAll('.goal-item');
        goalItems.forEach(item => {
            item.addEventListener('click', () => {
                if (item.classList.contains('pending')) {
                    item.classList.remove('pending');
                    item.classList.add('in-progress');
                    item.querySelector('.goal-checkbox').textContent = '○';
                } else if (item.classList.contains('in-progress')) {
                    item.classList.remove('in-progress');
                    item.classList.add('completed');
                    item.querySelector('.goal-checkbox').textContent = '✓';
                }
            });
        });
    }

    // =============================================================================
    // UTILITY FUNCTIONS
    // =============================================================================

    function showNotification(message, type = 'info') {
        // Create notification element
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
            background: ${type === 'success' ? '#10b981' : '#6366f1'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 300px;
        `;

        // Add to page
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
                document.body.removeChild(notification);
            }, 300);
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (document.body.contains(notification)) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }
        }, 5000);
    }

    // =============================================================================
    // PERFORMANCE OPTIMIZATION
    // =============================================================================

    // Throttle function for scroll events
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

    // Debounce function for resize events
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

    // Apply throttling to scroll events
    window.addEventListener('scroll', throttle(() => {
        // Scroll-based animations can be added here
    }, 16));

    // Apply debouncing to resize events
    window.addEventListener('resize', debounce(() => {
        // Reinitialize charts on resize
        initCharts();
    }, 250));

    // =============================================================================
    // ACCESSIBILITY ENHANCEMENTS
    // =============================================================================

    // Keyboard navigation for demo tabs
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            const activeTab = document.querySelector('.demo-tab.active');
            if (activeTab) {
                activeTab.focus();
            }
        }
    });

    // ARIA labels and roles
    const demoTabs = document.querySelectorAll('.demo-tab');
    demoTabs.forEach((tab, index) => {
        tab.setAttribute('role', 'tab');
        tab.setAttribute('aria-selected', tab.classList.contains('active'));
        tab.setAttribute('aria-controls', `panel-${index + 1}`);
    });

    const demoPanels = document.querySelectorAll('.demo-panel');
    demoPanels.forEach((panel, index) => {
        panel.setAttribute('role', 'tabpanel');
        panel.setAttribute('aria-labelledby', `tab-${index + 1}`);
    });

    // =============================================================================
    // ERROR HANDLING
    // =============================================================================

    window.addEventListener('error', (e) => {
        console.error('Brain RH Error:', e.error);
        // Could send error to analytics service here
    });

    // =============================================================================
    // EXPORT FOR GLOBAL ACCESS
    // =============================================================================

    // Make functions available globally if needed
    window.BrainRH = {
        initCharts,
        showNotification,
        animateCounter
    };

})();
