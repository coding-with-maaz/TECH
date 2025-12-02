@extends('layouts.app')

@section('title', $series->title . ' - Series - Tech Blog')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Series Header -->
    <div class="mb-8 bg-gradient-to-r from-purple-50 to-blue-50 dark:!from-purple-900/10 dark:!to-blue-900/10 rounded-lg border border-purple-200 dark:!border-purple-800 p-8">
        @if($series->featured_image)
            <div class="mb-6">
                <img src="{{ $series->featured_image }}" alt="{{ $series->title }}" class="w-full max-w-2xl mx-auto rounded-lg" onerror="this.style.display='none'">
            </div>
        @endif
        
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            {{ $series->title }}
        </h1>
        
        @if($series->description)
            <p class="text-lg text-gray-700 dark:!text-text-primary mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                {{ $series->description }}
            </p>
        @endif
        
        <div class="flex items-center gap-4 text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            <span><strong>{{ $series->articles->count() }}</strong> Articles</span>
            @if($series->author)
                <span>•</span>
                <span>By {{ $series->author->name }}</span>
            @endif
        </div>
    </div>

    <!-- Series Articles -->
    @if($series->articles->count() > 0)
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Articles in This Series
            </h2>
            
            @foreach($series->articles as $article)
            <article class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary overflow-hidden hover:shadow-lg transition-all">
                <div class="md:flex">
                    @if($article->featured_image)
                        <div class="md:w-64 flex-shrink-0">
                            @php
                                $imageUrl = str_starts_with($article->featured_image, 'http') 
                                    ? $article->featured_image 
                                    : asset('storage/' . $article->featured_image);
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $article->title }}" class="w-full h-48 md:h-full object-cover" onerror="this.style.display='none'">
                        </div>
                    @endif
                    <div class="flex-1 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold dark:!bg-purple-900/20 dark:!text-purple-400" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Part {{ $article->series_order ?? $loop->iteration }}
                            </span>
                            @if($article->category)
                                <a href="{{ route('categories.show', $article->category->slug) }}" class="px-3 py-1 bg-accent text-white rounded-full text-xs font-semibold hover:bg-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    {{ $article->category->name }}
                                </a>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 dark:!text-white mb-2 hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                        </h3>
                        
                        @if($article->excerpt)
                            <p class="text-gray-600 dark:!text-text-secondary mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ Str::limit($article->excerpt, 150) }}
                            </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            @if($article->published_at)
                                <span>{{ $article->published_at->format('M j, Y') }}</span>
                            @endif
                            @if($article->reading_time)
                                <span>•</span>
                                <span>{{ $article->reading_time }} min read</span>
                            @endif
                            <span>•</span>
                            <span>{{ number_format($article->views) }} views</span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary">
            <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                No articles in this series yet.
            </p>
        </div>
    @endif
</div>
@endsection

