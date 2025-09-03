@extends('layouts.app')

@section('title', 'Brain Assistant - AI-Powered Virtual Assistant & Automation | BRAIN Technology')
@section('meta_description', 'Transform your business with Brain Assistant. AI-powered virtual assistant, process automation, intelligent workflows, and smart decision support.')

@section('content')

<!-- Brain Assistant Solution Page -->
<main class="brain-assistant-main">
    
    <!-- Floating AI Particles Background -->
    <canvas id="brain-assistant-canvas"></canvas>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <span>AI-Powered Virtual Assistant</span>
                </div>
                
                <h1 class="hero-title">
                    Your Intelligent
                    <span class="gradient-text">Digital Companion</span>
                    for Every Task
                </h1>
                
                <p class="hero-description">
                    Brain Assistant combines cutting-edge AI with intuitive design to automate workflows, 
                    provide intelligent insights, and enhance productivity. Experience the future of 
                    digital assistance with our advanced virtual AI companion.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="95">95</div>
                        <div class="stat-label">% Task Automation</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="3">3</div>
                        <div class="stat-label">x Faster Response</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="24">24</div>
                        <div class="stat-label">/7 Availability</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#demo" class="btn-primary">
                        <span>Try Assistant</span>
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
                <div class="assistant-interface">
                    <div class="interface-header">
                        <div class="interface-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="interface-title">Brain Assistant</div>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Online</span>
                        </div>
                    </div>
                    <div class="interface-content">
                        <div class="chat-messages">
                            <div class="message assistant">
                                <div class="message-avatar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div class="message-content">
                                    <p>Hello! I'm your AI assistant. How can I help you today?</p>
                                </div>
                            </div>
                            <div class="message user">
                                <div class="message-content">
                                    <p>Can you help me schedule a meeting?</p>
                                </div>
                            </div>
                            <div class="message assistant">
                                <div class="message-avatar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div class="message-content">
                                    <p>Of course! I can help you schedule meetings, send reminders, and manage your calendar. What time works best for you?</p>
                                </div>
                            </div>
                        </div>
                        <div class="chat-input">
                            <input type="text" placeholder="Type your message..." class="message-input">
                            <button class="send-button">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                </svg>
                            </button>
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
                    <span>Core Capabilities</span>
                </div>
                <h2 class="section-title">
                    Intelligent Features
                    <span class="gradient-text">That Adapt</span>
                </h2>
                <p class="section-description">
                    Brain Assistant learns from your preferences and adapts to your workflow, 
                    providing personalized assistance for every task and challenge.
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card" data-feature="automation">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Smart Automation</h3>
                    <p class="feature-description">
                        Automate repetitive tasks, workflows, and processes with intelligent 
                        decision-making and adaptive learning capabilities.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Workflow Automation</span>
                        <span class="tag">Process Optimization</span>
                        <span class="tag">Decision Support</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="communication">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Natural Communication</h3>
                    <p class="feature-description">
                        Communicate naturally through text, voice, and visual interfaces with 
                        advanced NLP and contextual understanding.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Voice Recognition</span>
                        <span class="tag">NLP Processing</span>
                        <span class="tag">Multi-modal</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="analytics">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Predictive Analytics</h3>
                    <p class="feature-description">
                        Leverage machine learning to predict trends, identify patterns, and 
                        provide actionable insights for better decision-making.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Pattern Recognition</span>
                        <span class="tag">Trend Analysis</span>
                        <span class="tag">Predictive Models</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="integration">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                            <polyline points="16,6 12,2 8,6"/>
                            <line x1="12" y1="2" x2="12" y2="15"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Seamless Integration</h3>
                    <p class="feature-description">
                        Connect with your existing tools and platforms through APIs and 
                        custom integrations for a unified experience.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">API Integration</span>
                        <span class="tag">Custom Connectors</span>
                        <span class="tag">Unified Platform</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="security">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Enterprise Security</h3>
                    <p class="feature-description">
                        Bank-grade security with end-to-end encryption, compliance standards, 
                        and advanced threat protection for your data.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">End-to-End Encryption</span>
                        <span class="tag">Compliance Ready</span>
                        <span class="tag">Threat Protection</span>
                    </div>
                </div>
                
                <div class="feature-card" data-feature="learning">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Continuous Learning</h3>
                    <p class="feature-description">
                        The assistant learns from every interaction, improving accuracy and 
                        personalization over time with adaptive algorithms.
                    </p>
                    <div class="feature-tags">
                        <span class="tag">Adaptive Learning</span>
                        <span class="tag">Personalization</span>
                        <span class="tag">Performance Optimization</span>
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
                    Experience Brain Assistant
                    <span class="gradient-text">In Action</span>
                </h2>
                <p class="section-description">
                    Try our interactive demo to see how Brain Assistant can transform your 
                    workflow and boost productivity with AI-powered automation.
                </p>
            </div>
            
            <div class="demo-container">
                <div class="demo-tabs">
                    <button class="demo-tab active" data-tab="chat">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <span>Smart Chat</span>
                    </button>
                    <button class="demo-tab" data-tab="automation">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                        <span>Automation</span>
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
                    <div class="demo-panel active" data-panel="chat">
                        <div class="demo-header">
                            <h3>Intelligent Chat Interface</h3>
                            <p>Natural language processing with contextual understanding</p>
                        </div>
                        <div class="demo-widget">
                            <div class="chat-demo">
                                <div class="chat-messages-demo">
                                    <div class="message-demo assistant">
                                        <div class="message-avatar-demo">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                        </div>
                                        <div class="message-content-demo">
                                            <p>Hello! I can help you with scheduling, data analysis, document creation, and much more. What would you like to do today?</p>
                                        </div>
                                    </div>
                                    
                                    <div class="message-demo user">
                                        <div class="message-content-demo">
                                            <p>Can you analyze my sales data and create a report?</p>
                                        </div>
                                    </div>
                                    
                                    <div class="message-demo assistant">
                                        <div class="message-avatar-demo">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                        </div>
                                        <div class="message-content-demo">
                                            <p>I'd be happy to help! I can analyze your sales data and generate comprehensive reports. Would you like me to:</p>
                                            <div class="quick-actions">
                                                <button class="quick-action">📊 Generate Sales Report</button>
                                                <button class="quick-action">📈 Create Visual Charts</button>
                                                <button class="quick-action">🎯 Identify Trends</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-input-demo">
                                    <input type="text" placeholder="Type your message..." class="message-input-demo">
                                    <button class="send-button-demo">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="demo-panel" data-panel="automation">
                        <div class="demo-header">
                            <h3>Workflow Automation</h3>
                            <p>Visual automation builder with drag-and-drop interface</p>
                        </div>
                        <div class="demo-widget">
                            <div class="automation-demo">
                                <div class="automation-canvas">
                                    <div class="automation-node trigger">
                                        <div class="node-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                            </svg>
                                        </div>
                                        <div class="node-content">
                                            <h4>Email Received</h4>
                                            <p>Trigger when new email arrives</p>
                                        </div>
                                    </div>
                                    
                                    <div class="automation-connection"></div>
                                    
                                    <div class="automation-node action">
                                        <div class="node-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="node-content">
                                            <h4>Analyze Content</h4>
                                            <p>Extract key information</p>
                                        </div>
                                    </div>
                                    
                                    <div class="automation-connection"></div>
                                    
                                    <div class="automation-node action">
                                        <div class="node-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                                                <polyline points="16,6 12,2 8,6"/>
                                                <line x1="12" y1="2" x2="12" y2="15"/>
                                            </svg>
                                        </div>
                                        <div class="node-content">
                                            <h4>Create Task</h4>
                                            <p>Add to project management</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="automation-stats">
                                    <div class="stat">
                                        <span class="stat-value">247</span>
                                        <span class="stat-label">Automations Active</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">1,234</span>
                                        <span class="stat-label">Tasks Automated</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">89%</span>
                                        <span class="stat-label">Time Saved</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="demo-panel" data-panel="analytics">
                        <div class="demo-header">
                            <h3>AI Analytics Dashboard</h3>
                            <p>Real-time insights and predictive analytics</p>
                        </div>
                        <div class="demo-widget">
                            <div class="analytics-demo">
                                <div class="analytics-grid">
                                    <div class="analytics-card">
                                        <h4>Performance Metrics</h4>
                                        <div class="analytics-chart">
                                            <canvas id="performance-chart" width="300" height="150"></canvas>
                                        </div>
                                        <div class="analytics-insight">
                                            <span class="insight-label">Trend</span>
                                            <span class="insight-value">+15% improvement</span>
                                        </div>
                                    </div>
                                    
                                    <div class="analytics-card">
                                        <h4>Task Completion</h4>
                                        <div class="completion-stats">
                                            <div class="completion-item">
                                                <span class="completion-label">Completed</span>
                                                <span class="completion-value">1,247</span>
                                            </div>
                                            <div class="completion-item">
                                                <span class="completion-label">In Progress</span>
                                                <span class="completion-value">89</span>
                                            </div>
                                            <div class="completion-item">
                                                <span class="completion-label">Pending</span>
                                                <span class="completion-value">23</span>
                                            </div>
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
                    <span class="gradient-text">Organizations</span>
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
                        "Brain Assistant transformed our workflow completely. We automated 80% of our 
                        repetitive tasks and our team can now focus on strategic initiatives."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">David Chen</h4>
                            <p class="author-role">CTO</p>
                            <p class="author-company">TechFlow Solutions</p>
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
                        "The AI assistant understands our business context perfectly. It's like having 
                        an intelligent team member who never sleeps and always delivers."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Sarah Williams</h4>
                            <p class="author-role">Operations Director</p>
                            <p class="author-company">InnovateCorp</p>
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
                        "Brain Assistant's predictive analytics helped us identify opportunities 
                        we would have missed. It's become an essential part of our decision-making process."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" alt="Author" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name">Michael Rodriguez</h4>
                            <p class="author-role">CEO</p>
                            <p class="author-company">DataDrive Inc.</p>
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
                    Ready to Experience
                    <span class="gradient-text">AI-Powered Assistance?</span>
                </h2>
                <p class="cta-description">
                    Join thousands of organizations already using Brain Assistant to automate workflows, 
                    boost productivity, and unlock new possibilities with AI.
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
                        <span>24/7 AI support</span>
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
<link rel="stylesheet" href="{{ asset('assets/css/brain-assistant.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/brain-assistant.js') }}"></script>
@endpush
