<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'BRAIN - Advanced AI, Automation & Blockchain Solutions for Modern Enterprises')">
    <meta name="keywords" content="AI, Artificial Intelligence, Automation, Blockchain, Multi-Agent Systems, RAG, FinTech, HRTech">
    <meta name="author" content="BRAIN Technology">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'BRAIN - AI & Automation Solutions')">
    <meta property="og:description" content="@yield('og_description', 'Transform your business with cutting-edge AI, automation, and blockchain solutions')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/og-image.png') }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Title -->
    <title>@yield('title', 'BRAIN - AI & Automation Solutions')</title>
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- RAG Chat Widget Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/rag-chat-widget.css') }}">
    
    <!-- Additional Styles -->
    @stack('styles')
    
    <style>
    /* Global spacing for all pages to account for fixed header */
    main {
        padding-top: 120px;
    }
    
    /* Ensure consistent font family across all pages */
    body {
        font-family: 'Sora', 'Inter', system-ui, sans-serif;
    }
    
    /* Ensure header is always on top */
    .header-ultra { z-index: 1000; }

    /* Keep app content above background layers */
    #app, #main-content { position: relative; z-index: 1; }
    </style>
</head>

<body class="bg-gradient-to-b from-transparent to-black/20 text-neutral-100 antialiased min-h-screen">
    <!-- Soft energy glow behind neural lines -->
    <div class="neural-energy-glow" aria-hidden="true"></div>
    <!-- Three.js 3D network (preferred when available) -->
    <div id="three-network-bg" class="three-network-bg" aria-hidden="true"></div>
    
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-500 text-white px-4 py-2 rounded-button z-50">
        Skip to main content
    </a>
    
    <!-- App Root -->
    <div id="app" class="min-h-screen flex flex-col">
        
        <!-- Header -->
        @include('partials.header')
        
        <!-- Main Content -->
        <main id="main-content" class="flex-1" role="main">
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('partials.footer')
        
    </div>
    
    <!-- RAG Chat Widget -->
    <script src="{{ asset('assets/js/rag-chat-widget.js') }}"></script>
    
    <!-- Three.js background (CDN) + initializer -->
    <script defer src="https://unpkg.com/three@0.159.0/build/three.min.js"></script>
    <script defer src="{{ asset('assets/js/three-network-mesh.js') }}?v={{ time() }}"></script>
    <script>
        // When THREE loads, ensure proper initialization
        window.addEventListener('load', function() {
            console.log('🔄 Window loaded, checking Three.js...');
            if (window.THREE && document.getElementById('three-network-bg')) {
                console.log('✅ Three.js and container ready');
                document.body.classList.add('has-three-bg');
                // Force initialization
                if (window.BrainThreeNetwork && typeof window.BrainThreeNetwork.init === 'function') {
                    console.log('🚀 Force initializing comet system...');
                    window.BrainThreeNetwork.init('three-network-bg');
                } else {
                    console.error('❌ BrainThreeNetwork not available:', window.BrainThreeNetwork);
                }
            } else {
                console.error('❌ Missing Three.js or container:', {
                    THREE: !!window.THREE,
                    container: !!document.getElementById('three-network-bg')
                });
            }
        });
    </script>
    <script>
        // Initialize RAG Chat Widget
        document.addEventListener('DOMContentLoaded', function() {
            window.ragChatWidget = new BrainGenRAGChatWidget({
                apiEndpoint: '/api/chat',
                qualificationEndpoint: '/api/chat/qualify',
                autoOpen: false,
                theme: 'dark',
                position: 'bottom-right',
                welcomeMessage: "Hi! I'm your AI assistant from BrainGenTechnology. How can I help you explore our AI, automation, and blockchain solutions today?",
                brandName: 'BrainGenTechnology',
                autoQualifyAfter: 4
            });
            
            // Listen for lead qualification events
            document.addEventListener('ragChatLeadQualified', function(event) {
                console.log('Lead qualified:', event.detail);
                
                // Optional: Send to analytics
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'lead_qualified', {
                        'lead_score': event.detail.qualification.lead_score,
                        'sales_ready': event.detail.qualification.sales_ready,
                        'company_size': event.detail.qualification.company_size
                    });
                }
            });
        });
    </script>
    
    <!-- Chat Widget (Legacy) -->
    @include('partials.chat-widget')
    
    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Analytics / Tracking (if needed) -->
    @stack('analytics')
    
</body>
</html>
