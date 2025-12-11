@extends('layouts.app')

@section('title', $tag->name . ' - Nazaara Circle')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Tag: {{ $tag->name }}
        </h1>
        @if($tag->description)
            <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                {{ $tag->description }}
            </p>
        @endif
        <p class="text-sm text-gray-500 dark:!text-text-tertiary mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            {{ number_format($articles->total()) }} articles
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($articles as $article)
                    @include('articles._card', ['article' => $article])
                @empty
                    <div class="col-span-2 text-center py-16">
                        <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No articles found with this tag.
                        </p>
                    </div>
                @endforelse
            </div>

            @if($articles->hasPages())
            <div class="mt-8">
                {{ $articles->links() }}
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

            @if($popularTags->count() > 0)
            <div class="bg-white border border-gray-200 p-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Popular Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($popularTags as $popularTag)
                        <a href="{{ route('tags.show', $popularTag->slug) }}" class="px-3 py-1 bg-gray-100 hover:bg-accent text-gray-700 hover:text-white rounded-full text-xs transition-all dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-accent {{ $popularTag->id === $tag->id ? 'bg-accent text-white' : '' }}" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                            {{ $popularTag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

