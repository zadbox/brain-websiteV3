@extends('layouts.app')

@section('title', 'Brain Invest - AI-Powered Investment Solutions | BRAIN Technology')

@section('content')

<!-- Brain Invest Landing Page -->
<main class="brain-invest-page">
    
    <!-- Hero Section -->
    <section class="hero-brain-invest">
        <div class="hero-background">
            <div class="gradient-mesh"></div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge animate-fade-up" data-delay="100">
                    <svg class="badge-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83M22 12A10 10 0 0 0 12 2v10z"/>
                    </svg>
                    <span class="badge-text">AI Investment Platform</span>
                    <div class="badge-glow"></div>
                </div>
                
                <h1 class="hero-title animate-fade-up" data-delay="200">
                    <span class="title-line">Intelligent Investment</span>
                    <span class="title-line gradient-text">Powered by AI</span>
                    <span class="title-line">Maximize Your Returns</span>
                </h1>
                
                <p class="hero-subtitle animate-fade-up" data-delay="400">
                    Revolutionize your investment strategies with our advanced AI platform. 
                    Predictive analytics, automated risk management, and portfolio optimization 
                    to maximize your returns with intelligent automation.
                </p>
                
                <div class="hero-stats animate-fade-up" data-delay="600">
                    <div class="stat-item">
                        <div class="stat-number" data-target="247">247</div>
                        <div class="stat-label">% Average ROI</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="89">89</div>
                        <div class="stat-label">% Accuracy</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="24">24</div>
                        <div class="stat-label">h/7 Trading</div>
                    </div>
                </div>
                
                <div class="hero-actions animate-fade-up" data-delay="800">
                    <a href="#demo" class="btn-primary-invest">
                        <span class="btn-text">Try Demo</span>
                        <div class="btn-glow"></div>
                        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    
                    <a href="#features" class="btn-secondary-invest">
                        <span class="btn-text">Explore Features</span>
                        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual animate-fade-up" data-delay="1000">
                <div class="dashboard-mockup">
                    <div class="mockup-header">
                        <div class="header-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="header-title">Brain Invest Dashboard</div>
                    </div>
                    <div class="mockup-content">
                        <div class="chart-area">
                            <canvas id="hero-chart" width="400" height="200"></canvas>
                        </div>
                        <div class="metrics-panel">
                            <div class="metric">
                                <span class="metric-label">Portfolio Value</span>
                                <span class="metric-value">$2,847,392</span>
                                <span class="metric-change positive">+12.7%</span>
                            </div>
                            <div class="metric">
                                <span class="metric-label">Active Positions</span>
                                <span class="metric-value">47</span>
                                <span class="metric-change positive">+3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-brain-invest" id="features">
        <div class="container">
            <div class="section-header animate-slide-up">
                <div class="section-badge">
                    <svg class="badge-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span>Advanced Features</span>
                </div>
                <h2 class="section-title">
                    Artificial Intelligence
                    <span class="gradient-text">at Your Service</span>
                </h2>
                <p class="section-subtitle">
                    Sophisticated machine learning algorithms analyze markets in real-time 
                    to optimize your investment strategies and maximize returns.
                </p>
            </div>
            
            <div class="features-grid">
                <!-- Predictive Analytics -->
                <div class="feature-card animate-slide-up" data-delay="100">
                    <div class="card-background"></div>
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Predictive Analytics</h3>
                    <p class="feature-description">
                        Anticipate market movements with predictive models based on 
                        analysis of millions of historical and real-time data points.
                    </p>
                    <div class="feature-highlights">
                        <div class="highlight">Advanced Machine Learning</div>
                        <div class="highlight">Reliable Predictions</div>
                        <div class="highlight">Multi-Market Analysis</div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Risk Management -->
                <div class="feature-card animate-slide-up" data-delay="200">
                    <div class="card-background"></div>
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Risk Management</h3>
                    <p class="feature-description">
                        Automatic capital protection with risk management algorithms 
                        that adapt in real-time to market conditions.
                    </p>
                    <div class="feature-highlights">
                        <div class="highlight">Smart Stop-Loss</div>
                        <div class="highlight">Auto Diversification</div>
                        <div class="highlight">24/7 Monitoring</div>
                    </div>
                    <div class="card-glow"></div>
                </div>
                
                <!-- Automated Trading -->
                <div class="feature-card animate-slide-up" data-delay="300">
                    <div class="card-background"></div>
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Automated Trading</h3>
                    <p class="feature-description">
                        Automatic execution of your investment strategies with high-frequency 
                        algorithms that never miss an opportunity.
                    </p>
                    <div class="feature-highlights">
                        <div class="highlight">Fast Execution</div>
                        <div class="highlight">Multiple Strategies</div>
                        <div class="highlight">Continuous Optimization</div>
                    </div>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section class="demo-brain-invest" id="demo">
        <div class="container">
            <div class="demo-content">
                <div class="demo-info animate-slide-right">
                    <div class="demo-badge">
                        <span class="badge-text">Interactive Demo</span>
                    </div>
                    <h2 class="demo-title">
                        Experience Brain Invest
                        <span class="gradient-text">in Action</span>
                    </h2>
                    <p class="demo-description">
                        Discover the power of our platform with an interactive demonstration. 
                        Explore features, analyze real-time data, and see how AI can transform your investments.
                    </p>
                    
                    <div class="demo-features">
                        <div class="demo-feature">
                            <svg class="feature-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/>
                            </svg>
                            <span>Real-time market data</span>
                        </div>
                        <div class="demo-feature">
                            <svg class="feature-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                            </svg>
                            <span>Interactive predictive analysis</span>
                        </div>
                        <div class="demo-feature">
                            <svg class="feature-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            <span>Portfolio simulation</span>
                        </div>
                    </div>
                    
                    <div class="demo-actions">
                        <button class="btn-demo-start" onclick="startDemo()">
                            <span class="btn-text">Launch Demo</span>
                            <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5,3 19,12 5,21"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="demo-interface animate-slide-left">
                    <div class="interface-container">
                        <div class="interface-header">
                            <div class="header-nav">
                                <div class="nav-item active" data-tab="dashboard">Dashboard</div>
                                <div class="nav-item" data-tab="analytics">Analytics</div>
                                <div class="nav-item" data-tab="portfolio">Portfolio</div>
                            </div>
                        </div>
                        
                        <div class="interface-content">
                            <!-- Dashboard Tab -->
                            <div class="tab-content active" id="dashboard-tab">
                                <div class="dashboard-grid">
                                    <div class="dashboard-card">
                                        <div class="card-header">
                                            <h4>Global Performance</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="performance-chart">
                                                <canvas id="performance-chart" width="200" height="100"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="dashboard-card">
                                        <div class="card-header">
                                            <h4>Active Positions</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="positions-list">
                                                <div class="position-item">
                                                    <span class="symbol">AAPL</span>
                                                    <span class="change positive">+2.34%</span>
                                                </div>
                                                <div class="position-item">
                                                    <span class="symbol">GOOGL</span>
                                                    <span class="change positive">+1.87%</span>
                                                </div>
                                                <div class="position-item">
                                                    <span class="symbol">TSLA</span>
                                                    <span class="change negative">-0.92%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Analytics Tab -->
                            <div class="tab-content" id="analytics-tab">
                                <div class="analytics-content">
                                    <div class="prediction-panel">
                                        <h4>AI Predictions</h4>
                                        <div class="prediction-item">
                                            <span class="asset">BTC/USD</span>
                                            <span class="prediction bullish">Bullish</span>
                                            <span class="confidence">92%</span>
                                        </div>
                                        <div class="prediction-item">
                                            <span class="asset">EUR/USD</span>
                                            <span class="prediction bearish">Bearish</span>
                                            <span class="confidence">78%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Portfolio Tab -->
                            <div class="tab-content" id="portfolio-tab">
                                <div class="portfolio-content">
                                    <div class="allocation-chart">
                                        <canvas id="allocation-chart" width="150" height="150"></canvas>
                                    </div>
                                    <div class="allocation-legend">
                                        <div class="legend-item">
                                            <div class="legend-color" style="background: #6366f1;"></div>
                                            <span>Stocks (45%)</span>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-color" style="background: #8b5cf6;"></div>
                                            <span>Crypto (25%)</span>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-color" style="background: #06b6d4;"></div>
                                            <span>Bonds (30%)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-brain-invest">
        <div class="container">
            <div class="section-header animate-fade-up">
                <div class="section-badge">
                    <svg class="badge-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    <span>Pricing Plans</span>
                </div>
                <h2 class="section-title">
                    Choose Your
                    <span class="gradient-text">Investment Plan</span>
                </h2>
                <p class="section-subtitle">
                    Solutions tailored for all investor profiles, 
                    from beginners to professional traders.
                </p>
            </div>
            
            <div class="pricing-grid">
                <!-- Starter Plan -->
                <div class="pricing-card animate-slide-up" data-delay="100">
                    <div class="plan-header">
                        <div class="plan-name">Starter</div>
                        <div class="plan-price">
                            <span class="currency">$</span>
                            <span class="amount">99</span>
                            <span class="period">/month</span>
                        </div>
                        <div class="plan-description">Perfect for getting started with AI</div>
                    </div>
                    <div class="plan-features">
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Portfolio up to $10K</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Basic predictive analysis</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>5 pre-defined strategies</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Email support</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <button class="btn-plan">Get Started</button>
                    </div>
                </div>
                
                <!-- Pro Plan -->
                <div class="pricing-card featured animate-slide-up" data-delay="200">
                    <div class="featured-badge">Most Popular</div>
                    <div class="plan-header">
                        <div class="plan-name">Pro</div>
                        <div class="plan-price">
                            <span class="currency">$</span>
                            <span class="amount">299</span>
                            <span class="period">/month</span>
                        </div>
                        <div class="plan-description">For serious investors</div>
                    </div>
                    <div class="plan-features">
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Portfolio up to $100K</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Advanced AI + ML</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Unlimited strategies</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Automated trading</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Priority support 24/7</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <button class="btn-plan featured">Choose Pro</button>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="pricing-card animate-slide-up" data-delay="300">
                    <div class="plan-header">
                        <div class="plan-name">Enterprise</div>
                        <div class="plan-price">
                            <span class="amount">Custom</span>
                        </div>
                        <div class="plan-description">Customized solutions</div>
                    </div>
                    <div class="plan-features">
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Unlimited portfolio</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Custom AI models</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Complete API access</span>
                        </div>
                        <div class="feature-item">
                            <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <span>Dedicated manager</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <button class="btn-plan">Contact Us</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-brain-invest">
        <div class="cta-background">
            <div class="gradient-orbs">
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="cta-content animate-fade-up">
                <h2 class="cta-title">
                    Ready to Revolutionize
                    <span class="gradient-text">Your Investments?</span>
                </h2>
                
                <p class="cta-description">
                    Join thousands of investors who already trust Brain Invest 
                    to optimize their portfolios with artificial intelligence.
                </p>
                
                <div class="cta-actions">
                    <a href="{{url('/contact')}}" class="btn-cta-primary">
                        <span class="btn-text">Start Now</span>
                        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    
                    <a href="javascript:void(0)" onclick="toggleChatWidget()" class="btn-cta-secondary">
                        <span class="btn-text">Talk to Expert</span>
                        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </a>
                </div>
                
                <div class="cta-trust">
                    <div class="trust-item">
                        <svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <span>Secure & Regulated</span>
                    </div>
                    <div class="trust-item">
                        <svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20,6 9,17 4,12"/>
                        </svg>
                        <span>14-Day Free Trial</span>
                    </div>
                    <div class="trust-item">
                        <svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <span>Expert Support 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Stylesheets and Scripts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('assets/css/brain-invest.css')}}?v={{time()}}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('assets/js/brain-invest.js')}}?v={{time()}}" defer></script>

@endsection