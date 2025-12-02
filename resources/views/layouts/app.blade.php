<!DOCTYPE html>
<html lang="{{ $seo['locale'] ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        // ALWAYS prioritize PageSeo from database - ignore controller SEO if PageSeo exists
        $seoService = app(\App\Services\SeoService::class);
        
        // Detect page key from route
        $routeName = request()->route()?->getName();
        $pageKeyMap = [
            'home' => 'home',
            'articles.index' => 'articles.index',
            'articles.show' => 'articles.show',
            'categories.index' => 'categories.index',
            'categories.show' => 'categories.show',
            'tags.index' => 'tags.index',
            'tags.show' => 'tags.show',
            'search' => 'search',
            'about' => 'about',
            'contact' => 'contact',
            'privacy' => 'privacy',
            'terms' => 'terms',
        ];
        
        $detectedPageKey = $pageKeyMap[$routeName] ?? null;
        
        // ALWAYS check PageSeo first - this overrides controller SEO
        if ($detectedPageKey) {
            // Use the model method to get fresh PageSeo data
            $pageSeo = \App\Models\PageSeo::getByPageKey($detectedPageKey);
            
            if ($pageSeo) {
                // PageSeo exists and is active - ALWAYS use it (overrides controller SEO)
                // Pass empty array to ensure PageSeo data takes priority
                $seo = $seoService->generate([], $detectedPageKey);
            } else {
                // No active PageSeo - use controller SEO or auto-detect
                $seo = $seo ?? $seoService->forCurrentRoute();
            }
        } else {
            // Unknown route - use controller SEO or auto-detect
            $seo = $seo ?? $seoService->forCurrentRoute();
        }
    @endphp
    
    <!-- Primary Meta Tags -->
    <title>{{ $seo['title'] ?? 'Tech Blog - Articles & Tutorials' }}</title>
    <meta name="title" content="{{ $seo['title'] ?? 'Tech Blog - Articles & Tutorials' }}">
    <meta name="description" content="{{ $seo['description'] ?? 'Explore the latest technology articles, programming tutorials, and tech insights. Stay updated with cutting-edge developments.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'tech blog, programming, tutorials, technology, articles, web development, software' }}">
    <meta name="author" content="{{ $seo['author'] ?? 'Tech Blog' }}">
    <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}">
    <meta name="language" content="{{ $seo['locale'] ?? 'en' }}">
    <meta name="revisit-after" content="7 days">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['url'] ?? url()->current() }}">
    <meta property="og:title" content="{{ $seo['og_title'] ?? $seo['title'] ?? 'Tech Blog - Articles & Tutorials' }}">
    <meta property="og:description" content="{{ $seo['og_description'] ?? $seo['description'] ?? 'Explore the latest technology articles, programming tutorials, and tech insights. Stay updated with cutting-edge developments.' }}">
    <meta property="og:image" content="{{ $seo['og_image'] ?? $seo['image'] ?? asset('favicon.ico') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $seo['title'] ?? 'Tech Blog' }}">
    <meta property="og:site_name" content="Tech Blog">
    <meta property="og:locale" content="{{ $seo['locale'] ?? 'en_US' }}">
    @if(!empty($seo['published_time']))
    <meta property="og:published_time" content="{{ $seo['published_time'] }}">
    @endif
    @if(!empty($seo['modified_time']))
    <meta property="og:modified_time" content="{{ $seo['modified_time'] }}">
    @endif
    @if($seoService->getFacebookAppId())
    <meta property="fb:app_id" content="{{ $seoService->getFacebookAppId() }}">
    @endif
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}">
    <meta name="twitter:url" content="{{ $seo['url'] ?? url()->current() }}">
    <meta name="twitter:title" content="{{ $seo['twitter_title'] ?? $seo['title'] ?? 'Tech Blog - Articles & Tutorials' }}">
    <meta name="twitter:description" content="{{ $seo['twitter_description'] ?? $seo['description'] ?? 'Explore the latest technology articles, programming tutorials, and tech insights. Stay updated with cutting-edge developments.' }}">
    <meta name="twitter:image" content="{{ $seo['twitter_image'] ?? $seo['image'] ?? asset('favicon.ico') }}">
    <meta name="twitter:image:alt" content="{{ $seo['twitter_title'] ?? $seo['title'] ?? 'Tech Blog' }}">
    @if($seoService->getTwitterHandle())
    <meta name="twitter:site" content="{{ $seoService->getTwitterHandle() }}">
    <meta name="twitter:creator" content="{{ $seoService->getTwitterHandle() }}">
    @endif
    
    <!-- Additional SEO Enhancements -->
    <meta name="theme-color" content="#E50914">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <meta name="application-name" content="Tech Blog">
    <meta name="msapplication-TileColor" content="#E50914">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    
    <!-- Alternate Languages (Hreflang) -->
    @if(!empty($seo['alternate_locales']))
        @foreach($seo['alternate_locales'] as $locale => $url)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
        @endforeach
    @endif
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Structured Data (JSON-LD) -->
    @if(!empty($seo['schema']))
        @foreach($seo['schema'] as $schema)
        <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        @endforeach
    @endif
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
                    },
                    colors: {
                        'bg-primary': '#0D0D0D',
                        'bg-secondary': '#181818',
                        'bg-card': '#1F1F1F',
                        'bg-card-hover': '#2A2A2A',
                        'accent': '#E50914',
                        'accent-dark': '#B20710',
                        'accent-light': '#F40612',
                        'text-primary': '#FFFFFF',
                        'text-secondary': '#B3B3B3',
                        'text-tertiary': '#808080',
                        'text-muted': '#666666',
                        'border-primary': 'rgba(255, 255, 255, 0.1)',
                        'border-secondary': 'rgba(255, 255, 255, 0.05)',
                        'rating': '#FFD700',
                    },
                    backgroundImage: {
                        'gradient-primary': 'linear-gradient(135deg, #E50914 0%, #B20710 100%)',
                        'gradient-overlay': 'linear-gradient(180deg, rgba(13, 13, 13, 0.3) 0%, rgba(13, 13, 13, 0.9) 100%)',
                    },
                    boxShadow: {
                        'accent': '0 10px 30px rgba(229, 9, 20, 0.3)',
                        'accent-lg': '0 10px 30px rgba(229, 9, 20, 0.4)',
                        'card': '0 4px 12px rgba(0, 0, 0, 0.3)',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        :root {
            /* ============================================
               DARK NEUTRAL + RED ACCENT THEME
               Professional theme optimized for movie/TV content
               ============================================ */
            
            /* Primary Background */
            --bg-primary: #0D0D0D;
            
            /* Secondary Background */
            --bg-secondary: #181818;
            
            /* Cards/Containers */
            --bg-card: #1F1F1F;
            --bg-card-hover: #2A2A2A;
            
            /* Accent Color (Buttons/Links) - Netflix Red */
            --color-accent: #E50914;
            --color-accent-dark: #B20710;
            --color-accent-light: #F40612;
            --color-accent-hover: #F40612;
            
            /* Text Colors */
            --text-primary: #FFFFFF;
            --text-secondary: #B3B3B3;
            --text-tertiary: #808080;
            --text-muted: #666666;
            --text-disabled: #4D4D4D;
            
            /* Background Overlays */
            --bg-overlay: rgba(13, 13, 13, 0.95);
            --bg-overlay-light: rgba(31, 31, 31, 0.8);
            --bg-overlay-medium: rgba(31, 31, 31, 0.9);
            --bg-overlay-dark: rgba(13, 13, 13, 0.98);
            --bg-input: rgba(31, 31, 31, 0.8);
            
            /* Border Colors */
            --border-primary: rgba(255, 255, 255, 0.1);
            --border-secondary: rgba(255, 255, 255, 0.05);
            --border-accent: rgba(229, 9, 20, 0.3);
            --border-focus: rgba(229, 9, 20, 0.5);
            
            /* Gradient Colors */
            --gradient-primary: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
            --gradient-primary-reverse: linear-gradient(135deg, var(--color-accent-dark) 0%, var(--color-accent) 100%);
            --gradient-background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            --gradient-overlay: linear-gradient(180deg, rgba(13, 13, 13, 0.3) 0%, rgba(13, 13, 13, 0.9) 100%);
            --gradient-overlay-dark: linear-gradient(180deg, rgba(13, 13, 13, 0.5) 0%, rgba(13, 13, 13, 0.95) 100%);
            
            /* Status Colors */
            --color-success: #4ade80;
            --color-warning: #fbbf24;
            --color-error: #ef4444;
            --color-info: #60a5fa;
            --color-rating: #FFD700;
            
            /* Shadow Colors */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.5);
            --shadow-xl: 0 10px 30px rgba(229, 9, 20, 0.3);
            --shadow-glow: 0 0 20px rgba(229, 9, 20, 0.4);
            --shadow-card: 0 4px 12px rgba(0, 0, 0, 0.3);
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;
            
            /* Border Radius */
            --radius-xs: 4px;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 25px;
            --radius-xl: 50px;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 0.15s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
            
            /* Z-Index */
            --z-dropdown: 1000;
            --z-sticky: 1010;
            --z-modal: 1020;
            --z-tooltip: 1030;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Light Mode Styles (Default) */
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #FFFFFF !important;
            color: #1F1F1F !important;
            min-height: 100vh;
            transition: background 0.3s ease, color 0.3s ease;
            font-weight: 400;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        
        p {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.7;
        }
        
        a {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        
        button {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        .bg-bg-primary {
            background-color: #FFFFFF !important;
        }
        
        .bg-bg-card {
            background-color: #FFFFFF !important;
            border-color: #E0E0E0 !important;
        }
        
        .bg-bg-card-hover {
            background-color: #F5F5F5 !important;
        }
        
        .text-text-primary {
            color: #1F1F1F !important;
        }
        
        .text-text-secondary {
            color: #666666 !important;
        }
        
        .text-text-tertiary {
            color: #808080 !important;
        }
        
        .text-text-muted {
            color: #999999 !important;
        }
        
        .border-border-primary {
            border-color: #E0E0E0 !important;
        }
        
        .border-border-secondary {
            border-color: #D0D0D0 !important;
        }
        
        nav {
            background-color: #FFFFFF !important;
            border-bottom-color: #E0E0E0 !important;
        }
        
        nav .text-text-primary {
            color: #1F1F1F !important;
        }
        
        footer {
            background-color: #F8F8F8 !important;
            border-top-color: #E0E0E0 !important;
        }
        
        footer .text-text-secondary {
            color: #666666 !important;
        }
        
        input, textarea, select {
            background-color: #F5F5F5 !important;
            border-color: #E0E0E0 !important;
            color: #1F1F1F !important;
        }
        
        input::placeholder, textarea::placeholder {
            color: #999999 !important;
        }
        
        /* Dark Mode Styles */
        body.dark-mode,
        html.dark body {
            background: linear-gradient(135deg, #0D0D0D 0%, #181818 100%) !important;
            color: #FFFFFF !important;
        }
        
        body.dark-mode .bg-bg-primary,
        html.dark .bg-bg-primary {
            background-color: #0D0D0D !important;
        }
        
        body.dark-mode .bg-bg-card,
        html.dark .bg-bg-card {
            background-color: #1F1F1F !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark-mode .bg-bg-card-hover,
        html.dark .bg-bg-card-hover {
            background-color: #2A2A2A !important;
        }
        
        body.dark-mode .text-text-primary,
        html.dark .text-text-primary {
            color: #FFFFFF !important;
        }
        
        body.dark-mode .text-text-secondary,
        html.dark .text-text-secondary {
            color: #B3B3B3 !important;
        }
        
        body.dark-mode .text-text-tertiary,
        html.dark .text-text-tertiary {
            color: #808080 !important;
        }
        
        body.dark-mode .text-text-muted,
        html.dark .text-text-muted {
            color: #666666 !important;
        }
        
        body.dark-mode .border-border-primary,
        html.dark .border-border-primary {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark-mode .border-border-secondary,
        html.dark .border-border-secondary {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }
        
        body.dark-mode nav,
        html.dark nav {
            background-color: rgba(13, 13, 13, 0.95) !important;
            border-bottom-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark-mode nav .text-text-primary,
        html.dark nav .text-text-primary {
            color: #FFFFFF !important;
        }
        
        body.dark-mode footer,
        html.dark footer {
            background-color: #1F1F1F !important;
            border-top-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark-mode footer .text-text-secondary,
        html.dark footer .text-text-secondary {
            color: #B3B3B3 !important;
        }
        
        body.dark-mode input, 
        body.dark-mode textarea, 
        body.dark-mode select,
        html.dark input,
        html.dark textarea,
        html.dark select {
            background-color: #1F1F1F !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #FFFFFF !important;
        }
        
        body.dark-mode input::placeholder, 
        body.dark-mode textarea::placeholder,
        html.dark input::placeholder,
        html.dark textarea::placeholder {
            color: #666666 !important;
        }
        
        /* Additional Dark Mode Rules for Cards and Text */
        body.dark-mode article,
        html.dark article {
            background-color: #1F1F1F !important;
        }
        
        body.dark-mode article h2,
        html.dark article h2 {
            color: #FFFFFF !important;
        }
        
        body.dark-mode article p,
        html.dark article p {
            color: #B3B3B3 !important;
        }
        
        body.dark-mode article .text-gray-900,
        html.dark article .text-gray-900 {
            color: #FFFFFF !important;
        }
        
        body.dark-mode article .text-gray-600,
        html.dark article .text-gray-600 {
            color: #B3B3B3 !important;
        }
        
        body.dark-mode article .text-gray-500,
        html.dark article .text-gray-500 {
            color: #808080 !important;
        }
        
        body.dark-mode .bg-white,
        html.dark .bg-white {
            background-color: #1F1F1F !important;
        }
        
        body.dark-mode .text-gray-900,
        html.dark .text-gray-900 {
            color: #FFFFFF !important;
        }
        
        body.dark-mode .text-gray-600,
        html.dark .text-gray-600 {
            color: #B3B3B3 !important;
        }
        
        body.dark-mode .text-gray-500,
        html.dark .text-gray-500 {
            color: #808080 !important;
        }
        
        body.dark-mode .border-gray-200,
        html.dark .border-gray-200 {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark-mode .bg-gray-50,
        html.dark .bg-gray-50 {
            background-color: #2A2A2A !important;
        }
        
        body.dark-mode .bg-gray-100,
        html.dark .bg-gray-100 {
            background-color: #2A2A2A !important;
        }
        
        body.dark-mode .hover\:bg-gray-50:hover,
        html.dark .hover\:bg-gray-50:hover {
            background-color: #2A2A2A !important;
        }
        
        /* Force dark mode styles for all elements */
        html.dark body article,
        body.dark-mode article {
            background-color: #1F1F1F !important;
        }
        
        /* Apply dark background to article divs, but exclude image containers and their children */
        html.dark body article > div:not(.aspect-video),
        body.dark-mode article > div:not(.aspect-video),
        html.dark body article div:not(.aspect-video):not(.aspect-video *) {
            background-color: #1F1F1F !important;
        }
        
        /* Explicitly exclude image containers from dark background */
        html.dark body article .aspect-video,
        body.dark-mode article .aspect-video,
        html.dark body article .aspect-video *,
        body.dark-mode article .aspect-video * {
            background-color: transparent !important;
        }
        
        /* Keep the container background visible only for placeholder */
        html.dark body article .aspect-video.bg-gray-200.dark\:bg-gray-800,
        body.dark-mode article .aspect-video.bg-gray-200.dark\:bg-gray-800 {
            background-color: rgba(31, 41, 55, 0.3) !important;
        }
        
        html.dark body article h2,
        body.dark-mode article h2 {
            color: #FFFFFF !important;
        }
        
        html.dark body article h2 span,
        body.dark-mode article h2 span {
            color: #B3B3B3 !important;
        }
        
        /* Ensure titles are always visible - Light Mode */
        article h2 {
            color: #1F1F1F !important;
        }
        
        article h2 span {
            color: #666666 !important;
        }
        
        /* Ensure titles are always visible - Dark Mode */
        html.dark article h2,
        body.dark-mode article h2 {
            color: #FFFFFF !important;
        }
        
        html.dark article h2 span,
        body.dark-mode article h2 span {
            color: #B3B3B3 !important;
        }
        
        /* Override any inline styles for titles */
        html.dark article h2[style*="color"],
        body.dark-mode article h2[style*="color"] {
            color: #FFFFFF !important;
        }
        
        html.dark article h2 span[style*="color"],
        body.dark-mode article h2 span[style*="color"] {
            color: #B3B3B3 !important;
        }
        
        html.dark body article p,
        body.dark-mode article p {
            color: #B3B3B3 !important;
        }
        
        html.dark body article .text-gray-500,
        body.dark-mode article .text-gray-500 {
            color: #808080 !important;
        }
        
        html.dark body .bg-white,
        body.dark-mode .bg-white {
            background-color: #1F1F1F !important;
        }
        
        html.dark body .text-gray-900,
        body.dark-mode .text-gray-900 {
            color: #FFFFFF !important;
        }
        
        html.dark body .text-gray-600,
        body.dark-mode .text-gray-600 {
            color: #B3B3B3 !important;
        }
        
        html.dark body .text-gray-500,
        body.dark-mode .text-gray-500 {
            color: #808080 !important;
        }
        
        html.dark body .border-gray-200,
        body.dark-mode .border-gray-200 {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Sidebar dark mode fixes */
        html.dark body .lg\:col-span-1 div,
        body.dark-mode .lg\:col-span-1 div {
            background-color: #1F1F1F !important;
        }
        
        html.dark body .lg\:col-span-1 h3,
        body.dark-mode .lg\:col-span-1 h3 {
            color: #FFFFFF !important;
        }
        
        html.dark body .lg\:col-span-1 h4,
        body.dark-mode .lg\:col-span-1 h4 {
            color: #FFFFFF !important;
        }
        
        html.dark body .lg\:col-span-1 p,
        body.dark-mode .lg\:col-span-1 p {
            color: #B3B3B3 !important;
        }
        
        html.dark body .lg\:col-span-1 .border-b,
        body.dark-mode .lg\:col-span-1 .border-b {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Pagination dark mode */
        html.dark body .mt-8 a,
        body.dark-mode .mt-8 a {
            background-color: #1F1F1F !important;
            color: #B3B3B3 !important;
        }
        
        html.dark body .mt-8 a:hover,
        body.dark-mode .mt-8 a:hover {
            background-color: #2A2A2A !important;
            color: #FFFFFF !important;
        }
        
        html.dark body .mt-8 .bg-accent,
        body.dark-mode .mt-8 .bg-accent {
            background-color: #E50914 !important;
            color: #FFFFFF !important;
        }
        
        html.dark body .mt-8 span,
        body.dark-mode .mt-8 span {
            color: #B3B3B3 !important;
        }
        
        /* Filter tabs styling - Light mode */
        .flex-wrap a.bg-white {
            background-color: #FFFFFF !important;
            color: #1F1F1F !important;
            border-color: #E0E0E0 !important;
        }
        
        .flex-wrap a.bg-white:hover {
            background-color: #F5F5F5 !important;
        }
        
        .flex-wrap a.bg-accent {
            background-color: #E50914 !important;
            color: #FFFFFF !important;
            border-color: #E50914 !important;
        }
        
        /* Filter tabs styling - Dark mode */
        html.dark .flex-wrap a.bg-white,
        body.dark-mode .flex-wrap a.bg-white {
            background-color: #1F1F1F !important;
            color: #B3B3B3 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        html.dark .flex-wrap a.bg-white:hover,
        body.dark-mode .flex-wrap a.bg-white:hover {
            background-color: #2A2A2A !important;
            color: #FFFFFF !important;
        }
        
        html.dark .flex-wrap a.bg-accent,
        body.dark-mode .flex-wrap a.bg-accent {
            background-color: #E50914 !important;
            color: #FFFFFF !important;
            border-color: #E50914 !important;
        }
        
        /* Ensure image container divs don't hide images in dark mode */
        html.dark article .aspect-video,
        body.dark-mode article .aspect-video {
            background-color: transparent !important;
        }
        
        html.dark article .aspect-video.bg-gray-200,
        body.dark-mode article .aspect-video.bg-gray-200,
        html.dark article .aspect-video.dark\:bg-gray-800,
        body.dark-mode article .aspect-video.dark\:bg-gray-800 {
            background-color: transparent !important;
            background: none !important;
        }
        
        /* Ensure images are fully visible and bright in dark mode */
        html.dark article img,
        body.dark-mode article img,
        html.dark .aspect-video img,
        body.dark-mode .aspect-video img,
        html.dark article .aspect-video img,
        body.dark-mode article .aspect-video img,
        html.dark img[alt*="Movie"],
        body.dark-mode img[alt*="Movie"],
        html.dark img[alt*="TV Show"],
        body.dark-mode img[alt*="TV Show"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            filter: brightness(1.1) !important;
            -webkit-filter: brightness(1.1) !important;
            max-width: 100% !important;
            height: auto !important;
        }
        
        /* Ensure card images have proper stacking context and same size in dark mode */
        html.dark article .relative img,
        body.dark-mode article .relative img,
        html.dark article .aspect-video img,
        body.dark-mode article .aspect-video img {
            position: absolute !important;
            z-index: 1 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }
        
        /* Ensure aspect-video container maintains exact same size in dark mode as light mode */
        html.dark article .aspect-video,
        body.dark-mode article .aspect-video {
            width: 100% !important;
            aspect-ratio: 16 / 9 !important;
            min-height: 0 !important;
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
            max-width: 100% !important;
        }
        
        /* Ensure article containers maintain same dimensions in dark mode */
        html.dark article,
        body.dark-mode article {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }
        
        /* Ensure article links maintain same dimensions */
        html.dark article > a,
        body.dark-mode article > a {
            width: 100% !important;
            display: block !important;
        }
        
        /* Make overlay lighter in dark mode to show more of the image */
        html.dark article .absolute.inset-0.bg-gradient-to-t,
        body.dark-mode article .absolute.inset-0.bg-gradient-to-t {
            pointer-events: none !important;
            mix-blend-mode: normal !important;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0.15) 50%, transparent 70%) !important;
        }
        
        html.dark article .absolute.inset-0 > div,
        body.dark-mode article .absolute.inset-0 > div {
            pointer-events: auto !important;
        }
        
        /* TinyMCE Content Styling */
        .article-content {
            line-height: 1.8;
        }
        
        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            margin-top: 1em;
            margin-bottom: 0.5em;
            line-height: 1.3;
        }
        
        .article-content h1 {
            font-size: 2.5em;
        }
        
        .article-content h2 {
            font-size: 2em;
        }
        
        .article-content h3 {
            font-size: 1.75em;
        }
        
        .article-content h4 {
            font-size: 1.5em;
        }
        
        .article-content p {
            margin-bottom: 0.75em;
            line-height: 1.7;
        }
        
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1em 0;
        }
        
        .article-content figure {
            margin: 1em 0;
        }
        
        .article-content figure img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        .article-content figcaption {
            text-align: center;
            font-size: 0.875em;
            color: #666;
            margin-top: 0.5em;
            font-style: italic;
        }
        
        .article-content pre {
            background-color: #f4f4f4;
            padding: 0.75em;
            border-radius: 6px;
            overflow-x: auto;
            margin: 1em 0;
            border: 1px solid #e5e7eb;
            position: relative;
        }
        
        /* Code samples from TinyMCE codesample plugin */
        .article-content pre[class*="language-"],
        .article-content code[class*="language-"] {
            font-family: 'Fira Code', 'Courier New', 'Consolas', monospace;
            font-size: 0.9em;
            line-height: 1.6;
            direction: ltr;
            text-align: left;
            white-space: pre;
            word-spacing: normal;
            word-break: normal;
            tab-size: 4;
            hyphens: none;
        }
        
        .article-content pre[class*="language-"] {
            background-color: #2d2d2d;
            color: #f8f8f2;
            padding: 0.75em 1em;
            margin: 1em 0;
            overflow: auto;
            border-radius: 8px;
            border: 1px solid #3d3d3d;
        }
        
        .article-content code {
            background-color: #f4f4f4;
            padding: 0.2em 0.4em;
            border-radius: 3px;
            font-family: 'Fira Code', 'Courier New', 'Consolas', monospace;
            font-size: 0.9em;
            color: #e83e8c;
        }
        
        /* Inline code (not in pre) */
        .article-content p code,
        .article-content li code,
        .article-content td code {
            background-color: #f4f4f4;
            padding: 0.2em 0.4em;
            border-radius: 3px;
            font-size: 0.9em;
        }
        
        /* Code inside pre blocks */
        .article-content pre code {
            background-color: transparent;
            padding: 0;
            color: inherit;
            font-size: inherit;
            border-radius: 0;
        }
        
        /* Ensure code samples are visible */
        .article-content pre code[class*="language-"] {
            display: block;
            color: #f8f8f2;
        }
        
        .article-content blockquote {
            border-left: 4px solid #E50914;
            margin: 1em 0;
            padding-left: 1em;
            color: #666;
            font-style: italic;
        }
        
        .article-content ul,
        .article-content ol {
            margin: 1em 0;
            padding-left: 2em;
        }
        
        .article-content li {
            margin-bottom: 0.5em;
        }
        
        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }
        
        .article-content table td,
        .article-content table th {
            border: 1px solid #ddd;
            padding: 0.75em;
        }
        
        .article-content table th {
            background-color: #f2f2f2;
            font-weight: 600;
        }
        
        .article-content a {
            color: #E50914;
            text-decoration: underline;
        }
        
        .article-content a:hover {
            color: #b8070f;
        }
        
        /* Dark mode for article content */
        html.dark .article-content,
        body.dark-mode .article-content {
            color: #e5e7eb;
        }
        
        html.dark .article-content figcaption,
        body.dark-mode .article-content figcaption {
            color: #9ca3af;
        }
        
        html.dark .article-content blockquote,
        body.dark-mode .article-content blockquote {
            color: #d1d5db;
            border-left-color: #E50914;
        }
        
        html.dark .article-content pre,
        body.dark-mode .article-content pre {
            background-color: #1f2937;
            border-color: #374151;
        }
        
        html.dark .article-content pre[class*="language-"],
        body.dark-mode .article-content pre[class*="language-"] {
            background-color: #1e1e1e;
            border-color: #3d3d3d;
            color: #d4d4d4;
        }
        
        html.dark .article-content code,
        body.dark-mode .article-content code {
            background-color: #1f2937;
            color: #e5e7eb;
        }
        
        html.dark .article-content p code,
        html.dark .article-content li code,
        html.dark .article-content td code,
        body.dark-mode .article-content p code,
        body.dark-mode .article-content li code,
        body.dark-mode .article-content td code {
            background-color: #374151;
            color: #f472b6;
        }
        
        html.dark .article-content pre code[class*="language-"],
        body.dark-mode .article-content pre code[class*="language-"] {
            color: #d4d4d4;
        }
        
        html.dark .article-content table td,
        html.dark .article-content table th,
        body.dark-mode .article-content table td,
        body.dark-mode .article-content table th {
            border-color: #4b5563;
        }
        
        html.dark .article-content table th,
        body.dark-mode .article-content table th {
            background-color: #374151;
        }
    </style>
</head>
<body>
    <nav class="sticky top-0 z-50 bg-white backdrop-blur-lg shadow-lg border-b border-gray-200 dark:!bg-bg-primary/95 dark:!border-border-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="{{ route('home') }}" class="text-2xl md:text-3xl font-bold text-accent hover:text-accent-light transition-colors dark-mode:text-accent" style="font-family: 'Poppins', sans-serif; font-weight: 800; letter-spacing: -0.03em;">
                    Tech Blog
                </a>
                <ul class="hidden md:flex items-center gap-6 lg:gap-8">
                    <li><a href="{{ route('home') }}" class="text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Home</a></li>
                    <li><a href="{{ route('articles.index') }}" class="text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Articles</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Categories</a></li>
                    <li><a href="{{ route('tags.index') }}" class="text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Tags</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Contact</a></li>
                </ul>
                {{-- Search form commented out --}}
                {{-- <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center gap-2">
                    <input type="text" name="q" 
                           class="px-4 py-2 w-64 rounded-full bg-gray-100 border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all dark:!bg-bg-card dark:!border-border-primary dark:!text-white dark:!placeholder-text-muted" 
                           placeholder="Search articles..." 
                           value="{{ request('q') }}"
                           style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-full transition-all hover:scale-105 hover:shadow-accent" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Search
                    </button>
                </form> --}}
                <div class="flex items-center gap-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 transition-all dark:!bg-bg-card dark:!border-border-primary dark:!hover:bg-bg-card-hover">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="hidden md:block text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif;">
                                    {{ auth()->user()->name }}
                                </span>
                                <svg class="w-4 h-4 text-gray-900 dark:!text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white border border-gray-200 dark:!bg-bg-card dark:!border-border-primary z-50"
                                 style="display: none;">
                                <div class="py-1">
                                    <div class="px-4 py-2 border-b border-gray-200 dark:!border-border-primary">
                                        <p class="text-sm font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif;">
                                            {{ auth()->user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:!text-text-muted" style="font-family: 'Poppins', sans-serif;">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                    <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:!text-white dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif;">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            My Dashboard
                                        </div>
                                    </a>
                                    @if(auth()->user()->isAuthor())
                                        <a href="{{ route('author.dashboard') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:!text-white dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif;">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Author Dashboard
                                            </div>
                                        </a>
                                        <a href="{{ route('admin.articles.index') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:!text-white dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif;">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                My Articles
                                            </div>
                                        </a>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:!text-white dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif;">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                                Admin Dashboard
                                            </div>
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:!text-red-400 dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif;">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Logout
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Login/Register Buttons -->
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-900 hover:text-accent transition-colors font-semibold dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all hover:scale-105 hover:shadow-accent" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Sign Up
                            </a>
                        </div>
                    @endauth
                    
                    <!-- Theme Toggle -->
                    <button id="themeToggle" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 transition-all dark:!bg-bg-card dark:!border-border-primary dark:!hover:bg-bg-card-hover" title="Toggle Theme">
                        <svg id="sunIcon" class="w-5 h-5 text-gray-900 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="moonIcon" class="w-5 h-5 text-white hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    <button class="md:hidden text-gray-900 hover:text-accent dark:!text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    
    <main style="overflow-x: visible;">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-12 dark:!bg-bg-card dark:!border-border-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center space-y-4">
                <div class="flex justify-center items-center gap-4 mb-4">
                    <a href="#" class="text-gray-600 hover:text-accent transition-colors dark:!text-text-secondary">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-accent transition-colors dark:!text-text-secondary">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221c.328 0 .593.266.593.593v2.716c0 .327-.265.593-.593.593h-1.306v1.306h1.306c.327 0 .593.265.593.593v2.716c0 .327-.266.593-.593.593h-2.716c-.328 0-.593-.266-.593-.593v-1.306H9.221v1.306c0 .327-.265.593-.593.593H5.912c-.327 0-.593-.266-.593-.593v-2.716c0-.328.266-.593.593-.593h1.306V9.221H5.912c-.327 0-.593-.265-.593-.593V5.912c0-.327.266-.593.593-.593h2.716c.328 0 .593.266.593.593v1.306h5.557V5.912c0-.327.265-.593.593-.593h2.716c.327 0 .593.266.593.593v2.716c0 .328-.266.593-.593.593h-1.306v1.306h1.306z"/>
                        </svg>
                    </a>
                </div>
                <p class="text-gray-600 text-sm dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Copyright © {{ date('Y') }} - Tech Blog
                </p>
            </div>
        </div>
    </footer>
    
    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');
        const html = document.documentElement;
        const body = document.body;
        
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            body.classList.add('dark-mode');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
        } else {
            // Light mode is default, show sun icon
            html.classList.remove('dark');
            body.classList.remove('dark-mode');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        }
        
        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            body.classList.toggle('dark-mode');
            
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            } else {
                localStorage.setItem('theme', 'light');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            }
        });
    </script>
    
    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Prism.js for syntax highlighting (code samples) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" id="prism-theme-light" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" id="prism-theme-dark" media="(prefers-color-scheme: dark)" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    
    <!-- Initialize Prism.js for code samples -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to update Prism theme based on dark mode
            function updatePrismTheme() {
                const isDark = document.documentElement.classList.contains('dark') || 
                              document.body.classList.contains('dark-mode');
                const lightTheme = document.getElementById('prism-theme-light');
                const darkTheme = document.getElementById('prism-theme-dark');
                
                if (isDark) {
                    if (lightTheme) lightTheme.disabled = true;
                    if (darkTheme) darkTheme.disabled = false;
                } else {
                    if (lightTheme) lightTheme.disabled = false;
                    if (darkTheme) darkTheme.disabled = true;
                }
            }
            
            // Update theme on load
            updatePrismTheme();
            
            // Watch for theme changes
            const themeObserver = new MutationObserver(updatePrismTheme);
            themeObserver.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
            themeObserver.observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });
            
            // Re-run Prism highlighting after content loads
            if (typeof Prism !== 'undefined') {
                // Small delay to ensure content is fully rendered
                setTimeout(function() {
                    Prism.highlightAll();
                }, 100);
            }
        });
        
        // Also highlight after dynamic content loads
        if (typeof Prism !== 'undefined') {
            // Use MutationObserver to highlight new code blocks
            const observer = new MutationObserver(function(mutations) {
                let shouldHighlight = false;
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) { // Element node
                                if (node.tagName === 'PRE' || node.querySelector('pre, code[class*="language-"]')) {
                                    shouldHighlight = true;
                                }
                            }
                        });
                    }
                });
                if (shouldHighlight) {
                    setTimeout(function() {
                        Prism.highlightAll();
                    }, 50);
                }
            });
            
            // Observe the main content area and article content
            const mainContent = document.querySelector('main');
            const articleContent = document.querySelector('.article-content');
            
            if (mainContent) {
                observer.observe(mainContent, {
                    childList: true,
                    subtree: true
                });
            }
            if (articleContent) {
                observer.observe(articleContent, {
                    childList: true,
                    subtree: true
                });
            }
        }
    </script>
    
    <!-- TinyMCE Editor Component -->
    @if(request()->is('admin/articles/*') || request()->is('author/*'))
        <x-head.tinymce-config />
    @endif
    
    @stack('scripts')
</body>
</html>

