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
    
    <!-- Additional Styles -->
    @stack('styles')
</head>

<body class="bg-neutral-900 text-neutral-100 antialiased">
    <!-- Neural Network Background -->
    <canvas id="neural-network-canvas" class="neural-network-canvas"></canvas>
    
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
    
    <!-- Chat Widget -->
    @include('partials.chat-widget')
    
    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Analytics / Tracking (if needed) -->
    @stack('analytics')
    
</body>
</html>
