@extends('layouts.app')

@section('title', 'Search' . ($query ? ' - ' . $query : '') . ' - Nazaarabox')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-8 pl-4 border-l-4 border-accent">
        Search Results{{ $query ? ' for "' . $query . '"' : '' }}
    </h2>

    @if(!empty($movies))
    <div class="mb-12">
        <h3 class="text-xl md:text-2xl font-semibold text-text-primary mb-6 pl-4">Movies</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4 lg:gap-5">
            @foreach($movies as $movie)
            <a href="{{ route('movies.show', $movie['id']) }}" 
               class="group bg-bg-card rounded-lg overflow-hidden border border-border-secondary hover:border-accent transition-all duration-300 hover:-translate-y-2 hover:shadow-accent cursor-pointer">
                <div class="relative overflow-hidden aspect-[2/3]">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($movie['poster_path'] ?? null) }}" 
                         alt="{{ $movie['title'] ?? 'Movie' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div class="p-2 md:p-3">
                    <h3 class="text-xs md:text-sm font-semibold text-text-primary mb-1.5 line-clamp-2 group-hover:text-accent transition-colors">
                        {{ $movie['title'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-text-secondary">
                            {{ \Carbon\Carbon::parse($movie['release_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1 text-rating">
                            <span class="text-xs">★</span>
                            <span class="font-semibold text-text-primary text-xs">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($tvShows))
    <div class="mb-12">
        <h3 class="text-xl md:text-2xl font-semibold text-text-primary mb-6 pl-4">TV Shows</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4 lg:gap-5">
            @foreach($tvShows as $tvShow)
            <a href="{{ route('tv-shows.show', $tvShow['id']) }}" 
               class="group bg-bg-card rounded-lg overflow-hidden border border-border-secondary hover:border-accent transition-all duration-300 hover:-translate-y-2 hover:shadow-accent cursor-pointer">
                <div class="relative overflow-hidden aspect-[2/3]">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($tvShow['poster_path'] ?? null) }}" 
                         alt="{{ $tvShow['name'] ?? 'TV Show' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div class="p-2 md:p-3">
                    <h3 class="text-xs md:text-sm font-semibold text-text-primary mb-1.5 line-clamp-2 group-hover:text-accent transition-colors">
                        {{ $tvShow['name'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-text-secondary">
                            {{ \Carbon\Carbon::parse($tvShow['first_air_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1 text-rating">
                            <span class="text-xs">★</span>
                            <span class="font-semibold text-text-primary text-xs">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(empty($movies) && empty($tvShows) && $query)
    <div class="text-center py-16">
        <p class="text-text-secondary text-lg md:text-xl">
            No results found for "<span class="text-text-primary font-semibold">{{ $query }}</span>"
        </p>
    </div>
    @endif
</div>
@endsection
