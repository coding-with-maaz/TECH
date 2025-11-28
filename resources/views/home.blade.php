@extends('layouts.app')

@section('title', 'Home - Nazaarabox')

@section('content')
@php
    $heroBackdrop = !empty($popularMovies) && isset($popularMovies[0]['backdrop_path']) 
        ? $popularMovies[0]['backdrop_path'] 
        : '/kGzFbGhp99zva6oZODW5atUtnqi.jpg';
@endphp

<!-- Hero Section -->
<div class="relative min-h-[500px] md:min-h-[600px] flex items-center justify-center bg-cover bg-center bg-no-repeat mb-12" 
     style="background-image: linear-gradient(180deg, rgba(13, 13, 13, 0.5) 0%, rgba(13, 13, 13, 0.9) 100%), url('https://image.tmdb.org/t/p/w1920_and_h800_multi_faces{{ $heroBackdrop }}');">
    <div class="relative z-10 text-center px-4 w-full max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-2xl">
            Welcome to Nazaarabox
        </h1>
        <p class="text-lg md:text-xl text-text-secondary mb-8 max-w-2xl mx-auto">
            Discover your favorite movies and TV shows. Search from millions of titles.
        </p>
        <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-3 max-w-2xl mx-auto bg-bg-card/80 backdrop-blur-lg p-4 rounded-full border border-border-primary">
            <input type="text" name="q" 
                   class="flex-1 px-6 py-3 md:py-4 rounded-full bg-bg-card border border-border-primary text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all text-base md:text-lg" 
                   placeholder="Search for movies, TV shows..." 
                   value="{{ request('q') }}" 
                   required>
            <button type="submit" class="px-8 py-3 md:py-4 bg-gradient-primary text-white font-semibold rounded-full transition-all hover:scale-105 hover:shadow-accent-lg whitespace-nowrap text-base md:text-lg">
                Search
            </button>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    @if(!empty($popularMovies))
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Popular Movies
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-5 lg:gap-6">
            @foreach(array_slice($popularMovies, 0, 12) as $movie)
            <a href="{{ route('movies.show', $movie['id']) }}" 
               class="group relative bg-bg-card rounded-xl overflow-hidden border border-border-secondary hover:border-accent/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-accent/20 cursor-pointer">
                <!-- Image Container -->
                <div class="relative overflow-hidden aspect-[2/3] bg-gradient-to-br from-bg-card to-bg-card-hover">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($movie['poster_path'] ?? null) }}" 
                         alt="{{ $movie['title'] ?? 'Movie' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 border border-accent/30">
                        <span class="text-rating text-xs">★</span>
                        <span class="text-white text-xs font-bold">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                    </div>
                    
                    <!-- Hover Overlay with Info -->
                    <div class="absolute inset-0 flex items-end opacity-0 group-hover:opacity-100 transition-all duration-500 pb-3 px-3">
                        <div class="w-full">
                            <div class="bg-accent/90 backdrop-blur-sm rounded-lg px-3 py-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <p class="text-white text-xs font-semibold text-center">View Details</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-3 md:p-4 bg-gradient-to-b from-bg-card to-bg-card-hover">
                    <h3 class="text-sm md:text-base font-bold text-text-primary mb-2 line-clamp-2 group-hover:text-accent transition-colors duration-300 leading-tight">
                        {{ $movie['title'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary text-xs md:text-sm font-medium">
                            {{ \Carbon\Carbon::parse($movie['release_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1.5 bg-bg-card-hover rounded-full px-2 py-1">
                            <span class="text-rating text-xs">★</span>
                            <span class="font-bold text-text-primary text-xs">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($topRatedMovies))
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Top Rated Movies
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-5 lg:gap-6">
            @foreach(array_slice($topRatedMovies, 0, 12) as $movie)
            <a href="{{ route('movies.show', $movie['id']) }}" 
               class="group relative bg-bg-card rounded-xl overflow-hidden border border-border-secondary hover:border-accent/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-accent/20 cursor-pointer">
                <!-- Image Container -->
                <div class="relative overflow-hidden aspect-[2/3] bg-gradient-to-br from-bg-card to-bg-card-hover">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($movie['poster_path'] ?? null) }}" 
                         alt="{{ $movie['title'] ?? 'Movie' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 border border-accent/30">
                        <span class="text-rating text-xs">★</span>
                        <span class="text-white text-xs font-bold">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                    </div>
                    
                    <!-- Hover Overlay with Info -->
                    <div class="absolute inset-0 flex items-end opacity-0 group-hover:opacity-100 transition-all duration-500 pb-3 px-3">
                        <div class="w-full">
                            <div class="bg-accent/90 backdrop-blur-sm rounded-lg px-3 py-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <p class="text-white text-xs font-semibold text-center">View Details</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-3 md:p-4 bg-gradient-to-b from-bg-card to-bg-card-hover">
                    <h3 class="text-sm md:text-base font-bold text-text-primary mb-2 line-clamp-2 group-hover:text-accent transition-colors duration-300 leading-tight">
                        {{ $movie['title'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary text-xs md:text-sm font-medium">
                            {{ \Carbon\Carbon::parse($movie['release_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1.5 bg-bg-card-hover rounded-full px-2 py-1">
                            <span class="text-rating text-xs">★</span>
                            <span class="font-bold text-text-primary text-xs">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($nowPlayingMovies))
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Now Playing
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-5 lg:gap-6">
            @foreach(array_slice($nowPlayingMovies, 0, 12) as $movie)
            <a href="{{ route('movies.show', $movie['id']) }}" 
               class="group relative bg-bg-card rounded-xl overflow-hidden border border-border-secondary hover:border-accent/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-accent/20 cursor-pointer">
                <!-- Image Container -->
                <div class="relative overflow-hidden aspect-[2/3] bg-gradient-to-br from-bg-card to-bg-card-hover">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($movie['poster_path'] ?? null) }}" 
                         alt="{{ $movie['title'] ?? 'Movie' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 border border-accent/30">
                        <span class="text-rating text-xs">★</span>
                        <span class="text-white text-xs font-bold">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                    </div>
                    
                    <!-- Hover Overlay with Info -->
                    <div class="absolute inset-0 flex items-end opacity-0 group-hover:opacity-100 transition-all duration-500 pb-3 px-3">
                        <div class="w-full">
                            <div class="bg-accent/90 backdrop-blur-sm rounded-lg px-3 py-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <p class="text-white text-xs font-semibold text-center">View Details</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-3 md:p-4 bg-gradient-to-b from-bg-card to-bg-card-hover">
                    <h3 class="text-sm md:text-base font-bold text-text-primary mb-2 line-clamp-2 group-hover:text-accent transition-colors duration-300 leading-tight">
                        {{ $movie['title'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary text-xs md:text-sm font-medium">
                            {{ \Carbon\Carbon::parse($movie['release_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1.5 bg-bg-card-hover rounded-full px-2 py-1">
                            <span class="text-rating text-xs">★</span>
                            <span class="font-bold text-text-primary text-xs">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($popularTvShows))
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Popular TV Shows
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-5 lg:gap-6">
            @foreach(array_slice($popularTvShows, 0, 12) as $tvShow)
            <a href="{{ route('tv-shows.show', $tvShow['id']) }}" 
               class="group relative bg-bg-card rounded-xl overflow-hidden border border-border-secondary hover:border-accent/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-accent/20 cursor-pointer">
                <!-- Image Container -->
                <div class="relative overflow-hidden aspect-[2/3] bg-gradient-to-br from-bg-card to-bg-card-hover">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($tvShow['poster_path'] ?? null) }}" 
                         alt="{{ $tvShow['name'] ?? 'TV Show' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 border border-accent/30">
                        <span class="text-rating text-xs">★</span>
                        <span class="text-white text-xs font-bold">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}</span>
                    </div>
                    
                    <!-- Hover Overlay with Info -->
                    <div class="absolute inset-0 flex items-end opacity-0 group-hover:opacity-100 transition-all duration-500 pb-3 px-3">
                        <div class="w-full">
                            <div class="bg-accent/90 backdrop-blur-sm rounded-lg px-3 py-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <p class="text-white text-xs font-semibold text-center">View Details</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-3 md:p-4 bg-gradient-to-b from-bg-card to-bg-card-hover">
                    <h3 class="text-sm md:text-base font-bold text-text-primary mb-2 line-clamp-2 group-hover:text-accent transition-colors duration-300 leading-tight">
                        {{ $tvShow['name'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary text-xs md:text-sm font-medium">
                            {{ \Carbon\Carbon::parse($tvShow['first_air_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1.5 bg-bg-card-hover rounded-full px-2 py-1">
                            <span class="text-rating text-xs">★</span>
                            <span class="font-bold text-text-primary text-xs">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($topRatedTvShows))
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Top Rated TV Shows
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-5 lg:gap-6">
            @foreach(array_slice($topRatedTvShows, 0, 12) as $tvShow)
            <a href="{{ route('tv-shows.show', $tvShow['id']) }}" 
               class="group relative bg-bg-card rounded-xl overflow-hidden border border-border-secondary hover:border-accent/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-accent/20 cursor-pointer">
                <!-- Image Container -->
                <div class="relative overflow-hidden aspect-[2/3] bg-gradient-to-br from-bg-card to-bg-card-hover">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($tvShow['poster_path'] ?? null) }}" 
                         alt="{{ $tvShow['name'] ?? 'TV Show' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 border border-accent/30">
                        <span class="text-rating text-xs">★</span>
                        <span class="text-white text-xs font-bold">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}</span>
                    </div>
                    
                    <!-- Hover Overlay with Info -->
                    <div class="absolute inset-0 flex items-end opacity-0 group-hover:opacity-100 transition-all duration-500 pb-3 px-3">
                        <div class="w-full">
                            <div class="bg-accent/90 backdrop-blur-sm rounded-lg px-3 py-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <p class="text-white text-xs font-semibold text-center">View Details</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-3 md:p-4 bg-gradient-to-b from-bg-card to-bg-card-hover">
                    <h3 class="text-sm md:text-base font-bold text-text-primary mb-2 line-clamp-2 group-hover:text-accent transition-colors duration-300 leading-tight">
                        {{ $tvShow['name'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary text-xs md:text-sm font-medium">
                            {{ \Carbon\Carbon::parse($tvShow['first_air_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1.5 bg-bg-card-hover rounded-full px-2 py-1">
                            <span class="text-rating text-xs">★</span>
                            <span class="font-bold text-text-primary text-xs">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
