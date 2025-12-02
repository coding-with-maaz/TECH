@extends('layouts.app')

@section('title', $user->name . ' - Author Profile')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <!-- Cover Image -->
    @if($user->cover_image)
    <div class="mb-6 -mx-4 sm:-mx-6 lg:-mx-8 xl:-mx-12">
        <div class="h-48 md:h-64 lg:h-80 w-full overflow-hidden bg-gray-200 dark:!bg-gray-800">
            <img src="{{ $user->cover_image }}" alt="{{ $user->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
        </div>
    </div>
    @endif

    <div class="max-w-6xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 mb-6 -mt-16 relative z-10">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white dark:!border-bg-card shadow-lg object-cover">
                </div>

                <!-- User Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                                {{ $user->name }}
                            </h1>
                            @if($user->username)
                                <p class="text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    @{{ $user->username }}
                                </p>
                            @endif
                            @if($user->location)
                                <p class="text-sm text-gray-500 dark:!text-text-secondary mt-1 flex items-center gap-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $user->location }}
                                </p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            @auth
                                @if(Auth::id() === $user->id)
                                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        Edit Profile
                                    </a>
                                @else
                                    <button id="followButton" 
                                            data-user-id="{{ $user->id }}"
                                            data-following="{{ $isFollowing ? 'true' : 'false' }}"
                                            class="px-4 py-2 rounded-lg transition-colors font-semibold {{ $isFollowing ? 'bg-gray-100 hover:bg-gray-200 text-gray-900 dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card' : 'bg-accent hover:bg-accent-light text-white' }}"
                                            style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        <span id="followButtonText">{{ $isFollowing ? 'Following' : 'Follow' }}</span>
                                    </button>
                                @endauth
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Follow
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($user->bio)
                        <p class="text-gray-700 dark:!text-text-primary mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            {{ $user->bio }}
                        </p>
                    @endif

                    <!-- Social Links -->
                    @if($user->website || $user->twitter || $user->github || $user->linkedin)
                        <div class="flex flex-wrap gap-3">
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-accent dark:!text-text-secondary dark:!hover:text-accent transition-colors" title="Website">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </a>
                            @endif
                            @if($user->twitter)
                                <a href="https://twitter.com/{{ ltrim($user->twitter, '@') }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-400 dark:!text-text-secondary dark:!hover:text-blue-400 transition-colors" title="Twitter">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                    </svg>
                                </a>
                            @endif
                            @if($user->github)
                                <a href="https://github.com/{{ $user->github }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900 dark:!text-text-secondary dark:!hover:text-white transition-colors" title="GitHub">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif
                            @if($user->linkedin)
                                <a href="https://linkedin.com/in/{{ $user->linkedin }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 dark:!text-text-secondary dark:!hover:text-blue-400 transition-colors" title="LinkedIn">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ number_format($stats['articles']) }}
                </p>
                <p class="text-sm text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Articles
                </p>
            </div>
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ number_format($stats['views']) }}
                </p>
                <p class="text-sm text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Views
                </p>
            </div>
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ number_format($stats['likes']) }}
                </p>
                <p class="text-sm text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Likes
                </p>
            </div>
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ number_format($stats['comments']) }}
                </p>
                <p class="text-sm text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Comments
                </p>
            </div>
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ number_format($stats['followers']) }}
                </p>
                <p class="text-sm text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Followers
                </p>
            </div>
            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    {{ number_format($stats['following']) }}
                </p>
                <p class="text-sm text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Following
                </p>
            </div>
        </div>

        <!-- Badges -->
        @if($badges->count() > 0)
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Badges & Achievements
            </h2>
            <div class="flex flex-wrap gap-3">
                @foreach($badges as $badge)
                <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:!bg-bg-card-hover rounded-lg" title="{{ $badge->description }}">
                    @if($badge->icon)
                        <span class="text-lg">{{ $badge->icon }}</span>
                    @endif
                    <span class="font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        {{ $badge->name }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 dark:!border-border-secondary mb-6">
            <div class="flex space-x-8">
                <a href="{{ route('profile.show', $user->username ?? $user->id) }}" class="border-b-2 border-accent pb-4 px-1 text-sm font-semibold text-accent" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Articles
                </a>
                <a href="{{ route('profile.articles', $user->username ?? $user->id) }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 pb-4 px-1 text-sm font-semibold dark:!text-text-secondary dark:!hover:text-white transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    All Articles
                </a>
                <a href="{{ route('profile.activity', $user->username ?? $user->id) }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 pb-4 px-1 text-sm font-semibold dark:!text-text-secondary dark:!hover:text-white transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Activity
                </a>
            </div>
        </div>

        <!-- Recent Articles -->
        @if($recentArticles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentArticles as $article)
                @include('articles._card', ['article' => $article])
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary">
            <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                No articles published yet.
            </p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    const followButton = document.getElementById('followButton');
    if (!followButton) return;

    followButton.addEventListener('click', function() {
        const userId = this.getAttribute('data-user-id');
        const isFollowing = this.getAttribute('data-following') === 'true';

        this.disabled = true;

        fetch(`/profile/${userId}/toggle-follow`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.setAttribute('data-following', data.following ? 'true' : 'false');
                const buttonText = document.getElementById('followButtonText');
                if (buttonText) {
                    buttonText.textContent = data.following ? 'Following' : 'Follow';
                }
                
                if (data.following) {
                    this.classList.remove('bg-accent', 'hover:bg-accent-light', 'text-white');
                    this.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-900', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                } else {
                    this.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-900', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                    this.classList.add('bg-accent', 'hover:bg-accent-light', 'text-white');
                }
            }
            this.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            this.disabled = false;
        });
    });
});
</script>
@endauth
@endpush
@endsection

