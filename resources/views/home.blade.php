@extends('layouts.app')

@section('title', 'Home - Nazaarabox')

@section('content')
<!-- Hero Section with Search -->
<div class="relative w-full mb-12">
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black dark:from-gray-950 dark:via-gray-900 dark:to-black">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 50%, rgba(229, 9, 20, 0.3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(229, 9, 20, 0.2) 0%, transparent 50%);"></div>
        </div>
        
        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center">
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800; line-height: 1.2;">
                    Discover Movies & TV Shows
                </h1>
                
                <!-- Subheading -->
                <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-2xl mx-auto" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Search thousands of movies and TV series. Watch, download, and enjoy your favorite content.
                </p>
                
                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Search for movies, TV shows..." 
                            class="w-full px-6 py-4 pr-16 text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 text-lg transition-all duration-300"
                            style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                            autocomplete="off"
                            value="{{ request('q') }}">
                        <button 
                            type="submit" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-3 bg-accent hover:bg-accent-light text-white rounded-full font-semibold transition-all duration-300 hover:scale-105 flex items-center gap-2"
                            style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
                
                <!-- Quick Links -->
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <a href="{{ route('movies.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full transition-all duration-300 backdrop-blur-sm border border-white/20" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                        Popular Movies
                    </a>
                    <a href="{{ route('tv-shows.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full transition-all duration-300 backdrop-blur-sm border border-white/20" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                        TV Shows
                    </a>
                    <a href="{{ route('movies.index', ['type' => 'top_rated']) }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full transition-all duration-300 backdrop-blur-sm border border-white/20" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                        Top Rated
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-12 md:h-16 lg:h-20">
                <path d="M0,120 L60,105 C120,90 240,60 360,50 C480,40 600,50 720,55 C840,60 960,60 1080,55 C1200,50 1320,40 1380,35 L1440,30 L1440,120 L1380,120 C1320,120 1200,120 1080,120 C960,120 840,120 720,120 C600,120 480,120 360,120 C240,120 120,120 60,120 L0,120 Z" fill="white" class="dark:fill-gray-900"></path>
            </svg>
        </div>
    </div>
</div>

<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area (2 columns on large screens) -->
        <div class="lg:col-span-2">
            @php
                $allContent = [];
                
                // Add custom content first (higher priority)
                if (!empty($customContent)) {
                    foreach ($customContent as $content) {
                        $allContent[] = [
                            'type' => $content->type === 'tv_show' ? 'tv' : 'movie',
                            'id' => $content->slug ?? ('custom_' . $content->id), // Use slug if available
                            'slug' => $content->slug,
                            'title' => $content->title,
                            'date' => $content->release_date ? $content->release_date->format('Y-m-d') : null,
                            'rating' => $content->rating ?? 0,
                            'backdrop' => $content->backdrop_path ?? $content->poster_path ?? null,
                            'poster' => $content->poster_path ?? null,
                            'overview' => $content->description ?? '',
                            'is_custom' => true,
                            'content_id' => $content->id,
                            'content_type' => $content->type,
                            'dubbing_language' => $content->dubbing_language,
                        ];
                    }
                }
                
                // Combine movies and TV shows from TMDB
                if (!empty($popularMovies)) {
                    foreach (array_slice($popularMovies, 0, 20) as $movie) {
                        $allContent[] = [
                            'type' => 'movie',
                            'id' => $movie['id'],
                            'title' => $movie['title'] ?? 'Unknown',
                            'date' => $movie['release_date'] ?? null,
                            'rating' => $movie['vote_average'] ?? 0,
                            'backdrop' => $movie['backdrop_path'] ?? $movie['poster_path'] ?? null,
                            'poster' => $movie['poster_path'] ?? null,
                            'overview' => $movie['overview'] ?? '',
                            'is_custom' => false,
                        ];
                    }
                }
                
                if (!empty($popularTvShows)) {
                    foreach (array_slice($popularTvShows, 0, 20) as $tvShow) {
                        $allContent[] = [
                            'type' => 'tv',
                            'id' => $tvShow['id'],
                            'title' => $tvShow['name'] ?? 'Unknown',
                            'date' => $tvShow['first_air_date'] ?? null,
                            'rating' => $tvShow['vote_average'] ?? 0,
                            'backdrop' => $tvShow['backdrop_path'] ?? $tvShow['poster_path'] ?? null,
                            'poster' => $tvShow['poster_path'] ?? null,
                            'overview' => $tvShow['overview'] ?? '',
                            'is_custom' => false,
                        ];
                    }
                }
                
                // Sort by date (newest first), custom content first if same date
                usort($allContent, function($a, $b) {
                    $dateA = $a['date'] ?? '1970-01-01';
                    $dateB = $b['date'] ?? '1970-01-01';
                    if ($dateA === $dateB) {
                        // If same date, prioritize custom content
                        return ($b['is_custom'] ?? false) <=> ($a['is_custom'] ?? false);
                    }
                    return strcmp($dateB, $dateA);
                });
            @endphp

            <!-- 2 Column Grid for Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(array_slice($allContent, 0, 20) as $item)
                <article class="group relative bg-white overflow-hidden cursor-pointer dark:!bg-bg-card transition-all duration-300">
                    <a href="{{ $item['type'] === 'movie' ? route('movies.show', $item['id']) : route('tv-shows.show', $item['id']) }}" class="block">
                        <!-- Full Image - Backdrop Image with 16:9 Aspect Ratio -->
                        <div class="relative overflow-hidden w-full aspect-video bg-gray-200 dark:bg-gray-800">
                            @if($item['is_custom'] ?? false)
                                <img src="{{ $item['backdrop'] ? (str_starts_with($item['backdrop'], 'http') ? $item['backdrop'] : asset('storage/' . $item['backdrop'])) : ($item['poster'] ? (str_starts_with($item['poster'], 'http') ? $item['poster'] : asset('storage/' . $item['poster'])) : 'https://via.placeholder.com/780x439?text=No+Image') }}" 
                                     alt="{{ $item['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                     onerror="this.src='https://via.placeholder.com/780x439?text=No+Image'">
                            @else
                                <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($item['backdrop'] ?? $item['poster'], 'w780') }}" 
                                     alt="{{ $item['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                     onerror="this.src='https://via.placeholder.com/780x439?text=No+Image'">
                            @endif
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-3 bg-white dark:!bg-bg-card">
                            <!-- Title - Bold Text, Always Visible -->
                            <h2 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-accent transition-colors duration-300 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700; line-height: 1.4;">
                                {{ $item['title'] }}
                                @if($item['type'] === 'movie')
                                    <span class="font-normal text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">(Movie)</span>
                                @else
                                    <span class="font-normal text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">(TV Show)</span>
                                @endif
                            </h2>
                            
                            <!-- Content Details - Like "Hindi Dubbed [ Episode 6 ADD ]" -->
                            <p class="text-gray-600 text-xs mb-1 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.4;">
                                @if($item['is_custom'] ?? false)
                                    @php
                                        $typeLabel = ucfirst(str_replace('_', ' ', $item['content_type'] ?? 'Movie'));
                                        $dubbing = $item['dubbing_language'] ? ucfirst($item['dubbing_language']) . ' Dubbed' : '';
                                    @endphp
                                    {{ $typeLabel }}@if($dubbing) - {{ $dubbing }}@endif
                                @else
                                    @if($item['type'] === 'movie')
                                        Movie - [ Full Movie ]
                                    @else
                                        TV Series - [ Episode 1 ADD ]
                                    @endif
                                @endif
                            </p>
                            
                            <!-- Date - Smaller Lighter Gray Text -->
                            @if($item['date'])
                            <p class="text-gray-500 text-xs dark:!text-text-tertiary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ \Carbon\Carbon::parse($item['date'])->format('F d, Y') }}
                            </p>
                            @endif
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center items-center gap-2 flex-wrap">
                <a href="#" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-900 transition-all dark:!bg-bg-card dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Previous
                </a>
                <a href="#" class="px-4 py-2 bg-accent text-white font-semibold transition-all hover:bg-accent-light" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    1
                </a>
                <a href="#" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-900 transition-all dark:!bg-bg-card dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    2
                </a>
                <a href="#" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-900 transition-all dark:!bg-bg-card dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    3
                </a>
                <span class="text-gray-600 px-2 dark:!text-text-secondary">…</span>
                <a href="#" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-900 transition-all dark:!bg-bg-card dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    74
                </a>
                <a href="#" class="px-4 py-2 bg-accent hover:bg-accent-light text-white font-semibold transition-all" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    NEXT >
                </a>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-1">
            <!-- Telegram Promotion Card -->
            <div class="bg-white border border-gray-200 p-6 mb-6 sticky top-24 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 text-center dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Join our Telegram Channel & Group</h3>
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c.172 0 .31.139.31.311v1.378c0 .172-.138.311-.31.311h-1.378c-.172 0-.311-.139-.311-.311V8.472c0-.172.139-.311.311-.311h1.378zm-3.378 0c.172 0 .311.139.311.311v1.378c0 .172-.139.311-.311.311H12.81c-.172 0-.311-.139-.311-.311V8.472c0-.172.139-.311.311-.311h1.374zm-3.378 0c.172 0 .311.139.311.311v1.378c0 .172-.139.311-.311.311H9.432c-.172 0-.311-.139-.311-.311V8.472c0-.172.139-.311.311-.311h1.374zm-3.378 0c.172 0 .311.139.311.311v1.378c0 .172-.139.311-.311.311H6.054c-.172 0-.311-.139-.311-.311V8.472c0-.172.139-.311.311-.311h1.374zm12.756 2.322H5.184c-.172 0-.311.139-.311.311v1.378c0 .172.139.311.311.311h13.188c.172 0 .311-.139.311-.311v-1.378c0-.172-.139-.311-.311-.311z"/>
                        </svg>
                    </div>
                    <p class="text-gray-900 font-semibold text-lg dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Telegram</p>
                    <a href="#" class="w-full px-6 py-3 bg-gradient-primary hover:bg-accent-light text-white font-semibold rounded-lg transition-all text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Join Channel
                    </a>
                </div>
            </div>

            <!-- Popular Section -->
            <div class="bg-white border border-gray-200 p-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Popular Now</h3>
                <div class="space-y-4">
                    @if(!empty($topRatedMovies))
                        @foreach(array_slice($topRatedMovies, 0, 5) as $movie)
                        <a href="{{ route('movies.show', $movie['id']) }}" class="flex gap-3 group hover:bg-gray-50 p-2 rounded-lg transition-all dark:!hover:bg-bg-card-hover">
                            <div class="flex-shrink-0 w-16 h-24 rounded overflow-hidden bg-gray-100 dark:!bg-bg-card-hover">
                                <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($movie['poster_path'] ?? null, 'w185') }}" 
                                     alt="{{ $movie['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                     onerror="this.src='https://via.placeholder.com/185x278?text=No+Image'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-accent transition-colors line-clamp-2 mb-1 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600; line-height: 1.4;">
                                    {{ $movie['title'] ?? 'Unknown' }}
                                </h4>
                                <p class="text-gray-600 text-xs mb-1 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    {{ \Carbon\Carbon::parse($movie['release_date'] ?? '')->format('Y') ?? 'N/A' }}
                                </p>
                                <div class="flex items-center gap-1">
                                    <span class="text-rating text-xs">★</span>
                                    <span class="text-gray-900 text-xs font-semibold dark:!text-white">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
