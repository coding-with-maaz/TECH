<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;
use App\Models\NewsletterSubscription;
use App\Models\ContactMessage;
use App\Models\AuthorRequest;
use App\Models\AnalyticsView;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Total statistics
        $totalArticles = Article::count();
        $totalCategories = Category::count();
        $totalTags = Tag::count();
        $totalComments = Comment::count();
        $totalUsers = User::count();
        
        // Article status breakdown
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $scheduledArticles = Article::where('status', 'scheduled')->count();
        
        // Total views
        $totalViews = Article::sum('views') ?? 0;
        
        // Featured articles count
        $featuredArticles = Article::where('is_featured', true)->count();
        
        // Recent articles (last 10)
        $recentArticles = Article::with(['category', 'author'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Articles by category breakdown
        $articlesByCategory = Category::withCount('articles')
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->get();
        
        // Recent comments
        $recentComments = Comment::with(['article', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Articles with most views
        $topViewedArticles = Article::where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();
        
        // Articles added this month
        $thisMonthArticles = Article::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Articles added this week
        $thisWeekArticles = Article::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        
        // Comments this month
        $thisMonthComments = Comment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Newsletter subscriptions
        $totalSubscriptions = NewsletterSubscription::where('is_active', true)->count();
        $newSubscriptionsThisMonth = NewsletterSubscription::where('is_active', true)
            ->whereMonth('subscribed_at', now()->month)
            ->whereYear('subscribed_at', now()->year)
            ->count();
        
        // Contact messages
        $unreadMessages = ContactMessage::where('status', 'unread')->count();
        $totalMessages = ContactMessage::count();
        
        // Author statistics
        $totalAuthors = User::where(function($query) {
            $query->where('is_author', true)
                  ->orWhere('role', 'author')
                  ->orWhere('role', 'admin');
        })->count();
        
        $pendingAuthorRequests = AuthorRequest::where('status', 'pending')->count();

        // Quick Analytics Stats (last 24 hours)
        try {
            $analyticsService = app(AnalyticsService::class);
            $yesterday = Carbon::now()->subDay();
            $today = Carbon::now();
            
            $quickAnalytics = [
                'today_views' => AnalyticsView::whereBetween('viewed_at', [$yesterday, $today])->count(),
                'today_unique' => AnalyticsView::whereBetween('viewed_at', [$yesterday, $today])
                    ->distinct('session_id')->count('session_id'),
                'realtime' => $analyticsService->getRealTimeStats(30),
            ];
        } catch (\Exception $e) {
            // Analytics might not be set up yet
            $quickAnalytics = [
                'today_views' => 0,
                'today_unique' => 0,
                'realtime' => ['active_users' => 0, 'page_views' => 0],
            ];
        }

        return view('admin.dashboard', compact(
            'totalArticles',
            'totalCategories',
            'totalTags',
            'totalComments',
            'totalUsers',
            'publishedArticles',
            'draftArticles',
            'scheduledArticles',
            'totalViews',
            'featuredArticles',
            'recentArticles',
            'articlesByCategory',
            'recentComments',
            'topViewedArticles',
            'thisMonthArticles',
            'thisWeekArticles',
            'thisMonthComments',
            'totalSubscriptions',
            'newSubscriptionsThisMonth',
            'unreadMessages',
            'totalMessages',
            'totalAuthors',
            'pendingAuthorRequests',
            'quickAnalytics'
        ));
    }
}

