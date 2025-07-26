@extends('layouts.app')

@section('title', 'BrainGen Technology - AI & Blockchain Solutions')

@section('content')

<!-- Modern Dark Theme Landing Page -->
<main class="modern-landing">
    
    <!-- Neural Network Background -->
    <canvas id="neural-network-canvas" class="neural-network-canvas"></canvas>
    
    <!-- Gradient Background Overlay -->
    <div class="gradient-overlay"></div>
    
    <!-- Hero Section Ultra -->
    <section class="hero-section-ultra">
        <div class="hero-background-ultra">
            <canvas id="neural-canvas" class="neural-layer" width="569" height="1953"></canvas>
            <div class="neural-network-grid"></div>
        </div>
        <div class="hero-content-ultra">
            <div class="container">
                <div class="hero-grid">
                    <!-- Main Content -->
                    <div class="hero-main">
                        <div class="innovation-badge">
                            <div class="badge-glow"></div>
                            <div class="badge-content">
                                <svg class="badge-icon" width="20" height="20" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                                </svg>
                                <span class="badge-text">BRAIN TECHNOLOGY</span>
                                <div class="badge-pulse"></div>
                            </div>
                        </div>
                        <h1 class="hero-title-ultra">
                            <span class="title-line">
                                <span class="text-reveal">POWER</span>
                            </span>
                            <span class="title-line highlight">
                                <span class="text-reveal">YOUR FUTURE</span>
                                <div class="highlight-glow"></div>
                            </span>
                            <span class="title-line">
                                <span class="text-reveal">WITH AI</span>
                            </span>
                        </h1>
                        <p class="hero-subtitle-ultra">
                            Transform your business with cutting-edge 
                            <span class="highlight-text">AI</span> and 
                            <span class="highlight-text">automation</span> 
                            solutions designed for the modern enterprise.
                        </p>
                        <div class="hero-stats-ultra">
                            <div class="stat-card" data-stat="200">
                                <div class="stat-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number" data-target="200">200</span>
                                    <span class="stat-label">Projects Delivered</span>
                                </div>
                                <div class="stat-glow"></div>
                            </div>
                            <div class="stat-card" data-stat="50">
                                <div class="stat-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22,4 12,14.01 9,11.01"></polyline>
                                    </svg>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number" data-target="50">50</span>
                                    <span class="stat-label">Happy Clients</span>
                                </div>
                                <div class="stat-glow"></div>
                            </div>
                            <div class="stat-card" data-stat="99">
                                <div class="stat-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12,6 12,12 16,14"></polyline>
                                    </svg>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number" data-target="99">99</span>
                                    <span class="stat-label">% Success Rate</span>
                                </div>
                                <div class="stat-glow"></div>
                            </div>
                        </div>
                        <div class="hero-cta-ultra">
                            <a href="{{url('/contact')}}" class="btn-primary-ultra">
                                <span class="btn-text">Try it free</span>
                                <div class="btn-glow"></div>
                                <div class="btn-particles"></div>
                                <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <a href="#services" class="btn-secondary-ultra">
                                <span class="btn-text">Explore our services</span>
                                <div class="btn-outline"></div>
                                <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <div class="visual-container">
                            <div class="main-image">
                                <img src="{{asset('images/auto.webp')}}" alt="AI Automation" class="hero-img">
                                <div class="image-overlay"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-modern">
        <div class="container">
            <div class="section-header animate-item">
                <h2 class="section-title">
                    <span class="gradient-text">Cutting-Edge Solutions</span>
                </h2>
                <p class="section-subtitle">
                    We deliver next-generation technology solutions that transform how businesses operate
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card animate-item">
                    <div class="feature-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="feature-title">AI Automation</h3>
                    <p class="feature-description">
                        Intelligent automation that learns and adapts to your business processes
                    </p>
                    <div class="feature-stats">
                        <div class="stat-circle">
                            <div class="stat-value counter" data-target="85">0</div>
                            <div class="stat-text">% Efficiency</div>
                        </div>
                    </div>
                </div>
                
                <div class="feature-card animate-item">
                    <div class="feature-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3 class="feature-title">Blockchain Integration</h3>
                    <p class="feature-description">
                        Secure, transparent, and decentralized solutions for modern enterprises
                    </p>
                    <div class="feature-stats">
                        <div class="stat-circle">
                            <div class="stat-value counter" data-target="99">0</div>
                            <div class="stat-text">% Security</div>
                        </div>
                    </div>
                </div>
                
                <div class="feature-card animate-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Business Intelligence</h3>
                    <p class="feature-description">
                        Data-driven insights that power strategic decision making
                    </p>
                    <div class="feature-stats">
                        <div class="stat-circle">
                            <div class="stat-value counter" data-target="92">0</div>
                            <div class="stat-text">% Growth</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-modern">
        <div class="container">
            <div class="section-header animate-item">
                <h2 class="section-title">
                    <span class="gradient-text">Tailored Solutions</span>
                </h2>
                <p class="section-subtitle">
                    Choose your industry and discover how AI can transform your business
                </p>
            </div>
            
            <div class="industry-selector animate-item">
                <label for="industry-dropdown" class="selector-label">Select your industry</label>
                <div class="dropdown-container">
                    <select id="industry-dropdown" class="industry-dropdown">
                        <option value="">Choose your industry...</option>
                        <option value="technology">Technology</option>
                        <option value="healthcare">Healthcare</option>
                        <option value="finance">Finance</option>
                        <option value="manufacturing">Manufacturing</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="dropdown-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
            
            <div class="services-tabs" id="expertise-tabs">
                <div class="tab-navigation animate-item">
                    <button class="nav-link active" data-bs-target="#ai-tab">
                        <i class="fas fa-brain"></i>
                        <span>AI Solutions</span>
                    </button>
                    <button class="nav-link" data-bs-target="#blockchain-tab">
                        <i class="fas fa-link"></i>
                        <span>Blockchain</span>
                    </button>
                    <button class="nav-link" data-bs-target="#automation-tab">
                        <i class="fas fa-cogs"></i>
                        <span>Automation</span>
                    </button>
                </div>
                
                <div class="tab-content animate-item" id="expertise-section">
                    <div class="tab-panel active show" id="ai-tab">
                        <div class="service-content">
                            <div class="service-visual">
                                <div class="service-image">
                                    <img src="{{asset('images/digital.webp')}}" alt="AI Solutions">
                                </div>
                            </div>
                            <div class="service-details">
                                <h3>Artificial Intelligence Solutions</h3>
                                <p>Transform your business with intelligent automation, machine learning, and predictive analytics.</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-check"></i> Machine Learning Models</li>
                                    <li><i class="fas fa-check"></i> Natural Language Processing</li>
                                    <li><i class="fas fa-check"></i> Computer Vision</li>
                                    <li><i class="fas fa-check"></i> Predictive Analytics</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-panel" id="blockchain-tab">
                        <div class="service-content">
                            <div class="service-visual">
                                <div class="service-image">
                                    <img src="{{asset('images/blockchain.webp')}}" alt="Blockchain Solutions">
                                </div>
                            </div>
                            <div class="service-details">
                                <h3>Blockchain Technology</h3>
                                <p>Secure, transparent, and decentralized solutions for modern business challenges.</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-check"></i> Smart Contracts</li>
                                    <li><i class="fas fa-check"></i> Decentralized Applications</li>
                                    <li><i class="fas fa-check"></i> Digital Identity</li>
                                    <li><i class="fas fa-check"></i> Supply Chain Tracking</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-panel" id="automation-tab">
                        <div class="service-content">
                            <div class="service-visual">
                                <div class="service-image">
                                    <img src="{{asset('images/auto.webp')}}" alt="Automation Solutions">
                                </div>
                            </div>
                            <div class="service-details">
                                <h3>Business Automation</h3>
                                <p>Streamline operations with intelligent automation solutions that scale with your business.</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-check"></i> Process Automation</li>
                                    <li><i class="fas fa-check"></i> Workflow Optimization</li>
                                    <li><i class="fas fa-check"></i> Data Integration</li>
                                    <li><i class="fas fa-check"></i> Real-time Monitoring</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-modern">
        <div class="container">
            <div class="section-header animate-item">
                <h2 class="section-title">
                    <span class="gradient-text">Trusted by Industry Leaders</span>
                </h2>
                <p class="section-subtitle">
                    See what our clients say about working with us
                </p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card animate-item">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "BrainGen transformed our operations with their AI solutions. We've seen a 300% improvement in efficiency."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <div class="author-name">Sarah Johnson</div>
                            <div class="author-role">CTO, TechCorp</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card animate-item">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "The blockchain integration was seamless and has revolutionized our supply chain transparency."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <div class="author-name">Michael Chen</div>
                            <div class="author-role">Operations Director, LogiCorp</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card animate-item">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Outstanding service and cutting-edge technology. BrainGen exceeded all our expectations."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <div class="author-name">Emma Rodriguez</div>
                            <div class="author-role">CEO, InnovateCorp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-modern">
        <div class="container">
            <div class="cta-content animate-item">
                <div class="cta-badge">
                    <span class="badge-text">Ready to Transform?</span>
                </div>
                
                <h2 class="cta-title">
                    <span class="gradient-text">Start Your Digital Revolution</span>
                </h2>
                
                <p class="cta-subtitle">
                    Join hundreds of companies already transforming their business with our AI and blockchain solutions.
                </p>
                
                <div class="cta-actions">
                    <a href="{{url('/contact')}}" class="btn-glow primary large">
                        <span>Get Started Today</span>
                        <i class="fas fa-rocket"></i>
                    </a>
                    <a href="{{url('/a-propos')}}" class="btn-glow secondary large">
                        <span>Schedule a Demo</span>
                    </a>
                </div>
                
                <div class="cta-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Free Consultation</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Custom Solutions</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>24/7 Support</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Glowing Orbs - REMOVED -->
        <!-- Cube and particle animations disabled -->
    </section>

</main>

<!-- Import Font Awesome and Custom Scripts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('assets/css/index-page.css')}}?v={{time()}}">
<script src="{{asset('assets/js/index-page.js')}}?v={{time()}}" defer></script>

@endsection