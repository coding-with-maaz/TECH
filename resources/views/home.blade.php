@extends('layouts.app')

@section('title', 'Home - Tech Blog')

@section('content')
<!-- Hero Section with Search -->
<section class="relative overflow-hidden mb-12" style="width: 100vw; margin-left: calc(50% - 50vw); margin-right: calc(50% - 50vw); background: linear-gradient(to bottom right, #1a1a1a, #0d0d0d, #000000);">
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
        <div class="text-center">
            <!-- Main Heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 800; line-height: 1.2;">
                Discover Tech Articles & Tutorials
            </h1>
            
            <!-- Subheading -->
            <p class="text-base md:text-lg text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Explore the latest technology articles, programming tutorials, and tech insights. Stay updated with cutting-edge developments.
            </p>
            
            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto mb-8">
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search for articles, tutorials..." 
                        class="w-full px-6 py-4 pr-20 text-gray-800 bg-gray-200 border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-accent/50 text-base transition-all duration-300"
                        style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                        autocomplete="off"
                        value="{{ request('q') }}">
                    <button 
                        type="submit" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-3 bg-accent hover:bg-accent-light text-white rounded-full font-semibold transition-all duration-300 flex items-center gap-2 shadow-lg"
                        style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                </div>
            </form>
            
            <!-- Quick Links -->
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('articles.index') }}" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-full transition-all duration-300 text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    All Articles
                </a>
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-full transition-all duration-300 text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Categories
                </a>
                <a href="{{ route('tags.index') }}" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-full transition-all duration-300 text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Tags
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 right-0 w-full wave-separator" style="pointer-events: none; z-index: 10;">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full" style="height: 100px; display: block;">
            <defs>
                <filter id="waveShadowGlow" x="-50%" y="-150%" width="200%" height="400%">
                    <feGaussianBlur in="SourceAlpha" stdDeviation="10" result="blur1"/>
                    <feOffset dx="0" dy="-12" result="offset1"/>
                    <feFlood flood-color="#E50914" flood-opacity="0.6"/>
                    <feComposite in2="offset1" operator="in" result="glow1"/>
                    <feGaussianBlur in="SourceAlpha" stdDeviation="6" result="blur2"/>
                    <feOffset dx="0" dy="-8" result="offset2"/>
                    <feFlood flood-color="#E50914" flood-opacity="0.8"/>
                    <feComposite in2="offset2" operator="in" result="glow2"/>
                    <feGaussianBlur in="SourceAlpha" stdDeviation="4" result="blur3"/>
                    <feOffset dx="0" dy="-4" result="offset3"/>
                    <feFlood flood-color="#000000" flood-opacity="0.4"/>
                    <feComposite in2="offset3" operator="in" result="shadow1"/>
                    <feMerge>
                        <feMergeNode in="glow1"/>
                        <feMergeNode in="glow2"/>
                        <feMergeNode in="shadow1"/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
            </defs>
            <path id="wavePath" d="M0,120 L0,90 C120,70 240,50 360,60 C480,70 600,50 720,60 C840,70 960,50 1080,60 C1200,70 1320,50 1440,60 L1440,120 Z" fill="#FFFFFF"></path>
        </svg>
    </div>
    
    <style>
        .wave-separator #wavePath {
            fill: #FFFFFF;
            transition: fill 0.3s ease;
        }
        html.dark .wave-separator #wavePath {
            fill: #E50914;
            filter: url(#waveShadowGlow);
        }
        html.dark .wave-separator {
            filter: drop-shadow(0 -10px 30px rgba(229, 9, 20, 0.5)) drop-shadow(0 -5px 15px rgba(229, 9, 20, 0.3));
        }
    </style>
</section>

<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" style="align-items: start;">
        <!-- Main Content Area -->
        <div class="lg:col-span-2">
            <!-- Latest Articles -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Latest Articles
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($articles as $article)
                        @include('articles._card', ['article' => $article])
                    @empty
                        <div class="col-span-2 text-center py-16">
                            <p class="text-gray-600 dark:!text-text-secondary text-lg md:text-xl" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                No articles available at the moment.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-1" style="position: relative;">
            <!-- Categories -->
            @if($categories->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 dark:!bg-bg-card dark:!border-border-secondary" style="position: -webkit-sticky; position: sticky; top: 5.5rem; align-self: flex-start; z-index: 10;">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Categories
                </h3>
                <div class="space-y-2">
                    @foreach($categories->take(10) as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-all dark:!hover:bg-bg-card-hover group">
                            <span class="text-sm text-gray-700 dark:!text-white group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                {{ $category->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ number_format($category->articles_count ?? 0) }}
                            </span>
                        </a>
                    @endforeach
                    <a href="{{ route('categories.index') }}" class="block text-center text-sm text-accent hover:text-accent-light font-semibold mt-2 pt-2 border-t border-gray-200 dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        View All Categories →
                    </a>
                </div>
            </div>
            @endif

            <!-- Popular Articles -->
            @if($popularArticles->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Popular Articles
                </h3>
                <div class="space-y-4">
                    @foreach($popularArticles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="flex gap-3 group hover:bg-gray-50 p-2 rounded-lg transition-all dark:!hover:bg-bg-card-hover">
                            <div class="flex-shrink-0 w-20 h-20 rounded overflow-hidden bg-gray-100 dark:!bg-bg-card-hover">
                                @if($article->featured_image)
                                    @php
                                        $imageUrl = str_starts_with($article->featured_image, 'http') 
                                            ? $article->featured_image 
                                            : asset('storage/' . $article->featured_image);
                                    @endphp
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $article->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         onerror="this.src='https://via.placeholder.com/200x200?text=No+Image'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-accent transition-colors line-clamp-2 mb-1 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600; line-height: 1.4;">
                                    {{ $article->title }}
                                </h4>
                                <p class="text-gray-600 text-xs mb-1 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600 text-xs dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                        👁 {{ number_format($article->views) }} views
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Popular Tags -->
            @if($popularTags->count() > 0)
            <div class="bg-white border border-gray-200 p-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Popular Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($popularTags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-3 py-1 bg-gray-100 hover:bg-accent text-gray-700 hover:text-white rounded-full text-xs transition-all dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-accent" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
