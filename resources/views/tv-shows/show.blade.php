@extends('layouts.app')

@section('title', ($tvShow['name'] ?? 'TV Show') . ' - Nazaarabox')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Poster -->
        <div class="lg:col-span-1">
            <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($tvShow['poster_path'] ?? null, 'w500') }}" 
                 alt="{{ $tvShow['name'] ?? 'TV Show' }}" 
                 class="w-full rounded-xl shadow-2xl"
                 onerror="this.src='https://via.placeholder.com/500x750?text=No+Image'">
        </div>
        
        <!-- Details -->
        <div class="lg:col-span-2">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-text-primary mb-4">
                {{ $tvShow['name'] ?? 'Unknown' }}
            </h1>
            
            <div class="flex flex-wrap items-center gap-4 mb-6">
                <div class="flex items-center gap-2 text-rating">
                    <span class="text-2xl">★</span>
                    <span class="text-xl font-bold text-text-primary">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}/10</span>
                </div>
                <span class="text-text-secondary">•</span>
                <span class="text-text-secondary">{{ \Carbon\Carbon::parse($tvShow['first_air_date'] ?? '')->format('Y') ?? 'N/A' }}</span>
                @if(isset($tvShow['number_of_seasons']))
                <span class="text-text-secondary">•</span>
                <span class="text-text-secondary">{{ $tvShow['number_of_seasons'] }} Season{{ $tvShow['number_of_seasons'] > 1 ? 's' : '' }}</span>
                @endif
                @if(isset($tvShow['number_of_episodes']))
                <span class="text-text-secondary">•</span>
                <span class="text-text-secondary">{{ $tvShow['number_of_episodes'] }} Episode{{ $tvShow['number_of_episodes'] > 1 ? 's' : '' }}</span>
                @endif
            </div>

            @if(isset($tvShow['genres']) && is_array($tvShow['genres']))
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($tvShow['genres'] as $genre)
                <span class="px-3 py-1 bg-bg-card text-text-secondary rounded-full text-sm border border-border-primary">
                    {{ $genre['name'] }}
                </span>
                @endforeach
            </div>
            @endif

            @if(isset($tvShow['overview']))
            <p class="text-text-secondary leading-relaxed mb-6 text-base md:text-lg">
                {{ $tvShow['overview'] }}
            </p>
            @endif

            @if(isset($tvShow['credits']['cast']) && count($tvShow['credits']['cast']) > 0)
            <div class="mt-8">
                <h3 class="text-xl font-bold text-text-primary mb-4">Cast</h3>
                <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                    @foreach(array_slice($tvShow['credits']['cast'], 0, 10) as $cast)
                    <div class="min-w-[100px] text-center flex-shrink-0">
                        @if(isset($cast['profile_path']))
                        <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($cast['profile_path'], 'w185') }}" 
                             alt="{{ $cast['name'] }}" 
                             class="w-20 h-28 md:w-24 md:h-36 object-cover rounded-lg mb-2 shadow-lg"
                             onerror="this.style.display='none'">
                        @endif
                        <p class="text-sm font-medium text-text-primary">{{ $cast['name'] ?? 'Unknown' }}</p>
                        <p class="text-xs text-text-secondary mt-1">
                            {{ $cast['character'] ?? '' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    @if(isset($tvShow['videos']['results']) && count($tvShow['videos']['results']) > 0)
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Trailers
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(array_slice($tvShow['videos']['results'], 0, 3) as $video)
            @if($video['site'] === 'YouTube')
            <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-xl">
                <iframe src="https://www.youtube.com/embed/{{ $video['key'] }}" 
                        class="absolute top-0 left-0 w-full h-full border-0"
                        allowfullscreen></iframe>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endif

    @if(isset($tvShow['recommendations']['results']) && count($tvShow['recommendations']['results']) > 0)
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
            Recommended TV Shows
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4 lg:gap-5">
            @foreach(array_slice($tvShow['recommendations']['results'], 0, 12) as $recommended)
            <a href="{{ route('tv-shows.show', $recommended['id']) }}" 
               class="group bg-bg-card rounded-lg overflow-hidden border border-border-secondary hover:border-accent transition-all duration-300 hover:-translate-y-2 hover:shadow-accent cursor-pointer">
                <div class="relative overflow-hidden aspect-[2/3]">
                    <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($recommended['poster_path'] ?? null) }}" 
                         alt="{{ $recommended['name'] ?? 'TV Show' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                         onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div class="p-2 md:p-3">
                    <h3 class="text-xs md:text-sm font-semibold text-text-primary mb-1.5 line-clamp-2 group-hover:text-accent transition-colors">
                        {{ $recommended['name'] ?? 'Unknown' }}
                    </h3>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-text-secondary">
                            {{ \Carbon\Carbon::parse($recommended['first_air_date'] ?? '')->format('Y') ?? 'N/A' }}
                        </span>
                        <div class="flex items-center gap-1 text-rating">
                            <span class="text-xs">★</span>
                            <span class="font-semibold text-text-primary text-xs">{{ number_format($recommended['vote_average'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
