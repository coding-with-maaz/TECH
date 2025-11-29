<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $tmdb;

    public function __construct(TmdbService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    public function index(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $perPage = 20; // Items per page

        // Get all custom content (published only) - will be shown on first pages
        $allCustomContent = Content::published()
            ->orderBy('sort_order', 'asc')
            ->orderBy('release_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Convert custom content to array format
        $customContentArray = [];
        foreach ($allCustomContent as $content) {
            $customContentArray[] = [
                'type' => in_array($content->type, ['tv_show', 'web_series', 'anime', 'reality_show', 'talk_show']) ? 'tv' : 'movie',
                'id' => $content->slug ?? ('custom_' . $content->id),
                'slug' => $content->slug,
                'title' => $content->title,
                'date' => $content->release_date ? $content->release_date->format('Y-m-d') : null,
                'rating' => $content->rating ?? 0,
                'backdrop' => $content->backdrop_path ?? $content->poster_path ?? null,
                'poster' => $content->poster_path ?? null,
                'overview' => $content->description ?? '',
                'is_custom' => true,
                'content_id' => $content->id,
                'content_type' => $content->content_type ?? 'custom', // Store the actual content_type (custom/tmdb)
                'content_type_name' => $content->type, // Store the type name (movie/tv_show/etc)
                'dubbing_language' => $content->dubbing_language,
            ];
        }

        // Only show custom content from database (no TMDB content)
        $allContent = [];

        // Paginate custom content
        $totalContentCount = count($customContentArray);
        $totalPages = max(1, ceil($totalContentCount / $perPage));
        
        // Get items for current page
        $startIndex = ($page - 1) * $perPage;
        $allContent = array_slice($customContentArray, $startIndex, $perPage);

        // Sort by date (newest first)
        usort($allContent, function($a, $b) {
            $dateA = $a['date'] ?? '1970-01-01';
            $dateB = $b['date'] ?? '1970-01-01';
            return strcmp($dateB, $dateA);
        });

        // Get popular content based on views for sidebar
        $popularContent = Content::published()
            ->orderBy('views', 'desc')
            ->orderBy('release_date', 'desc')
            ->take(5)
            ->get();

        return view('home', [
            'allContent' => $allContent,
            'currentPage' => $page,
            'totalPages' => max(1, $totalPages),
            'popularContent' => $popularContent,
        ]);
    }
}
