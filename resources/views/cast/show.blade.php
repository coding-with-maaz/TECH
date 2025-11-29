@extends('layouts.app')

@section('title', ($cast->name ?? 'Cast Member') . ' - Nazaarabox')

@section('content')
@php
    $profileUrl = null;
    $profilePath = $cast->profile_path ?? null;
    
    if ($profilePath) {
        // Check if it's a full URL
        if (str_starts_with($profilePath, 'http')) {
            $profileUrl = $profilePath;
        } elseif (str_starts_with($profilePath, '/')) {
            // TMDB path (starts with /) - use TMDB service
            $profileUrl = app(\App\Services\TmdbService::class)->getImageUrl($profilePath, 'w500');
        } else {
            // Custom path - use directly
            $profileUrl = $profilePath;
        }
    }
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Profile Photo -->
        <div class="lg:col-span-1">
            @if($profileUrl)
            <img src="{{ $profileUrl }}" 
                 alt="{{ $cast->name }}" 
                 class="w-full rounded-xl shadow-2xl"
                 onerror="this.src='https://via.placeholder.com/500x750?text=No+Image'">
            @else
            <div class="w-full aspect-[2/3] bg-gray-200 dark:bg-gray-800 rounded-xl shadow-2xl flex items-center justify-center">
                <span class="text-gray-400 text-lg">No Photo</span>
            </div>
            @endif
        </div>
        
        <!-- Details -->
        <div class="lg:col-span-2">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">
                {{ $cast->name }}
            </h1>
            
            <!-- Biography -->
            @if($cast->biography)
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Biography</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    {{ $cast->biography }}
                </p>
            </div>
            @endif
            
            <!-- Personal Information -->
            <div class="space-y-3 mb-6">
                @if($cast->birthday)
                <div class="flex items-start gap-3">
                    <span class="text-gray-600 dark:!text-text-secondary font-semibold min-w-[120px]" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Birthday:</span>
                    <span class="text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;">{{ $cast->birthday->format('F d, Y') }}</span>
                </div>
                @endif
                
                @if($cast->birthplace)
                <div class="flex items-start gap-3">
                    <span class="text-gray-600 dark:!text-text-secondary font-semibold min-w-[120px]" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Birthplace:</span>
                    <span class="text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;">{{ $cast->birthplace }}</span>
                </div>
                @endif
                
                @if($movies->count() > 0 || $tvShows->count() > 0)
                <div class="flex items-start gap-3">
                    <span class="text-gray-600 dark:!text-text-secondary font-semibold min-w-[120px]" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Known For:</span>
                    <span class="text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ $movies->count() + $tvShows->count() }} {{ Str::plural('Title', $movies->count() + $tvShows->count()) }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Movies Section -->
    @if($movies->count() > 0)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Movies ({{ $movies->count() }})
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($movies as $movie)
            @php
                $posterPath = $movie->poster_path ?? null;
                $posterUrl = null;
                
                if ($posterPath) {
                    if (str_starts_with($posterPath, 'http')) {
                        $posterUrl = $posterPath;
                    } elseif (str_starts_with($posterPath, '/') || ($movie->content_type ?? 'custom') === 'tmdb') {
                        $posterUrl = app(\App\Services\TmdbService::class)->getImageUrl($posterPath, 'w185');
                    } else {
                        $posterUrl = $posterPath;
                    }
                }
                
                // Get character name from pivot
                $character = $movie->pivot->character ?? '';
                $routeName = 'movies.show';
                $itemId = $movie->slug ?? ('custom_' . $movie->id);
            @endphp
            <article class="group cursor-pointer">
                <a href="{{ route($routeName, $itemId) }}" class="block">
                    <div class="relative overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-800 aspect-[2/3] mb-2">
                        @if($posterUrl)
                        <img src="{{ $posterUrl }}" 
                             alt="{{ $movie->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='https://via.placeholder.com/185x278?text=No+Image'">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:!text-white group-hover:text-accent transition-colors line-clamp-2 mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        {{ $movie->title }}
                    </h3>
                    @if($character)
                    <p class="text-xs text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        as {{ $character }}
                    </p>
                    @endif
                    @if($movie->release_date)
                    <p class="text-xs text-gray-500 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ $movie->release_date->format('Y') }}
                    </p>
                    @endif
                </a>
            </article>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- TV Shows Section -->
    @if($tvShows->count() > 0)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            TV Shows & Series ({{ $tvShows->count() }})
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($tvShows as $tvShow)
            @php
                $posterPath = $tvShow->poster_path ?? null;
                $posterUrl = null;
                
                if ($posterPath) {
                    if (str_starts_with($posterPath, 'http')) {
                        $posterUrl = $posterPath;
                    } elseif (str_starts_with($posterPath, '/') || ($tvShow->content_type ?? 'custom') === 'tmdb') {
                        $posterUrl = app(\App\Services\TmdbService::class)->getImageUrl($posterPath, 'w185');
                    } else {
                        $posterUrl = $posterPath;
                    }
                }
                
                // Get character name from pivot
                $character = $tvShow->pivot->character ?? '';
                $routeName = 'tv-shows.show';
                $itemId = $tvShow->slug ?? ('custom_' . $tvShow->id);
            @endphp
            <article class="group cursor-pointer">
                <a href="{{ route($routeName, $itemId) }}" class="block">
                    <div class="relative overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-800 aspect-[2/3] mb-2">
                        @if($posterUrl)
                        <img src="{{ $posterUrl }}" 
                             alt="{{ $tvShow->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='https://via.placeholder.com/185x278?text=No+Image'">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:!text-white group-hover:text-accent transition-colors line-clamp-2 mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        {{ $tvShow->title }}
                    </h3>
                    @if($character)
                    <p class="text-xs text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        as {{ $character }}
                    </p>
                    @endif
                    @if($tvShow->release_date)
                    <p class="text-xs text-gray-500 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ $tvShow->release_date->format('Y') }}
                    </p>
                    @endif
                </a>
            </article>
            @endforeach
        </div>
    </div>
    @endif
    
    @if($movies->count() === 0 && $tvShows->count() === 0)
    <div class="text-center py-12">
        <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            No movies or TV shows available for this cast member.
        </p>
    </div>
    @endif
</div>
@endsection

