@extends('layouts.app')

@section('title', 'Industries - AI Solutions for Every Sector | BRAIN Technology')
@section('meta_description', 'Discover how BRAIN Technology transforms industries with AI solutions. Healthcare, finance, retail, manufacturing, and more - tailored AI automation for every sector.')

@section('content')

<!-- Industries Page -->
<main class="industries-main">
    
    <!-- Neural Network Background Canvas -->
    <canvas id="industries-canvas"></canvas>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27,6.96 12,12.01 20.73,6.96"/>
                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                    <span>AI Solutions for Every Industry</span>
                </div>
                
                <h1 class="hero-title">
                    Transforming
                    <span class="gradient-text">Every Industry</span>
                    with Intelligent Automation
                </h1>
                
                <p class="hero-description">
                    From healthcare to finance, retail to manufacturing, BRAIN Technology delivers 
                    tailored AI solutions that revolutionize operations, boost efficiency, and drive 
                    innovation across every sector.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="15">15</div>
                        <div class="stat-label">Industries Served</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="500">500</div>
                        <div class="stat-label">+ Clients Worldwide</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="95">95</div>
                        <div class="stat-label">% Success Rate</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#industries" class="btn-primary">
                        <span>Explore Industries</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#solutions" class="btn-secondary">
                        <span>Industry Solutions</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="industries-showcase">
                    <div class="showcase-header">
                        <div class="showcase-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="showcase-title">Industry Solutions</div>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Active</span>
                        </div>
                    </div>
                    <div class="showcase-content">
                        <div class="industry-grid">
                            <div class="industry-item healthcare">
                                <div class="industry-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                    </svg>
                                </div>
                                <span>Healthcare</span>
                            </div>
                            <div class="industry-item finance">
                                <div class="industry-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                </div>
                                <span>Finance</span>
                            </div>
                            <div class="industry-item retail">
                                <div class="industry-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                        <line x1="3" y1="6" x2="21" y2="6"/>
                                        <path d="M16 10a4 4 0 0 1-8 0"/>
                                    </svg>
                                </div>
                                <span>Retail</span>
                            </div>
                            <div class="industry-item manufacturing">
                                <div class="industry-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                    </svg>
                                </div>
                                <span>Manufacturing</span>
                            </div>
                        </div>
                        <div class="showcase-stats">
                            <div class="stat">
                                <span class="stat-label">Active Solutions</span>
                                <span class="stat-value">247</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Industries</span>
                                <span class="stat-value">15</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Success Rate</span>
                                <span class="stat-value">95%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Industries Grid Section -->
    <section class="industries-section" id="industries">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                    <span>Industry Solutions</span>
                </div>
                <h2 class="section-title">
                    AI Solutions for
                    <span class="gradient-text">Every Sector</span>
                </h2>
                <p class="section-description">
                    Discover how BRAIN Technology transforms operations across diverse industries 
                    with tailored AI solutions that address unique challenges and drive growth.
                </p>
            </div>
            
            <div class="industries-grid">
                <!-- Healthcare -->
                <div class="industry-card healthcare">
                    <div class="card-background"></div>
                    <div class="industry-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    <h3 class="industry-title">Healthcare</h3>
                    <p class="industry-description">
                        Revolutionize patient care with AI-powered diagnostics, automated medical records, 
                        and intelligent healthcare management systems.
                    </p>
                    <div class="industry-features">
                        <div class="feature">AI Diagnostics</div>
                        <div class="feature">Patient Analytics</div>
                        <div class="feature">Medical Automation</div>
                    </div>
                    <div class="industry-stats">
                        <div class="stat">
                            <span class="stat-value">99.2%</span>
                            <span class="stat-label">Accuracy</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">60%</span>
                            <span class="stat-label">Time Saved</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Finance -->
                <div class="industry-card finance">
                    <div class="card-background"></div>
                    <div class="industry-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <h3 class="industry-title">Finance</h3>
                    <p class="industry-description">
                        Transform financial services with intelligent risk assessment, automated trading, 
                        and predictive market analysis.
                    </p>
                    <div class="industry-features">
                        <div class="feature">Risk Analytics</div>
                        <div class="feature">Trading Automation</div>
                        <div class="feature">Fraud Detection</div>
                    </div>
                    <div class="industry-stats">
                        <div class="stat">
                            <span class="stat-value">89%</span>
                            <span class="stat-label">Risk Reduction</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">3x</span>
                            <span class="stat-label">Faster Processing</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Retail -->
                <div class="industry-card retail">
                    <div class="card-background"></div>
                    <div class="industry-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </div>
                    <h3 class="industry-title">Retail</h3>
                    <p class="industry-description">
                        Enhance customer experience with personalized recommendations, inventory optimization, 
                        and intelligent supply chain management.
                    </p>
                    <div class="industry-features">
                        <div class="feature">Customer Analytics</div>
                        <div class="feature">Inventory Management</div>
                        <div class="feature">Personalization</div>
                    </div>
                    <div class="industry-stats">
                        <div class="stat">
                            <span class="stat-value">40%</span>
                            <span class="stat-label">Sales Increase</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">85%</span>
                            <span class="stat-label">Customer Satisfaction</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Manufacturing -->
                <div class="industry-card manufacturing">
                    <div class="card-background"></div>
                    <div class="industry-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                    </div>
                    <h3 class="industry-title">Manufacturing</h3>
                    <p class="industry-description">
                        Optimize production with predictive maintenance, quality control automation, 
                        and intelligent supply chain management.
                    </p>
                    <div class="industry-features">
                        <div class="feature">Predictive Maintenance</div>
                        <div class="feature">Quality Control</div>
                        <div class="feature">Supply Chain AI</div>
                    </div>
                    <div class="industry-stats">
                        <div class="stat">
                            <span class="stat-value">30%</span>
                            <span class="stat-label">Cost Reduction</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">99.9%</span>
                            <span class="stat-label">Quality Rate</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Education -->
                <div class="industry-card education">
                    <div class="card-background"></div>
                    <div class="industry-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                    <h3 class="industry-title">Education</h3>
                    <p class="industry-description">
                        Transform learning with personalized education, automated grading, 
                        and intelligent student performance analytics.
                    </p>
                    <div class="industry-features">
                        <div class="feature">Personalized Learning</div>
                        <div class="feature">Automated Grading</div>
                        <div class="feature">Student Analytics</div>
                    </div>
                    <div class="industry-stats">
                        <div class="stat">
                            <span class="stat-value">45%</span>
                            <span class="stat-label">Performance Boost</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">70%</span>
                            <span class="stat-label">Time Saved</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Transportation -->
                <div class="industry-card transportation">
                    <div class="card-background"></div>
                    <div class="industry-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M5 17h-2v-6l2-5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5"/>
                        </svg>
                    </div>
                    <h3 class="industry-title">Transportation</h3>
                    <p class="industry-description">
                        Optimize logistics with route optimization, predictive maintenance, 
                        and intelligent fleet management systems.
                    </p>
                    <div class="industry-features">
                        <div class="feature">Route Optimization</div>
                        <div class="feature">Fleet Management</div>
                        <div class="feature">Predictive Analytics</div>
                    </div>
                    <div class="industry-stats">
                        <div class="stat">
                            <span class="stat-value">25%</span>
                            <span class="stat-label">Fuel Savings</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">90%</span>
                            <span class="stat-label">On-time Delivery</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Overview Section -->
    <section class="solutions-section" id="solutions">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span>Tailored Solutions</span>
                </div>
                <h2 class="section-title">
                    Custom AI Solutions
                    <span class="gradient-text">for Your Industry</span>
                </h2>
                <p class="section-description">
                    Every industry has unique challenges. Our team works closely with you to develop 
                    custom AI solutions that address your specific needs and drive measurable results.
                </p>
            </div>
            
            <div class="solutions-timeline">
                <div class="solution-step">
                    <div class="step-number">01</div>
                    <div class="step-content">
                        <h3 class="step-title">Industry Analysis</h3>
                        <p class="step-description">
                            Deep dive into your industry's specific challenges, regulations, and opportunities 
                            to understand how AI can best serve your organization.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">Regulatory compliance</span>
                            <span class="metric">Industry benchmarks</span>
                            <span class="metric">Competitive analysis</span>
                        </div>
                    </div>
                </div>
                
                <div class="solution-step">
                    <div class="step-number">02</div>
                    <div class="step-content">
                        <h3 class="step-title">Custom Solution Design</h3>
                        <p class="step-description">
                            Design tailored AI solutions that integrate seamlessly with your existing 
                            systems and address your specific pain points.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">System integration</span>
                            <span class="metric">Custom algorithms</span>
                            <span class="metric">Scalable architecture</span>
                        </div>
                    </div>
                </div>
                
                <div class="solution-step">
                    <div class="step-number">03</div>
                    <div class="step-content">
                        <h3 class="step-title">Implementation & Training</h3>
                        <p class="step-description">
                            Deploy your custom solution with comprehensive training and support 
                            to ensure successful adoption across your organization.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">Phased deployment</span>
                            <span class="metric">Team training</span>
                            <span class="metric">Ongoing support</span>
                        </div>
                    </div>
                </div>
                
                <div class="solution-step">
                    <div class="step-number">04</div>
                    <div class="step-content">
                        <h3 class="step-title">Continuous Optimization</h3>
                        <p class="step-description">
                            Monitor performance, gather feedback, and continuously optimize your AI solution 
                            to ensure maximum ROI and long-term success.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">Performance monitoring</span>
                            <span class="metric">Regular updates</span>
                            <span class="metric">ROI tracking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories Section -->
    <section class="success-stories-section">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span>Success Stories</span>
                </div>
                <h2 class="section-title">
                    Real Results Across
                    <span class="gradient-text">Industries</span>
                </h2>
            </div>
            
            <div class="stories-grid">
                <div class="story-card healthcare">
                    <div class="story-header">
                        <div class="story-industry">Healthcare</div>
                        <div class="story-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <p class="story-text">
                        "BRAIN Technology's AI diagnostics reduced our diagnosis time by 60% and improved 
                        accuracy to 99.2%. Our patients receive faster, more accurate care."
                    </p>
                    <div class="story-author">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Dr. Sarah Johnson</h4>
                            <p class="author-role">Chief Medical Officer</p>
                            <p class="author-company">MedTech Solutions</p>
                        </div>
                    </div>
                </div>
                
                <div class="story-card finance">
                    <div class="story-header">
                        <div class="story-industry">Finance</div>
                        <div class="story-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <p class="story-text">
                        "The AI-powered risk assessment system helped us reduce fraud by 89% and 
                        process transactions 3x faster. Game-changing technology."
                    </p>
                    <div class="story-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Michael Chen</h4>
                            <p class="author-role">CTO</p>
                            <p class="author-company">Global Finance Corp</p>
                        </div>
                    </div>
                </div>
                
                <div class="story-card retail">
                    <div class="story-header">
                        <div class="story-industry">Retail</div>
                        <div class="story-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <p class="story-text">
                        "Personalized recommendations increased our sales by 40% and customer 
                        satisfaction reached 85%. BRAIN Technology transformed our business."
                    </p>
                    <div class="story-author">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Emily Rodriguez</h4>
                            <p class="author-role">VP of Digital</p>
                            <p class="author-company">Retail Innovations</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-title">
                    Ready to Transform
                    <span class="gradient-text">Your Industry?</span>
                </h2>
                <p class="cta-description">
                    Join hundreds of organizations already using BRAIN Technology to revolutionize 
                    their operations and stay ahead of the competition.
                </p>
                <div class="cta-actions">
                    <a href="{{ url('/contact') }}" class="btn-primary">
                        <span>Start Your Transformation</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ url('/solutions/brain-assistant') }}" class="btn-secondary">
                        <span>Explore Solutions</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
                <div class="cta-features">
                    <div class="feature-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                        <span>Industry expertise</span>
                    </div>
                    <div class="feature-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                        <span>Custom solutions</span>
                    </div>
                    <div class="feature-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                        <span>Proven results</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/industries.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/industries.js') }}"></script>
@endpush 