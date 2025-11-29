<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Total statistics
        $totalContent = Content::count();
        $totalMovies = Content::whereIn('type', ['movie', 'documentary', 'short_film'])->count();
        $totalTvShows = Content::whereIn('type', ['tv_show', 'web_series', 'anime', 'reality_show', 'talk_show'])->count();
        $totalEpisodes = Episode::count();
        
        // Status breakdown
        $publishedContent = Content::where('status', 'published')->count();
        $draftContent = Content::where('status', 'draft')->count();
        $upcomingContent = Content::where('status', 'upcoming')->count();
        
        // Content type breakdown
        $tmdbContent = Content::where('content_type', 'tmdb')->count();
        $customContent = Content::where('content_type', 'custom')->count();
        
        // Total views
        $totalViews = Content::sum('views') ?? 0;
        
        // Featured content count
        $featuredContent = Content::where('is_featured', true)->count();
        
        // Recent content (last 10)
        $recentContent = Content::orderBy('created_at', 'desc')->limit(10)->get();
        
        // Content by type breakdown
        $contentByType = Content::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();
        
        // Recent episodes
        $recentEpisodes = Episode::with('content')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Content with most views
        $topViewedContent = Content::where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();
        
        // Content added this month
        $thisMonthContent = Content::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Content added this week
        $thisWeekContent = Content::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        
        // Episodes added this month
        $thisMonthEpisodes = Episode::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.dashboard', compact(
            'totalContent',
            'totalMovies',
            'totalTvShows',
            'totalEpisodes',
            'publishedContent',
            'draftContent',
            'upcomingContent',
            'tmdbContent',
            'customContent',
            'totalViews',
            'featuredContent',
            'recentContent',
            'contentByType',
            'recentEpisodes',
            'topViewedContent',
            'thisMonthContent',
            'thisWeekContent',
            'thisMonthEpisodes'
        ));
    }
}

