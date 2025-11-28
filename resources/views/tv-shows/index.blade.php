@extends('layouts.app')

@section('title', 'TV Shows - Nazaarabox')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area (2 columns on large screens) -->
        <div class="lg:col-span-2">
            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('tv-shows.index', ['type' => 'popular']) }}" 
                   class="px-4 py-2 border border-gray-300 transition-all {{ $type === 'popular' ? 'bg-accent text-white border-accent' : 'bg-white hover:bg-gray-50 text-gray-900 dark:!bg-bg-card dark:!border-border-primary dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white' }}" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Popular
                </a>
                <a href="{{ route('tv-shows.index', ['type' => 'top_rated']) }}" 
                   class="px-4 py-2 border border-gray-300 transition-all {{ $type === 'top_rated' ? 'bg-accent text-white border-accent' : 'bg-white hover:bg-gray-50 text-gray-900 dark:!bg-bg-card dark:!border-border-primary dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white' }}" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Top Rated
                </a>
            </div>

            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                TV Shows
            </h2>

            @php
                $allTvShows = [];
                
                // Add custom TV shows first (higher priority)
                if (!empty($customTvShows)) {
                    foreach ($customTvShows as $content) {
                        $allTvShows[] = [
                            'id' => $content->slug ?? ('custom_' . $content->id), // Use slug if available
                            'slug' => $content->slug,
                            'name' => $content->title,
                            'first_air_date' => $content->release_date ? $content->release_date->format('Y-m-d') : null,
                            'backdrop_path' => $content->backdrop_path,
                            'poster_path' => $content->poster_path,
                            'is_custom' => true,
                            'content_id' => $content->id,
                            'dubbing_language' => $content->dubbing_language,
                            'type' => $content->type,
                        ];
                    }
                }
                
                // Add TMDB TV shows
                if (!empty($tvShows)) {
                    foreach ($tvShows as $tvShow) {
                        $allTvShows[] = [
                            'id' => $tvShow['id'],
                            'name' => $tvShow['name'] ?? 'Unknown',
                            'first_air_date' => $tvShow['first_air_date'] ?? null,
                            'backdrop_path' => $tvShow['backdrop_path'] ?? null,
                            'poster_path' => $tvShow['poster_path'] ?? null,
                            'is_custom' => false,
                        ];
                    }
                }
                
                // Sort by date (newest first), custom content first if same date
                usort($allTvShows, function($a, $b) {
                    $dateA = $a['first_air_date'] ?? '1970-01-01';
                    $dateB = $b['first_air_date'] ?? '1970-01-01';
                    if ($dateA === $dateB) {
                        return ($b['is_custom'] ?? false) <=> ($a['is_custom'] ?? false);
                    }
                    return strcmp($dateB, $dateA);
                });
            @endphp

            @if(!empty($allTvShows))
            <!-- 2 Column Grid for Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($allTvShows as $tvShow)
                <article class="group relative bg-white overflow-hidden cursor-pointer dark:!bg-bg-card transition-all duration-300">
                    <a href="{{ route('tv-shows.show', $tvShow['id']) }}" class="block">
                        <!-- Full Image - Backdrop Image with 16:9 Aspect Ratio -->
                        <div class="relative overflow-hidden w-full aspect-video bg-gray-200 dark:bg-gray-800">
                            @if($tvShow['is_custom'] ?? false)
                                <img src="{{ $tvShow['backdrop_path'] ? (str_starts_with($tvShow['backdrop_path'], 'http') ? $tvShow['backdrop_path'] : asset('storage/' . $tvShow['backdrop_path'])) : ($tvShow['poster_path'] ? (str_starts_with($tvShow['poster_path'], 'http') ? $tvShow['poster_path'] : asset('storage/' . $tvShow['poster_path'])) : 'https://via.placeholder.com/780x439?text=No+Image') }}" 
                                     alt="{{ $tvShow['name'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                     onerror="this.src='https://via.placeholder.com/780x439?text=No+Image'">
                            @else
                                <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($tvShow['backdrop_path'] ?? $tvShow['poster_path'] ?? null, 'w780') }}" 
                                     alt="{{ $tvShow['name'] ?? 'TV Show' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                     onerror="this.src='https://via.placeholder.com/780x439?text=No+Image'">
                            @endif
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-3 bg-white dark:!bg-bg-card">
                            <!-- Title - Bold Text -->
                            <h2 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-accent transition-colors duration-300 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700; line-height: 1.4;">
                                {{ $tvShow['name'] ?? 'Unknown' }}
                                <span class="font-normal text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">(TV Show)</span>
                            </h2>
                            
                            <!-- Content Details -->
                            <p class="text-gray-600 text-xs mb-1 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.4;">
                                @if($tvShow['is_custom'] ?? false)
                                    @php
                                        $typeLabel = ucfirst(str_replace('_', ' ', $tvShow['type'] ?? 'TV Show'));
                                        $dubbing = $tvShow['dubbing_language'] ? ucfirst($tvShow['dubbing_language']) . ' Dubbed' : '';
                                    @endphp
                                    {{ $typeLabel }}@if($dubbing) - {{ $dubbing }}@endif
                                @else
                                    TV Series - [ Episode 1 ADD ]
                                @endif
                            </p>
                            
                            <!-- Date - Smaller Lighter Gray Text -->
                            @if(!empty($tvShow['first_air_date']))
                            <p class="text-gray-500 text-xs dark:!text-text-tertiary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ \Carbon\Carbon::parse($tvShow['first_air_date'])->format('F d, Y') }}
                            </p>
                            @endif
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">No TV shows found.</p>
            </div>
            @endif

            <!-- Pagination -->
            @if($totalPages > 1)
            <div class="mt-8 flex justify-center items-center gap-2 flex-wrap">
                @if($currentPage > 1)
                <a href="{{ route('tv-shows.index', ['type' => $type, 'page' => $currentPage - 1]) }}" 
                   class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-900 transition-all dark:!bg-bg-card dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Previous
                </a>
                @endif
                
                @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                <a href="{{ route('tv-shows.index', ['type' => $type, 'page' => $i]) }}" 
                   class="px-4 py-2 transition-all {{ $i === $currentPage ? 'bg-accent text-white dark:!bg-accent dark:!text-white' : 'bg-white hover:bg-gray-50 text-gray-900 dark:!bg-bg-card dark:!text-text-secondary dark:!hover:bg-bg-card-hover dark:!hover:text-white' }}" style="font-family: 'Poppins', sans-serif; font-weight: {{ $i === $currentPage ? '600' : '500' }};">
                    {{ $i }}
                </a>
                @endfor
                
                @if($currentPage < $totalPages)
                <a href="{{ route('tv-shows.index', ['type' => $type, 'page' => $currentPage + 1]) }}" 
                   class="px-4 py-2 bg-accent hover:bg-accent-light text-white font-semibold transition-all" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    NEXT >
                </a>
                @endif
            </div>
            @endif
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

            <!-- Popular Now Section -->
            <div class="bg-white border border-gray-200 p-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Popular Now</h3>
                <div class="space-y-4">
                    @if(!empty($topRatedTvShows))
                        @foreach(array_slice($topRatedTvShows, 0, 5) as $tvShow)
                        <a href="{{ route('tv-shows.show', $tvShow['id']) }}" class="flex gap-3 group hover:bg-gray-50 p-2 rounded-lg transition-all dark:!hover:bg-bg-card-hover">
                            <div class="flex-shrink-0 w-16 h-24 rounded overflow-hidden bg-gray-100 dark:!bg-bg-card-hover">
                                <img src="{{ app(\App\Services\TmdbService::class)->getImageUrl($tvShow['poster_path'] ?? null, 'w185') }}" 
                                     alt="{{ $tvShow['name'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                     onerror="this.src='https://via.placeholder.com/185x278?text=No+Image'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-accent transition-colors line-clamp-2 mb-1 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600; line-height: 1.4;">
                                    {{ $tvShow['name'] ?? 'Unknown' }}
                                </h4>
                                <p class="text-gray-600 text-xs mb-1 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    {{ \Carbon\Carbon::parse($tvShow['first_air_date'] ?? '')->format('Y') ?? 'N/A' }}
                                </p>
                                <div class="flex items-center gap-1">
                                    <span class="text-rating text-xs">★</span>
                                    <span class="text-gray-900 text-xs font-semibold dark:!text-white">{{ number_format($tvShow['vote_average'] ?? 0, 1) }}</span>
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
