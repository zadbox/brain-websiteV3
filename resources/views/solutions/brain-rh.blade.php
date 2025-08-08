@extends('layouts.app')

@section('title', 'Brain RH - AI-Powered HR Management & Talent Optimization | BRAIN Technology')
@section('meta_description', 'Transform your HR operations with Brain RH. AI-powered recruitment, talent management, performance analytics, and employee engagement solutions.')

@section('content')

<!-- Brain RH Solution Page -->
<main class="brain-rh-main">
    
    <!-- Neural Network Background -->
    <canvas id="brain-rh-canvas"></canvas>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/>
                    </svg>
                    <span>AI-Powered HR Management</span>
                </div>
                
                <h1 class="hero-title">
                    Revolutionize Your
                    <span class="gradient-text">HR Operations</span>
                    with Intelligent Automation
                </h1>
                
                <p class="hero-description">
                    Brain RH combines cutting-edge AI with deep HR expertise to streamline recruitment, 
                    optimize talent management, and enhance employee engagement. Transform your workforce 
                    with data-driven insights and intelligent automation.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="85">85</div>
                        <div class="stat-label">% Faster Hiring</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="92">92</div>
                        <div class="stat-label">% Retention Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="78">78</div>
                        <div class="stat-label">% Cost Reduction</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#demo" class="btn-primary">
                        <span>Watch Demo</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#features" class="btn-secondary">
                        <span>Explore Features</span>
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
                        <div class="dashboard-title">Brain RH Dashboard</div>
                    </div>
                    <div class="dashboard-content">
                        <div class="metrics-grid">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/>
                                    </svg>
                                </div>
                                <div class="metric-info">
                                    <span class="metric-value">247</span>
                                    <span class="metric-label">Active Candidates</span>
                                </div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                                    </svg>
                                </div>
                                <div class="metric-info">
                                    <span class="metric-value">94%</span>
                                    <span class="metric-label">Satisfaction</span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="hr-chart" width="400" height="200"></canvas>
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
                    <span>Core Features</span>
                </div>
                <h2 class="section-title">
                    Intelligent HR Solutions
                    <span class="gradient-text">That Scale</span>
                </h2>
                <p class="section-description">
                    From recruitment to retention, Brain RH provides comprehensive AI-powered tools 
                    to optimize every aspect of your human resources operations.
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card" data-feature="recruitment">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/>
                            <path d="M12 12v6"/>
                            <path d="M9 15h6"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">AI Recruitment</h3>
                    <p class="feature-description">
                        Intelligent candidate screening, automated job matching, and predictive hiring 
                        analytics to find the perfect fit faster.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Resume Parsing</span>
                        <span class="tag">Skill Matching</span>
                        <span class="tag">Predictive Analytics</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="performance">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2z"/>
                            <path d="M21 19v-6a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2z"/>
                            <path d="M15 19v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Performance Analytics</h3>
                    <p class="feature-description">
                        Real-time performance tracking, goal management, and AI-driven insights 
                        to optimize team productivity and growth.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">KPI Tracking</span>
                        <span class="tag">Goal Setting</span>
                        <span class="tag">360° Reviews</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="engagement">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Employee Engagement</h3>
                    <p class="feature-description">
                        Pulse surveys, sentiment analysis, and engagement metrics to build 
                        a positive workplace culture and boost retention.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Pulse Surveys</span>
                        <span class="tag">Sentiment Analysis</span>
                        <span class="tag">Culture Building</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="learning">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Learning & Development</h3>
                    <p class="feature-description">
                        Personalized learning paths, skill gap analysis, and AI-recommended 
                        training to accelerate career growth and skill development.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Personalized Learning</span>
                        <span class="tag">Skill Gaps</span>
                        <span class="tag">Career Paths</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="compliance">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Compliance Management</h3>
                    <p class="feature-description">
                        Automated compliance tracking, policy management, and audit trails 
                        to ensure regulatory adherence and risk mitigation.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Policy Management</span>
                        <span class="tag">Audit Trails</span>
                        <span class="tag">Risk Mitigation</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="analytics">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">HR Analytics</h3>
                    <p class="feature-description">
                        Advanced analytics and predictive insights to make data-driven 
                        decisions and optimize workforce planning strategies.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Predictive Insights</span>
                        <span class="tag">Workforce Planning</span>
                        <span class="tag">Data Visualization</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Demo Section -->
    <section class="demo-section" id="demo">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.828 14.828a4 4 0 0 1-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                    </svg>
                    <span>Interactive Demo</span>
                </div>
                <h2 class="section-title">
                    Experience Brain RH
                    <span class="gradient-text">In Action</span>
                </h2>
                <p class="section-description">
                    Explore our interactive demo to see how Brain RH transforms HR operations 
                    with AI-powered automation and intelligent insights.
                </p>
            </div>
            
            <div class="demo-container">
                <div class="demo-tabs">
                    <button class="demo-tab active" data-tab="recruitment">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/>
                        </svg>
                        <span>Recruitment</span>
                    </button>
                    <button class="demo-tab" data-tab="performance">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2z"/>
                        </svg>
                        <span>Performance</span>
                    </button>
                    <button class="demo-tab" data-tab="analytics">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                        <span>Analytics</span>
                    </button>
                </div>
                
                <div class="demo-content">
                    <div class="demo-panel active" data-panel="recruitment">
                        <div class="demo-header">
                            <h3>AI-Powered Recruitment Dashboard</h3>
                            <p>Intelligent candidate screening and matching</p>
                        </div>
                        <div class="demo-widget">
                            <div class="candidate-list">
                                <div class="candidate-item" data-score="95">
                                    <div class="candidate-avatar">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face" alt="Candidate">
                                        <div class="ai-score">95%</div>
                                    </div>
                                    <div class="candidate-info">
                                        <h4>Alex Johnson</h4>
                                        <p>Senior Software Engineer</p>
                                        <div class="candidate-skills">
                                            <span class="skill">React</span>
                                            <span class="skill">Node.js</span>
                                            <span class="skill">Python</span>
                                        </div>
                                    </div>
                                    <div class="candidate-actions">
                                        <button class="btn-action">View Profile</button>
                                        <button class="btn-action primary">Schedule Interview</button>
                                    </div>
                                </div>
                                
                                <div class="candidate-item" data-score="87">
                                    <div class="candidate-avatar">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop&crop=face" alt="Sarah Chen - Product Manager">
                                        <div class="ai-score">87%</div>
                                    </div>
                                    <div class="candidate-info">
                                        <h4>Sarah Chen</h4>
                                        <p>Product Manager</p>
                                        <div class="candidate-skills">
                                            <span class="skill">Agile</span>
                                            <span class="skill">UX Design</span>
                                            <span class="skill">Analytics</span>
                                        </div>
                                    </div>
                                    <div class="candidate-actions">
                                        <button class="btn-action">View Profile</button>
                                        <button class="btn-action primary">Schedule Interview</button>
                                    </div>
                                </div>
                                
                                <div class="candidate-item" data-score="92">
                                    <div class="candidate-avatar">
                                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face" alt="Candidate">
                                        <div class="ai-score">92%</div>
                                    </div>
                                    <div class="candidate-info">
                                        <h4>Michael Rodriguez</h4>
                                        <p>Data Scientist</p>
                                        <div class="candidate-skills">
                                            <span class="skill">Machine Learning</span>
                                            <span class="skill">Python</span>
                                            <span class="skill">SQL</span>
                                        </div>
                                    </div>
                                    <div class="candidate-actions">
                                        <button class="btn-action">View Profile</button>
                                        <button class="btn-action primary">Schedule Interview</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="demo-panel" data-panel="performance">
                        <div class="demo-header">
                            <h3>Performance Management System</h3>
                            <p>Real-time tracking and goal management</p>
                        </div>
                        <div class="demo-widget">
                            <div class="performance-grid">
                                <div class="performance-card">
                                    <div class="performance-header">
                                        <h4>Team Performance</h4>
                                        <div class="performance-score">94%</div>
                                    </div>
                                    <div class="performance-chart">
                                        <canvas id="team-chart" width="200" height="100"></canvas>
                                    </div>
                                    <div class="performance-metrics">
                                        <div class="metric">
                                            <span class="metric-label">Goals Met</span>
                                            <span class="metric-value">87%</span>
                                        </div>
                                        <div class="metric">
                                            <span class="metric-label">Productivity</span>
                                            <span class="metric-value">+12%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="performance-card">
                                    <div class="performance-header">
                                        <h4>Individual Goals</h4>
                                        <div class="performance-score">89%</div>
                                    </div>
                                    <div class="goals-list">
                                        <div class="goal-item completed">
                                            <div class="goal-checkbox">✓</div>
                                            <div class="goal-content">
                                                <span class="goal-text">Complete Q4 Project</span>
                                                <span class="goal-deadline">Dec 15, 2024</span>
                                            </div>
                                        </div>
                                        <div class="goal-item in-progress">
                                            <div class="goal-checkbox">○</div>
                                            <div class="goal-content">
                                                <span class="goal-text">Team Training</span>
                                                <span class="goal-deadline">Jan 20, 2025</span>
                                            </div>
                                        </div>
                                        <div class="goal-item pending">
                                            <div class="goal-checkbox">○</div>
                                            <div class="goal-content">
                                                <span class="goal-text">Process Optimization</span>
                                                <span class="goal-deadline">Feb 10, 2025</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="demo-panel" data-panel="analytics">
                        <div class="demo-header">
                            <h3>HR Analytics Dashboard</h3>
                            <p>Data-driven insights and predictive analytics</p>
                        </div>
                        <div class="demo-widget">
                            <div class="analytics-grid">
                                <div class="analytics-card">
                                    <h4>Employee Retention</h4>
                                    <div class="analytics-chart">
                                        <canvas id="retention-chart" width="300" height="150"></canvas>
                                    </div>
                                    <div class="analytics-insight">
                                        <span class="insight-label">Prediction</span>
                                        <span class="insight-value">+8% retention rate</span>
                                    </div>
                                </div>
                                
                                <div class="analytics-card">
                                    <h4>Hiring Pipeline</h4>
                                    <div class="pipeline-stages">
                                        <div class="pipeline-stage">
                                            <span class="stage-name">Applied</span>
                                            <span class="stage-count">247</span>
                                        </div>
                                        <div class="pipeline-stage">
                                            <span class="stage-name">Screening</span>
                                            <span class="stage-count">89</span>
                                        </div>
                                        <div class="pipeline-stage">
                                            <span class="stage-name">Interview</span>
                                            <span class="stage-count">34</span>
                                        </div>
                                        <div class="pipeline-stage">
                                            <span class="stage-name">Offer</span>
                                            <span class="stage-count">12</span>
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

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span>Success Stories</span>
                </div>
                <h2 class="section-title">
                    Trusted by Leading
                    <span class="gradient-text">Companies</span>
                </h2>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p class="testimonial-text">
                        "Brain RH transformed our recruitment process. We reduced hiring time by 60% 
                        and improved candidate quality significantly. The AI insights are invaluable."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">David Chen</h4>
                            <p class="author-role">HR Director</p>
                            <p class="author-company">TechCorp Inc.</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p class="testimonial-text">
                        "The performance analytics helped us identify skill gaps and create targeted 
                        training programs. Employee satisfaction increased by 40%."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=60&h=60&fit=crop&crop=face" alt="Sarah Williams - VP of People at InnovateLab" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Sarah Williams</h4>
                            <p class="author-role">VP of People</p>
                            <p class="author-company">InnovateLab</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p class="testimonial-text">
                        "Brain RH's predictive analytics saved us millions in turnover costs. 
                        The AI recommendations are spot-on and actionable."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Michael Rodriguez</h4>
                            <p class="author-role">Chief People Officer</p>
                            <p class="author-company">Global Solutions</p>
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
                    <span class="gradient-text">Your HR Operations?</span>
                </h2>
                <p class="cta-description">
                    Join thousands of companies already using Brain RH to optimize their workforce 
                    and drive business growth with AI-powered HR solutions.
                </p>
                <div class="cta-actions">
                    <a href="{{ url('/contact') }}" class="btn-primary">
                        <span>Get Started Today</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ url('/demo') }}" class="btn-secondary">
                        <span>Request Demo</span>
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
                        <span>Free 30-day trial</span>
                    </div>
                    <div class="feature-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                        <span>24/7 support</span>
                    </div>
                    <div class="feature-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                        <span>No setup fees</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/brain-rh.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/brain-rh.js') }}"></script>
@endpush
