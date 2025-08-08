@extends('layouts.app')

@section('title', 'BRAIN - Advanced AI & Automation Solutions | Transform Your Business')
@section('meta_description', 'Transform your business with BRAIN\'s cutting-edge AI, automation, and blockchain solutions. Trusted by industry leaders for intelligent automation and digital transformation.')

@section('content')

<!-- Modern Professional Homepage -->
<main class="homepage-main">
    
    <!-- Neural Network Canvas Background -->
    <canvas id="neural-canvas"></canvas>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Transform Your Business
                    <span class="gradient-text">With Advanced AI</span>
                    & Intelligent Automation
                </h1>
                
                <p class="hero-description">
                    Unlock the full potential of artificial intelligence with our cutting-edge solutions. 
                    From intelligent automation to blockchain integration, we deliver enterprise-grade 
                    technology that drives real business results.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="500">500</div>
                        <div class="stat-label">+ Projects Delivered</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="98">98</div>
                        <div class="stat-label">% Client Satisfaction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="24">24</div>
                        <div class="stat-label">h/7 Support</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{url('/contact')}}" class="btn-primary">
                        <span>Start Your Transformation</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#solutions" class="btn-secondary">
                        <span>Explore Solutions</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="dashboard-preview">
                    <div class="dashboard-header">
                        <div class="dashboard-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="dashboard-title">BRAIN AI Dashboard</div>
                    </div>
                    <div class="dashboard-content">
                        <div class="metrics-row">
                            <div class="metric-card">
                                <span class="metric-label">AI Efficiency</span>
                                <span class="metric-value">94.7%</span>
                                <span class="metric-trend">↗ +12%</span>
                            </div>
                            <div class="metric-card">
                                <span class="metric-label">Automation Rate</span>
                                <span class="metric-value">87.3%</span>
                                <span class="metric-trend">↗ +8%</span>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="hero-chart" width="400" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span>Advanced Capabilities</span>
                </div>
                <h2 class="section-title">
                    Enterprise-Grade AI Solutions
                    <span class="gradient-text">Built for Modern Business</span>
                </h2>
                <p class="section-description">
                    Harness the power of artificial intelligence with our comprehensive suite of 
                    enterprise solutions designed to accelerate growth and innovation.
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-2.04Z"/>
                            <path d="M14 6.5a2.5 2.5 0 0 1 4.96-.44 2.5 2.5 0 0 1 2.96 3.08 3 3 0 0 1 .34 5.58 2.5 2.5 0 0 1-1.32 4.24 2.5 2.5 0 0 1-4.44 2.04A2.5 2.5 0 0 1 14 17.5Z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">AI & Machine Learning</h3>
                    <p class="feature-description">
                        Advanced neural networks and deep learning models that adapt and evolve 
                        with your business needs, delivering predictive insights and automation.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Predictive Analytics</span>
                        <span class="tag">Neural Networks</span>
                        <span class="tag">Deep Learning</span>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 1v6m0 6v6"/>
                            <path d="m21 12-6-3-6 3-6-3"/>
                            <path d="m3 12 6 3 6-3 6 3"/>
                            <path d="M5.636 5.636 12 12l6.364-6.364"/>
                            <path d="M18.364 18.364 12 12 5.636 5.636"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Intelligent Automation</h3>
                    <p class="feature-description">
                        Streamline operations with smart process automation that reduces costs, 
                        eliminates errors, and accelerates business workflows.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Process Mining</span>
                        <span class="tag">Smart Workflows</span>
                        <span class="tag">24/7 Operation</span>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/>
                            <path d="M12 12h.01"/>
                            <path d="M8 12h.01"/>
                            <path d="M16 12h.01"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Blockchain Integration</h3>
                    <p class="feature-description">
                        Secure, transparent, and immutable solutions that enhance trust, 
                        traceability, and efficiency across your business ecosystem.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Smart Contracts</span>
                        <span class="tag">Digital Identity</span>
                        <span class="tag">Supply Chain</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section class="solutions-section" id="solutions">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    <span>Our Solutions</span>
                </div>
                <h2 class="section-title">
                    Specialized AI Solutions
                    <span class="gradient-text">For Every Industry</span>
                </h2>
                <p class="section-description">
                    Discover our comprehensive suite of AI-powered solutions designed 
                    to meet the unique challenges of your industry.
                </p>
            </div>
            
            <div class="solutions-grid">
                <div class="solution-card">
                    <div class="solution-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                        </svg>
                    </div>
                    <h3 class="solution-title">Brain Invest</h3>
                    <p class="solution-description">
                        AI-powered investment platform with predictive analytics, automated trading, 
                        and intelligent portfolio management for maximum returns.
                    </p>
                    <div class="solution-features">
                        <div class="feature-item">Predictive Market Analysis</div>
                        <div class="feature-item">Automated Risk Management</div>
                        <div class="feature-item">Real-time Trading</div>
                    </div>
                    <a href="{{url('/solutions/brain-invest')}}" class="solution-link">
                        <span>Explore Brain Invest</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="solution-title">Brain RH</h3>
                    <p class="solution-description">
                        Revolutionary HR management system powered by AI for talent acquisition, 
                        performance optimization, and workforce analytics.
                    </p>
                    <div class="solution-features">
                        <div class="feature-item">AI Talent Matching</div>
                        <div class="feature-item">Performance Analytics</div>
                        <div class="feature-item">Workforce Optimization</div>
                    </div>
                    <a href="{{url('/solutions/brain-rh')}}" class="solution-link">
                        <span>Explore Brain RH</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            <path d="M8 9h8"/>
                            <path d="M8 13h6"/>
                        </svg>
                    </div>
                    <h3 class="solution-title">Brain Assistant</h3>
                    <p class="solution-description">
                        Intelligent virtual assistant powered by advanced NLP and machine learning 
                        for enhanced customer service and business automation.
                    </p>
                    <div class="solution-features">
                        <div class="feature-item">Natural Language Processing</div>
                        <div class="feature-item">24/7 Customer Support</div>
                        <div class="feature-item">Multi-channel Integration</div>
                    </div>
                    <a href="{{url('/solutions/brain-assistant')}}" class="solution-link">
                        <span>Explore Brain Assistant</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span>Client Success</span>
                </div>
                <h2 class="section-title">
                    Trusted by Global Leaders
                    <span class="gradient-text">in Digital Innovation</span>
                </h2>
                <p class="section-description">
                    Join thousands of organizations worldwide who trust BRAIN to deliver 
                    transformative AI solutions that drive real business results.
                </p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <p class="testimonial-text">
                        "BRAIN's AI solutions have revolutionized our operations. We achieved 400% ROI within the first year and completely transformed our customer experience."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">SJ</div>
                        <div class="author-info">
                            <div class="author-name">Sarah Johnson</div>
                            <div class="author-role">Chief Technology Officer</div>
                            <div class="author-company">TechnovationCorp</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <p class="testimonial-text">
                        "The blockchain integration transformed our supply chain transparency. We now have real-time visibility and enhanced security across all operations."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">MC</div>
                        <div class="author-info">
                            <div class="author-name">Michael Chen</div>
                            <div class="author-role">Operations Director</div>
                            <div class="author-company">GlobalLogistics Inc.</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <svg class="star" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <p class="testimonial-text">
                        "Exceptional service and innovative technology. BRAIN exceeded our expectations and delivered solutions that scale with our growing business."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">ER</div>
                        <div class="author-info">
                            <div class="author-name">Emma Rodriguez</div>
                            <div class="author-role">Chief Executive Officer</div>
                            <div class="author-company">InnovateNext Ltd.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="section-container">
            <div class="cta-content">
                <h2 class="cta-title">
                    Ready to Transform
                    <span class="gradient-text">Your Business with AI?</span>
                </h2>
                
                <p class="cta-description">
                    Join thousands of forward-thinking companies who have already revolutionized 
                    their operations with BRAIN's intelligent automation and AI solutions.
                </p>
                
                <div class="cta-actions">
                    <a href="{{url('/contact')}}" class="btn-primary">
                        <span>Start Your Transformation</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    
                    <a href="javascript:void(0)" onclick="toggleChatWidget()" class="btn-secondary">
                        <span>Schedule a Demo</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </a>
                </div>
                
                <div class="cta-features">
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <span>Enterprise Security</span>
                    </div>
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20,6 9,17 4,12"/>
                        </svg>
                        <span>Proven Results</span>
                    </div>
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <span>24/7 Expert Support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Modern Stylesheets and Scripts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/index-page.css')}}?v={{time()}}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('assets/js/index-page.js')}}?v={{time()}}" defer></script>

@endsection