@extends('layouts.app')

@section('title', $series->title . ' - Series - Nazaara Circle')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <!-- Breadcrumbs -->
    <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary transition-colors">Home</a></li>
            <li><span class="text-gray-400 dark:!text-text-tertiary">/</span></li>
            <li><a href="{{ route('series.index') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary transition-colors">Series</a></li>
            <li><span class="text-gray-400 dark:!text-text-tertiary">/</span></li>
            <li><span class="text-gray-900 dark:!text-white font-semibold">{{ $series->title }}</span></li>
        </ol>
    </nav>

    <!-- Series Header with Image/Color -->
    <div class="relative mb-8 rounded-lg overflow-hidden">
        <div class="relative h-64 md:h-80 bg-gradient-to-r from-purple-600 to-blue-600">
            @if($series->featured_image)
                @php
                    $imageUrl = str_starts_with($series->featured_image, 'http') 
                        ? $series->featured_image 
                        : asset('storage/' . $series->featured_image);
                @endphp
                <img src="{{ $imageUrl }}" 
                     alt="{{ $series->title }}" 
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
            @endif
            
            <div class="absolute inset-0 flex items-end">
                <div class="w-full p-6 md:p-8 text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 800; text-shadow: 0 2px 12px rgba(0,0,0,0.8);">
                        {{ $series->title }}
                    </h1>
                    @if($series->description)
                        <p class="text-lg text-gray-200 max-w-3xl mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400; text-shadow: 0 1px 6px rgba(0,0,0,0.8);">
                            {{ $series->description }}
                        </p>
                    @endif
                    
                    <!-- Quick Stats in Header -->
                    <div class="flex flex-wrap gap-4 text-sm">
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ number_format($seriesStats['total_articles']) }} Articles</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ number_format($seriesStats['total_views']) }} Views</span>
                        </div>
                        @if($seriesStats['avg_reading_time'] > 0)
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ $seriesStats['avg_reading_time'] }} min avg</span>
                        </div>
                        @endif
                        @if($seriesStats['total_reading_time'] > 0)
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ $seriesStats['total_reading_time'] }} min total</span>
                        </div>
                        @endif
                        @if($series->author)
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ $series->author->name }}</span>
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
            <!-- Series Articles -->
            @if($series->articles->count() > 0)
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        📚 Articles in This Series
                    </h2>
                </div>
                
                <div class="space-y-6">
                    @foreach($series->articles as $article)
                    <article class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary overflow-hidden hover:shadow-lg transition-all group">
                        <div class="md:flex">
                            @if($article->featured_image)
                                <div class="md:w-64 flex-shrink-0">
                                    @php
                                        $imageUrl = str_starts_with($article->featured_image, 'http') 
                                            ? $article->featured_image 
                                            : asset('storage/' . $article->featured_image);
                                    @endphp
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $article->title }}" 
                                             class="w-full h-48 md:h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                             onerror="this.style.display='none'">
                                    </a>
                                </div>
                            @endif
                            <div class="flex-1 p-6">
                                <div class="flex items-center gap-3 mb-3 flex-wrap">
                                    <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-full text-sm font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        Part {{ $article->series_order ?? $loop->iteration }}
                                    </span>
                                    @if($article->category)
                                        <a href="{{ route('categories.show', $article->category->slug) }}" class="px-3 py-1 bg-accent text-white rounded-full text-xs font-semibold hover:bg-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                            {{ $article->category->name }}
                                        </a>
                                    @endif
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 dark:!text-white mb-2 group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                
                                @if($article->excerpt)
                                    <p class="text-gray-600 dark:!text-text-secondary mb-4 line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                        {{ $article->excerpt }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:!text-text-secondary flex-wrap" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    @if($article->published_at)
                                        <span>{{ $article->published_at->format('M j, Y') }}</span>
                                    @endif
                                    @if($article->reading_time)
                                        <span>•</span>
                                        <span>{{ $article->reading_time }} min read</span>
                                    @endif
                                    <span>•</span>
                                    <span>👁 {{ number_format($article->views) }} views</span>
                                    @if($article->author)
                                        <span>•</span>
                                        <a href="{{ route('profile.show', $article->author->username ?? $article->author->id) }}" class="hover:text-accent transition-colors">
                                            {{ $article->author->name }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        No articles in this series yet.
                    </p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Series Statistics Dashboard -->
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    📊 Statistics
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Total Articles</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($seriesStats['total_articles']) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Total Views</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($seriesStats['total_views']) }}</span>
                    </div>
                    @if($seriesStats['avg_reading_time'] > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Avg Reading Time</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ $seriesStats['avg_reading_time'] }} min</span>
                    </div>
                    @endif
                    @if($seriesStats['total_reading_time'] > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Total Reading Time</span>
                        <span class="text-lg font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ $seriesStats['total_reading_time'] }} min</span>
                    </div>
                    @endif
                    @if($seriesStats['latest_article'])
                    <div class="pt-4 border-t border-gray-200 dark:!border-border-primary">
                        <p class="text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Latest Article</p>
                        <p class="text-sm font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            {{ $seriesStats['latest_article']->published_at ? $seriesStats['latest_article']->published_at->format('M d, Y') : $seriesStats['latest_article']->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Popular Articles in Series -->
            @if($popularInSeries->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    🔥 Popular in Series
                </h3>
                <div class="space-y-4">
                    @foreach($popularInSeries as $popularArticle)
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

            <!-- Related Series -->
            @if($relatedSeries->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    🔗 Related Series
                </h3>
                <div class="space-y-2">
                    @foreach($relatedSeries as $relatedSer)
                        <a href="{{ route('series.show', $relatedSer->slug) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-all dark:!hover:bg-bg-card-hover group">
                            <span class="text-sm text-gray-700 dark:!text-white group-hover:text-purple-600 dark:!group-hover:text-purple-400 transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                {{ $relatedSer->title }}
                            </span>
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ number_format($relatedSer->articles_count ?? 0) }}
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

            <!-- Categories -->
            @if($categories->count() > 0)
            <div class="bg-white border border-gray-200 p-6 rounded-lg dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Categories
                </h3>
                <div class="space-y-2">
                    @foreach($categories->take(10) as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-all dark:!hover:bg-bg-card-hover group">
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
