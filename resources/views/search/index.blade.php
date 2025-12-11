@extends('layouts.app')

@section('title', 'Search' . ($query ? ' - ' . $query : '') . ' - Nazaaracircle')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area -->
        <div class="lg:col-span-2">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:!text-white mb-4 pl-4 border-l-4 border-accent" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Search Results{{ $query ? ' for "' . $query . '"' : '' }}
            </h2>

            <!-- Advanced Search Filters -->
            <div class="mb-6 bg-white dark:!bg-bg-card border border-gray-200 dark:!border-border-secondary rounded-lg p-4">
                <form method="GET" action="{{ route('search') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Search</label>
                            <input type="text" name="q" value="{{ $query }}" placeholder="Search articles..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Category</label>
                            <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Author</label>
                            <select name="author_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                                <option value="">All Authors</option>
                                @foreach($authors ?? [] as $author)
                                    <option value="{{ $author->id }}" {{ $selectedAuthor == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">From Date</label>
                                <input type="date" name="date_from" value="{{ $dateFrom }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">To Date</label>
                                <input type="date" name="date_to" value="{{ $dateTo }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Search
                        </button>
                        <a href="{{ route('search') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card dark:!text-white dark:!hover:bg-bg-card-hover" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($articles as $article)
                        @include('articles._card', ['article' => $article])
                    @endforeach
                </div>

                @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
                @endif
            @elseif($query)
                <div class="text-center py-16">
                    <p class="text-gray-600 dark:!text-text-secondary text-lg md:text-xl" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        No results found for "<span class="text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ $query }}</span>"
                    </p>
                </div>
            @else
                <div class="text-center py-16">
                    <p class="text-gray-600 dark:!text-text-secondary text-lg md:text-xl" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        Enter a search term to find articles.
                    </p>
                </div>
            @endif
        </div>

        <!-- Right Sidebar -->
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
