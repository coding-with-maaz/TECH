@extends('layouts.app')

@section('title', $article->title . ' - Tech Blog')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Article Header -->
            <div class="mb-6">
                @if($article->category)
                    <a href="{{ route('categories.show', $article->category->slug) }}" class="inline-block px-3 py-1 bg-accent text-white rounded-full text-sm font-semibold mb-4 hover:bg-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        {{ $article->category->name }}
                    </a>
                @endif
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ $article->title }}
                </h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-600 dark:!text-text-secondary mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    @if($article->author)
                        <span>By {{ $article->author->name }}</span>
                    @endif
                    @if($article->published_at)
                        <span>•</span>
                        <span>{{ $article->published_at->format('M d, Y') }}</span>
                    @endif
                    @if($article->reading_time)
                        <span>•</span>
                        <span>{{ $article->reading_time }} min read</span>
                    @endif
                    <span>•</span>
                    <span>👁 {{ number_format($article->views) }} views</span>
                </div>

                <!-- Tags -->
                @if($article->tags->count() > 0)
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($article->tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="px-3 py-1 bg-gray-100 hover:bg-accent text-gray-700 hover:text-white rounded-full text-xs transition-all dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-accent" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
                <div class="mb-8 rounded-lg overflow-hidden">
                    @php
                        $imageUrl = str_starts_with($article->featured_image, 'http') 
                            ? $article->featured_image 
                            : asset('storage/' . $article->featured_image);
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $article->title }}" class="w-full h-auto" onerror="this.style.display='none'">
                </div>
            @endif

            <!-- Article Content -->
            <div class="prose prose-lg dark:prose-invert max-w-none mb-8" style="font-family: 'Poppins', sans-serif;">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200 dark:!border-border-secondary">
                <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Related Articles
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($relatedArticles as $relatedArticle)
                        @include('articles._card', ['article' => $relatedArticle])
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            @if($featuredArticles->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 sticky top-24 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Featured Articles
                </h3>
                <div class="space-y-4">
                    @foreach($featuredArticles as $featuredArticle)
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

            @if($categories->count() > 0)
            <div class="bg-white border border-gray-200 p-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Categories
                </h3>
                <div class="space-y-2">
                    @foreach($categories->take(10) as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-all dark:!hover:bg-bg-card-hover group">
                            <span class="text-sm text-gray-700 dark:!text-white group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                {{ $category->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ number_format($category->articles_count ?? 0) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

