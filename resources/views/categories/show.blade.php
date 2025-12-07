@extends('layouts.app')

@section('title', $category->name . ' - TECHNAZAARA')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <!-- Breadcrumbs -->
    <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary transition-colors">Home</a></li>
            <li><span class="text-gray-400 dark:!text-text-tertiary">/</span></li>
            <li><a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary transition-colors">Categories</a></li>
            <li><span class="text-gray-400 dark:!text-text-tertiary">/</span></li>
            <li><span class="text-gray-900 dark:!text-white font-semibold">{{ $category->name }}</span></li>
        </ol>
    </nav>

    <!-- Category Header with Image/Color -->
    <div class="relative mb-8 rounded-lg overflow-hidden">
        <div class="relative h-64 md:h-80" style="background: {{ $category->color ?? 'linear-gradient(135deg, #E50914 0%, #B20710 100%)' }};">
            @if($category->image)
                @php
                    $imageUrl = str_starts_with($category->image, 'http') 
                        ? $category->image 
                        : asset('storage/' . $category->image);
                @endphp
                <img src="{{ $imageUrl }}" 
                     alt="{{ $category->name }}" 
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
            @elseif($category->color)
                <div class="w-full h-full" style="background: {{ $category->color }};"></div>
            @endif
            
            <div class="absolute inset-0 flex items-end">
                <div class="w-full p-6 md:p-8 text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 800; text-shadow: 0 2px 12px rgba(0,0,0,0.8);">
                        {{ $category->name }}
                    </h1>
                    @if($category->description)
                        <p class="text-lg text-gray-200 max-w-3xl mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400; text-shadow: 0 1px 6px rgba(0,0,0,0.8);">
                            {{ $category->description }}
                        </p>
                    @endif
                    
                    <!-- Quick Stats in Header -->
                    <div class="flex flex-wrap gap-4 text-sm">
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ number_format($categoryStats['total_articles']) }} Articles</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ number_format($categoryStats['total_views']) }} Views</span>
                        </div>
                        @if($categoryStats['avg_reading_time'] > 0)
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ $categoryStats['avg_reading_time'] }} min avg</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Filters and Sorting -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 dark:!bg-bg-card dark:!border-border-secondary">
                <form method="GET" action="{{ route('categories.show', $category->slug) }}" class="flex flex-col md:flex-row gap-4">
                    <!-- Sort By -->
                    <div class="flex-1">
                        <label class="block text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 500;">Sort By</label>
                        <select name="sort" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                                onchange="this.form.submit()">
                            <option value="latest" {{ $filters['sort'] === 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ $filters['sort'] === 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="oldest" {{ $filters['sort'] === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="title" {{ $filters['sort'] === 'title' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="reading_time" {{ $filters['sort'] === 'reading_time' ? 'selected' : '' }}>Reading Time</option>
                        </select>
                    </div>
                    
                    <!-- Reading Time Filter -->
                    <div>
                        <label class="block text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 500;">Reading Time</label>
                        <select name="reading_time" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                                onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="short" {{ $filters['reading_time'] === 'short' ? 'selected' : '' }}>Short (≤5 min)</option>
                            <option value="medium" {{ $filters['reading_time'] === 'medium' ? 'selected' : '' }}>Medium (6-15 min)</option>
                            <option value="long" {{ $filters['reading_time'] === 'long' ? 'selected' : '' }}>Long (>15 min)</option>
                        </select>
                    </div>
                    
                    <!-- Date From -->
                    <div>
                        <label class="block text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 500;">From</label>
                        <input type="date" 
                               name="date_from" 
                               value="{{ $filters['date_from'] }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                               onchange="this.form.submit()">
                    </div>
                    
                    <!-- Date To -->
                    <div>
                        <label class="block text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 500;">To</label>
                        <input type="date" 
                               name="date_to" 
                               value="{{ $filters['date_to'] }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                               onchange="this.form.submit()">
                    </div>
                    
                    <!-- Per Page -->
                    <div>
                        <label class="block text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 500;">Per Page</label>
                        <select name="per_page" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                                onchange="this.form.submit()">
                            <option value="12" {{ $filters['per_page'] == 12 ? 'selected' : '' }}>12</option>
                            <option value="15" {{ $filters['per_page'] == 15 ? 'selected' : '' }}>15</option>
                            <option value="24" {{ $filters['per_page'] == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ $filters['per_page'] == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                    
                    <!-- Clear Filters -->
                    @if($filters['sort'] !== 'latest' || $filters['reading_time'] || $filters['date_from'] || $filters['date_to'] || $filters['per_page'] != 15)
                        <div class="flex items-end">
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all dark:!bg-bg-card-hover dark:!text-white"
                               style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Clear
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Results Count -->
            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Showing {{ $articles->firstItem() ?? 0 }}-{{ $articles->lastItem() ?? 0 }} of {{ number_format($articles->total()) }} articles
                </p>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($articles as $article)
                    @include('articles._card', ['article' => $article])
                @empty
                    <div class="col-span-2 text-center py-16">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-600 dark:!text-text-secondary text-lg mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No articles found in this category.
                        </p>
                        <p class="text-sm text-gray-500 dark:!text-text-tertiary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            Try adjusting your filters or check back later.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Category Statistics Dashboard -->
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    📊 Statistics
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Total Articles</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($categoryStats['total_articles']) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Total Views</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($categoryStats['total_views']) }}</span>
                    </div>
                    @if($categoryStats['avg_reading_time'] > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Avg Reading Time</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ $categoryStats['avg_reading_time'] }} min</span>
                    </div>
                    @endif
                    @if($categoryStats['latest_article'])
                    <div class="pt-4 border-t border-gray-200 dark:!border-border-primary">
                        <p class="text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Latest Article</p>
                        <p class="text-sm font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            {{ $categoryStats['latest_article']->published_at ? $categoryStats['latest_article']->published_at->format('M d, Y') : $categoryStats['latest_article']->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Popular Articles in Category -->
            @if($popularInCategory->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    🔥 Popular in {{ $category->name }}
                </h3>
                <div class="space-y-4">
                    @foreach($popularInCategory as $popularArticle)
                        <a href="{{ route('articles.show', $popularArticle->slug) }}" class="flex gap-3 group hover:bg-gray-50 p-2 rounded-lg transition-all dark:!hover:bg-bg-card-hover">
                            <div class="flex-shrink-0 w-20 h-20 rounded overflow-hidden bg-gray-100 dark:!bg-bg-card-hover">
                                @if($popularArticle->featured_image)
                                    @php
                                        $imageUrl = str_starts_with($popularArticle->featured_image, 'http') 
                                            ? $popularArticle->featured_image 
                                            : asset('storage/' . $popularArticle->featured_image);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $popularArticle->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" onerror="this.src='https://via.placeholder.com/200x200?text=No+Image'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-accent transition-colors line-clamp-2 mb-1 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    {{ $popularArticle->title }}
                                </h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:!text-text-tertiary">
                                    <span>👁 {{ number_format($popularArticle->views) }}</span>
                                    @if($popularArticle->reading_time)
                                        <span>•</span>
                                        <span>{{ $popularArticle->reading_time }} min</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Related Categories -->
            @if($relatedCategories->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    🔗 Related Categories
                </h3>
                <div class="space-y-2">
                    @foreach($relatedCategories as $relatedCat)
                        <a href="{{ route('categories.show', $relatedCat->slug) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-all dark:!hover:bg-bg-card-hover group">
                            <span class="text-sm text-gray-700 dark:!text-white group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                {{ $relatedCat->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ number_format($relatedCat->articles_count ?? 0) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Featured Articles -->
            @if($featuredArticles->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    ⭐ Featured Articles
                </h3>
                <div class="space-y-4">
                    @foreach($featuredArticles->take(5) as $featuredArticle)
                        <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="flex gap-3 group hover:bg-gray-50 p-2 rounded-lg transition-all dark:!hover:bg-bg-card-hover">
                            <div class="flex-shrink-0 w-20 h-20 rounded overflow-hidden bg-gray-100 dark:!bg-bg-card-hover">
                                @if($featuredArticle->featured_image)
                                    @php
                                        $imageUrl = str_starts_with($featuredArticle->featured_image, 'http') 
                                            ? $featuredArticle->featured_image 
                                            : asset('storage/' . $featuredArticle->featured_image);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $featuredArticle->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" onerror="this.src='https://via.placeholder.com/200x200?text=No+Image'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-accent transition-colors line-clamp-2 mb-1 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    {{ $featuredArticle->title }}
                                </h4>
                                <p class="text-gray-600 text-xs dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    {{ $featuredArticle->published_at ? $featuredArticle->published_at->format('M d, Y') : $featuredArticle->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- All Categories -->
            @if($categories->count() > 0)
            <div class="bg-white border border-gray-200 p-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Categories
                </h3>
                <div class="space-y-2">
                    @foreach($categories->take(10) as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-all dark:!hover:bg-bg-card-hover group {{ $cat->id === $category->id ? 'bg-accent/10' : '' }}">
                            <span class="text-sm text-gray-700 dark:!text-white group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                {{ $cat->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ number_format($cat->articles_count ?? 0) }}
                            </span>
                        </a>
                    @endforeach
                    <a href="{{ route('categories.index') }}" class="block text-center text-sm text-accent hover:text-accent-light font-semibold mt-2 pt-2 border-t border-gray-200 dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        View All Categories →
                    </a>
                </div>
            </div>
            @endif

            <!-- Popular Tags -->
            @if($popularTags->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mt-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    🏷️ Popular Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($popularTags->take(15) as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-3 py-1 bg-gray-100 hover:bg-accent hover:text-white text-gray-700 rounded-full text-xs transition-all dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-accent" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
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
