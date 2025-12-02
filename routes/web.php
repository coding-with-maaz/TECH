<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

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
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Tag routes
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{slug}', [TagController::class, 'show'])->name('tags.show');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Article management
    Route::resource('articles', AdminArticleController::class);
    
    // Category management
    Route::resource('categories', AdminCategoryController::class);
    
    // Tag management
    Route::resource('tags', AdminTagController::class);
    
    // Public Pages SEO Management
    Route::resource('page-seo', PageSeoController::class);
});
