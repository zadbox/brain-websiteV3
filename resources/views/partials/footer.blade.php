<footer class="modern-footer">
  <div class="footer-background">
    <div class="footer-particles"></div>
    <div class="footer-grid"></div>
  </div>
  
  <div class="container">
    <div class="footer-content">
      <!-- Main Footer Section -->
      <div class="footer-main">
        <div class="footer-brand">
          <div class="brand-logo">
            <img src="{{ asset('assets/LogoBrainBlanc.png') }}" alt="BRAIN Technology Logo" class="h-10 w-auto">
            <span class="brand-text">BRAIN TECHNOLOGY</span>
          </div>
          <p class="brand-description">
            Transform your business with next-generation artificial intelligence. 
            We help you free your teams from repetitive and low-value tasks by automating what can be automated, 
            allowing them to focus on strategic and creative missions.
          </p>
          <div class="social-links">
            <a href="#" class="social-link" aria-label="LinkedIn">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                <rect x="2" y="9" width="4" height="12"/>
                <circle cx="4" cy="4" r="2"/>
              </svg>
            </a>
            <a href="#" class="social-link" aria-label="Twitter">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
              </svg>
            </a>
            <a href="#" class="social-link" aria-label="Facebook">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
              </svg>
            </a>
            <a href="#" class="social-link" aria-label="YouTube">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/>
                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>
              </svg>
            </a>
          </div>
        </div>
        
        <div class="footer-links">
          <div class="footer-column">
            <h4 class="column-title">Useful Links</h4>
            <ul class="footer-menu">
              <li><a href="{{url('/')}}" class="footer-link">Home</a></li>
              <li><a href="{{url('/about')}}" class="footer-link">About Us</a></li>
              <li><a href="{{url('/services')}}" class="footer-link">Our Services</a></li>
              <li><a href="{{url('/demarche')}}" class="footer-link">Our Approach</a></li>
              <li><a href="{{url('/contact')}}" class="footer-link">Contact</a></li>
            </ul>
          </div>
          
          <div class="footer-column">
            <h4 class="column-title">AI Solutions</h4>
            <ul class="footer-menu">
              <li><a href="{{ url('/solutions/brain-invest') }}" class="footer-link">Brain Invest</a></li>
              <li><a href="{{ url('/solutions/brain-rh') }}" class="footer-link">Brain RH+</a></li>
              <li><a href="{{ url('/solutions/brain-assistant') }}" class="footer-link">Brain Assistant</a></li>
              <li><a href="{{ url('/solutions') }}" class="footer-link">All Solutions</a></li>
              <li><a href="#" class="footer-link">Blockchain & AI</a></li>
            </ul>
          </div>
          
          <div class="footer-column">
            <h4 class="column-title">Services</h4>
            <ul class="footer-menu">
              <li><a href="{{ url('/services#service-communication') }}" class="footer-link">Communication & Digital Marketing</a></li>
              <li><a href="{{ url('/services#service-immo') }}" class="footer-link">Real Estate Promotion</a></li>
              <li><a href="{{ url('/services#service-agro') }}" class="footer-link">Agri-food & Traceability</a></li>
              <li><a href="{{ url('/services#service-conciergerie') }}" class="footer-link">Concierge Services</a></li>
            </ul>
          </div>
          
          <div class="footer-column">
            <h4 class="column-title">Support</h4>
            <ul class="footer-menu">
              <li><a href="{{ url('/faq') }}" class="footer-link">FAQ</a></li>
              <li><a href="{{ url('/demo') }}" class="footer-link">Request Demo</a></li>
              <li><a href="{{ url('/support') }}" class="footer-link">Documentation</a></li>
              <li><a href="#" class="footer-link" onclick="toggleChatWidget()">Talk to Brain Assistant</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <!-- Newsletter Section -->
      <div class="footer-newsletter">
        <div class="newsletter-content">
          <div class="newsletter-info">
            <h4 class="newsletter-title">Stay Connected</h4>
            <p class="newsletter-description">
              Get the latest news about AI and our technological innovations
            </p>
          </div>
          <div class="newsletter-form">
            <div class="input-group">
              <input type="email" placeholder="Your email address" class="newsletter-input" />
              <button type="submit" class="newsletter-btn">
                <span>Subscribe</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </button>
            </div>
            <p class="newsletter-privacy">
              By subscribing, you accept our 
              <a href="#" class="privacy-link">privacy policy</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="footer-bottom-content">
        <div class="copyright">
          <p>&copy; {{ date('Y') }} BRAIN TECHNOLOGY. All rights reserved.</p>
        </div>
        <div class="footer-legal">
          <a href="{{ url('/privacy') }}" class="legal-link">Privacy Policy</a>
          <a href="{{ url('/terms') }}" class="legal-link">Terms of Service</a>
          <a href="{{ url('/security') }}" class="legal-link">Security</a>
          <a href="#" class="legal-link">Cookies</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<script>
function toggleChatWidget() {
    // This will be implemented when the chat widget is ready
    console.log('Chat widget toggle');
}
</script>
