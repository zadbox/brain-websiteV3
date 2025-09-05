@extends('layouts.app')

@section('title', 'Contact Us - Get in Touch | BRAIN Technology')
@section('meta_description', 'Ready to transform your business? Contact BRAIN Technology today. Our AI automation and blockchain experts are here to help you succeed.')

@section('content')

<!-- Contact Page -->
<main class="contact-main">
    
    
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        <path d="M13 8H7"/>
                        <path d="M17 12H7"/>
                    </svg>
                    <span>Let's Connect</span>
                </div>
                
                <h1 class="hero-title">
                    Ready to Transform
                    <span class="gradient-text">Your Business?</span>
                </h1>
                
                <p class="hero-description">
                    Our AI automation and blockchain experts are here to help you succeed. 
                    Let's discuss your project and explore how we can accelerate your digital transformation.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="24">24</div>
                        <div class="stat-label">Hour Response</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="500">500</div>
                        <div class="stat-label">+ Happy Clients</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="95">95</div>
                        <div class="stat-label">% Success Rate</div>
                    </div>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="contact-showcase">
                    <div class="showcase-header">
                        <div class="showcase-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="showcase-title">Contact Hub</div>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Online</span>
                        </div>
                    </div>
                    <div class="showcase-content">
                        <div class="contact-methods">
                            <div class="method-item">
                                <div class="method-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                </div>
                                <span>Phone</span>
                            </div>
                            <div class="method-item">
                                <div class="method-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </div>
                                <span>Email</span>
                            </div>
                            <div class="method-item">
                                <div class="method-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </div>
                                <span>Location</span>
                            </div>
                            <div class="method-item">
                                <div class="method-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    </svg>
                                </div>
                                <span>Chat</span>
                            </div>
                        </div>
                        <div class="showcase-stats">
                            <div class="stat">
                                <span class="stat-label">Response Time</span>
                                <span class="stat-value">< 24h</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Languages</span>
                                <span class="stat-value">3</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Support</span>
                                <span class="stat-value">24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="section-container">
            <div class="contact-grid">
                <!-- Contact Information -->
                <div class="contact-info">
                    <div class="info-header">
                        <div class="info-badge">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            </svg>
                            <span>Get in Touch</span>
                        </div>
                        <h2 class="info-title">
                            Let's Start Your
                            <span class="gradient-text">Transformation</span>
                        </h2>
                        <p class="info-description">
                            Ready to revolutionize your business with AI automation and blockchain technology? 
                            Our experts are here to guide you every step of the way.
                        </p>
                    </div>
                    
                    <div class="contact-methods-grid">
                        <div class="contact-method-card">
                            <div class="method-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div class="method-content">
                                <h3 class="method-title">Phone</h3>
                                <div class="method-details">
                                    <a href="tel:+33780959284" class="method-link">+(33) 780959284</a>
                                    <a href="tel:+33755547091" class="method-link">+(33) 755547091</a>
                                    <a href="tel:+212677740552" class="method-link">+(212) 677740552</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-method-card">
                            <div class="method-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div class="method-content">
                                <h3 class="method-title">Email</h3>
                                <div class="method-details">
                                    <a href="mailto:contact@braingentech.com" class="method-link">contact@braingentech.com</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-method-card">
                            <div class="method-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="method-content">
                                <h3 class="method-title">Location</h3>
                                <div class="method-details">
                                    <span class="method-text">107 Rue Paul Vaillant Couturier,<br>Alfortville 94140 France</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-method-card">
                            <div class="method-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    <path d="M13 8H7"/>
                                    <path d="M17 12H7"/>
                                </svg>
                            </div>
                            <div class="method-content">
                                <h3 class="method-title">Live Chat</h3>
                                <div class="method-details">
                                    <span class="method-text">Available 24/7<br>Instant response</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <div class="form-card">
                        <div class="form-header">
                            <h3 class="form-title">
                                Send us a
                                <span class="gradient-text">Message</span>
                            </h3>
                            <p class="form-subtitle">
                                Tell us about your project and we'll get back to you within 24 hours.
                            </p>
                        </div>
                        
                        @if (session('success'))
                            <div class="success-message">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif
                        
                        <form action="{{ url('/message') }}" method="post" class="contact-form">
                            @csrf
                            <div class="form-group">
                                <label for="user-name" class="form-label">Full Name</label>
                                <input type="text" id="user-name" name="user-name" class="form-input" placeholder="Enter your full name" required>
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="user-email" class="form-label">Email Address</label>
                                <input type="email" id="user-email" name="user-email" class="form-input" placeholder="Enter your email address" required>
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="user-subject" class="form-label">Service Interest</label>
                                <select id="user-subject" name="user-subject" class="form-select" required>
                                    <option value="" disabled selected>Select a service</option>
                                    <option value="communication-marketing">Communication & Digital Marketing</option>
                                    <option value="immobilier-conciergerie">Real Estate & Concierge Services</option>
                                    <option value="agroalimentaire-tracabilite">Agri-food & Traceability</option>
                                    <option value="autre">Other / Custom Solution</option>
                                </select>
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="user-message" class="form-label">Message</label>
                                <textarea id="user-message" name="user-message" class="form-textarea" placeholder="Tell us about your project, goals, and how we can help..." rows="4" required></textarea>
                                <div class="input-icon textarea-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Send Message</span>
                                <span class="btn-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                    </svg>
                                </span>
                                <div class="btn-loading">
                                    <div class="loading-spinner"></div>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="section-container">
            <div class="map-header">
                <div class="map-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Our Location</span>
                </div>
                <h2 class="map-title">
                    Visit Our
                    <span class="gradient-text">Office</span>
                </h2>
            </div>
            
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2627.5654994109623!2d2.414947976016333!3d48.809270804162544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e673049e8a9b3f%3A0xf6ba4803e56483fa!2s107%20Rue%20Paul%20Vaillant%20Couturier%2C%2094140%20Alfortville%2C%20France!5e0!3m2!1sfr!2sma!4v1728779706734!5m2!1sfr!2sma" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-title">
                    Ready to Start Your
                    <span class="gradient-text">Journey?</span>
                </h2>
                <p class="cta-description">
                    Join hundreds of businesses that have already transformed their operations with BRAIN Technology. 
                    Let's build the future together.
                </p>
                <div class="cta-actions">
                    <a href="#contact-form" class="btn-primary">
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
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/contact.js') }}"></script>
@endpush
