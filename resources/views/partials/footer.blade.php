<footer class="bg-neutral-800 border-t border-neutral-700" role="contentinfo">
    <div class="container section-padding">
        
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            
            <!-- Brand Column -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('assets/LogoBrainBlanc.png') }}" 
                         alt="BRAIN Technology Logo" 
                         class="h-8 w-auto">
                    <span class="font-display font-bold text-xl text-white">BRAIN</span>
                </div>
                <p class="text-neutral-400 mb-6 leading-relaxed">
                    Advanced AI, Automation & Blockchain solutions that transform how modern enterprises operate and compete in the digital economy.
                </p>
                
                <!-- Social Links -->
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-neutral-700 hover:bg-primary-500 rounded-full flex items-center justify-center transition-colors duration-300" aria-label="LinkedIn">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-neutral-700 hover:bg-primary-500 rounded-full flex items-center justify-center transition-colors duration-300" aria-label="Twitter">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-neutral-700 hover:bg-primary-500 rounded-full flex items-center justify-center transition-colors duration-300" aria-label="GitHub">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Solutions Column -->
            <div>
                <h3 class="font-display font-semibold text-white mb-6">Solutions</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ url('/solutions/brain-invest') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Brain Invest
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/solutions/brain-rh') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Brain RH+
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/solutions/brain-assistant') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Brain Assistant
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/solutions') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            All Solutions
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Company Column -->
            <div>
                <h3 class="font-display font-semibold text-white mb-6">Company</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ url('/about') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/technology') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Technology
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/industries') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Industries
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/resources') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Resources
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Support Column -->
            <div>
                <h3 class="font-display font-semibold text-white mb-6">Support</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ url('/faq') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/demo') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Request Demo
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/support') }}" class="text-neutral-400 hover:text-white transition-colors duration-200">
                            Documentation
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-neutral-400 hover:text-white transition-colors duration-200" onclick="toggleChatWidget()">
                            Talk to Brain Assistant
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>
        
        <!-- Bottom Section -->
        <div class="mt-12 pt-8 border-t border-neutral-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                
                <!-- Copyright -->
                <div class="text-neutral-400 text-sm mb-4 md:mb-0">
                    © {{ date('Y') }} BRAIN Technology. All rights reserved.
                </div>
                
                <!-- Legal Links -->
                <div class="flex flex-wrap gap-6">
                    <a href="{{ url('/privacy') }}" class="text-neutral-400 hover:text-white text-sm transition-colors duration-200">
                        Privacy Policy
                    </a>
                    <a href="{{ url('/terms') }}" class="text-neutral-400 hover:text-white text-sm transition-colors duration-200">
                        Terms of Service
                    </a>
                    <a href="{{ url('/security') }}" class="text-neutral-400 hover:text-white text-sm transition-colors duration-200">
                        Security
                    </a>
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
