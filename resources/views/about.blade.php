@extends('layouts.app')

@section('title', 'About Us - Our Story & Mission | BRAIN Technology')
@section('meta_description', 'Discover the story behind BRAIN Technology - from our founding in 2020 to becoming a leader in AI automation and blockchain solutions. Learn about our values and mission.')

@section('content')

<!-- About Page -->
<main class="about-main">
    
    <!-- Neural Network Background Canvas -->
    <canvas id="about-canvas"></canvas>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <span>Our Story & Mission</span>
                </div>
                
                <h1 class="hero-title">
                    Transforming Business Through
                    <span class="gradient-text">Intelligent Automation</span>
                </h1>
                
                <p class="hero-description">
                    Founded in 2020, BRAIN Technology has emerged as a pioneering force in AI automation and blockchain solutions. 
                    We help businesses liberate their teams from repetitive tasks, enabling them to focus on strategic and creative missions.
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-target="4">4</div>
                        <div class="stat-label">Years of Innovation</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="500">500</div>
                        <div class="stat-label">+ Clients Served</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="95">95</div>
                        <div class="stat-label">% Success Rate</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#story" class="btn-primary">
                        <span>Our Journey</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#values" class="btn-secondary">
                        <span>Our Values</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="about-showcase">
                    <div class="showcase-header">
                        <div class="showcase-controls">
                            <div class="control red"></div>
                            <div class="control yellow"></div>
                            <div class="control green"></div>
                        </div>
                        <div class="showcase-title">BRAIN Technology</div>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>Active</span>
                        </div>
                    </div>
                    <div class="showcase-content">
                        <div class="company-info">
                            <div class="info-item">
                                <div class="info-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                    </svg>
                                </div>
                                <span>AI & Automation</span>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                    </svg>
                                </div>
                                <span>Blockchain</span>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                    </svg>
                                </div>
                                <span>Innovation</span>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                                    </svg>
                                </div>
                                <span>Trust</span>
                            </div>
                        </div>
                        <div class="showcase-stats">
                            <div class="stat">
                                <span class="stat-label">Founded</span>
                                <span class="stat-value">2020</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Solutions</span>
                                <span class="stat-value">15+</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Industries</span>
                                <span class="stat-value">6</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="about-content-section">
        <div class="section-container">
            <div class="content-grid">
                <div class="content-text">
                    <div class="content-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                        <span>BRAIN Technology</span>
                    </div>
                    
                    <h2 class="content-title">
                        Empowering Businesses Through
                        <span class="gradient-text">Intelligent Solutions</span>
                    </h2>
                    
                    <p class="content-description">
                        At BRAIN, we help you liberate your teams from repetitive and low-value tasks by automating 
                        what can be automated, allowing them to focus on strategic and creative missions. Our expertise 
                        in process automation, supported by artificial intelligence and blockchain technologies, enables 
                        us to create customized solutions tailored to the specific needs of each client, regardless of 
                        their sector and objectives.
                    </p>
                    
                    <div class="content-features">
                        <div class="feature-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                            </svg>
                            <span>Communication Agencies and Digital Marketing</span>
                        </div>
                        <div class="feature-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                            </svg>
                            <span>Real Estate Promotion and Concierge Services</span>
                        </div>
                        <div class="feature-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                            </svg>
                            <span>Agri-food and Traceability</span>
                        </div>
                    </div>
                    
                    <div class="content-actions">
                        <a href="{{ url('/contact') }}" class="btn-primary">
                            <span>Schedule a Demo</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="content-visual">
                    <div class="image-container">
                        <img src="images/about.webp" alt="BRAIN Technology Team" class="about-image">
                        <div class="image-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Timeline Section -->
    <section class="story-section" id="story">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    </svg>
                    <span>Our Journey</span>
                </div>
                <h2 class="section-title">
                    Born in the technology universe in 2020,
                    <span class="gradient-text">BRAIN Technology</span>
                </h2>
                <p class="section-description">
                    BRAIN Technology has quickly established itself as a key player in process automation 
                    and artificial intelligence. This success is built on a team of passionate individuals, 
                    expertise developed in France, and a constant commitment to innovation.
                </p>
            </div>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2017</div>
                    <div class="timeline-content">
                        <div class="timeline-image">
                            <img src="images/first.webp" alt="Les débuts d'une idée">
                        </div>
                        <div class="timeline-text">
                            <h3 class="timeline-title">The Beginning of an Idea</h3>
                            <p class="timeline-description">
                                It all started around a table, between Houssam and Mounim, two friends driven by a shared passion for technology. Frustrated by seeing their time consumed by repetitive tasks, they dreamed of a solution that would liberate businesses from these constraints. Their mission took shape: to give SMEs the freedom to focus on what matters by automating tedious tasks, with a promise of increased productivity.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2018</div>
                    <div class="timeline-content">
                        <div class="timeline-image">
                            <img src="images/blockchain.webp" alt="Exploration de la blockchain">
                        </div>
                        <div class="timeline-text">
                            <h3 class="timeline-title">Blockchain Exploration</h3>
                            <p class="timeline-description">
                                The evolution of the project led them to explore revolutionary technologies like blockchain, whose potential to secure and trace processes fascinated them. Houssam and Mounim integrated blockchain as a pillar of their vision, convinced that transparency and security are essential. They outlined the foundations of a unique solution, combining artificial intelligence and blockchain, for automation that inspires trust and guarantees transaction integrity.
                            </p>
                            <div class="timeline-features">
                                <span class="feature-tag">Public Blockchain</span>
                                <span class="feature-tag">Private Blockchain</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2019</div>
                    <div class="timeline-content">
                        <div class="timeline-image">
                            <img src="images/idee.webp" alt="L'idée prend forme">
                        </div>
                        <div class="timeline-text">
                            <h3 class="timeline-title">The Idea Takes Shape</h3>
                            <p class="timeline-description">
                                The idea of creating a company around automation becomes tangible. Their project becomes clearer: to transform businesses by liberating collaborators from repetitive tasks through advanced language models (LLM). Their solution begins to take shape with the goal of automating data management and significantly improving decision-making processes.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <div class="timeline-image">
                            <img src="images/lancement.webp" alt="1ère solution d'automatisation">
                        </div>
                        <div class="timeline-text">
                            <h3 class="timeline-title">1<sup>st</sup> Automation Solution</h3>
                            <p class="timeline-description">
                                After long months of hard work, BRAIN Technology finally launches its first solution. This platform, designed to automate tasks for communication agencies and digital marketing, radically transforms the daily lives of its users. Thanks to advanced AI models, it becomes a reference for companies seeking to optimize their productivity. This initial success confirms Houssam and Mounim in their vision and pushes them to develop increasingly innovative solutions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Technology Partners</span>
                </div>
                <h2 class="section-title">
                    Our Technology
                    <span class="gradient-text">Partners</span>
                </h2>
            </div>
            
            <div class="partners-grid">
                <div class="partner-item">
                    <img src="images/7.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/8.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/9.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/1.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/2.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/3.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/4.png" alt="Partner" class="partner-logo">
                </div>
                <div class="partner-item">
                    <img src="images/5.png" alt="Partner" class="partner-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section" id="values">
        <div class="section-container">
            <div class="section-header">
                <div class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span>Our Values</span>
                </div>
                <h2 class="section-title">
                    The Values That
                    <span class="gradient-text">Drive Us</span>
                </h2>
            </div>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <img src="images/valeurs/agile.png" alt="Agilité" class="value-image">
                    </div>
                    <h3 class="value-title">Agility</h3>
                    <p class="value-description">
                        Your business evolves, and we evolve with you. Our solutions are
                        flexible and adapt to your specific needs, allowing you to
                        remain agile in a constantly changing market.
                    </p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <img src="images/valeurs/inovation ecosystem.png" alt="Éco-responsabilité" class="value-image">
                    </div>
                    <h3 class="value-title">Eco-responsibility</h3>
                    <p class="value-description">
                        We combine performance and environmental respect. By optimizing
                        your processes, we help you reduce your ecological footprint
                        while increasing your efficiency.
                    </p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <img src="images/valeurs/Big data and analytic.png" alt="Transparence" class="value-image">
                    </div>
                    <h3 class="value-title">Transparency</h3>
                    <p class="value-description">
                        A healthy collaboration is based on trust. With BRAIN Technology,
                        there are no hidden surprises or incomprehensible jargon. We
                        accompany you with clarity at every step.
                    </p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <img src="images/valeurs/Design thinking.png" alt="Innovation" class="value-image">
                    </div>
                    <h3 class="value-title">Innovation</h3>
                    <p class="value-description">
                        Innovation is our driving force. We put cutting-edge
                        technologies, once reserved for industry giants, within your reach
                        to propel your SME to new heights.
                    </p>
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
                    <span>Client Testimonials</span>
                </div>
                <h2 class="section-title">
                    What Our Clients
                    <span class="gradient-text">Say</span>
                </h2>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="images/avatar/author/sm-q.jpg" alt="Élodie Martin" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Élodie Martin</h4>
                            <p class="testimonial-role">General Manager ComDigitale</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="quote-icon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p class="testimonial-text">
                            BRain Technology has completely transformed our way of working. Thanks to
                            automation, we have gained precious time.
                        </p>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="images/avatar/author/sm-r.jpg" alt="Jean Dupont" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Jean Dupont</h4>
                            <p class="testimonial-role">IT Manager at ImmoPlus</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="quote-icon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p class="testimonial-text">
                            BRain's blockchain solution has brought total transparency to our
                            transactions, strengthening our partners' trust.
                        </p>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="images/avatar/author/sm-s.jpg" alt="Sophie Leclerc" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Sophie Leclerc</h4>
                            <p class="testimonial-role">Quality Manager at AgroBio</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="quote-icon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p class="testimonial-text">
                            Thanks to BRain Technology, we have been able to improve the traceability of our
                            products, ensuring total transparency.
                        </p>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="images/avatar/author/sm-r.jpg" alt="Laurent Bernard" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Laurent Bernard</h4>
                            <p class="testimonial-role">CEO at TechVille</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="quote-icon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p class="testimonial-text">
                            BRain's solutions have allowed us to make a leap forward in our
                            digital transformation.
                        </p>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="images/avatar/author/sm-q.jpg" alt="Caroline Durand" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Caroline Durand</h4>
                            <p class="testimonial-role">Operations Director at InnovGreen</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="quote-icon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p class="testimonial-text">
                            The efficiency of our operations has been transformed thanks to BRain's
                            automation.
                        </p>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="images/avatar/author/sm-s.jpg" alt="Thomas Lefèvre" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Thomas Lefèvre</h4>
                            <p class="testimonial-role">CTO at DataSoft</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="quote-icon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p class="testimonial-text">
                            With BRain, we have reached a milestone in optimizing our IT processes.
                        </p>
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
                    <span class="gradient-text">Your Business?</span>
                </h2>
                <p class="cta-description">
                    Join the hundreds of companies already using BRAIN Technology to revolutionize 
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
                        <span>Discover Our Solutions</span>
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
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/about.js') }}"></script>
@endpush
