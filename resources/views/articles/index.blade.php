@extends('layouts.app')

@section('title', 'Articles - Tech Blog')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            All Articles
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Browse all our tech articles, tutorials, and insights
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            @if($featuredArticles->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Featured Articles
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($featuredArticles as $article)
                        @include('articles._card', ['article' => $article])
                    @endforeach
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($articles as $article)
                    @include('articles._card', ['article' => $article])
                @empty
                    <div class="col-span-2 text-center py-16">
                        <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No articles found.
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
            @if($categories->count() > 0)
            <div class="bg-white border border-gray-200 p-6 mb-6 sticky top-24 dark:!bg-bg-card dark:!border-border-secondary">
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

            @if($popularTags->count() > 0)
            <div class="bg-white border border-gray-200 p-6 dark:!bg-bg-card dark:!border-border-secondary">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3 dark:!text-white dark:!border-border-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Popular Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($popularTags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-3 py-1 bg-gray-100 hover:bg-accent text-gray-700 hover:text-white rounded-full text-xs transition-all dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-accent" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
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

