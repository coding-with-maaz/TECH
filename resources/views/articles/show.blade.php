@extends('layouts.app')

@section('title', $article->title . ' - Nazaaracircle')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="amphtml" href="{{ route('amp.article', $article->slug) }}">
@endpush

@section('content')
@if($hasValidToken && $downloadLink)
<!-- Download Processing Section - Shows on article page -->
<div id="downloadProcessing" class="w-full mb-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg p-6 text-white" style="display: block;">
    <div class="text-center">
        <!-- Phase 1: Generating Link (0-15 seconds) -->
        <div id="phase1" class="mb-6">
            <div class="w-20 h-20 mx-auto mb-4 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            <h2 class="text-2xl font-bold mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Please Wait
            </h2>
            <p class="text-purple-100 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Generating your download link...
            </p>
            <div class="text-4xl font-bold mb-2" id="phase1Countdown" style="font-family: 'Poppins', sans-serif; font-weight: 700;">15</div>
            <p class="text-sm text-purple-200" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                seconds remaining
            </p>
            <div class="w-full max-w-xs mx-auto bg-white/30 rounded-full h-2 mt-4">
                <div id="phase1Progress" class="bg-white h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                                </div>
                                </div>

        <!-- Phase 2: Scroll Down Button (after 15 seconds) -->
        <div id="phase2" class="mb-6" style="display: none;">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto mb-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
                <h2 class="text-2xl font-bold mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Link Generated!
                </h2>
                <p class="text-purple-100 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Scroll down to finalize your download
                </p>
                <button id="scrollDownBtn" 
                        class="px-8 py-3 bg-white text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-colors shadow-lg" 
                        style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Scroll Down ↓
                </button>
                    </div>
                </div>
                
        <!-- Phase 3: Finalizing Download (after scroll, 15 more seconds) -->
        <div id="phase3" class="mb-6" style="display: none;">
            <div class="w-20 h-20 mx-auto mb-4 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            <h2 class="text-2xl font-bold mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Finalizing Download
            </h2>
            <p class="text-purple-100 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Generating final download link...
            </p>
            <div class="text-4xl font-bold mb-2" id="phase3Countdown" style="font-family: 'Poppins', sans-serif; font-weight: 700;">15</div>
            <p class="text-sm text-purple-200" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                seconds remaining
            </p>
            <div class="w-full max-w-xs mx-auto bg-white/30 rounded-full h-2 mt-4">
                <div id="phase3Progress" class="bg-white h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                            </div>
                    </div>
                </div>
            </div>


<script>
(function() {
    // Only run if we have a valid download link
    const downloadLink = @json($downloadLink);
    if (!downloadLink) {
        return; // Exit if no valid download link
    }
    
    const phase1 = document.getElementById('phase1');
    const phase2 = document.getElementById('phase2');
    const phase3 = document.getElementById('phase3');
    const phase1Countdown = document.getElementById('phase1Countdown');
    const phase1Progress = document.getElementById('phase1Progress');
    const phase3Countdown = document.getElementById('phase3Countdown');
    const phase3Progress = document.getElementById('phase3Progress');
    const phase3CountdownFinal = document.getElementById('phase3CountdownFinal');
    const phase3ProgressFinal = document.getElementById('phase3ProgressFinal');
    const phase3CountdownSection = document.getElementById('phase3CountdownSection');
    const phase4DownloadButton = document.getElementById('phase4DownloadButton');
    const downloadButtonLink = document.getElementById('downloadButtonLink');
    
    let phase1Seconds = 15;
    let phase3Seconds = 15;
    let phase1Interval = null;
    let phase3Interval = null;
    let hasScrolled = false;
    
    // Function to start Phase 3 countdown
    function startPhase3Countdown() {
        console.log('Starting Phase 3 countdown');
        
        // Get fresh references to elements
        const countdownEl = document.getElementById('phase3CountdownFinal');
        const progressEl = document.getElementById('phase3ProgressFinal');
        const countdownSection = document.getElementById('phase3CountdownSection');
        const downloadButton = document.getElementById('phase4DownloadButton');
        const downloadLinkEl = document.getElementById('downloadButtonLink');
        
        // Reset seconds
        let currentSeconds = 15;
        
        // Clear any existing interval
        if (phase3Interval) {
            clearInterval(phase3Interval);
            phase3Interval = null;
        }
        
        // Update initial display
        if (countdownEl) {
            countdownEl.textContent = currentSeconds;
            console.log('Initial countdown set to:', currentSeconds);
        }
        if (progressEl) {
            progressEl.style.width = '0%';
        }
        
        // Start the countdown interval
        phase3Interval = setInterval(function() {
            currentSeconds--;
            console.log('Phase 3 countdown:', currentSeconds);
            
            // Update countdown display
            if (countdownEl) {
                countdownEl.textContent = currentSeconds;
            }
            
            // Update progress bar
            if (progressEl) {
                const progress = ((15 - currentSeconds) / 15 * 100);
                progressEl.style.width = progress + '%';
            }
            
            // Check if countdown is complete
            if (currentSeconds <= 0) {
                console.log('Phase 3 countdown complete');
                
                // Clear interval
                if (phase3Interval) {
                    clearInterval(phase3Interval);
                    phase3Interval = null;
                }
                
                // Hide countdown section
                if (countdownSection) {
                    countdownSection.style.display = 'none';
                }
                
                // Show download button
                if (downloadButton) {
                    downloadButton.style.display = 'block';
                }
                
                // Set download link
                if (downloadLinkEl && downloadLink) {
                    downloadLinkEl.href = downloadLink;
                    console.log('Download link set:', downloadLink);
                }
            }
        }, 1000);
        
        console.log('Phase 3 interval created:', phase3Interval);
    }
    
    // Function to scroll down and start Phase 3 - Define it first
    window.scrollToDownload = function() {
        console.log('scrollToDownload called');
        if (hasScrolled) {
            console.log('Already scrolled, returning');
            return; // Prevent multiple clicks
        }
        hasScrolled = true;
        
        // Hide Phase 2
        if (phase2) {
            phase2.style.display = 'none';
        }
        
        // Find download finalize section (it's placed after article content)
        const downloadFinalize = document.getElementById('downloadFinalize');
        console.log('downloadFinalize element:', downloadFinalize);
        
        if (downloadFinalize) {
            // Show the finalize section
            downloadFinalize.style.display = 'block';
            
            // Wait a bit for display to take effect, then scroll
            setTimeout(function() {
                downloadFinalize.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Start Phase 3 countdown after scroll completes
                setTimeout(function() {
                    startPhase3Countdown();
                }, 500);
            }, 300);
        } else {
            console.error('downloadFinalize element not found');
            // Fallback: try to find it again or show error
            alert('Download section not found. Please refresh the page.');
        }
    };
    
    // Phase 1: Generate link (15 seconds)
    phase1Interval = setInterval(function() {
        phase1Seconds--;
        if (phase1Countdown) {
            phase1Countdown.textContent = phase1Seconds;
        }
        if (phase1Progress) {
            phase1Progress.style.width = ((15 - phase1Seconds) / 15 * 100) + '%';
        }
        
        if (phase1Seconds <= 0) {
            clearInterval(phase1Interval);
            // Show Phase 2 (Scroll Down button)
            if (phase1) phase1.style.display = 'none';
            if (phase2) phase2.style.display = 'block';
            
            // Add event listener to scroll button
            const scrollBtn = document.getElementById('scrollDownBtn');
            if (scrollBtn) {
                scrollBtn.addEventListener('click', window.scrollToDownload);
                // Also add onclick as backup
                scrollBtn.setAttribute('onclick', 'window.scrollToDownload()');
            }
        }
    }, 1000);
})();
</script>
@endif
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Main Content -->
        <article data-viewable-type="{{ addslashes(get_class($article)) }}" data-viewable-id="{{ $article->id }}">
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
            <div class="prose prose-lg dark:prose-invert max-w-none mb-8 article-content" style="font-family: 'Poppins', sans-serif;">
                {!! $article->rendered_content !!}
            </div>

            <!-- Download Finalize Section (shown after scroll) - Placed after article content -->
            @if($hasValidToken && $downloadLink)
            <div id="downloadFinalize" class="w-full mb-8 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg p-6 text-white" style="display: none;">
                <div class="text-center">
                    <!-- Phase 3: Countdown -->
                    <div id="phase3CountdownSection">
                        <div class="w-20 h-20 mx-auto mb-4 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
                        <h2 class="text-2xl font-bold mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            Finalizing Download
                        </h2>
                        <p class="text-green-100 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            Generating final download link...
                        </p>
                        <div class="text-4xl font-bold mb-2" id="phase3CountdownFinal" style="font-family: 'Poppins', sans-serif; font-weight: 700;">15</div>
                        <p class="text-sm text-green-200" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            seconds remaining
                        </p>
                        <div class="w-full max-w-xs mx-auto bg-white/30 rounded-full h-2 mt-4">
                            <div id="phase3ProgressFinal" class="bg-white h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <!-- Phase 4: Download Button (shown after countdown) -->
                    <div id="phase4DownloadButton" style="display: none;">
                        <div class="mb-6">
                            <svg class="w-20 h-20 mx-auto mb-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h2 class="text-2xl font-bold mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                                Download Ready!
                            </h2>
                            <p class="text-green-100 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                Your download link is ready. Click the button below to download.
                            </p>
                            <a id="downloadButtonLink" href="#" target="_blank" 
                               class="inline-block px-8 py-4 bg-white text-green-600 rounded-lg font-bold hover:bg-green-50 transition-colors shadow-lg text-lg" 
                               style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                                📥 Download Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Series Navigation (Previous/Next) -->
            @if($article->series && ($previousArticle || $nextArticle))
            <div class="mb-8 pb-6 border-b border-gray-200 dark:!border-border-secondary">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Previous Article -->
                    @if($previousArticle)
                    <a href="{{ route('articles.show', $previousArticle->slug) }}" class="group flex items-center gap-4 p-4 bg-gray-50 hover:bg-gray-100 dark:!bg-bg-card-hover dark:!hover:bg-bg-card rounded-lg transition-colors border border-gray-200 dark:!border-border-secondary">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                Previous Article
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:!text-white truncate group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $previousArticle->title }}
                            </p>
                        </div>
                    </a>
                    @else
                    <div></div>
                    @endif
                    
                    <!-- Next Article -->
                    @if($nextArticle)
                    <a href="{{ route('articles.show', $nextArticle->slug) }}" class="group flex items-center gap-4 p-4 bg-gray-50 hover:bg-gray-100 dark:!bg-bg-card-hover dark:!hover:bg-bg-card rounded-lg transition-colors border border-gray-200 dark:!border-border-secondary text-right">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:!text-text-secondary mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                Next Article
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:!text-white truncate group-hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $nextArticle->title }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Article Actions (Like & Bookmark Buttons) -->
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-200 dark:!border-border-secondary">
                <button id="likeButton" 
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ $isLiked ?? false ? 'bg-red-100 text-red-600 dark:!bg-red-900/20 dark:!text-red-400' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card' }}"
                        data-article-slug="{{ $article->slug }}"
                        data-liked="{{ $isLiked ?? false ? 'true' : 'false' }}">
                    <svg class="w-5 h-5" fill="{{ $isLiked ?? false ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <span id="likesCount">{{ $article->likes()->count() }}</span> Like{{ $article->likes()->count() !== 1 ? 's' : '' }}
                    </span>
                </button>
                
                @auth
                <button id="bookmarkButton" 
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ $isBookmarked ?? false ? 'bg-yellow-100 text-yellow-600 dark:!bg-yellow-900/20 dark:!text-yellow-400' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card' }}"
                        data-article-slug="{{ $article->slug }}"
                        data-bookmarked="{{ $isBookmarked ?? false ? 'true' : 'false' }}">
                    <svg class="w-5 h-5" fill="{{ $isBookmarked ?? false ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <span class="font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        {{ $isBookmarked ?? false ? 'Bookmarked' : 'Bookmark' }}
                    </span>
                </button>
                @else
                <a href="{{ route('login') }}" 
                   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all bg-gray-100 text-gray-700 hover:bg-gray-200 dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <span class="font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Bookmark
                    </span>
                </a>
                @endauth
            </div>

            <!-- AdSense Unit 4 - Before Comments -->
            @if(config('services.adsense.client_id'))
            <div class="mb-8 text-center">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="{{ config('services.adsense.client_id') }}"
                     data-ad-slot="{{ config('services.adsense.unit_4', '') }}"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            @endif

            <!-- Comments Section -->
            @if($article->allow_comments)
            <div class="mt-12 pt-8 border-t border-gray-200 dark:!border-border-secondary">
                <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Comments ({{ $article->comments->count() }})
                </h2>

                <!-- Comment Form -->
                <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Leave a Comment
                    </h3>
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:!bg-green-900/20 dark:!border-green-700 dark:!text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('comments.store', $article) }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="comment-name" 
                                       value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                       placeholder="Your name">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="comment-email" 
                                       value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                       placeholder="your@email.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Comment <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" id="content" rows="5" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                      placeholder="Write your comment here...">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all hover:scale-105 hover:shadow-accent" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Post Comment
                        </button>
                    </form>
                </div>

                <!-- Comments List -->
                <div id="commentsList" class="space-y-3">
                @if($article->comments->count() > 0)
                    @foreach($article->comments as $comment)
                            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($comment->user && $comment->user->avatar)
                                            <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-semibold text-sm">
                                                {{ strtoupper(substr($comment->user ? $comment->user->name : $comment->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Comment Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                {{ $comment->user ? $comment->user->name : $comment->name }}
                                            </h4>
                                            @if($comment->user && $comment->user->isAuthor())
                                                <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                                    Author
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                                • {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:!text-text-primary mb-2 whitespace-pre-line text-sm break-words" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.6;">
                                            {{ trim($comment->content) }}
                                        </p>

                                        <!-- Reply Button -->
                                        <button onclick="showReplyForm({{ $comment->id }})" class="text-sm text-accent hover:text-accent-light font-semibold transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                            Reply
                                        </button>

                                        <!-- Reply Form (Hidden by default) -->
                                        <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 pt-4 border-t border-gray-200 dark:!border-border-secondary">
                                            <form action="{{ route('comments.reply', [$article, $comment]) }}" method="POST">
                                                @csrf
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label for="reply-name-{{ $comment->id }}" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                            Name <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="text" name="name" id="reply-name-{{ $comment->id }}" 
                                                               class="reply-name-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" 
                                                               value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                                               required
                                                               placeholder="Your name">
                                                    </div>
                                                    <div>
                                                        <label for="reply-email-{{ $comment->id }}" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                            Email <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="email" name="email" id="reply-email-{{ $comment->id }}" 
                                                               class="reply-email-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" 
                                                               value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                                               required
                                                               placeholder="your@email.com">
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <textarea name="content" rows="3" required
                                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                                              placeholder="Write your reply..."></textarea>
                                                </div>

                                                <div class="flex gap-3">
                                                    <button type="submit" class="px-4 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                        Post Reply
                                                    </button>
                                                    <button type="button" onclick="hideReplyForm({{ $comment->id }})" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all text-sm dark:!bg-bg-card-hover dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Replies -->
                                        @if($comment->replies->count() > 0)
                                            <div class="mt-6 ml-8 space-y-4 border-l-2 border-gray-200 dark:!border-border-secondary pl-6">
                                                @foreach($comment->replies as $reply)
                                                    <div class="flex items-start gap-4">
                                                        <div class="flex-shrink-0">
                                                            @if($reply->user && $reply->user->avatar)
                                                                <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" class="w-10 h-10 rounded-full object-cover">
                                                            @else
                                                                <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-semibold">
                                                                    {{ strtoupper(substr($reply->user ? $reply->user->name : $reply->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-3 mb-1">
                                                                <h5 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                                    {{ $reply->user ? $reply->user->name : $reply->name }}
                                                                </h5>
                                                                @if($reply->user && $reply->user->isAuthor())
                                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                                                        Author
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p class="text-xs text-gray-500 dark:!text-text-secondary mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                                                {{ $reply->created_at->format('M d, Y \a\t g:i A') }}
                                                            </p>
                                                            <p class="text-gray-700 dark:!text-text-primary text-sm whitespace-pre-line break-words" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.6;">
                                                                {{ trim($reply->content) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @else
                    <div id="noCommentsMessage" class="text-center py-12 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary">
                        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No comments yet. Be the first to comment!
                        </p>
                    </div>
                @endif
                </div>
            </div>
            @else
            <div class="mt-12 pt-8 border-t border-gray-200 dark:!border-border-secondary text-center">
                <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Comments are disabled for this article.
                </p>
            </div>
            @endif

        </article>

            <!-- AdSense Unit 5 - Before Related Articles -->
            @if(config('services.adsense.client_id'))
            <div class="mb-8 text-center">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="{{ config('services.adsense.client_id') }}"
                     data-ad-slot="{{ config('services.adsense.unit_5', '') }}"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            @endif

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
        </article>
        </div>
    </div>

<!-- Fixed Series Progress Widget (Bottom Right) -->
@if($article->series && $seriesArticles && $seriesArticles->count() > 0)
<div class="hidden lg:block fixed bottom-4 right-4 z-40 w-72" x-data="{ open: false }">
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary shadow-xl overflow-hidden">
        <!-- Header (Clickable to toggle) -->
        <button @click="open = !open" class="w-full p-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white hover:from-purple-600 hover:to-blue-600 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-left">
                    <p class="text-xs font-semibold mb-0.5" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Article {{ $currentSeriesIndex ?? 1 }} of {{ $totalSeriesArticles }}
                    </p>
                    <p class="text-xs opacity-90" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        {{ round((($currentSeriesIndex ?? 1) / $totalSeriesArticles) * 100) }}% Complete
                    </p>
</div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <!-- Progress Bar -->
            <div class="mt-2 w-full bg-white/20 rounded-full h-1.5">
                <div class="bg-white h-1.5 rounded-full transition-all duration-300" style="width: {{ ($totalSeriesArticles ? round((($currentSeriesIndex ?? 1) / $totalSeriesArticles) * 100) : 0) }}%"></div>
            </div>
        </button>
        
        <!-- Expandable Content -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             style="display: none;">
            <div class="p-4 max-h-96 overflow-y-auto">
                <a href="{{ route('series.show', $article->series->slug) }}" class="text-xs font-semibold text-purple-600 dark:!text-purple-400 hover:text-purple-700 dark:!hover:text-purple-300 transition-colors mb-3 block" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    {{ $article->series->title }}
                </a>
                
                <h4 class="text-xs font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Table of Contents
                </h4>
                <div class="space-y-1.5">
                    @foreach($seriesArticles as $seriesArticle)
                        <div class="flex items-start gap-2 {{ $seriesArticle->id === $article->id ? 'bg-purple-50 dark:!bg-purple-900/10 rounded p-1.5 -mx-1.5' : '' }}">
                            <span class="text-xs text-gray-500 dark:!text-text-tertiary w-5 flex-shrink-0 pt-0.5" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $seriesArticle->series_order ?? $loop->iteration }}.
                            </span>
                            @if($seriesArticle->id === $article->id)
                                <span class="text-xs font-semibold text-purple-600 dark:!text-purple-400 flex-1 line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    {{ $seriesArticle->title }} <span class="text-purple-500">(Current)</span>
                                </span>
                            @else
                                <a href="{{ route('articles.show', $seriesArticle->slug) }}" class="text-xs text-gray-700 hover:text-purple-600 dark:!text-text-secondary dark:!hover:text-purple-400 flex-1 line-clamp-2 transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                    {{ $seriesArticle->title }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
// LocalStorage keys
const COMMENT_NAME_KEY = 'comment_user_name';
const COMMENT_EMAIL_KEY = 'comment_user_email';

// Load saved name and email from localStorage
document.addEventListener('DOMContentLoaded', function() {
    const savedName = localStorage.getItem(COMMENT_NAME_KEY);
    const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY);
    
    // Fill main comment form
    const nameInput = document.getElementById('comment-name');
    const emailInput = document.getElementById('comment-email');
    
    if (nameInput && savedName) {
        nameInput.value = savedName;
    }
    if (emailInput && savedEmail) {
        emailInput.value = savedEmail;
    }
    
    // Fill reply forms when they're shown
    const replyNameInputs = document.querySelectorAll('.reply-name-input');
    const replyEmailInputs = document.querySelectorAll('.reply-email-input');
    
    replyNameInputs.forEach(input => {
        if (savedName) {
            input.value = savedName;
        }
    });
    
    replyEmailInputs.forEach(input => {
        if (savedEmail) {
            input.value = savedEmail;
        }
    });
});

// AJAX Comment Submission
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.querySelector('form[action*="comments.store"]');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Posting...';
            
            // Save to localStorage
            const nameInput = document.getElementById('comment-name');
            const emailInput = document.getElementById('comment-email');
            
            if (nameInput && nameInput.value.trim()) {
                localStorage.setItem(COMMENT_NAME_KEY, nameInput.value.trim());
            }
            if (emailInput && emailInput.value.trim()) {
                localStorage.setItem(COMMENT_EMAIL_KEY, emailInput.value.trim());
            }
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');
                    
                    // Clear form
                    this.reset();
                    
                    // Re-fill with saved values
                    if (nameInput) nameInput.value = localStorage.getItem(COMMENT_NAME_KEY) || '';
                    if (emailInput) emailInput.value = localStorage.getItem(COMMENT_EMAIL_KEY) || '';
                    
                    // If not pending, add comment to list
                    if (!data.pending && data.comment) {
                        addCommentToPage(data.comment);
                        updateCommentCount();
                        document.getElementById('noCommentsMessage')?.remove();
                    }
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        });
    }
    
    // AJAX Reply Submission
    document.addEventListener('submit', function(e) {
        if (e.target.matches('form[action*="comments.reply"]')) {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            // Extract parent comment ID from form action: /articles/{article}/comments/{commentId}/reply
            const actionParts = form.action.split('/');
            const parentId = actionParts[actionParts.length - 2]; // Second to last part
            
            submitButton.disabled = true;
            submitButton.textContent = 'Posting...';
            
            // Save to localStorage
            const nameInput = form.querySelector('.reply-name-input');
            const emailInput = form.querySelector('.reply-email-input');
            
            if (nameInput && nameInput.value.trim()) {
                localStorage.setItem(COMMENT_NAME_KEY, nameInput.value.trim());
            }
            if (emailInput && emailInput.value.trim()) {
                localStorage.setItem(COMMENT_EMAIL_KEY, emailInput.value.trim());
            }
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    
                    // Hide reply form
                    const replyFormDiv = form.closest('[id^="reply-form-"]');
                    if (replyFormDiv) {
                        const commentId = replyFormDiv.id.replace('reply-form-', '');
                        hideReplyForm(commentId);
                    }
                    
                    // If not pending, add reply to page
                    if (!data.pending && data.reply) {
                        addReplyToPage(data.reply, parentId);
                        updateCommentCount();
                    }
                } else {
                    showMessage(data.message || 'An error occurred. Please try again.', 'error');
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        }
    });
});

// Helper functions
function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `mb-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-100 border border-green-400 text-green-700 dark:!bg-green-900/20 dark:!border-green-700 dark:!text-green-400' : 'bg-red-100 border border-red-400 text-red-700 dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400'}`;
    messageDiv.textContent = message;
    messageDiv.style.fontFamily = "'Poppins', sans-serif";
    
    const commentForm = document.querySelector('.bg-white.dark\\!bg-bg-card.rounded-lg.border');
    if (commentForm) {
        const existingMessage = commentForm.querySelector('.mb-4.p-4.rounded-lg');
        if (existingMessage) {
            existingMessage.remove();
        }
        commentForm.insertBefore(messageDiv, commentForm.querySelector('form'));
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
}

function addCommentToPage(comment) {
    const commentsList = document.getElementById('commentsList');
    if (!commentsList) return;
    
    const commentHtml = `
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    ${comment.avatar ? 
                        `<img src="${comment.avatar}" alt="${comment.name}" class="w-10 h-10 rounded-full object-cover">` :
                        `<div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-semibold text-sm">${comment.name.charAt(0).toUpperCase()}</div>`
                    }
                            </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            ${comment.name}
                                </h4>
                        ${comment.is_author ? '<span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: \'Poppins\', sans-serif; font-weight: 500;">Author</span>' : ''}
                        <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            • ${comment.created_at}
                        </span>
                    </div>
                    <p class="text-gray-700 dark:!text-text-primary mb-2 whitespace-pre-line text-sm break-words" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.6;">
                        ${comment.content.trim()}
                    </p>
                    <button onclick="showReplyForm(${comment.id})" class="text-sm text-accent hover:text-accent-light font-semibold transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Reply
                    </button>
                    <div id="reply-form-${comment.id}" class="hidden mt-4 pt-4 border-t border-gray-200 dark:!border-border-secondary">
                        ${getReplyFormHtml(comment.id)}
                            </div>
                </div>
            </div>
        </div>
    `;
    
    commentsList.insertAdjacentHTML('afterbegin', commentHtml);
}

function addReplyToPage(reply, parentId) {
    // Find parent comment - could be a main comment or a nested reply
    let parentElement = document.querySelector(`[data-comment-id="${parentId}"]`);
    
    // If not found as main comment, try to find in replies
    if (!parentElement) {
        const allReplies = document.querySelectorAll('.replies-container > div');
        for (let replyDiv of allReplies) {
            if (replyDiv.getAttribute('data-reply-id') === parentId.toString()) {
                parentElement = replyDiv;
                break;
            }
        }
    }
    
    if (!parentElement) {
        // Find by looking for the reply form that was just submitted
        const replyForm = document.querySelector(`form[action*="/comments/${parentId}/reply"]`);
        if (replyForm) {
            parentElement = replyForm.closest('[data-comment-id]') || replyForm.closest('.bg-white');
        }
    }
    
    if (!parentElement) return;
    
    let repliesContainer = parentElement.querySelector('.replies-container');
    if (!repliesContainer) {
        repliesContainer = document.createElement('div');
        repliesContainer.className = 'mt-3 ml-6 space-y-2 border-l-2 border-gray-200 dark:!border-border-secondary pl-4 replies-container';
        const commentContent = parentElement.querySelector('.flex-1');
        if (commentContent) {
            commentContent.appendChild(repliesContainer);
        }
    }
    
    const replyHtml = `
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                ${reply.avatar ? 
                    `<img src="${reply.avatar}" alt="${reply.name}" class="w-8 h-8 rounded-full object-cover">` :
                    `<div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-white font-semibold text-xs">${reply.name.charAt(0).toUpperCase()}</div>`
                }
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <h5 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        ${reply.name}
                    </h5>
                    ${reply.is_author ? '<span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: \'Poppins\', sans-serif; font-weight: 500;">Author</span>' : ''}
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        • ${reply.created_at}
                            </span>
                </div>
                <p class="text-gray-700 dark:!text-text-primary text-sm whitespace-pre-line break-words mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.6;">
                    ${reply.content.trim()}
                </p>
            </div>
        </div>
    `;
    
    repliesContainer.insertAdjacentHTML('beforeend', replyHtml);
}

function getReplyFormHtml(commentId) {
    const savedName = localStorage.getItem(COMMENT_NAME_KEY) || '';
    const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY) || '';
    const articleId = {{ $article->id }};
    
    return `
        <form action="/articles/${articleId}/comments/${commentId}/reply" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" class="reply-name-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" value="${savedName}" required placeholder="Your name">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" class="reply-email-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" value="${savedEmail}" required placeholder="your@email.com">
    </div>
</div>
            <div class="mb-4">
                <textarea name="content" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" placeholder="Write your reply..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Post Reply</button>
                <button type="button" onclick="hideReplyForm(${commentId})" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all text-sm dark:!bg-bg-card-hover dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Cancel</button>
            </div>
        </form>
    `;
}

function updateCommentCount() {
    const commentsList = document.getElementById('commentsList');
    const comments = commentsList.querySelectorAll('.bg-white.dark\\!bg-bg-card.rounded-lg');
    const count = comments.length;
    const countElement = document.querySelector('h2');
    if (countElement && countElement.textContent.includes('Comments')) {
        countElement.textContent = `Comments (${count})`;
    }
}

function showReplyForm(commentId) {
    const replyForm = document.getElementById('reply-form-' + commentId);
    replyForm.classList.remove('hidden');
    
    // Load saved name and email into reply form
    const savedName = localStorage.getItem(COMMENT_NAME_KEY);
    const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY);
    
    const nameInput = document.getElementById('reply-name-' + commentId);
    const emailInput = document.getElementById('reply-email-' + commentId);
    
    if (nameInput && savedName) {
        nameInput.value = savedName;
    }
    if (emailInput && savedEmail) {
        emailInput.value = savedEmail;
    }
}

function hideReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).classList.add('hidden');
    // Clear form
    const form = document.getElementById('reply-form-' + commentId).querySelector('form');
    if (form) {
        form.reset();
        
        // Re-fill with saved values after reset
        const savedName = localStorage.getItem(COMMENT_NAME_KEY);
        const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY);
        
        const nameInput = form.querySelector('.reply-name-input');
        const emailInput = form.querySelector('.reply-email-input');
        
        if (nameInput && savedName) {
            nameInput.value = savedName;
        }
        if (emailInput && savedEmail) {
            emailInput.value = savedEmail;
        }
    }
}

// Article Like functionality
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.getElementById('likeButton');
    if (likeButton) {
        likeButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const articleSlug = this.getAttribute('data-article-slug');
            if (!articleSlug) {
                console.error('Article slug not found');
                alert('Failed to like article. Article information is missing.');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value ||
                             document.querySelector('input[name="csrf_token"]')?.value;
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                alert('Security token missing. Please refresh the page and try again.');
                return;
            }
            
            // Disable button during request
            this.disabled = true;
            
            // Create form data for POST request
            const formData = new FormData();
            formData.append('_token', csrfToken);
            
            // Construct the like URL using article slug (route model binding uses slug)
            const likeUrl = `/articles/${articleSlug}/like`;
            fetch(likeUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                // Handle different response statuses
                if (response.status === 404) {
                    console.error('Like route not found:', likeUrl);
                    alert('Like feature is not available. Please try again later.');
                    throw new Error('Route not found');
                }
                
                if (!response.ok) {
                    // Try to parse error response
                    return response.text().then(text => {
                        let errorData;
                        try {
                            errorData = JSON.parse(text);
                        } catch (e) {
                            errorData = { message: text || 'Failed to like article' };
                        }
                        console.error('Server error response:', errorData);
                        throw new Error(errorData.message || errorData.error || 'Failed to like article');
                    });
                }
                
                return response.json();
            })
            .then(data => {
                this.disabled = false;
                
                const likesCountEl = document.getElementById('likesCount');
                if (likesCountEl && data.likes_count !== undefined) {
                    const likeText = data.likes_count === 1 ? 'Like' : 'Likes';
                    const parent = likesCountEl.parentElement;
                    if (parent) {
                        parent.innerHTML = `<span id="likesCount">${data.likes_count}</span> ${likeText}`;
                    }
                }
                
                // Update button state
                if (data.liked) {
                    this.setAttribute('data-liked', 'true');
                    this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                    this.classList.add('bg-red-100', 'text-red-600', 'dark:!bg-red-900/20', 'dark:!text-red-400');
                    const svg = this.querySelector('svg');
                    if (svg) {
                        svg.setAttribute('fill', 'currentColor');
                    }
                } else {
                    this.setAttribute('data-liked', 'false');
                    this.classList.remove('bg-red-100', 'text-red-600', 'dark:!bg-red-900/20', 'dark:!text-red-400');
                    this.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                    const svg = this.querySelector('svg');
                    if (svg) {
                        svg.setAttribute('fill', 'none');
                    }
                }
            })
            .catch(error => {
                this.disabled = false;
                console.error('Like error:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack,
                    likeUrl: likeUrl,
                    articleSlug: articleSlug
                });
                
                // Don't show alert if it's already been shown (e.g., for 404)
                if (error.message !== 'Route not found') {
                    const errorMessage = error.message || 'Failed to like article. Please try again.';
                    alert(errorMessage);
                }
            });
        });
    }

    // Article Bookmark functionality
    const bookmarkButton = document.getElementById('bookmarkButton');
    if (bookmarkButton) {
        bookmarkButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const articleSlug = this.getAttribute('data-article-slug');
            if (!articleSlug) {
                console.error('Article slug not found');
                alert('Failed to bookmark article. Article information is missing.');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value ||
                             document.querySelector('input[name="csrf_token"]')?.value;
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                alert('Security token missing. Please refresh the page and try again.');
                return;
            }
            
            // Disable button during request
            this.disabled = true;
            
            // Create form data for POST request
            const formData = new FormData();
            formData.append('_token', csrfToken);
            
            // Construct the bookmark URL using article slug (route model binding uses slug)
            const bookmarkUrl = `/articles/${articleSlug}/bookmark`;
            
            fetch(bookmarkUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                // Handle authentication errors
                if (response.status === 401) {
                    return response.json().then(err => {
                        alert(err.message || 'You must be logged in to bookmark articles.');
                        window.location.href = '{{ route("login") }}';
                        throw new Error('Unauthorized');
                    });
                }
                
                // Handle 404 errors
                if (response.status === 404) {
                    console.error('Bookmark route not found:', bookmarkUrl);
                    alert('Bookmark feature is not available. Please try again later.');
                    throw new Error('Route not found');
                }
                
                if (!response.ok) {
                    // Try to parse error response
                    return response.text().then(text => {
                        let errorData;
                        try {
                            errorData = JSON.parse(text);
                        } catch (e) {
                            errorData = { message: text || 'Failed to bookmark article' };
                        }
                        console.error('Server error response:', errorData);
                        throw new Error(errorData.message || errorData.error || 'Failed to bookmark article');
                    });
                }
                
                return response.json();
            })
            .then(data => {
                this.disabled = false;
                
                if (data.success) {
                    // Update button state
                    const isBookmarked = data.bookmarked;
                    this.setAttribute('data-bookmarked', isBookmarked ? 'true' : 'false');
                    
                    const buttonText = this.querySelector('span');
                    const svg = this.querySelector('svg');
                    
                    if (isBookmarked) {
                        this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                        this.classList.add('bg-yellow-100', 'text-yellow-600', 'dark:!bg-yellow-900/20', 'dark:!text-yellow-400');
                        if (svg) svg.setAttribute('fill', 'currentColor');
                        if (buttonText) buttonText.textContent = 'Bookmarked';
                    } else {
                        this.classList.remove('bg-yellow-100', 'text-yellow-600', 'dark:!bg-yellow-900/20', 'dark:!text-yellow-400');
                        this.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                        if (svg) svg.setAttribute('fill', 'none');
                        if (buttonText) buttonText.textContent = 'Bookmark';
                    }
                    
                    // Show message if available
                    if (data.message) {
                        showMessage(data.message, 'success');
                    }
                }
            })
            .catch(error => {
                this.disabled = false;
                console.error('Bookmark error:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack,
                    bookmarkUrl: bookmarkUrl,
                    articleSlug: articleSlug
                });
                
                // Don't show alert if it's already been shown (e.g., for 401 or 404)
                if (error.message !== 'Unauthorized' && error.message !== 'Route not found') {
                    // Try to get more details from the error
                    const errorMessage = error.message || 'Failed to bookmark article. Please try again.';
                    alert(errorMessage);
                }
            });
        });
    }
});

// Inject AdSense after first paragraph
document.addEventListener('DOMContentLoaded', function() {
    const articleContent = document.querySelector('.article-content');
    if (articleContent) {
        const paragraphs = articleContent.querySelectorAll('p');
        if (paragraphs.length > 0 && document.getElementById('adsense-unit-2')) {
            // Insert ad after first paragraph
            paragraphs[0].insertAdjacentElement('afterend', document.getElementById('adsense-unit-2'));
            document.getElementById('adsense-unit-2').style.display = 'block';
        }
    }
});
</script>
@endsection

