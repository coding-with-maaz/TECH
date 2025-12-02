@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Admin Dashboard
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Welcome to the admin panel. Here's an overview of your tech blog management system.
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Articles -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:!text-text-secondary uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Total Articles
                    </p>
                    <p class="text-3xl font-bold text-gray-900 dark:!text-white mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        {{ number_format($totalArticles) }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:!bg-blue-900/20 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 dark:!text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 dark:!text-green-400 font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    {{ number_format($publishedArticles) }} Published
                </span>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    {{ number_format($draftArticles) }} Draft
                </span>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:!text-text-secondary uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Categories
                    </p>
                    <p class="text-3xl font-bold text-gray-900 dark:!text-white mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        {{ number_format($totalCategories) }}
                    </p>
                </div>
                <div class="p-3 bg-purple-100 dark:!bg-purple-900/20 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600 dark:!text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Active categories
            </div>
        </div>

        <!-- Tags -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:!text-text-secondary uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Tags
                    </p>
                    <p class="text-3xl font-bold text-gray-900 dark:!text-white mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        {{ number_format($totalTags) }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 dark:!bg-green-900/20 rounded-lg">
                    <svg class="w-8 h-8 text-green-600 dark:!text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-600 dark:!text-text-secondary font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    {{ number_format($totalComments) }} Comments
                </span>
            </div>
        </div>

        <!-- Total Views -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:!text-text-secondary uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Total Views
                    </p>
                    <p class="text-3xl font-bold text-gray-900 dark:!text-white mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                        {{ number_format($totalViews) }}
                    </p>
                </div>
                <div class="p-3 bg-orange-100 dark:!bg-orange-900/20 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600 dark:!text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                All time views
            </div>
        </div>
    </div>

    <!-- Secondary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
        <!-- Published Articles -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Published</p>
            <p class="text-2xl font-bold text-green-600 dark:!text-green-400" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($publishedArticles) }}</p>
        </div>

        <!-- Draft Articles -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Draft</p>
            <p class="text-2xl font-bold text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($draftArticles) }}</p>
        </div>

        <!-- Featured Articles -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Featured</p>
            <p class="text-2xl font-bold text-yellow-600 dark:!text-yellow-400" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($featuredArticles) }}</p>
        </div>

        <!-- This Month -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">This Month</p>
            <p class="text-2xl font-bold text-blue-600 dark:!text-blue-400" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($thisMonthArticles) }}</p>
        </div>

        <!-- Total Authors -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Authors</p>
            <p class="text-2xl font-bold text-teal-600 dark:!text-teal-400" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($totalAuthors ?? 0) }}</p>
        </div>

        <!-- Pending Author Requests -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <p class="text-sm text-gray-600 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Pending Requests</p>
            <p class="text-2xl font-bold text-orange-600 dark:!text-orange-400" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($pendingAuthorRequests ?? 0) }}</p>
            @if(($pendingAuthorRequests ?? 0) > 0)
                <a href="{{ route('admin.authors.requests') }}" class="text-xs text-accent hover:underline mt-1 block" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Review Now →
                </a>
            @endif
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Articles -->
        <div class="lg:col-span-2 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Recent Articles
                </h2>
                <a href="{{ route('admin.articles.index') }}" class="text-sm text-accent hover:underline font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    View All →
                </a>
            </div>
            
            @if($recentArticles->count() > 0)
                <div class="space-y-4">
                    @foreach($recentArticles as $article)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 dark:!bg-bg-card-hover rounded-lg hover:bg-gray-100 dark:!hover:bg-bg-card-hover transition-colors">
                            <div class="w-20 h-20 rounded overflow-hidden bg-gray-200 dark:!bg-gray-700 flex-shrink-0">
                                @if($article->featured_image)
                                    @php
                                        $imageUrl = str_starts_with($article->featured_image, 'http') 
                                            ? $article->featured_image 
                                            : asset('storage/' . $article->featured_image);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/200x200?text=No+Image'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 dark:!text-white mb-1 truncate" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:!text-text-secondary mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    @if($article->category)
                                        <span class="px-2 py-0.5 bg-purple-100 text-purple-800 rounded text-xs dark:!bg-purple-900/20 dark:!text-purple-400">{{ $article->category->name }}</span>
                                    @endif
                                </p>
                                <div class="flex items-center gap-3 text-xs text-gray-500 dark:!text-text-tertiary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    <span>{{ $article->created_at->diffForHumans() }}</span>
                                    @if($article->status === 'published')
                                        <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded dark:!bg-green-900/20 dark:!text-green-400">Published</span>
                                    @elseif($article->status === 'draft')
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-800 rounded dark:!bg-gray-800 dark:!text-gray-400">Draft</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded dark:!bg-blue-900/20 dark:!text-blue-400">Scheduled</span>
                                    @endif
                                    <span>{{ number_format($article->views) }} views</span>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="px-3 py-1 bg-accent hover:bg-accent-light text-white rounded text-sm transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        No articles yet. <a href="{{ route('admin.articles.create') }}" class="text-accent hover:underline">Create your first article</a>
                    </p>
                </div>
            @endif
        </div>

        <!-- Quick Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Quick Actions
                </h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.articles.create') }}" class="block w-full px-4 py-3 bg-accent hover:bg-accent-light text-white text-center rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Add New Article
                    </a>
                    <a href="{{ route('admin.articles.index') }}" class="block w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 text-center rounded-lg transition-colors dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card-hover font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Manage Articles
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="block w-full px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white text-center rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Manage Categories
                    </a>
                    <a href="{{ route('admin.tags.index') }}" class="block w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white text-center rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Manage Tags
                    </a>
                    <a href="{{ route('admin.page-seo.index') }}" class="block w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Public Pages SEO Management
                    </a>
                    <a href="{{ route('admin.authors.index') }}" class="block w-full px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white text-center rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Manage Authors
                    </a>
                    <a href="{{ route('admin.authors.requests') }}" class="block w-full px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white text-center rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Author Requests
                    </a>
                </div>
            </div>

            <!-- Articles by Category -->
            @if($articlesByCategory->count() > 0)
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Articles by Category
                </h2>
                <div class="space-y-3">
                    @foreach($articlesByCategory->take(5) as $category)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">{{ $category->name }}</span>
                            <span class="font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ number_format($category->articles_count) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Recent Activity
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-accent rounded-full mt-2"></div>
                        <div>
                            <p class="text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $thisWeekArticles }} articles added this week
                            </p>
                            <p class="text-gray-600 dark:!text-text-secondary text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $thisMonthArticles }} this month
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $thisMonthComments }} comments this month
                            </p>
                        </div>
                    </div>
                    @if($totalSubscriptions > 0)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ number_format($totalSubscriptions) }} newsletter subscribers
                            </p>
                            <p class="text-gray-600 dark:!text-text-secondary text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $newSubscriptionsThisMonth }} new this month
                            </p>
                        </div>
                    </div>
                    @endif
                    @if($unreadMessages > 0)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $unreadMessages }} unread messages
                            </p>
                        </div>
                    </div>
                    @endif
                    @if(($pendingAuthorRequests ?? 0) > 0)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-gray-900 dark:!text-white font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $pendingAuthorRequests }} pending author requests
                            </p>
                            <a href="{{ route('admin.authors.requests') }}" class="text-xs text-accent hover:underline" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Review now →
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top Viewed Articles -->
    @if($topViewedArticles->count() > 0)
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Most Viewed Articles
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($topViewedArticles as $article)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[2/3] rounded-lg overflow-hidden bg-gray-200 dark:!bg-gray-700 mb-2">
                        @if($article->featured_image)
                            @php
                                $imageUrl = str_starts_with($article->featured_image, 'http') 
                                    ? $article->featured_image 
                                    : asset('storage/' . $article->featured_image);
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://via.placeholder.com/400x600?text=No+Image'">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                        @endif
                        <div class="absolute top-2 right-2 px-2 py-1 bg-black/70 text-white text-xs font-semibold rounded">
                            {{ number_format($article->views ?? 0) }} views
                        </div>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:!text-white text-sm truncate group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        {{ $article->title }}
                    </h3>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Comments -->
    @if($recentComments->count() > 0)
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Recent Comments
        </h2>
        <div class="space-y-4">
            @foreach($recentComments as $comment)
                <div class="p-4 bg-gray-50 dark:!bg-bg-card-hover rounded-lg">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $comment->user ? $comment->user->name : $comment->name }}
                            </p>
                            <p class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                on <a href="{{ route('articles.show', $comment->article->slug) }}" class="text-accent hover:underline">{{ $comment->article->title }}</a>
                            </p>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs dark:!bg-green-900/20 dark:!text-green-400">
                            {{ $comment->status }}
                        </span>
                    </div>
                    <p class="text-gray-700 dark:!text-text-primary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ Str::limit($comment->content, 150) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:!text-text-tertiary mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
