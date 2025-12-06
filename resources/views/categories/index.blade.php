@extends('layouts.app')

@section('title', 'Categories - HARPALJOB TECH')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Categories
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Explore our content organized by topics and themes
        </p>
    </div>

    <!-- Featured Categories Section -->
    @if($featuredCategories->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            ⭐ Featured Categories
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($featuredCategories as $featured)
                <a href="{{ route('categories.show', $featured->slug) }}" class="group relative overflow-hidden rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-white p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    @if($featured->image)
                        @php
                            $imageUrl = str_starts_with($featured->image, 'http') 
                                ? $featured->image 
                                : asset('storage/' . $featured->image);
                        @endphp
                        <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity">
                            <img src="{{ $imageUrl }}" alt="{{ $featured->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
                        </div>
                    @endif
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $featured->name }}
                        </h3>
                        @if($featured->description)
                            <p class="text-gray-300 text-sm mb-3 line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $featured->description }}
                            </p>
                        @endif
                        <div class="flex items-center gap-4 text-sm">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ number_format($featured->articles_count) }} articles
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 dark:!bg-bg-card dark:!border-border-secondary">
        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Search categories..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                       style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            </div>
            
            <!-- Sort By -->
            <div>
                <select name="sort" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                        style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                        onchange="this.form.submit()">
                    <option value="sort_order" {{ $sort === 'sort_order' ? 'selected' : '' }}>Default</option>
                    <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="articles" {{ $sort === 'articles' ? 'selected' : '' }}>Most Articles</option>
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Latest Article</option>
                </select>
            </div>
            
            <!-- Order -->
            <div>
                <select name="order" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                        style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                        onchange="this.form.submit()">
                    <option value="asc" {{ $order === 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ $order === 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" 
                    class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all hover:scale-105 hover:shadow-accent"
                    style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Search
            </button>
            
            @if($search)
                <a href="{{ route('categories.index') }}" 
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all dark:!bg-bg-card-hover dark:!text-white"
                   style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="group bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 dark:!bg-bg-card dark:!border-border-secondary">
                <!-- Category Image/Color Header -->
                <div class="relative h-32 overflow-hidden" style="background: {{ $category->color ?? 'linear-gradient(135deg, #E50914 0%, #B20710 100%)' }};">
                    @if($category->image)
                        @php
                            $imageUrl = str_starts_with($category->image, 'http') 
                                ? $category->image 
                                : asset('storage/' . $category->image);
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.style.display='none'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    @elseif($category->color)
                        <div class="w-full h-full" style="background: {{ $category->color }};"></div>
                    @endif
                    
                    <!-- Category Name Badge -->
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="text-xl font-bold text-white mb-1 group-hover:text-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 700; text-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                            {{ $category->name }}
                        </h3>
                    </div>
                </div>
                
                <!-- Category Content -->
                <div class="p-6">
                    @if($category->description)
                        <p class="text-sm text-gray-600 dark:!text-text-secondary line-clamp-2 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            {{ $category->description }}
                        </p>
                    @endif
                    
                    <!-- Statistics -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4 text-sm">
                            <span class="flex items-center gap-1 text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ number_format($category->articles_count ?? 0) }} articles
                            </span>
                        </div>
                    </div>
                    
                    <!-- Latest Article Info -->
                    @if($category->articles->count() > 0 && $category->articles->first())
                        @php
                            $latestArticle = $category->articles->first();
                        @endphp
                        <div class="pt-4 border-t border-gray-200 dark:!border-border-primary">
                            <p class="text-xs text-gray-500 dark:!text-text-tertiary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                Latest Article
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:!text-white line-clamp-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $latestArticle->published_at ? $latestArticle->published_at->format('M d, Y') : $latestArticle->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    @endif
                    
                    <!-- View More Arrow -->
                    <div class="mt-4 flex items-center text-accent group-hover:text-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <span class="text-sm">Explore Category</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <p class="text-gray-600 dark:!text-text-secondary text-lg mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    @if($search)
                        No categories found matching "{{ $search }}"
                    @else
                        No categories found.
                    @endif
                </p>
                @if($search)
                    <a href="{{ route('categories.index') }}" class="text-accent hover:text-accent-light font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        View All Categories
                    </a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
