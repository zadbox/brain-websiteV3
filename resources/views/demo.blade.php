@extends('layouts.app')

@section('title', 'Interactive Demo - Experience the Future | BRAIN Technology')
@section('meta_description', 'Experience the power of AI automation with our interactive demo. See how BRAIN Technology transforms business processes in real-time.')

@section('content')

<!-- Demo Page -->
<main class="demo-main">
    
    <!-- Animated Background Canvas -->
    <canvas id="demo-canvas"></canvas>
    
    <!-- Floating Particles Background -->
    <div class="floating-particles">
        <div class="particle" data-speed="2"></div>
        <div class="particle" data-speed="1.5"></div>
        <div class="particle" data-speed="3"></div>
        <div class="particle" data-speed="2.5"></div>
        <div class="particle" data-speed="1"></div>
        <div class="particle" data-speed="2.8"></div>
        <div class="particle" data-speed="1.8"></div>
        <div class="particle" data-speed="3.2"></div>
    </div>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <div class="badge-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                    </div>
                    <span>Interactive Experience</span>
                </div>
                
                <h1 class="hero-title">
                    Experience the
                    <span class="gradient-text">Future of AI</span>
                </h1>
                
                <p class="hero-description">
                    Step into the world of intelligent automation. Watch as AI transforms your business processes 
                    in real-time with our cutting-edge interactive demo.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="99">99</div>
                        <div class="stat-label">% Accuracy</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="10">10</div>
                        <div class="stat-label">x Faster</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="24">24</div>
                        <div class="stat-label">/7 Active</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <button class="btn-primary start-demo-btn">
                        <span>Start Interactive Demo</span>
                        <div class="btn-glow"></div>
                    </button>
                    <button class="btn-secondary learn-more-btn">
                        <span>Learn More</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="logo-container">
                    <div class="logo-wrapper">
                        <!-- BRAIN Technology Logo -->
                        <div class="logo-text">
                            <span class="logo-letter" data-letter="B">B</span>
                            <span class="logo-letter" data-letter="R">R</span>
                            <span class="logo-letter" data-letter="A">A</span>
                            <span class="logo-letter" data-letter="I">I</span>
                            <span class="logo-letter" data-letter="N">N</span>
                        </div>
                        <div class="logo-subtitle">
                            <span class="subtitle-letter" data-letter="T">T</span>
                            <span class="subtitle-letter" data-letter="E">E</span>
                            <span class="subtitle-letter" data-letter="C">C</span>
                            <span class="subtitle-letter" data-letter="H">H</span>
                            <span class="subtitle-letter" data-letter="N">N</span>
                            <span class="subtitle-letter" data-letter="O">O</span>
                            <span class="subtitle-letter" data-letter="L">L</span>
                            <span class="subtitle-letter" data-letter="O">O</span>
                            <span class="subtitle-letter" data-letter="G">G</span>
                            <span class="subtitle-letter" data-letter="Y">Y</span>
                        </div>
                        
                        <!-- Logo Glow Effects -->
                        <div class="logo-glow logo-glow-1"></div>
                        <div class="logo-glow logo-glow-2"></div>
                        <div class="logo-glow logo-glow-3"></div>
                        
                        <!-- Floating Particles Around Logo -->
                        <div class="logo-particles">
                            <div class="logo-particle" style="--delay: 0s"></div>
                            <div class="logo-particle" style="--delay: 0.5s"></div>
                            <div class="logo-particle" style="--delay: 1s"></div>
                            <div class="logo-particle" style="--delay: 1.5s"></div>
                            <div class="logo-particle" style="--delay: 2s"></div>
                            <div class="logo-particle" style="--delay: 2.5s"></div>
                            <div class="logo-particle" style="--delay: 3s"></div>
                            <div class="logo-particle" style="--delay: 3.5s"></div>
                        </div>
                        
                        <!-- Energy Rings -->
                        <div class="energy-ring energy-ring-1"></div>
                        <div class="energy-ring energy-ring-2"></div>
                        <div class="energy-ring energy-ring-3"></div>
                        
                        <!-- Tech Circuit Lines -->
                        <div class="circuit-lines">
                            <div class="circuit-line circuit-line-1"></div>
                            <div class="circuit-line circuit-line-2"></div>
                            <div class="circuit-line circuit-line-3"></div>
                            <div class="circuit-line circuit-line-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Demo Section -->
    <section class="demo-section" id="interactive-demo">
        <div class="section-container">
            <div class="demo-header">
                <h2 class="demo-title">
                    Real-Time
                    <span class="gradient-text">AI Processing</span>
                </h2>
                <p class="demo-subtitle">
                    Watch as our AI processes data, makes decisions, and automates tasks in real-time.
                </p>
            </div>
            
            <div class="demo-interface">
                <div class="demo-sidebar">
                    <div class="sidebar-header">
                        <h3>AI Control Panel</h3>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Active</span>
                        </div>
                    </div>
                    
                    <div class="control-panel">
                        <div class="control-group">
                            <label>Processing Speed</label>
                            <div class="slider-container">
                                <input type="range" id="speed-slider" min="1" max="10" value="5" class="slider">
                                <div class="slider-value">5x</div>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label>AI Intelligence</label>
                            <div class="toggle-container">
                                <input type="checkbox" id="ai-toggle" class="toggle" checked>
                                <label for="ai-toggle" class="toggle-label"></label>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label>Data Stream</label>
                            <div class="button-group">
                                <button class="control-btn active" data-stream="emails">Emails</button>
                                <button class="control-btn" data-stream="documents">Documents</button>
                                <button class="control-btn" data-stream="analytics">Analytics</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="demo-main-area">
                    <div class="demo-workspace">
                        <div class="workspace-header">
                            <div class="workspace-tabs">
                                <button class="tab-btn active" data-tab="processing">Processing</button>
                                <button class="tab-btn" data-tab="analysis">Analysis</button>
                                <button class="tab-btn" data-tab="automation">Automation</button>
                            </div>
                            <div class="workspace-controls">
                                <button class="control-btn" id="reset-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                        <path d="M21 3v5h-5"/>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                        <path d="M3 21v-5h5"/>
                                    </svg>
                                </button>
                                <button class="control-btn" id="fullscreen-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M8 3H5a2 2 0 0 0-2 2v3"/>
                                        <path d="M21 8V5a2 2 0 0 0-2-2h-3"/>
                                        <path d="M3 16v3a2 2 0 0 0 2 2h3"/>
                                        <path d="M16 21h3a2 2 0 0 0 2-2v-3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="workspace-content">
                            <div class="tab-content active" id="processing-tab">
                                <div class="processing-visualization">
                                    <div class="data-flow">
                                        <div class="data-node input-node">
                                            <div class="node-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                                    <polyline points="22,6 12,13 2,6"/>
                                                </svg>
                                            </div>
                                            <div class="node-label">Input Data</div>
                                            <div class="node-status">Receiving...</div>
                                        </div>
                                        
                                        <div class="flow-line">
                                            <div class="flow-particle"></div>
                                        </div>
                                        
                                        <div class="data-node processing-node">
                                            <div class="node-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                            </div>
                                            <div class="node-label">AI Processing</div>
                                            <div class="node-status">Analyzing...</div>
                                        </div>
                                        
                                        <div class="flow-line">
                                            <div class="flow-particle"></div>
                                        </div>
                                        
                                        <div class="data-node output-node">
                                            <div class="node-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                                                </svg>
                                            </div>
                                            <div class="node-label">Output Result</div>
                                            <div class="node-status">Complete</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-content" id="analysis-tab">
                                <div class="analysis-dashboard">
                                    <div class="chart-container">
                                        <canvas id="analysis-chart"></canvas>
                                    </div>
                                    <div class="metrics-grid">
                                        <div class="metric-card">
                                            <div class="metric-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                                </svg>
                                            </div>
                                            <div class="metric-value">98.7%</div>
                                            <div class="metric-label">Accuracy</div>
                                        </div>
                                        <div class="metric-card">
                                            <div class="metric-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                                </svg>
                                            </div>
                                            <div class="metric-value">2.3s</div>
                                            <div class="metric-label">Response Time</div>
                                        </div>
                                        <div class="metric-card">
                                            <div class="metric-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                                </svg>
                                            </div>
                                            <div class="metric-value">1,247</div>
                                            <div class="metric-label">Processed</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-content" id="automation-tab">
                                <div class="automation-workflow">
                                    <div class="workflow-step active" data-step="1">
                                        <div class="step-number">1</div>
                                        <div class="step-content">
                                            <h4>Data Collection</h4>
                                            <p>AI automatically collects and organizes incoming data</p>
                                        </div>
                                        <div class="step-status">Complete</div>
                                    </div>
                                    <div class="workflow-step" data-step="2">
                                        <div class="step-number">2</div>
                                        <div class="step-content">
                                            <h4>Pattern Recognition</h4>
                                            <p>Advanced algorithms identify patterns and trends</p>
                                        </div>
                                        <div class="step-status">Processing</div>
                                    </div>
                                    <div class="workflow-step" data-step="3">
                                        <div class="step-number">3</div>
                                        <div class="step-content">
                                            <h4>Decision Making</h4>
                                            <p>AI makes intelligent decisions based on analysis</p>
                                        </div>
                                        <div class="step-status">Pending</div>
                                    </div>
                                    <div class="workflow-step" data-step="4">
                                        <div class="step-number">4</div>
                                        <div class="step-content">
                                            <h4>Action Execution</h4>
                                            <p>Automated actions are executed based on decisions</p>
                                        </div>
                                        <div class="step-status">Pending</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Showcase -->
    <section class="features-section">
        <div class="section-container">
            <div class="features-header">
                <h2 class="features-title">
                    Powered by
                    <span class="gradient-text">Advanced AI</span>
                </h2>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3>Machine Learning</h3>
                    <p>Advanced algorithms that learn and improve over time</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3>Natural Language Processing</h3>
                    <p>Understand and process human language naturally</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3>Predictive Analytics</h3>
                    <p>Forecast trends and make data-driven predictions</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <h3>Process Automation</h3>
                    <p>Automate complex workflows and business processes</p>
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
                    <span class="gradient-text">the Future?</span>
                </h2>
                <p class="cta-description">
                    Transform your business with the power of AI automation. 
                    Start your journey today and see the difference.
                </p>
                <div class="cta-actions">
                    <a href="{{ url('/contact') }}" class="btn-primary">
                        <span>Get Started</span>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="{{ url('/solutions/brain-assistant') }}" class="btn-secondary">
                        <span>Learn More</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/demo.js') }}"></script>
@endpush 