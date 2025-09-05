@extends('layouts.app')

@section('title', 'Resources - Whitepapers, Guides & Tools | BRAIN Technology')
@section('meta_description', 'Access BRAIN Technology\'s comprehensive resources including whitepapers, case studies, implementation guides, and AI automation tools to accelerate your digital transformation.')

@section('content')

<!-- Resources Page -->
<main class="resources-main">
    
    
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10,9 9,9 8,9"/>
                    </svg>
                    <span>Knowledge Hub</span>
                </div>
                
                <h1 class="hero-title">
                    Accelerate Your Success with
                    <span class="gradient-text">Expert Resources</span>
                </h1>
                
                <p class="hero-description">
                    Access our comprehensive library of whitepapers, case studies, implementation guides, and AI automation tools. 
                    Everything you need to accelerate your digital transformation and stay ahead of the competition.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="50">50</div>
                        <div class="stat-label">+ Resources</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="25">25</div>
                        <div class="stat-label">Case Studies</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="15">15</div>
                        <div class="stat-label">Whitepapers</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#whitepapers" class="btn-primary">
                        <span>Explore Resources</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#newsletter" class="btn-secondary">
                        <span>Stay Updated</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="resources-showcase">
                    <div class="showcase-header">
                        <div class="showcase-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="showcase-title">Resource Library</div>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Updated</span>
                        </div>
                    </div>
                    <div class="showcase-content">
                        <div class="resource-categories">
                            <div class="category-item">
                                <div class="category-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14,2 14,8 20,8"/>
                                    </svg>
                                </div>
                                <span>Whitepapers</span>
                            </div>
                            <div class="category-item">
                                <div class="category-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                                    </svg>
                                </div>
                                <span>Case Studies</span>
                            </div>
                            <div class="category-item">
                                <div class="category-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                    </svg>
                                </div>
                                <span>Guides</span>
                            </div>
                            <div class="category-item">
                                <div class="category-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                    </svg>
                                </div>
                                <span>Tools</span>
                            </div>
                        </div>
                        <div class="showcase-stats">
                            <div class="stat">
                                <span class="stat-label">Downloads</span>
                                <span class="stat-value">10K+</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Languages</span>
                                <span class="stat-value">3</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Updated</span>
                                <span class="stat-value">Weekly</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Resource Categories Section -->
    <section class="categories-section">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3h18v18H3zM21 9H3M21 15H3M12 3v18"/>
                    </svg>
                    <span>Resource Categories</span>
                </div>
                <h2 class="section-title">
                    Everything You Need to
                    <span class="gradient-text">Succeed</span>
                </h2>
                <p class="section-description">
                    From comprehensive whitepapers to practical implementation guides, our resources are designed 
                    to help you navigate the complex world of AI automation and digital transformation.
                </p>
            </div>
            
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14,2 14,8 20,8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10,9 9,9 8,9"/>
                        </svg>
                    </div>
                    <h3 class="category-title">Whitepapers</h3>
                    <p class="category-description">
                        In-depth research and analysis on AI automation, blockchain technology, and digital transformation strategies.
                    </p>
                    <div class="category-meta">
                        <span class="meta-item">15 Papers</span>
                        <span class="meta-item">Updated Monthly</span>
                    </div>
                    <a href="#whitepapers" class="category-link">
                        <span>Explore Whitepapers</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                    </div>
                    <h3 class="category-title">Case Studies</h3>
                    <p class="category-description">
                        Real-world examples of how businesses have successfully implemented BRAIN Technology solutions.
                    </p>
                    <div class="category-meta">
                        <span class="meta-item">25 Studies</span>
                        <span class="meta-item">Multiple Industries</span>
                    </div>
                    <a href="#case-studies" class="category-link">
                        <span>View Case Studies</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3 class="category-title">Implementation Guides</h3>
                    <p class="category-description">
                        Step-by-step guides to help you implement AI automation and blockchain solutions in your organization.
                    </p>
                    <div class="category-meta">
                        <span class="meta-item">12 Guides</span>
                        <span class="meta-item">Beginner to Advanced</span>
                    </div>
                    <a href="#guides" class="category-link">
                        <span>Read Guides</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <h3 class="category-title">Tools & Templates</h3>
                    <p class="category-description">
                        Practical tools, templates, and calculators to help you assess and implement automation solutions.
                    </p>
                    <div class="category-meta">
                        <span class="meta-item">8 Tools</span>
                        <span class="meta-item">Free Access</span>
                    </div>
                    <a href="#tools" class="category-link">
                        <span>Access Tools</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Whitepapers Section -->
    <section class="whitepapers-section" id="whitepapers">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                    </svg>
                    <span>Featured Whitepapers</span>
                </div>
                <h2 class="section-title">
                    Deep Dive into
                    <span class="gradient-text">AI Automation</span>
                </h2>
            </div>
            
            <div class="whitepapers-grid">
                <div class="whitepaper-card featured">
                    <div class="whitepaper-badge">Featured</div>
                    <div class="whitepaper-content">
                        <div class="whitepaper-meta">
                            <span class="meta-tag">AI Automation</span>
                            <span class="meta-date">March 2024</span>
                        </div>
                        <h3 class="whitepaper-title">
                            The Future of Business Automation: AI-Powered Process Optimization
                        </h3>
                        <p class="whitepaper-excerpt">
                            Discover how artificial intelligence is revolutionizing business processes and creating unprecedented opportunities for efficiency and growth.
                        </p>
                        <div class="whitepaper-stats">
                            <span class="stat">25 pages</span>
                            <span class="stat">15 min read</span>
                            <span class="stat">2.5K downloads</span>
                        </div>
                        <a href="#" class="download-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7,10 12,15 17,10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
                
                <div class="whitepaper-card">
                    <div class="whitepaper-content">
                        <div class="whitepaper-meta">
                            <span class="meta-tag">Blockchain</span>
                            <span class="meta-date">February 2024</span>
                        </div>
                        <h3 class="whitepaper-title">
                            Blockchain for Business: Transparency and Trust in Digital Transactions
                        </h3>
                        <p class="whitepaper-excerpt">
                            Explore how blockchain technology is transforming business operations and creating new opportunities for secure, transparent transactions.
                        </p>
                        <div class="whitepaper-stats">
                            <span class="stat">18 pages</span>
                            <span class="stat">12 min read</span>
                            <span class="stat">1.8K downloads</span>
                        </div>
                        <a href="#" class="download-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7,10 12,15 17,10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
                
                <div class="whitepaper-card">
                    <div class="whitepaper-content">
                        <div class="whitepaper-meta">
                            <span class="meta-tag">Digital Transformation</span>
                            <span class="meta-date">January 2024</span>
                        </div>
                        <h3 class="whitepaper-title">
                            Digital Transformation Roadmap: A Comprehensive Guide for SMEs
                        </h3>
                        <p class="whitepaper-excerpt">
                            A step-by-step guide to help small and medium enterprises navigate their digital transformation journey successfully.
                        </p>
                        <div class="whitepaper-stats">
                            <span class="stat">32 pages</span>
                            <span class="stat">20 min read</span>
                            <span class="stat">3.2K downloads</span>
                        </div>
                        <a href="#" class="download-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7,10 12,15 17,10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="section-footer">
                <a href="#" class="btn-secondary">
                    <span>View All Whitepapers</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Case Studies Section -->
    <section class="case-studies-section" id="case-studies">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                    </svg>
                    <span>Success Stories</span>
                </div>
                <h2 class="section-title">
                    Real Results from
                    <span class="gradient-text">Real Companies</span>
                </h2>
            </div>
            
            <div class="case-studies-grid">
                <div class="case-study-card">
                    <div class="case-study-image">
                        <img src="images/ai-image/gallery/a.jpg" alt="ComDigitale Case Study">
                        <div class="case-study-overlay">
                            <div class="overlay-content">
                                <span class="industry-tag">Digital Marketing</span>
                                <h4>ComDigitale</h4>
                                <p>300% increase in campaign efficiency</p>
                            </div>
                        </div>
                    </div>
                    <div class="case-study-content">
                        <h3 class="case-study-title">Automating Marketing Campaigns</h3>
                        <p class="case-study-excerpt">
                            How ComDigitale achieved 300% increase in campaign efficiency through AI-powered automation.
                        </p>
                        <div class="case-study-metrics">
                            <div class="metric">
                                <span class="metric-value">300%</span>
                                <span class="metric-label">Efficiency Increase</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">50%</span>
                                <span class="metric-label">Time Saved</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">2x</span>
                                <span class="metric-label">ROI Improvement</span>
                            </div>
                        </div>
                        <a href="#" class="case-study-link">
                            <span>Read Full Case Study</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="case-study-card">
                    <div class="case-study-image">
                        <img src="images/ai-image/gallery/b.jpg" alt="ImmoPlus Case Study">
                        <div class="case-study-overlay">
                            <div class="overlay-content">
                                <span class="industry-tag">Real Estate</span>
                                <h4>ImmoPlus</h4>
                                <p>100% transaction transparency</p>
                            </div>
                        </div>
                    </div>
                    <div class="case-study-content">
                        <h3 class="case-study-title">Blockchain-Powered Real Estate</h3>
                        <p class="case-study-excerpt">
                            ImmoPlus implemented blockchain technology to ensure complete transparency in all real estate transactions.
                        </p>
                        <div class="case-study-metrics">
                            <div class="metric">
                                <span class="metric-value">100%</span>
                                <span class="metric-label">Transparency</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">60%</span>
                                <span class="metric-label">Faster Processing</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">0</span>
                                <span class="metric-label">Security Breaches</span>
                            </div>
                        </div>
                        <a href="#" class="case-study-link">
                            <span>Read Full Case Study</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="case-study-card">
                    <div class="case-study-image">
                        <img src="images/ai-image/gallery/c.jpg" alt="AgroBio Case Study">
                        <div class="case-study-overlay">
                            <div class="overlay-content">
                                <span class="industry-tag">Agri-food</span>
                                <h4>AgroBio</h4>
                                <p>Complete supply chain traceability</p>
                            </div>
                        </div>
                    </div>
                    <div class="case-study-content">
                        <h3 class="case-study-title">Supply Chain Traceability</h3>
                        <p class="case-study-excerpt">
                            AgroBio achieved complete traceability across their entire supply chain using AI and blockchain technology.
                        </p>
                        <div class="case-study-metrics">
                            <div class="metric">
                                <span class="metric-value">100%</span>
                                <span class="metric-label">Traceability</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">40%</span>
                                <span class="metric-label">Cost Reduction</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">24/7</span>
                                <span class="metric-label">Monitoring</span>
                            </div>
                        </div>
                        <a href="#" class="case-study-link">
                            <span>Read Full Case Study</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tools Section -->
    <section class="tools-section" id="tools">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                    <span>Free Tools</span>
                </div>
                <h2 class="section-title">
                    Practical Tools to
                    <span class="gradient-text">Get Started</span>
                </h2>
            </div>
            
            <div class="tools-grid">
                <div class="tool-card">
                    <div class="tool-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z"/>
                        </svg>
                    </div>
                    <h3 class="tool-title">ROI Calculator</h3>
                    <p class="tool-description">
                        Calculate the potential return on investment for implementing AI automation in your business.
                    </p>
                    <a href="#" class="tool-link">
                        <span>Try Calculator</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                    </div>
                    <h3 class="tool-title">Automation Assessment</h3>
                    <p class="tool-description">
                        Evaluate which processes in your organization are ready for automation.
                    </p>
                    <a href="#" class="tool-link">
                        <span>Start Assessment</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3 class="tool-title">Implementation Checklist</h3>
                    <p class="tool-description">
                        A comprehensive checklist to ensure successful AI automation implementation.
                    </p>
                    <a href="#" class="tool-link">
                        <span>Download Checklist</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3 class="tool-title">AI Chat Demo</h3>
                    <p class="tool-description">
                        Experience our AI assistant capabilities with this interactive demo.
                    </p>
                    <a href="#" class="tool-link">
                        <span>Try Demo</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

        <!-- Newsletter Section -->
    <section class="newsletter-section" id="newsletter">
        <div class="section-container">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h2 class="newsletter-title">
                        Stay Updated with
                        <span class="gradient-text">Latest Insights</span>
                    </h2>
                    <p class="newsletter-description">
                        Get the latest whitepapers, case studies, and industry insights delivered directly to your inbox. 
                        Join thousands of professionals staying ahead of the curve.
                    </p>
                    <div class="newsletter-benefits">
                        <div class="benefit-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                            </svg>
                            <span>Monthly whitepapers and case studies</span>
                        </div>
                        <div class="benefit-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                            </svg>
                            <span>Exclusive industry insights and trends</span>
                        </div>
                        <div class="benefit-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                            </svg>
                            <span>Early access to new tools and resources</span>
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
                    Ready to Access
                    <span class="gradient-text">All Resources?</span>
                </h2>
                <p class="cta-description">
                    Join thousands of professionals who are already using our resources to accelerate their digital transformation.
                </p>
                <div class="cta-actions">
                    <a href="{{ url('/contact') }}" class="btn-primary">
                        <span>Get Started Today</span>
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
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/resources.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/resources.js') }}"></script>
@endpush 
