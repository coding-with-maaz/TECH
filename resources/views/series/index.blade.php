@extends('layouts.app')

@section('title', 'Article Series - Tech Blog')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Article Series
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Explore our curated collections of related articles
        </p>
    </div>

    @if($series->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($series as $ser)
            <a href="{{ route('series.show', $ser->slug) }}" class="group bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary overflow-hidden hover:shadow-lg transition-all">
                @if($ser->featured_image)
                    <div class="aspect-video overflow-hidden bg-gray-200 dark:!bg-gray-700">
                        <img src="{{ $ser->featured_image }}" alt="{{ $ser->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.style.display='none'">
                    </div>
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-2 group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        {{ $ser->title }}
                    </h2>
                    @if($ser->description)
                        <p class="text-sm text-gray-600 dark:!text-text-secondary mb-4 line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            {{ Str::limit($ser->description, 100) }}
                        </p>
                    @endif
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        <span>{{ $ser->articles_count ?? 0 }} Articles</span>
                        <span class="text-accent group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                No series available yet.
            </p>
        </div>
    @endif
</div>
@endsection

