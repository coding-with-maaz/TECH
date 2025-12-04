<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AuthorDashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\AnalyticsTrackingController;
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.store');
    
    // Firebase Authentication Route
    Route::post('/auth/firebase', [FirebaseAuthController::class, 'authenticate'])->name('firebase.authenticate');
    
    // Social Authentication Routes (optional - requires Laravel Socialite)
    // Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    // Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Email Verification Routes
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    // User Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/dashboard/request-author', [UserDashboardController::class, 'requestAuthor'])->name('user.request-author');
    
    // Author Dashboard
    Route::prefix('author')->middleware('author')->name('author.')->group(function () {
        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');
    });
});

// SEO routes (must be before other routes for proper matching)
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

// Sitemap routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/index.xml', [SitemapController::class, 'sitemapIndex'])->name('sitemap.sitemap-index');
Route::get('/sitemap/static.xml', [SitemapController::class, 'static'])->name('sitemap.static');
Route::get('/sitemap/articles.xml', [SitemapController::class, 'articles'])->name('sitemap.articles');
Route::get('/sitemap/categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('/sitemap/tags.xml', [SitemapController::class, 'tags'])->name('sitemap.tags');

// Article routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Article actions (must come before slug route to avoid conflicts)
Route::post('/articles/{article}/like', [App\Http\Controllers\ArticleLikeController::class, 'toggle'])->name('articles.like');
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/articles/{article}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

// Article show route (must be last to avoid conflicts)
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Movie download redirect (from movie site)
Route::get('/go/{slug}', [App\Http\Controllers\MovieRedirectController::class, 'redirect'])->name('movie.redirect');

// AMP routes
Route::get('/amp/articles/{slug}', [App\Http\Controllers\AmpController::class, 'article'])->name('amp.article');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Tag routes
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{slug}', [TagController::class, 'show'])->name('tags.show');

// Series routes
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{slug}', [SeriesController::class, 'show'])->name('series.show');

// Profile routes
Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{username}/articles', [ProfileController::class, 'articles'])->name('profile.articles');

// Bookmark routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/articles/{article}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/articles/{article}/bookmark/store', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::put('/bookmarks/{bookmark}', [BookmarkController::class, 'update'])->name('bookmarks.update');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::delete('/articles/{article}/bookmark', [BookmarkController::class, 'removeByArticle'])->name('bookmarks.remove-by-article');
});

// Follow routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/profile/{user}/follow', [FollowController::class, 'follow'])->name('profile.follow');
    Route::delete('/profile/{user}/unfollow', [FollowController::class, 'unfollow'])->name('profile.unfollow');
    Route::post('/profile/{user}/toggle-follow', [FollowController::class, 'toggle'])->name('profile.toggle-follow');
    Route::get('/profile/{username}/followers', [FollowController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{username}/following', [FollowController::class, 'following'])->name('profile.following');
    
    // Profile edit routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Activity feed routes
    Route::get('/activity', [ActivityController::class, 'timeline'])->name('activity.timeline');
    Route::get('/profile/{username}/activity', [ActivityController::class, 'index'])->name('profile.activity');
});

// Analytics Tracking (public endpoints for JavaScript)
Route::post('/analytics/track/view', [AnalyticsTrackingController::class, 'trackView'])->name('analytics.track.view');
Route::post('/analytics/track/time', [AnalyticsTrackingController::class, 'trackTimeOnPage'])->name('analytics.track.time');
Route::post('/analytics/track/event', [AnalyticsTrackingController::class, 'trackEvent'])->name('analytics.track.event');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Admin routes - Protected with authentication and admin middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Article management
    Route::resource('articles', AdminArticleController::class);
    
    // Article revisions
    Route::get('articles/{article}/revisions', [App\Http\Controllers\Admin\ArticleRevisionController::class, 'index'])->name('articles.revisions');
    Route::get('articles/{article}/revisions/{revision}', [App\Http\Controllers\Admin\ArticleRevisionController::class, 'show'])->name('articles.revisions.show');
    Route::get('articles/{article}/revisions/{revision1}/compare/{revision2?}', [App\Http\Controllers\Admin\ArticleRevisionController::class, 'compare'])->name('articles.revisions.compare');
    Route::post('articles/{article}/revisions/{revision}/restore', [App\Http\Controllers\Admin\ArticleRevisionController::class, 'restore'])->name('articles.revisions.restore');
    
    // Category management
    Route::resource('categories', AdminCategoryController::class);
    
    // Tag management
    Route::resource('tags', AdminTagController::class);
    
    // Series management
    Route::resource('series', App\Http\Controllers\Admin\SeriesController::class);
    // Series article management (must be after resource route)
    Route::post('series/{series}/add-article', [App\Http\Controllers\Admin\SeriesController::class, 'addArticle'])->name('series.add-article');
    Route::post('series/{series}/update-article-order', [App\Http\Controllers\Admin\SeriesController::class, 'updateArticleOrder'])->name('series.update-article-order');
    Route::delete('series/{series}/articles/{article}', [App\Http\Controllers\Admin\SeriesController::class, 'removeArticle'])->name('series.remove-article');
    
    // Settings management
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/facebook', [App\Http\Controllers\Admin\SettingsController::class, 'updateFacebook'])->name('settings.facebook.update');
    Route::post('settings/facebook/test', [App\Http\Controllers\Admin\SettingsController::class, 'testFacebook'])->name('settings.facebook.test');
    Route::post('settings/twitter', [App\Http\Controllers\Admin\SettingsController::class, 'updateTwitter'])->name('settings.twitter.update');
    Route::post('settings/twitter/test', [App\Http\Controllers\Admin\SettingsController::class, 'testTwitter'])->name('settings.twitter.test');
    Route::post('settings/instagram', [App\Http\Controllers\Admin\SettingsController::class, 'updateInstagram'])->name('settings.instagram.update');
    Route::post('settings/instagram/test', [App\Http\Controllers\Admin\SettingsController::class, 'testInstagram'])->name('settings.instagram.test');
    Route::post('settings/threads', [App\Http\Controllers\Admin\SettingsController::class, 'updateThreads'])->name('settings.threads.update');
    Route::post('settings/threads/test', [App\Http\Controllers\Admin\SettingsController::class, 'testThreads'])->name('settings.threads.test');
    
    // Author management
    Route::get('authors', [App\Http\Controllers\Admin\AuthorController::class, 'index'])->name('authors.index');
    // Author requests routes (must come before {author} route to avoid conflicts)
    Route::get('authors/requests', [App\Http\Controllers\Admin\AuthorController::class, 'requests'])->name('authors.requests');
    Route::post('authors/requests/{request}/approve', [App\Http\Controllers\Admin\AuthorController::class, 'approveRequest'])->name('authors.requests.approve');
    Route::post('authors/requests/{request}/reject', [App\Http\Controllers\Admin\AuthorController::class, 'rejectRequest'])->name('authors.requests.reject');
    // Author detail routes (must come after requests routes)
    Route::get('authors/{author}', [App\Http\Controllers\Admin\AuthorController::class, 'show'])->name('authors.show');
    Route::put('authors/{author}/permissions', [App\Http\Controllers\Admin\AuthorController::class, 'updatePermissions'])->name('authors.update-permissions');
    Route::delete('authors/{author}/remove-status', [App\Http\Controllers\Admin\AuthorController::class, 'removeAuthorStatus'])->name('authors.remove-status');
    
    // Public Pages SEO Management
    Route::resource('page-seo', PageSeoController::class);
    
    // Analytics Dashboard
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/realtime', [AnalyticsController::class, 'realTime'])->name('analytics.realtime');
    Route::get('articles/{article}/analytics', [AnalyticsController::class, 'articlePerformance'])->name('articles.analytics');
    Route::get('analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
});

// Author article management routes (auth middleware, no admin required)
Route::prefix('admin')->middleware(['auth', 'author'])->name('admin.')->group(function () {
    // Article auto-save (for authors)
    Route::post('articles/{article?}/auto-save', [AdminArticleController::class, 'autoSave'])->name('articles.auto-save');
    
    // Article revisions (authors can view their own)
    Route::get('articles/{article}/revisions', [App\Http\Controllers\Admin\ArticleRevisionController::class, 'index'])->name('articles.revisions');
    Route::get('articles/{article}/revisions/{revision}', [App\Http\Controllers\Admin\ArticleRevisionController::class, 'show'])->name('articles.revisions.show');
});
