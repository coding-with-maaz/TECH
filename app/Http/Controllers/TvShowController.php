<?php

namespace App\Http\Controllers;

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

        return view('tv-shows.index', [
            'tvShows' => $tvShows['results'] ?? [],
            'currentPage' => $tvShows['page'] ?? 1,
            'totalPages' => $tvShows['total_pages'] ?? 1,
            'type' => $type,
        ]);
    }

    public function show($id)
    {
        $tvShow = $this->tmdb->getTvShowDetails($id);

        if (!$tvShow) {
            abort(404);
        }

        return view('tv-shows.show', [
            'tvShow' => $tvShow,
        ]);
    }
}
