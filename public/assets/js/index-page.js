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
    
    // Interactive cursor effect for hero background
    const heroBackground = document.querySelector('.hero-background');
    if (heroBackground) {
        document.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const x = (clientX / window.innerWidth) * 100;
            const y = (clientY / window.innerHeight) * 100;
            
            heroBackground.style.background = `
                radial-gradient(circle at ${x}% ${y}%, rgba(88, 101, 242, 0.1) 0%, transparent 50%),
                radial-gradient(circle at ${100-x}% ${100-y}%, rgba(255, 178, 107, 0.05) 0%, transparent 50%)
            `;
        });
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
    // NEURAL NETWORK BACKGROUND - SOBRE ET TECHNIQUE
    // =============================================================================
    
    const canvas = document.getElementById('neural-network-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        
        // Configuration du réseau de neurones
        const config = {
            nodeCount: window.innerWidth < 768 ? 25 : 40,
            connectionDistance: 120,
            nodeSpeed: 0.3,
            nodeSize: 2,
            connectionOpacity: 0.15,
            nodeColor: 'rgba(88, 101, 242, 0.8)',
            connectionColor: 'rgba(88, 101, 242, 0.3)',
            pulseSpeed: 0.002
        };
        
        // Redimensionnement du canvas
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        
        // Classe Node pour les nœuds du réseau
        class NeuralNode {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * config.nodeSpeed;
                this.vy = (Math.random() - 0.5) * config.nodeSpeed;
                this.size = config.nodeSize + Math.random() * 2;
                this.pulse = Math.random() * Math.PI * 2;
                this.connections = [];
            }
            
            update() {
                this.x += this.vx;
                this.y += this.vy;
                
                // Rebond sur les bords
                if (this.x < 0 || this.x > canvas.width) this.vx = -this.vx;
                if (this.y < 0 || this.y > canvas.height) this.vy = -this.vy;
                
                // Mise à jour du pulse
                this.pulse += config.pulseSpeed;
            }
            
            draw() {
                // Dessiner le nœud principal
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = config.nodeColor;
                ctx.fill();
                
                // Effet de pulse subtil
                const pulseIntensity = Math.sin(this.pulse) * 0.5 + 0.5;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size + pulseIntensity, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(88, 101, 242, ${0.1 * pulseIntensity})`;
                ctx.fill();
            }
        }
        
        // Initialisation des nœuds
        const nodes = [];
        for (let i = 0; i < config.nodeCount; i++) {
            nodes.push(new NeuralNode());
        }
        
        // Animation du réseau
        function animateNetwork() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Mise à jour et dessin des nœuds
            nodes.forEach(node => {
                node.update();
                node.draw();
            });
            
            // Dessin des connexions
            for (let i = 0; i < nodes.length; i++) {
                for (let j = i + 1; j < nodes.length; j++) {
                    const dx = nodes[i].x - nodes[j].x;
                    const dy = nodes[i].y - nodes[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < config.connectionDistance) {
                        const opacity = config.connectionOpacity * (1 - distance / config.connectionDistance);
                        
                        // Ligne de connexion
                        ctx.beginPath();
                        ctx.moveTo(nodes[i].x, nodes[i].y);
                        ctx.lineTo(nodes[j].x, nodes[j].y);
                        ctx.strokeStyle = `rgba(88, 101, 242, ${opacity})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                        
                        // Animation de pulse le long de la ligne
                        const pulsePosition = (Date.now() * 0.001) % 1;
                        const pulseX = nodes[i].x + (nodes[j].x - nodes[i].x) * pulsePosition;
                        const pulseY = nodes[i].y + (nodes[j].y - nodes[i].y) * pulsePosition;
                        
                        ctx.beginPath();
                        ctx.arc(pulseX, pulseY, 1, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(88, 101, 242, ${opacity * 2})`;
                        ctx.fill();
                    }
                }
            }
            
            requestAnimationFrame(animateNetwork);
        }
        
        // Démarrer l'animation si les animations ne sont pas réduites
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            animateNetwork();
        }
    }
    
    // Interaction avec l'arrière-plan héros
    const heroBackground = document.querySelector('.hero-background');
    if (heroBackground) {
        document.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const x = (clientX / window.innerWidth) * 100;
            const y = (clientY / window.innerHeight) * 100;
            
            heroBackground.style.background = `
                radial-gradient(circle at ${x}% ${y}%, rgba(88, 101, 242, 0.1) 0%, transparent 50%),
                radial-gradient(circle at ${100-x}% ${100-y}%, rgba(255, 178, 107, 0.05) 0%, transparent 50%)
            `;
        });
    }

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