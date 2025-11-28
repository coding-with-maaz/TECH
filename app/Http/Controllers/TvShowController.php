<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    protected $tmdb;

    public function __construct(TmdbService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $type = $request->get('type', 'popular');

        $tvShows = match($type) {
            'top_rated' => $this->tmdb->getTopRatedTvShows($page),
            default => $this->tmdb->getPopularTvShows($page),
        };

        // Get custom TV show content
        $customTvShows = Content::published()
            ->whereIn('type', ['tv_show', 'web_series', 'anime', 'reality_show', 'talk_show'])
            ->orderBy('sort_order', 'asc')
            ->orderBy('release_date', 'desc')
            ->get();

        // Get top rated TV shows for sidebar
        $topRatedTvShows = $this->tmdb->getTopRatedTvShows(1);

        return view('tv-shows.index', [
            'tvShows' => $tvShows['results'] ?? [],
            'customTvShows' => $customTvShows,
            'topRatedTvShows' => $topRatedTvShows['results'] ?? [],
            'currentPage' => $tvShows['page'] ?? 1,
            'totalPages' => $tvShows['total_pages'] ?? 1,
            'type' => $type,
        ]);
    }

    public function show($slug)
    {
        // First, try to find custom content by slug
        $content = Content::whereIn('type', ['tv_show', 'web_series', 'anime', 'reality_show', 'talk_show'])
            ->where(function($query) use ($slug) {
                $query->where('slug', $slug)
                      ->orWhere(function($q) use ($slug) {
                          // Backward compatibility: check if it's an old custom_ format
                          if (str_starts_with($slug, 'custom_')) {
                              $contentId = str_replace('custom_', '', $slug);
                              $q->where('id', $contentId);
                          }
                      });
            })
            ->first();

        if ($content) {
            // Load published episodes with servers
            $episodes = $content->episodes()
                ->where('is_published', true)
                ->with('servers')
                ->orderBy('episode_number')
                ->get();
            
            // Set episodes as a collection attribute
            $content->setRelation('episodes', $episodes);
            
            // Get recommended movies for custom content
            $recommendedMovies = $this->tmdb->getPopularMovies(1);
            
            return view('tv-shows.show', [
                'content' => $content,
                'isCustom' => true,
                'recommendedMovies' => $recommendedMovies['results'] ?? [],
            ]);
        }

        // If not found as custom content, try as TMDB ID (numeric)
        if (is_numeric($slug)) {
            $tvShow = $this->tmdb->getTvShowDetails($slug);

            if ($tvShow) {
                // Check if there's a custom content linked to this TMDB ID
                $customContent = Content::where('tmdb_id', $slug)
                    ->whereIn('type', ['tv_show', 'web_series', 'anime', 'reality_show', 'talk_show'])
                    ->first();
                
                // Load published episodes only if custom content exists
                if ($customContent) {
                    $episodes = $customContent->episodes()
                        ->where('is_published', true)
                        ->with('servers')
                        ->orderBy('episode_number')
                        ->get();
                    $customContent->setRelation('episodes', $episodes);
                }

                // Get recommended movies
                $recommendedMovies = $this->tmdb->getPopularMovies(1);

                return view('tv-shows.show', [
                    'tvShow' => $tvShow,
                    'content' => $customContent,
                    'isCustom' => false,
                    'recommendedMovies' => $recommendedMovies['results'] ?? [],
                ]);
            }
        }

        // Not found
        abort(404);
    }
}
