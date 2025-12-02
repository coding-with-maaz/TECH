@extends('layouts.app')

@section('title', 'Categories - Tech Blog')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Categories
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Browse articles by category
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="group bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all dark:!bg-bg-card dark:!border-border-secondary">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:!text-white mb-2 group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $category->name }}
                        </h3>
                        @if($category->description)
                            <p class="text-sm text-gray-600 dark:!text-text-secondary line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $category->description }}
                            </p>
                        @endif
                    </div>
                    @if($category->image)
                        <div class="w-16 h-16 rounded overflow-hidden bg-gray-200 dark:!bg-gray-700 flex-shrink-0 ml-4">
                            @php
                                $imageUrl = str_starts_with($category->image, 'http') 
                                    ? $category->image 
                                    : asset('storage/' . $category->image);
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $category->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ number_format($category->articles_count ?? 0) }} articles
                    </span>
                    <span class="text-accent group-hover:translate-x-1 transition-transform" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        →
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center py-16">
                <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    No categories found.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection

