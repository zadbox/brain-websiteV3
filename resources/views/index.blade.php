@extends('layouts.app')

@section('title', 'BrainGen Technology - AI & Blockchain Solutions')

@section('content')

<!-- Modern Dark Theme Landing Page -->
<main class="modern-landing">
    
    <!-- Neural Network Background -->
    <canvas id="neural-network-canvas" class="neural-network-canvas"></canvas>
    
    <!-- Gradient Background Overlay -->
    <div class="gradient-overlay"></div>
    
    <!-- Hero Section -->
    <section class="hero-huly">
        <!-- Huly-style Background Animation -->
        <div class="hero-background">
            <!-- Option 1: CSS-only animation (current) -->
            <div class="spatial-light-beam"></div>
            <div class="smoke-effect"></div>
            <div class="particle-field"></div>
            
            <!-- Option 2: Video background (uncomment to use) -->
            <!-- <video class="hero-video" autoplay muted loop playsinline>
                <source src="{{asset('assets/videos/hero-background.mp4')}}" type="video/mp4">
                <source src="{{asset('assets/videos/hero-background.webm')}}" type="video/webm">
            </video> -->
        </div>
        
        <div class="container">
            <div class="hero-content-huly">
                <div class="hero-badge animate-item">
                    <span class="badge-text">🚀 Welcome to the Future</span>
                </div>
                
                <h1 class="hero-title-huly animate-item">
                    <span class="gradient-text-huly">Accelerate your performance</span>
                    <br>
                    <span class="gradient-text-huly">with AI and Automation</span>
                </h1>
                
                <p class="hero-subtitle-huly animate-item">
                    Transform your business with cutting-edge artificial intelligence 
                    and automation solutions designed for the modern enterprise.
                </p>
                
                <div class="hero-actions-huly animate-item">
                    <a href="{{url('/contact')}}" class="btn-huly primary glow-effect">
                        <span>Try it free</span>
                        <div class="btn-glow"></div>
                    </a>
                </div>
                
                <div class="hero-stats-huly animate-item">
                    <div class="stat-item-huly">
                        <div class="stat-number-huly">200+</div>
                        <div class="stat-label-huly">Projects Delivered</div>
                    </div>
                    <div class="stat-item-huly">
                        <div class="stat-number-huly">50+</div>
                        <div class="stat-label-huly">Happy Clients</div>
                    </div>
                    <div class="stat-item-huly">
                        <div class="stat-number-huly">99%</div>
                        <div class="stat-label-huly">Success Rate</div>
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