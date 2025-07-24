<header class="sticky top-0 z-40 bg-neutral-900/90 backdrop-blur-md border-b border-neutral-700/50" role="banner">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8" aria-label="Main navigation">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('assets/LogoBrainBlanc.png') }}" 
                         alt="BRAIN Technology Logo" 
                         class="h-8 w-auto transition-transform duration-300 group-hover:scale-105">
                    <span class="font-display font-bold text-xl text-white hidden sm:block">
                        BRAIN
                    </span>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                
                <!-- Solutions Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 text-neutral-300 hover:text-white transition-colors duration-200 py-2"
                            aria-expanded="false" aria-haspopup="true">
                        <span>Solutions</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 w-80 bg-neutral-800 border border-neutral-700 rounded-card shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 mt-1">
                        <div class="p-6">
                            <div class="space-y-4">
                                <a href="{{ url('/solutions/brain-invest') }}" class="block p-3 rounded-button hover:bg-neutral-700 transition-colors duration-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-primary-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-white">Brain Invest</h4>
                                            <p class="text-sm text-neutral-400">AI-powered investment analysis and portfolio optimization</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ url('/solutions/brain-rh') }}" class="block p-3 rounded-button hover:bg-neutral-700 transition-colors duration-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-accent-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-accent-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-white">Brain RH+</h4>
                                            <p class="text-sm text-neutral-400">Intelligent HR management and talent optimization</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ url('/solutions/brain-assistant') }}" class="block p-3 rounded-button hover:bg-neutral-700 transition-colors duration-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-warning/10 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-warning" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-white">Brain Assistant</h4>
                                            <p class="text-sm text-neutral-400">Conversational AI for business automation</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Technology -->
                <a href="{{ url('/technology') }}" 
                   class="text-neutral-300 hover:text-white transition-colors duration-200 py-2">
                    Technology
                </a>
                
                <!-- Industries -->
                <a href="{{ url('/industries') }}" 
                   class="text-neutral-300 hover:text-white transition-colors duration-200 py-2">
                    Industries
                </a>
                
                <!-- About -->
                <a href="{{ url('/about') }}" 
                   class="text-neutral-300 hover:text-white transition-colors duration-200 py-2">
                    About
                </a>
                
                <!-- Resources -->
                <a href="{{ url('/resources') }}" 
                   class="text-neutral-300 hover:text-white transition-colors duration-200 py-2">
                    Resources
                </a>
                
            </div>
            
            <!-- CTA Buttons -->
            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                <a href="{{ url('/demo') }}" 
                   class="btn-secondary text-sm">
                    Request Demo
                </a>
                <a href="{{ url('/contact') }}" 
                   class="btn-primary text-sm">
                    Talk to Brain Assistant
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button type="button" 
                    class="lg:hidden p-2 rounded-button text-neutral-400 hover:text-white hover:bg-neutral-800 transition-colors duration-200"
                    aria-controls="mobile-menu" 
                    aria-expanded="false"
                    id="mobile-menu-button">
                <span class="sr-only">Open main menu</span>
                <!-- Hamburger Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
        </div>
        
        <!-- Mobile Menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-neutral-800 rounded-card mt-2">
                
                <!-- Solutions -->
                <div class="px-3 py-2">
                    <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wide mb-2">Solutions</div>
                    <div class="space-y-1">
                        <a href="{{ url('/solutions/brain-invest') }}" class="block px-3 py-2 text-sm text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                            Brain Invest
                        </a>
                        <a href="{{ url('/solutions/brain-rh') }}" class="block px-3 py-2 text-sm text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                            Brain RH+
                        </a>
                        <a href="{{ url('/solutions/brain-assistant') }}" class="block px-3 py-2 text-sm text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                            Brain Assistant
                        </a>
                    </div>
                </div>
                
                <!-- Other Links -->
                <a href="{{ url('/technology') }}" class="block px-3 py-2 text-base text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                    Technology
                </a>
                <a href="{{ url('/industries') }}" class="block px-3 py-2 text-base text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                    Industries
                </a>
                <a href="{{ url('/about') }}" class="block px-3 py-2 text-base text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                    About
                </a>
                <a href="{{ url('/resources') }}" class="block px-3 py-2 text-base text-neutral-300 hover:text-white hover:bg-neutral-700 rounded-button transition-colors">
                    Resources
                </a>
                
                <!-- Mobile CTAs -->
                <div class="px-3 py-4 space-y-2 border-t border-neutral-700">
                    <a href="{{ url('/demo') }}" class="block w-full btn-secondary text-center">
                        Request Demo
                    </a>
                    <a href="{{ url('/contact') }}" class="block w-full btn-primary text-center">
                        Talk to Brain Assistant
                    </a>
                </div>
                
            </div>
        </div>
        
    </nav>
</header>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
            
            // Change icon
            const icon = mobileMenuButton.querySelector('svg');
            if (!isExpanded) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            } else {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            }
        });
    }
});
</script>
