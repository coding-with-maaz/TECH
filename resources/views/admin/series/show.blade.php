@extends('layouts.app')

@section('title', 'View Series - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('admin.series.index') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary dark:!hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    ← Back to Series
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                {{ $series->title }}
            </h1>
            <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Series Details
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('series.show', $series->slug) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                View Public
            </a>
            <a href="{{ route('admin.series.edit', $series) }}" class="px-4 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($series->featured_image)
                <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        Featured Image
                    </h2>
                    <img src="{{ $series->featured_image }}" alt="{{ $series->title }}" class="w-full rounded-lg" onerror="this.src='https://via.placeholder.com/800x400?text=No+Image'">
                </div>
            @endif

            <!-- Description -->
            @if($series->description)
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Description
                </h2>
                <p class="text-gray-700 dark:!text-text-primary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    {{ $series->description }}
                </p>
            </div>
            @endif

            <!-- Articles in Series -->
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Articles in Series ({{ $series->articles->count() }})
                </h2>
                
                @if($series->articles->count() > 0)
                    <div class="space-y-3">
                        @foreach($series->articles as $article)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:!bg-bg-card-hover rounded-lg hover:bg-gray-100 dark:!hover:bg-bg-card transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-sm text-gray-500 dark:!text-text-secondary font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        #{{ $article->series_order ?? $loop->iteration }}
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        {{ $article->title }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-4 text-xs text-gray-500 dark:!text-text-secondary ml-8" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    <span class="px-2 py-1 bg-{{ $article->status === 'published' ? 'green' : ($article->status === 'draft' ? 'yellow' : 'blue') }}-100 text-{{ $article->status === 'published' ? 'green' : ($article->status === 'draft' ? 'yellow' : 'blue') }}-800 rounded dark:!bg-{{ $article->status === 'published' ? 'green' : ($article->status === 'draft' ? 'yellow' : 'blue') }}-900/20 dark:!text-{{ $article->status === 'published' ? 'green' : ($article->status === 'draft' ? 'yellow' : 'blue') }}-400">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                    <span>{{ $article->views }} views</span>
                                    <span>{{ $article->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.articles.edit', $article) }}" 
                               class="px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors dark:!bg-blue-900/20 dark:!text-blue-400 dark:!hover:bg-blue-900/30 text-sm font-semibold ml-4" 
                               style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Edit
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No articles in this series yet. <a href="{{ route('admin.articles.create') }}" class="text-accent hover:underline">Create an article</a> and assign it to this series.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Series Info -->
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Series Information
                </h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Status</p>
                        <p class="font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            @if($series->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs dark:!bg-green-900/20 dark:!text-green-400">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs dark:!bg-gray-800 dark:!text-gray-400">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Total Articles</p>
                        <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $series->articles->count() }}
                        </p>
                    </div>
                    @if($series->author)
                    <div>
                        <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Author</p>
                        <p class="font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            {{ $series->author->name }}
                        </p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Created</p>
                        <p class="font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            {{ $series->created_at->format('M j, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Slug</p>
                        <p class="font-semibold text-gray-900 dark:!text-white text-sm break-all" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            {{ $series->slug }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

