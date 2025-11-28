<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nazaarabox - Movies & TV Shows')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
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
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0D0D0D 0%, #181818 100%);
            color: #FFFFFF;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <nav class="sticky top-0 z-50 bg-bg-primary/95 backdrop-blur-lg shadow-lg border-b border-border-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="{{ route('home') }}" class="text-2xl md:text-3xl font-bold text-accent hover:text-accent-light transition-colors">
                    Nazaarabox
                </a>
                <ul class="hidden md:flex items-center gap-6 lg:gap-8">
                    <li><a href="{{ route('home') }}" class="text-text-primary hover:text-accent transition-colors font-medium">Home</a></li>
                    <li><a href="{{ route('movies.index') }}" class="text-text-primary hover:text-accent transition-colors font-medium">Movies</a></li>
                    <li><a href="{{ route('tv-shows.index') }}" class="text-text-primary hover:text-accent transition-colors font-medium">TV Shows</a></li>
                </ul>
                <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center gap-2">
                    <input type="text" name="q" 
                           class="px-4 py-2 w-64 rounded-full bg-bg-card border border-border-primary text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all" 
                           placeholder="Search movies or TV shows..." 
                           value="{{ request('q') }}">
                    <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-full transition-all hover:scale-105 hover:shadow-accent">
                        Search
                    </button>
                </form>
                <button class="md:hidden text-text-primary hover:text-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    
    <main>
        @yield('content')
    </main>
</body>
</html>

