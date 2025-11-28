@extends('layouts.app')

@section('title', 'Movies - Nazaarabox')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('movies.index', ['type' => 'popular']) }}" 
           class="px-6 py-2 rounded-full font-semibold transition-all {{ $type === 'popular' ? 'bg-accent text-white shadow-accent' : 'bg-bg-card text-text-secondary hover:bg-bg-card-hover hover:text-text-primary border border-border-primary' }}">
            Popular
        </a>
        <a href="{{ route('movies.index', ['type' => 'top_rated']) }}" 
           class="px-6 py-2 rounded-full font-semibold transition-all {{ $type === 'top_rated' ? 'bg-accent text-white shadow-accent' : 'bg-bg-card text-text-secondary hover:bg-bg-card-hover hover:text-text-primary border border-border-primary' }}">
            Top Rated
        </a>
        <a href="{{ route('movies.index', ['type' => 'now_playing']) }}" 
           class="px-6 py-2 rounded-full font-semibold transition-all {{ $type === 'now_playing' ? 'bg-accent text-white shadow-accent' : 'bg-bg-card text-text-secondary hover:bg-bg-card-hover hover:text-text-primary border border-border-primary' }}">
            Now Playing
        </a>
        <a href="{{ route('movies.index', ['type' => 'upcoming']) }}" 
           class="px-6 py-2 rounded-full font-semibold transition-all {{ $type === 'upcoming' ? 'bg-accent text-white shadow-accent' : 'bg-bg-card text-text-secondary hover:bg-bg-card-hover hover:text-text-primary border border-border-primary' }}">
            Upcoming
        </a>
    </div>

    <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-6 pl-4 border-l-4 border-accent">
        Movies
    </h2>

    @if(!empty($movies))
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4 lg:gap-5 mb-8">
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
    @else
    <div class="text-center py-12">
        <p class="text-text-secondary text-lg">No movies found.</p>
    </div>
    @endif

    @if($totalPages > 1)
    <div class="flex justify-center items-center gap-2 mt-8">
        @if($currentPage > 1)
        <a href="{{ route('movies.index', ['type' => $type, 'page' => $currentPage - 1]) }}" 
           class="px-4 py-2 bg-bg-card hover:bg-bg-card-hover text-text-primary rounded-lg border border-border-primary transition-all">
            Previous
        </a>
        @endif
        
        @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
        <a href="{{ route('movies.index', ['type' => $type, 'page' => $i]) }}" 
           class="px-4 py-2 rounded-lg transition-all {{ $i === $currentPage ? 'bg-gradient-primary text-white shadow-accent' : 'bg-bg-card hover:bg-bg-card-hover text-text-primary border border-border-primary' }}">
            {{ $i }}
        </a>
        @endfor
        
        @if($currentPage < $totalPages)
        <a href="{{ route('movies.index', ['type' => $type, 'page' => $currentPage + 1]) }}" 
           class="px-4 py-2 bg-bg-card hover:bg-bg-card-hover text-text-primary rounded-lg border border-border-primary transition-all">
            Next
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
