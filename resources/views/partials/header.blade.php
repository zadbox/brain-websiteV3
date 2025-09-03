<!-- Normalized Header for BRAIN Technology -->
<header class="header-ultra" id="main-header">
    <!-- Neural Network Background Effect -->
    <div class="header-bg-effect">
        <div class="neural-particles"></div>
        <div class="holographic-overlay"></div>
    </div>
    
    <div class="container">
        <div class="header-content">
            
            <!-- Logo with Animation Support -->
            <div class="logo-ultra">
                <a href="{{ url('/') }}" class="logo-link-ultra" aria-label="BRAIN Technology Homepage">
                    <div id="header-animated-logo" class="logo-container animated-logo-container">
                        <!-- BRAIN Logo Image -->
                        <div class="brain-logo-simple">
                            <img src="{{ asset('assets/logo-b-white.png') }}" alt="BRAIN Technology" class="logo-image-simple">
                        </div>
                        <div class="logo-glow-effect"></div>
                        <div class="logo-hologram-effect"></div>
                    </div>
                </a>
            </div>
            
            <!-- Navigation with Advanced Hover Effects -->
            <nav class="nav-ultra">
                <ul class="nav-list">
                    
                    <!-- Solutions Dropdown -->
                    <li class="nk-menu-item dropdown-item">
                        <a href="#" class="nav-link dropdown-trigger" data-dropdown="solutions">
                            <span class="link-text">Solutions</span>
                            <span class="link-indicator"></span>
                            <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </a>
                        
                        <!-- Solutions Dropdown Menu -->
                        <div class="dropdown-menu solutions-dropdown" id="solutions-dropdown">
                            <div class="dropdown-content">
                                <div class="dropdown-grid">
                                    <a href="{{ url('/solutions/brain-invest') }}" class="dropdown-item-card">
                                        <div class="card-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83M22 12A10 10 0 0 0 12 2v10z"/>
                                            </svg>
                                        </div>
                                        <div class="card-content">
                                            <h4>Brain Invest</h4>
                                            <p>AI-powered investment analysis and portfolio optimization</p>
                                        </div>
                                        <div class="card-glow"></div>
                                    </a>
                                    
                                    <a href="{{ url('/solutions/brain-rh') }}" class="dropdown-item-card">
                                        <div class="card-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/>
                                            </svg>
                                        </div>
                                        <div class="card-content">
                                            <h4>Brain RH</h4>
                                            <p>Intelligent HR management and talent optimization</p>
                                        </div>
                                        <div class="card-glow"></div>
                                    </a>
                                    
                                    <a href="{{ url('/solutions/brain-assistant') }}" class="dropdown-item-card">
                                        <div class="card-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="card-content">
                                            <h4>Brain Assistant</h4>
                                            <p>Conversational AI for business automation</p>
                                        </div>
                                        <div class="card-glow"></div>
                                    </a>
                                </div>
                                <div class="dropdown-footer">
                                    <a href="{{ url('/solutions') }}" class="view-all-link">
                                        View all solutions
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Other Navigation Links -->
                    <li class="nk-menu-item">
                        <a href="{{ url('/technology') }}" class="nav-link {{ request()->is('technology') ? 'active' : '' }}">
                            <span class="link-text">Technology</span>
                            <span class="link-indicator"></span>
                        </a>
                    </li>
                    
                    <li class="nk-menu-item">
                        <a href="{{ url('/industries') }}" class="nav-link {{ request()->is('industries') ? 'active' : '' }}">
                            <span class="link-text">Industries</span>
                            <span class="link-indicator"></span>
                        </a>
                    </li>
                    
                    <li class="nk-menu-item">
                        <a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                            <span class="link-text">About</span>
                            <span class="link-indicator"></span>
                        </a>
                    </li>
                    
                    <li class="nk-menu-item">
                        <a href="{{ url('/resources') }}" class="nav-link {{ request()->is('resources') ? 'active' : '' }}">
                            <span class="link-text">Resources</span>
                            <span class="link-indicator"></span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
            
            <!-- Action Buttons -->
            <div class="header-actions">
                
                <!-- CTA Button -->
                <a href="{{ url('/contact') }}" class="cta-button-ultra">
                    <span class="button-text">Get Started</span>
                    <div class="button-glow"></div>
                    <div class="button-particles"></div>
                    <svg class="button-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                
                <!-- Demo Button -->
                <a href="{{ url('/demo') }}" class="demo-button-ultra">
                    <span class="button-text">Request Demo</span>
                    <div class="button-border"></div>
                </a>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobile-menu-button" aria-label="Toggle mobile menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-content">
                <div class="mobile-nav">
                    <div class="mobile-section">
                        <h3 class="mobile-section-title">Solutions</h3>
                        <div class="mobile-links">
                            <a href="{{ url('/solutions/brain-invest') }}" class="mobile-link">Brain Invest</a>
                            <a href="{{ url('/solutions/brain-rh') }}" class="mobile-link">Brain RH</a>
                            <a href="{{ url('/solutions/brain-assistant') }}" class="mobile-link">Brain Assistant</a>
                        </div>
                    </div>
                    
                    <div class="mobile-section">
                        <h3 class="mobile-section-title">Navigation</h3>
                        <div class="mobile-links">
                            <a href="{{ url('/technology') }}" class="mobile-link">Technology</a>
                            <a href="{{ url('/industries') }}" class="mobile-link">Industries</a>
                            <a href="{{ url('/about') }}" class="mobile-link">About</a>
                            <a href="{{ url('/resources') }}" class="mobile-link">Resources</a>
                        </div>
                    </div>
                </div>
                
                <div class="mobile-actions">
                    <a href="{{ url('/demo') }}" class="mobile-cta secondary">Request Demo</a>
                    <a href="{{ url('/contact') }}" class="mobile-cta primary">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Include Animated Logo Assets -->
<link rel="stylesheet" href="{{ asset('assets/css/animated-logo.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/video-logo.css') }}">

<!-- Header JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize motion path animation
    initHeaderMotionPath();
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            
            // Toggle states
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('active');
            document.body.classList.toggle('mobile-menu-open');
            
            // Animate hamburger
            mobileMenuButton.classList.toggle('active');
        });
    }
    
    // Dropdown functionality
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            const isOpen = dropdown.classList.contains('active');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('active');
            });
            
            // Toggle current dropdown
            if (!isOpen) {
                dropdown.classList.add('active');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-item')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('active');
            });
        }
    });
    
    // Header scroll effect
    const header = document.getElementById('main-header');
    let lastScrollY = window.scrollY;
    
    function updateHeader() {
        const scrollY = window.scrollY;
        
        if (scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScrollY = scrollY;
    }
    
    // Throttled scroll listener
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
            setTimeout(() => { ticking = false; }, 10);
        }
    });
    
    // Logo animation on load
    const logo = document.querySelector('.logo-ultra');
    if (logo) {
        setTimeout(() => {
            logo.classList.add('loaded');
        }, 500);
    }
    
    // Particle effect for CTA button
    const ctaButton = document.querySelector('.cta-button-ultra');
    if (ctaButton) {
        ctaButton.addEventListener('mouseenter', function() {
            this.classList.add('particles-active');
        });
        
        ctaButton.addEventListener('mouseleave', function() {
            this.classList.remove('particles-active');
        });
    }
    
    // Header BRAIN Logo Animation (based on your example)
    function initHeaderMotionPath() {
        const container = document.getElementById('header-animated-logo');
        if (!container) return;
        
        // Load anime.js if not already loaded
        if (typeof anime === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js';
            script.onload = () => {
                startHeaderBrainAnimation();
            };
            document.head.appendChild(script);
        } else {
            startHeaderBrainAnimation();
        }
        
        function startHeaderBrainAnimation() {
            const letters = container.querySelectorAll('.brain-letter');
            const subtitle = container.querySelector('.brain-subtitle');
            
            // Slow motion sequential letter animation
            anime({
                targets: letters,
                opacity: [0, 1],
                scale: [0.3, 1.2, 1],
                translateY: [50, -10, 0],
                rotate: [15, -5, 0],
                easing: 'easeOutElastic(1, .8)',
                duration: 1200,
                delay: (el, i) => i * 400, // Much slower sequential timing
                complete: function() {
                    // Add lit class for glow effect with individual timing
                    letters.forEach((letter, index) => {
                        setTimeout(() => {
                            letter.classList.add('lit');
                        }, index * 100);
                    });
                }
            });

            // Slower fade in subtitle with bounce
            if (subtitle) {
                anime({
                    targets: subtitle,
                    opacity: [0, 1],
                    translateY: [30, 0],
                    scale: [0.8, 1.1, 1],
                    easing: 'easeOutElastic(1, .6)',
                    duration: 1500,
                    delay: 2400 // After all letters finish
                });
            }
        }
    }
});
</script>

<!-- Animated Logo Assets -->
<script>
// Preload critical animation assets for better performance
document.addEventListener('DOMContentLoaded', function() {
    // Only preload if not on reduced motion
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const preloadLinks = [
            '{{ asset("assets/videos/brain-logo-1.mp4") }}' // Video
            // Add Lottie JSON path when available
        ];
        
        preloadLinks.forEach(href => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = href.endsWith('.mp4') ? 'video' : 'fetch';
            link.href = href;
            if (!href.endsWith('.mp4')) {
                link.crossOrigin = 'anonymous';
            }
            document.head.appendChild(link);
        });
    }
});
</script>

<!-- Normalized Header Styles -->
<style>
/* BRAIN Simple Logo Styles */
.brain-logo-simple {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.logo-image-simple {
    height: 65px;
    width: 65px;
    object-fit: cover;
    border-radius: 50%;
    filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.4));
    transition: all 0.3s ease;
}

.logo-image-simple:hover {
    filter: drop-shadow(0 0 15px rgba(0, 186, 255, 0.5));
    transform: scale(1.05);
}

.logo-text-simple {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.main-text-simple {
    font-family: 'Arial', sans-serif;
    font-size: 2rem;
    font-weight: 700;
    color: white;
    letter-spacing: 0.1rem;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    line-height: 1;
}

.subtitle-simple {
    font-family: 'Arial', sans-serif;
    font-size: 0.5rem;
    font-weight: 400;
    letter-spacing: 0.2rem;
    color: #6baed6;
    text-transform: uppercase;
    margin-top: 0.25rem;
}

/* Header BRAIN Text Logo Animation Styles (kept for compatibility) */
.brain-text-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.brain-letters {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-family: 'Arial', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    line-height: 1;
}

.brain-letter {
    transition: all 0.3s ease;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    opacity: 0;
}

.brain-letter.b-letter,
.brain-letter.n-letter {
    color: white;
}

.brain-letter.r-letter,
.brain-letter.a-letter,
.brain-letter.i-letter {
    color: #6baed6;
}

.brain-letter.lit {
    opacity: 1;
    filter: drop-shadow(0 0 8px currentColor);
}

.brain-subtitle {
    font-family: 'Arial', sans-serif;
    font-size: 0.65rem;
    font-weight: 400;
    letter-spacing: 0.25rem;
    color: #6baed6;
    text-transform: uppercase;
    opacity: 0;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .logo-image-simple {
        height: 50px;
        width: 50px;
    }
}

/* Normalized Header Base Styles - Using Index Page Dimensions */
.header-ultra {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: rgba(10, 10, 10, 0.9);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: 'Sora', 'Inter', system-ui, sans-serif;
    height: 80px; /* Fixed height from index page */
}

.header-ultra.scrolled {
    background: rgba(15, 15, 15, 0.95);
    border-bottom-color: rgba(255, 255, 255, 0.15);
}

/* Background Effects */
.header-bg-effect {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.neural-particles {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(0, 186, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    animation: particleFloat 20s ease-in-out infinite;
}

.holographic-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.02) 50%, transparent 70%);
    animation: holographicShift 8s ease-in-out infinite;
}

/* Container and Layout - Using Index Page Dimensions */
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 80px; /* Fixed height from index page */
    position: relative;
    padding: 0 1rem; /* Consistent padding from index page */
    gap: 1rem; /* Consistent gap between elements */
}

/* Logo Styles - Using Index Page Dimensions */
.logo-ultra {
    position: relative;
    z-index: 10;
    height: 40px; /* Match button height for perfect alignment */
    display: flex;
    align-items: center;
    flex-shrink: 0; /* Prevent logo from shrinking */
}

.logo-link-ultra {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    height: 100%; /* Ensure full height */
}

.logo-container {
    position: relative;
    display: flex;
    align-items: center;
    height: 100%;
}

.logo-image {
    display: block;
    filter: drop-shadow(0 0 20px rgba(0, 186, 255, 0.3));
    transition: all 0.3s ease;
    height: 32px; /* Fixed height for consistent sizing */
    width: auto;
    max-width: 180px;
}

.logo-glow-effect {
    position: absolute;
    inset: -10px;
    background: radial-gradient(circle, rgba(0, 186, 255, 0.2) 0%, transparent 70%);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.logo-hologram-effect {
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.logo-link-ultra:hover .logo-image {
    filter: drop-shadow(0 0 30px rgba(0, 186, 255, 0.5));
    transform: scale(1.05);
}

.logo-link-ultra:hover .logo-glow-effect {
    opacity: 1;
}

.logo-link-ultra:hover .logo-hologram-effect {
    opacity: 1;
    animation: holographicScan 2s ease-in-out infinite;
}

.logo-subtitle {
    margin-left: 0.75rem; /* Slightly reduced margin for better spacing */
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
}

.subtitle-text {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6366f1;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.subtitle-line {
    width: 20px;
    height: 2px;
    background: linear-gradient(90deg, #00baff, #6366f1);
    margin-top: 2px;
    border-radius: 1px;
}

/* Navigation Styles - Using Index Page Dimensions */
.nav-ultra {
    display: flex;
    align-items: center;
    height: 40px; /* Match button height for perfect alignment */
    margin: 0 auto; /* Center navigation in available space */
    flex: 1; /* Take available space */
    justify-content: center; /* Center the navigation items */
}

.nav-list {
    display: flex;
    align-items: center;
    gap: 0.25rem; /* Reduced gap for tighter spacing */
    list-style: none;
    margin: 0;
    padding: 0;
    height: 100%;
}

.nk-menu-item {
    position: relative;
    display: flex;
    align-items: center;
    height: 100%;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem; /* Same padding as index page navigation */
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    height: 40px; /* Consistent height for navigation items */
}

.nav-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 186, 255, 0.1), rgba(99, 102, 241, 0.1));
    border-radius: 12px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.nav-link:hover::before {
    opacity: 1;
}

.nav-link:hover {
    color: white;
    transform: translateY(-2px);
}

.link-text {
    position: relative;
    z-index: 2;
}

.link-indicator {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #00baff, #6366f1);
    border-radius: 1px;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover .link-indicator {
    width: 80%;
}

.nav-link.active .link-indicator {
    width: 80%;
}

/* Dropdown Styles */
.dropdown-arrow {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.dropdown-trigger:hover .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 400px;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
}

.dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-content {
    padding: 1.5rem;
}

.dropdown-grid {
    display: grid;
    gap: 1rem;
}

.dropdown-item-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.dropdown-item-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 186, 255, 0.1), rgba(99, 102, 241, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.dropdown-item-card:hover::before {
    opacity: 1;
}

.dropdown-item-card:hover {
    transform: translateY(-2px);
    border-color: rgba(0, 186, 255, 0.3);
}

.card-icon {
    width: 40px;
    height: 40px;
    background: rgba(0, 186, 255, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: #00baff;
}

.card-content h4 {
    font-weight: 600;
    color: white;
    margin: 0 0 0.25rem 0;
    font-size: 0.95rem;
}

.card-content p {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.4;
}

.dropdown-footer {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.view-all-link {
    display: flex;
    align-items: center;
    color: #00baff;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.view-all-link:hover {
    color: #6366f1;
}

.view-all-link svg {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.view-all-link:hover svg {
    transform: translateX(4px);
}

/* Action Buttons - Using Index Page Dimensions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem; /* Slightly smaller gap to match index page */
    height: 40px; /* Match button height for perfect alignment */
    flex-shrink: 0; /* Prevent buttons from shrinking */
    margin-left: auto; /* Push to the right */
}

/* CTA Button - Using Index Page Dimensions */
.cta-button-ultra {
    position: relative;
    display: flex;
    align-items: center;
    padding: 0.625rem 1.25rem; /* Smaller padding to match index page exactly */
    background: linear-gradient(135deg, #00baff, #6366f1);
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem; /* Slightly smaller font size */
    border-radius: 8px; /* Smaller border radius */
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 186, 255, 0.3);
    height: 40px; /* Fixed height to match index page buttons exactly */
    line-height: 1;
}

.cta-button-ultra::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.cta-button-ultra:hover::before {
    opacity: 1;
}

.cta-button-ultra:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 186, 255, 0.4);
}

.button-text {
    position: relative;
    z-index: 2;
}

.button-glow {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.cta-button-ultra:hover .button-glow {
    opacity: 1;
}

.button-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.button-particles::before,
.button-particles::after {
    content: '';
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s ease;
}

.button-particles::before {
    top: 20%;
    left: 20%;
}

.button-particles::after {
    bottom: 20%;
    right: 20%;
}

.cta-button-ultra.particles-active .button-particles::before {
    opacity: 1;
    animation: particleFloat1 1s ease-out;
}

.cta-button-ultra.particles-active .button-particles::after {
    opacity: 1;
    animation: particleFloat2 1s ease-out 0.2s;
}

.button-arrow {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.cta-button-ultra:hover .button-arrow {
    transform: translateX(4px);
}

/* Demo Button - Using Index Page Dimensions */
.demo-button-ultra {
    position: relative;
    display: flex;
    align-items: center;
    padding: 0.625rem 1.25rem; /* Smaller padding to match index page exactly */
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem; /* Slightly smaller font size */
    border-radius: 8px; /* Smaller border radius */
    transition: all 0.3s ease;
    overflow: hidden;
    height: 40px; /* Fixed height to match index page buttons exactly */
    line-height: 1;
}

.button-border {
    position: absolute;
    inset: 0;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px; /* Match the button border radius */
    transition: all 0.3s ease;
}

.demo-button-ultra::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 186, 255, 0.1), rgba(99, 102, 241, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 8px; /* Match the button border radius */
}

.demo-button-ultra:hover::before {
    opacity: 1;
}

.demo-button-ultra:hover {
    color: white;
    transform: translateY(-2px);
}

.demo-button-ultra:hover .button-border {
    border-color: rgba(0, 186, 255, 0.5);
    box-shadow: 0 0 20px rgba(0, 186, 255, 0.2);
    border-radius: 8px; /* Match the button border radius */
}

/* Mobile Menu Toggle - Using Index Page Dimensions */
.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 40px; /* Match button dimensions from index page */
    height: 40px; /* Match button dimensions from index page */
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px; /* Match button border radius */
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    flex-shrink: 0; /* Prevent from shrinking */
    margin-left: 0.75rem; /* Space from buttons */
}

.mobile-menu-toggle::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 186, 255, 0.1), rgba(99, 102, 241, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 12px;
}

.mobile-menu-toggle:hover::before {
    opacity: 1;
}

.hamburger-line {
    width: 20px;
    height: 2px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 1px;
    transition: all 0.3s ease;
    margin: 2px 0;
}

.mobile-menu-toggle.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.mobile-menu-toggle.active .hamburger-line:nth-child(2) {
    opacity: 0;
}

.mobile-menu-toggle.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* Mobile Menu - Using Index Page Dimensions */
.mobile-menu {
    position: fixed;
    top: 80px; /* Match header height from index page */
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.98);
    backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    transform: translateY(-100%);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 999;
}

.mobile-menu.active {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.mobile-menu-content {
    padding: 2rem;
}

.mobile-nav {
    margin-bottom: 2rem;
}

.mobile-section {
    margin-bottom: 2rem;
}

.mobile-section-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.5);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}

.mobile-links {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.mobile-link {
    display: block;
    padding: 0.75rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.mobile-link:hover {
    color: white;
    background: rgba(0, 186, 255, 0.1);
    border-color: rgba(0, 186, 255, 0.3);
}

.mobile-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.mobile-cta {
    display: block;
    padding: 1rem;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.mobile-cta.secondary {
    color: rgba(255, 255, 255, 0.8);
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.mobile-cta.primary {
    color: white;
    background: linear-gradient(135deg, #00baff, #6366f1);
    box-shadow: 0 4px 20px rgba(0, 186, 255, 0.3);
}

.mobile-cta:hover {
    transform: translateY(-2px);
}

/* Animations */
@keyframes particleFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

@keyframes holographicShift {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(20px); }
}

@keyframes holographicScan {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

@keyframes particleFloat1 {
    0% { transform: translate(0, 0); opacity: 1; }
    100% { transform: translate(-20px, -20px); opacity: 0; }
}

@keyframes particleFloat2 {
    0% { transform: translate(0, 0); opacity: 1; }
    100% { transform: translate(20px, -20px); opacity: 0; }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .nav-ultra {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: flex;
    }
    
    .header-actions {
        gap: 0.5rem;
    }
    
    .demo-button-ultra {
        display: none;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .header-content {
        height: 70px; /* Slightly smaller on mobile like index page */
        gap: 0.5rem; /* Smaller gap on mobile */
    }
    
    .logo-image {
        width: 120px; /* Smaller logo on mobile */
        height: 28px; /* Proportional height */
    }
    
    .logo-subtitle {
        display: none;
    }
    
    .nav-ultra {
        display: none; /* Hide navigation on mobile */
    }
    
    .cta-button-ultra {
        padding: 0.5rem 1rem; /* Smaller padding on mobile */
        font-size: 0.8rem;
        height: 36px; /* Smaller height on mobile */
    }
    
    .demo-button-ultra {
        padding: 0.5rem 1rem; /* Smaller padding on mobile */
        font-size: 0.8rem;
        height: 36px; /* Smaller height on mobile */
    }
    
    .mobile-menu-toggle {
        width: 36px; /* Smaller on mobile */
        height: 36px;
        margin-left: 0.5rem; /* Smaller margin on mobile */
    }
}

@media (max-width: 480px) {
    .header-content {
        gap: 0.25rem; /* Very small gap on tiny screens */
    }
    
    .header-actions {
        gap: 0.25rem;
    }
    
    .logo-image {
        width: 100px; /* Even smaller logo on very small screens */
        height: 24px; /* Proportional height */
    }
    
    .cta-button-ultra {
        padding: 0.375rem 0.75rem; /* Even smaller padding on very small screens */
        font-size: 0.75rem;
        height: 32px; /* Even smaller height on very small screens */
    }
    
    .demo-button-ultra {
        padding: 0.375rem 0.75rem; /* Even smaller padding on very small screens */
        font-size: 0.75rem;
        height: 32px; /* Even smaller height on very small screens */
    }
    
    .mobile-menu-toggle {
        width: 32px; /* Even smaller on very small screens */
        height: 32px;
        margin-left: 0.25rem; /* Very small margin */
    }
    
    .button-arrow {
        display: none;
    }
}

/* Dark mode support */
.dark-mode .header-ultra {
    background: rgba(0, 0, 0, 0.9);
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Focus styles */
button:focus-visible,
a:focus-visible {
    outline: 2px solid #00baff;
    outline-offset: 2px;
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .header-ultra {
        background: rgba(0, 0, 0, 0.95);
        border-bottom-color: rgba(255, 255, 255, 0.3);
    }
    
    .nav-link {
        color: rgba(255, 255, 255, 0.9);
    }
}
</style>