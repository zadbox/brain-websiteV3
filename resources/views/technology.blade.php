@extends('layouts.app')

@section('title', 'Technology - AI, Machine Learning & Innovation Stack | BRAIN Technology')
@section('meta_description', 'Discover the cutting-edge technology behind BRAIN Technology. Advanced AI, machine learning, neural networks, and innovative solutions that power our intelligent automation platform.')

@section('content')

<!-- Technology Page -->
<main class="technology-main">
    
    <!-- Neural Network Background Canvas -->
    <canvas id="technology-canvas"></canvas>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <span>Cutting-Edge AI Technology</span>
                </div>
                
                <h1 class="hero-title">
                    The Technology
                    <span class="gradient-text">Behind Innovation</span>
                    That Drives Results
                </h1>
                
                <p class="hero-description">
                    Explore the advanced AI, machine learning, and neural network technologies that power 
                    BRAIN Technology's intelligent automation platform. From deep learning algorithms to 
                    real-time processing, discover how we're pushing the boundaries of what's possible.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="99">99</div>
                        <div class="stat-label">% Accuracy</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="50">50</div>
                        <div class="stat-label">ms Response Time</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="10">10</div>
                        <div class="stat-label">AI Models</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#tech-stack" class="btn-primary">
                        <span>Explore Tech Stack</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#ai-capabilities" class="btn-secondary">
                        <span>AI Capabilities</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="tech-interface">
                    <div class="interface-header">
                        <div class="interface-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="interface-title">AI Neural Network</div>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Active</span>
                        </div>
                    </div>
                    <div class="interface-content">
                        <div class="neural-network">
                            <div class="network-layer input-layer">
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                            </div>
                            <div class="network-layer hidden-layer">
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                            </div>
                            <div class="network-layer output-layer">
                                <div class="neuron"></div>
                                <div class="neuron"></div>
                            </div>
                            <div class="connections"></div>
                        </div>
                        <div class="network-stats">
                            <div class="stat">
                                <span class="stat-label">Processing</span>
                                <span class="stat-value">2.4M ops/s</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Memory</span>
                                <span class="stat-value">8.2GB</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Efficiency</span>
                                <span class="stat-value">94%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section class="tech-stack-section" id="tech-stack">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span>Technology Stack</span>
                </div>
                <h2 class="section-title">
                    Built with
                    <span class="gradient-text">Modern Technologies</span>
                </h2>
                <p class="section-description">
                    Our technology stack combines cutting-edge AI frameworks, robust cloud infrastructure, 
                    and scalable microservices to deliver enterprise-grade solutions.
                </p>
            </div>
            
            <div class="tech-categories">
                <!-- AI & Machine Learning -->
                <div class="tech-category">
                    <h3 class="category-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        AI & Machine Learning
                    </h3>
                    <div class="tech-grid">
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>TensorFlow</h4>
                                <p>Deep learning framework for neural networks</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>PyTorch</h4>
                                <p>Dynamic neural networks and research</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="M21 21l-4.35-4.35"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Scikit-learn</h4>
                                <p>Machine learning algorithms and tools</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 3v18h18"/>
                                    <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Pandas</h4>
                                <p>Data manipulation and analysis</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Backend & APIs -->
                <div class="tech-category">
                    <h3 class="category-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                            <polyline points="16,6 12,2 8,6"/>
                            <line x1="12" y1="2" x2="12" y2="15"/>
                        </svg>
                        Backend & APIs
                    </h3>
                    <div class="tech-grid">
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                                    <polyline points="16,6 12,2 8,6"/>
                                    <line x1="12" y1="2" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Laravel</h4>
                                <p>PHP framework for web applications</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Python</h4>
                                <p>AI/ML services and data processing</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>FastAPI</h4>
                                <p>High-performance API framework</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Redis</h4>
                                <p>In-memory data structure store</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cloud & Infrastructure -->
                <div class="tech-category">
                    <h3 class="category-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>
                        </svg>
                        Cloud & Infrastructure
                    </h3>
                    <div class="tech-grid">
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>AWS</h4>
                                <p>Cloud computing and services</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                    <line x1="8" y1="21" x2="16" y2="21"/>
                                    <line x1="12" y1="17" x2="12" y2="21"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Docker</h4>
                                <p>Containerization platform</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <circle cx="12" cy="12" r="6"/>
                                    <circle cx="12" cy="12" r="2"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Kubernetes</h4>
                                <p>Container orchestration</p>
                            </div>
                        </div>
                        <div class="tech-item">
                            <div class="tech-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                                </svg>
                            </div>
                            <div class="tech-info">
                                <h4>Terraform</h4>
                                <p>Infrastructure as code</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Capabilities Section -->
    <section class="ai-capabilities-section" id="ai-capabilities">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83M22 12A10 10 0 0 0 12 2v10z"/>
                    </svg>
                    <span>AI Capabilities</span>
                </div>
                <h2 class="section-title">
                    Advanced AI
                    <span class="gradient-text">Technologies</span>
                </h2>
                <p class="section-description">
                    Our AI platform leverages state-of-the-art technologies to deliver intelligent, 
                    adaptive, and scalable solutions for complex business challenges.
                </p>
            </div>
            
            <div class="capabilities-grid">
                <div class="capability-card">
                    <div class="capability-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3 class="capability-title">Natural Language Processing</h3>
                    <p class="capability-description">
                        Advanced NLP models for text analysis, sentiment detection, and conversational AI 
                        with multilingual support and contextual understanding.
                    </p>
                    <div class="capability-metrics">
                        <div class="metric">
                            <span class="metric-value">99.2%</span>
                            <span class="metric-label">Accuracy</span>
                        </div>
                        <div class="metric">
                            <span class="metric-value">50ms</span>
                            <span class="metric-label">Response Time</span>
                        </div>
                    </div>
                </div>
                
                <div class="capability-card">
                    <div class="capability-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                    </div>
                    <h3 class="capability-title">Predictive Analytics</h3>
                    <p class="capability-description">
                        Machine learning models for forecasting, trend analysis, and pattern recognition 
                        with real-time data processing and adaptive learning.
                    </p>
                    <div class="capability-metrics">
                        <div class="metric">
                            <span class="metric-value">94.7%</span>
                            <span class="metric-label">Precision</span>
                        </div>
                        <div class="metric">
                            <span class="metric-value">24/7</span>
                            <span class="metric-label">Monitoring</span>
                        </div>
                    </div>
                </div>
                
                <div class="capability-card">
                    <div class="capability-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                    </div>
                    <h3 class="capability-title">Computer Vision</h3>
                    <p class="capability-description">
                        Advanced image and video analysis with object detection, facial recognition, 
                        and visual pattern identification for automated processing.
                    </p>
                    <div class="capability-metrics">
                        <div class="metric">
                            <span class="metric-value">98.5%</span>
                            <span class="metric-label">Detection Rate</span>
                        </div>
                        <div class="metric">
                            <span class="metric-value">100ms</span>
                            <span class="metric-label">Processing</span>
                        </div>
                    </div>
                </div>
                
                <div class="capability-card">
                    <div class="capability-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                    <h3 class="capability-title">Deep Learning</h3>
                    <p class="capability-description">
                        Neural networks and deep learning models for complex pattern recognition, 
                        automated decision-making, and continuous learning from data.
                    </p>
                    <div class="capability-metrics">
                        <div class="metric">
                            <span class="metric-value">10M+</span>
                            <span class="metric-label">Parameters</span>
                        </div>
                        <div class="metric">
                            <span class="metric-value">99.9%</span>
                            <span class="metric-label">Uptime</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovation Process Section -->
    <section class="innovation-section">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span>Innovation Process</span>
                </div>
                <h2 class="section-title">
                    How We Build
                    <span class="gradient-text">Future Technology</span>
                </h2>
                <p class="section-description">
                    Our systematic approach to innovation combines research, development, and deployment 
                    to create cutting-edge solutions that solve real-world problems.
                </p>
            </div>
            
            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-number">01</div>
                    <div class="step-content">
                        <h3 class="step-title">Research & Discovery</h3>
                        <p class="step-description">
                            Deep market research and technology exploration to identify opportunities 
                            and understand user needs and pain points.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">6 months avg.</span>
                            <span class="metric">50+ sources</span>
                            <span class="metric">Expert interviews</span>
                        </div>
                    </div>
                </div>
                
                <div class="process-step">
                    <div class="step-number">02</div>
                    <div class="step-content">
                        <h3 class="step-title">Prototype & Design</h3>
                        <p class="step-description">
                            Rapid prototyping and iterative design to validate concepts and create 
                            user-centered solutions with modern UX/UI principles.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">2-4 weeks</span>
                            <span class="metric">User testing</span>
                            <span class="metric">Iterative design</span>
                        </div>
                    </div>
                </div>
                
                <div class="process-step">
                    <div class="step-number">03</div>
                    <div class="step-content">
                        <h3 class="step-title">Development & Testing</h3>
                        <p class="step-description">
                            Agile development with continuous integration, automated testing, and 
                            quality assurance to ensure robust and scalable solutions.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">CI/CD pipeline</span>
                            <span class="metric">99.9% coverage</span>
                            <span class="metric">Performance testing</span>
                        </div>
                    </div>
                </div>
                
                <div class="process-step">
                    <div class="step-number">04</div>
                    <div class="step-content">
                        <h3 class="step-title">Deployment & Optimization</h3>
                        <p class="step-description">
                            Production deployment with monitoring, optimization, and continuous 
                            improvement based on real-world usage and feedback.
                        </p>
                        <div class="step-metrics">
                            <span class="metric">Zero downtime</span>
                            <span class="metric">Real-time monitoring</span>
                            <span class="metric">Continuous optimization</span>
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
                    <span class="gradient-text">Next-Gen Technology?</span>
                </h2>
                <p class="cta-description">
                    Join the future of intelligent automation with BRAIN Technology. 
                    Let's build something amazing together.
                </p>
                <div class="cta-actions">
                    <a href="{{ url('/contact') }}" class="btn-primary">
                        <span>Start Your Project</span>
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
                        <span>Free consultation</span>
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
                        <span>24/7 support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/technology.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/technology.js') }}"></script>
@endpush 