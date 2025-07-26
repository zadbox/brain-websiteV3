/**
 * =============================================================================
 * INDEX PAGE - SCRIPTS JAVASCRIPT
 * BrainGenTechnology - Page d'accueil
 * =============================================================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // =============================================================================
    // ANIMATIONS D'APPARITION DES ÉLÉMENTS - HULY STYLE
    // =============================================================================
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Ajouter un délai progressif pour un effet en cascade
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 100);
            }
        });
    }, observerOptions);

    // Appliquer l'animation à tous les éléments avec la classe animate-item
    document.querySelectorAll('.animate-item').forEach(item => {
        observer.observe(item);
    });
    
    // =============================================================================
    // ENHANCED HULY-STYLE HERO ANIMATIONS
    // =============================================================================
    
    // Animate hero elements with staggered delays
    const heroElements = document.querySelectorAll('.hero-content-huly .animate-item');
    heroElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.2}s`;
    });
    
    // Interactive cursor effect for hero background - Optimized
    const heroBackground = document.querySelector('.hero-background');
    if (heroBackground) {
        let isHovering = false;
        let animationFrameId = null;
        
        // Throttle function for better performance
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
        
        heroBackground.addEventListener('mouseenter', () => {
            isHovering = true;
        });
        
        heroBackground.addEventListener('mouseleave', () => {
            isHovering = false;
            // Smoothly reset to base background
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }
            heroBackground.style.background = '';
        });
        
        const handleMouseMove = throttle((e) => {
            if (!isHovering) return;
            
            const { clientX, clientY } = e;
            const x = (clientX / window.innerWidth) * 100;
            const y = (clientY / window.innerHeight) * 100;
            
            // Use requestAnimationFrame for smooth animation
            animationFrameId = requestAnimationFrame(() => {
                heroBackground.style.background = `
                    radial-gradient(circle at ${x}% ${y}%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at ${100-x}% ${100-y}%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at ${50+x/2}% ${50+y/2}%, rgba(139, 92, 246, 0.05) 0%, transparent 50%)
                `;
            });
        }, 16); // ~60fps
        
        document.addEventListener('mousemove', handleMouseMove);
    }
    
    // Smooth scroll for CTA button
    const ctaButton = document.querySelector('.btn-huly');
    if (ctaButton) {
        ctaButton.addEventListener('click', function(e) {
            // Add click ripple effect
            const ripple = document.createElement('div');
            ripple.className = 'ripple-effect';
            ripple.style.left = e.offsetX + 'px';
            ripple.style.top = e.offsetY + 'px';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    // =============================================================================
    // ANIMATION DES COMPTEURS
    // =============================================================================
    
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                animateCounter(counter, target);
                counterObserver.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });

    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 20);
    }

    // =============================================================================
    // CANVAS PARTICLE NETWORK ANIMATION
    // =============================================================================
    
    (function() {
        function ParticleNetwork(canvasId) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            let width = canvas.offsetWidth;
            let height = canvas.offsetHeight;
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            const nodeCount = Math.floor((width * height) / 9000) + 18;
            const nodes = [];
            for (let i = 0; i < nodeCount; i++) {
                nodes.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 0.5,
                    vy: (Math.random() - 0.5) * 0.5,
                    r: Math.random() * 2.5 + 1.5
                });
            }
            function animate() {
                ctx.clearRect(0, 0, width, height);
                // Draw connections
                for (let i = 0; i < nodes.length; i++) {
                    for (let j = i + 1; j < nodes.length; j++) {
                        const dx = nodes[i].x - nodes[j].x;
                        const dy = nodes[i].y - nodes[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 120) {
                            ctx.save();
                            ctx.globalAlpha = 0.18 * (1 - dist / 120);
                            ctx.strokeStyle = 'rgba(59,130,246,0.7)';
                            ctx.lineWidth = 1.2;
                            ctx.beginPath();
                            ctx.moveTo(nodes[i].x, nodes[i].y);
                            ctx.lineTo(nodes[j].x, nodes[j].y);
                            ctx.stroke();
                            ctx.restore();
                        }
                    }
                }
                // Draw nodes
                nodes.forEach(node => {
                    ctx.save();
                    ctx.beginPath();
                    ctx.arc(node.x, node.y, node.r, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(59,130,246,0.7)';
                    ctx.shadowColor = '#3b82f6';
                    ctx.shadowBlur = 8;
                    ctx.fill();
                    ctx.restore();
                });
                // Move nodes
                nodes.forEach(node => {
                    node.x += node.vx;
                    node.y += node.vy;
                    if (node.x < 0 || node.x > width) node.vx *= -1;
                    if (node.y < 0 || node.y > height) node.vy *= -1;
                });
                requestAnimationFrame(animate);
            }
            animate();
            // Responsive resize
            window.addEventListener('resize', () => {
                width = canvas.offsetWidth;
                height = canvas.offsetHeight;
                canvas.width = width;
                canvas.height = height;
            });
        }
        
        // Initialize when DOM is loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                ParticleNetwork('neural-network-canvas');
            });
        } else {
            ParticleNetwork('neural-network-canvas');
        }
    })();
    
    // Interaction avec l'arrière-plan héros (supprimé car déjà défini plus haut)

    // =============================================================================
    // THREE.JS ANIMATIONS REMOVED
    // =============================================================================
    
    // Three.js beam background animations have been removed
    console.log('Three.js animations disabled - cube animations removed');

    // =============================================================================
    // INDUSTRY SELECTOR FUNCTIONALITY
    // =============================================================================
    
    const industryDropdown = document.getElementById('industry-dropdown');
    const dropdownArrow = document.querySelector('.dropdown-arrow');
    
    if (industryDropdown) {
        industryDropdown.addEventListener('change', function(e) {
            const selectedIndustry = e.target.value;
            if (selectedIndustry) {
                updateServicesForIndustry(selectedIndustry);
                // Add visual feedback
                this.style.borderColor = 'var(--accent-primary)';
                setTimeout(() => {
                    this.style.borderColor = '';
                }, 1000);
            }
        });

        // Dropdown arrow animation
        industryDropdown.addEventListener('focus', () => {
            if (dropdownArrow) {
                dropdownArrow.style.transform = 'translateY(-50%) rotate(180deg)';
            }
        });

        industryDropdown.addEventListener('blur', () => {
            if (dropdownArrow) {
                dropdownArrow.style.transform = 'translateY(-50%) rotate(0deg)';
            }
        });
    }

    function updateServicesForIndustry(industry) {
        const serviceCards = document.querySelectorAll('.service-content, .feature-card');
        
        // Add subtle animation to indicate change
        serviceCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.transform = 'scale(0.95)';
                card.style.opacity = '0.7';
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                    card.style.opacity = '1';
                }, 150);
            }, index * 100);
        });

        // Show notification
        showNotification(`Services updated for ${industry} industry`, 'info');
        console.log(`Services updated for industry: ${industry}`);
    }

    // =============================================================================
    // ENHANCED METRICS ANIMATION WITH PERFECT CENTERING
    // =============================================================================
    
    const heroStats = document.querySelectorAll('.hero-stats-huly .stat-item-huly');
    const featureStats = document.querySelectorAll('.feature-card .stat-circle');
    
    // Perfect centering animation for hero stats
    heroStats.forEach((stat, index) => {
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number-huly');
                    if (statNumber && !statNumber.classList.contains('animated')) {
                        // Add perfect centering animation
                        entry.target.style.animation = `perfectCenter 0.8s ease-out ${index * 0.2}s both`;
                        // Animate the counter
                        animateCounter(statNumber, parseInt(statNumber.textContent.replace(/[^0-9]/g, '')) || 95);
                        statNumber.classList.add('animated');
                    }
                }
            });
        }, { threshold: 0.5 });
        
        statObserver.observe(stat);
    });

    // Enhanced feature stats animation
    featureStats.forEach((stat, index) => {
        const featureObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statValue = entry.target.querySelector('.stat-value');
                    if (statValue && !statValue.classList.contains('animated')) {
                        // Add circular progress animation
                        entry.target.style.animation = `circularProgress 1.2s ease-out ${index * 0.3}s both`;
                        // Animate the counter
                        const targetValue = parseInt(statValue.getAttribute('data-target')) || 85;
                        animateCounter(statValue, targetValue);
                        statValue.classList.add('animated');
                    }
                }
            });
        }, { threshold: 0.3 });
        
        featureObserver.observe(stat);
    });

    // =============================================================================
    // GESTION DES ONGLETS EXPERTISE AVEC AUTO-SCROLL
    // =============================================================================
    
    const expertiseTabs = document.querySelectorAll('#expertise-tabs .nav-link');
    let currentTabIndex = 0;
    let tabInterval;

    function switchTab(index) {
        expertiseTabs.forEach((tab, i) => {
            tab.classList.toggle('active', i === index);
            const target = document.querySelector(tab.getAttribute('data-bs-target'));
            if (target) {
                target.classList.toggle('show', i === index);
                target.classList.toggle('active', i === index);
            }
        });
    }

    function autoSwitchTabs() {
        currentTabIndex = (currentTabIndex + 1) % expertiseTabs.length;
        switchTab(currentTabIndex);
    }

    function startAutoSwitch() {
        tabInterval = setInterval(autoSwitchTabs, 3000);
    }

    function stopAutoSwitch() {
        clearInterval(tabInterval);
    }

    // Démarrer l'auto-switch
    if (expertiseTabs.length > 0) {
        startAutoSwitch();

        // Gérer les interactions utilisateur
        const expertiseSection = document.getElementById('expertise-section');
        if (expertiseSection) {
            expertiseSection.addEventListener('mouseenter', stopAutoSwitch);
            expertiseSection.addEventListener('mouseleave', startAutoSwitch);
        }

        // Gérer les clics manuels
        expertiseTabs.forEach((tab, index) => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                currentTabIndex = index;
                switchTab(index);
            });
        });
    }

    // =============================================================================
    // INITIALISATION SWIPER POUR LES PARTENAIRES
    // =============================================================================
    
    if (typeof Swiper !== 'undefined') {
        new Swiper('.mySwiper', {
            slidesPerView: 5,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            speed: 1000,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 35,
                },
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 40,
                }
            },
        });
    }

    // =============================================================================
    // GESTION DES PERFORMANCES
    // =============================================================================
    
    // Lazy loading des images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
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
    // GESTION DES ERREURS
    // =============================================================================
    
    window.addEventListener('error', function(e) {
        console.error('Erreur détectée:', e.error);
        // Ici vous pouvez ajouter un système de reporting d'erreurs
    });

    // =============================================================================
    // ACCESSIBILITÉ
    // =============================================================================
    
    // Gestion du focus pour les éléments interactifs
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });

    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });

    // =============================================================================
    // OPTIMISATIONS MOBILE
    // =============================================================================
    
    // Désactiver les animations sur mobile pour les performances
    if (window.innerWidth < 768) {
        document.querySelectorAll('.animate-item').forEach(item => {
            item.style.transition = 'none';
        });
    }

    // Gestion de l'orientation
    window.addEventListener('orientationchange', function() {
        setTimeout(resizeCanvas, 100);
    });

    // =============================================================================
    // MÉTRIQUES DE PERFORMANCE
    // =============================================================================
    
    // Mesurer le temps de chargement
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        console.log(`Page chargée en ${loadTime.toFixed(2)}ms`);
        
        // Ici vous pouvez envoyer les métriques à votre service d'analytics
    });

    // =============================================================================
    // NOTIFICATIONS ET FEEDBACK
    // =============================================================================
    
    // Fonction pour afficher des notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideInNotification 0.3s ease-out reverse';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 3000);
    }
    
    // Make showNotification available globally
    window.showNotification = showNotification;

    // Feedback sur les interactions
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });

    // =============================================================================
    // NETTOYAGE DES RESSOURCES
    // =============================================================================
    
    window.addEventListener('beforeunload', function() {
        // Nettoyer les intervalles
        if (tabInterval) {
            clearInterval(tabInterval);
        }
        
        // Nettoyer les observateurs
        if (observer) {
            observer.disconnect();
        }
        
        if (counterObserver) {
            counterObserver.disconnect();
        }
    });

    // =============================================================================
    // INITIALISATION TERMINÉE
    // =============================================================================
    
    console.log('BrainGenTechnology - Page d\'accueil initialisée avec succès');
    
    // Émettre un événement personnalisé pour signaler que la page est prête
    document.dispatchEvent(new CustomEvent('brainPageReady', {
        detail: {
            timestamp: new Date().toISOString(),
            page: 'index'
        }
    }));
});

// =============================================================================
// FONCTIONS UTILITAIRES GLOBALES
// =============================================================================

/**
 * Fonction pour scroller vers un élément
 * @param {string} selector - Sélecteur CSS de l'élément
 * @param {number} offset - Décalage optionnel
 */
function scrollToElement(selector, offset = 0) {
    const element = document.querySelector(selector);
    if (element) {
        const elementPosition = element.offsetTop - offset;
        window.scrollTo({
            top: elementPosition,
            behavior: 'smooth'
        });
    }
}

/**
 * Fonction pour détecter si un élément est visible
 * @param {Element} element - L'élément à vérifier
 * @returns {boolean}
 */
function isElementVisible(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Fonction pour throttler les appels de fonction
 * @param {Function} func - Fonction à throttler
 * @param {number} delay - Délai en millisecondes
 * @returns {Function}
 */
function throttle(func, delay) {
    let timeoutId;
    let lastExecTime = 0;
    return function (...args) {
        const currentTime = Date.now();
        
        if (currentTime - lastExecTime > delay) {
            func.apply(this, args);
            lastExecTime = currentTime;
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(this, args);
                lastExecTime = Date.now();
            }, delay - (currentTime - lastExecTime));
        }
    };
}

// =============================================================================
// ULTRA MODERN HERO SECTION - BRAIN THEME
// =============================================================================

// Neural Network Canvas Animation for Ultra Hero
function initUltraNeuralCanvas() {
    const canvas = document.getElementById('neural-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = canvas.offsetWidth;
    let height = canvas.offsetHeight;
    
    canvas.width = width;
    canvas.height = height;

    // Brain logo colors
    const colors = {
        primary: '#3b82f6',
        secondary: '#6366f1',
        tertiary: '#8b5cf6'
    };

    const nodeCount = Math.floor((width * height) / 8000) + 25;
    const nodes = [];

    // Initialize nodes
    for (let i = 0; i < nodeCount; i++) {
        nodes.push({
            x: Math.random() * width,
            y: Math.random() * height,
            vx: (Math.random() - 0.5) * 0.8,
            vy: (Math.random() - 0.5) * 0.8,
            r: Math.random() * 3 + 2,
            color: [colors.primary, colors.secondary, colors.tertiary][Math.floor(Math.random() * 3)]
        });
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Draw connections
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const dx = nodes[i].x - nodes[j].x;
                const dy = nodes[i].y - nodes[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < 150) {
                    ctx.save();
                    ctx.globalAlpha = 0.2 * (1 - dist / 150);
                    ctx.strokeStyle = colors.primary;
                    ctx.lineWidth = 1.5;
                    ctx.beginPath();
                    ctx.moveTo(nodes[i].x, nodes[i].y);
                    ctx.lineTo(nodes[j].x, nodes[j].y);
                    ctx.stroke();
                    ctx.restore();
                }
            }
        }

        // Draw nodes
        nodes.forEach(node => {
            ctx.save();
            ctx.beginPath();
            ctx.arc(node.x, node.y, node.r, 0, Math.PI * 2);
            
            // Create gradient for each node
            const gradient = ctx.createRadialGradient(node.x, node.y, 0, node.x, node.y, node.r);
            gradient.addColorStop(0, node.color + '80');
            gradient.addColorStop(1, node.color + '20');
            
            ctx.fillStyle = gradient;
            ctx.shadowColor = node.color;
            ctx.shadowBlur = 15;
            ctx.fill();
            ctx.restore();

            // Move nodes
            node.x += node.vx;
            node.y += node.vy;

            // Bounce off edges
            if (node.x < 0 || node.x > width) node.vx *= -1;
            if (node.y < 0 || node.y > height) node.vy *= -1;
        });

        requestAnimationFrame(animate);
    }

    animate();

    // Responsive resize
    window.addEventListener('resize', () => {
        width = canvas.offsetWidth;
        height = canvas.offsetHeight;
        canvas.width = width;
        canvas.height = height;
    });
}

// Animated Counter for Stats
function initUltraCounters() {
    const statNumbers = document.querySelectorAll('.stat-number[data-target]');
    
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const targetValue = parseFloat(target.getAttribute('data-target'));
                animateCounter(target, targetValue);
                observer.unobserve(target);
            }
        });
    }, observerOptions);

    statNumbers.forEach(stat => observer.observe(stat));
}

function animateCounter(element, targetValue) {
    const duration = 2000;
    const startTime = performance.now();
    const startValue = 0;
    const suffix = targetValue % 1 === 0 ? '' : '%';

    function updateCounter(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // Easing function for smooth animation
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        const currentValue = startValue + (targetValue - startValue) * easeOutQuart;
        
        element.textContent = suffix === '%' ? 
            currentValue.toFixed(1) + suffix : 
            Math.floor(currentValue) + suffix;

        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        }
    }

    requestAnimationFrame(updateCounter);
}

// Text Reveal Animation
function initTextReveal() {
    const textElements = document.querySelectorAll('.text-reveal');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, { threshold: 0.1 });

    textElements.forEach(element => {
        element.style.animationPlayState = 'paused';
        observer.observe(element);
    });
}

// Initialize Ultra Hero when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize existing neural network
    if (typeof ParticleNetwork === 'function') {
        ParticleNetwork('neural-network-canvas');
    }
    
    // Initialize ultra neural canvas
    initUltraNeuralCanvas();
    
    // Initialize counters
    initUltraCounters();
    
    // Initialize text reveal
    initTextReveal();
    
    // Add smooth scroll for anchor links
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
});

// Enhanced hover effects for stat cards
document.addEventListener('DOMContentLoaded', function() {
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Parallax effect for hero visual
document.addEventListener('DOMContentLoaded', function() {
    const heroVisual = document.querySelector('.hero-visual');
    const mainImage = document.querySelector('.main-image');
    
    if (heroVisual && mainImage) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            mainImage.style.transform = `translateY(${rate}px)`;
        });
    }
});