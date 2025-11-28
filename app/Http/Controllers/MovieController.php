<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
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

        $movies = match($type) {
            'top_rated' => $this->tmdb->getTopRatedMovies($page),
            'now_playing' => $this->tmdb->getNowPlayingMovies($page),
            'upcoming' => $this->tmdb->getUpcomingMovies($page),
            default => $this->tmdb->getPopularMovies($page),
        };

        // Get custom movie content
        $customMovies = Content::published()
            ->whereIn('type', ['movie', 'documentary', 'short_film'])
            ->orderBy('sort_order', 'asc')
            ->orderBy('release_date', 'desc')
            ->get();

        // Get top rated movies for sidebar
        $topRatedMovies = $this->tmdb->getTopRatedMovies(1);

        return view('movies.index', [
            'movies' => $movies['results'] ?? [],
            'customMovies' => $customMovies,
            'topRatedMovies' => $topRatedMovies['results'] ?? [],
            'currentPage' => $movies['page'] ?? 1,
            'totalPages' => $movies['total_pages'] ?? 1,
            'type' => $type,
        ]);
    }

    public function show($id)
    {
        $movie = $this->tmdb->getMovieDetails($id);

        if (!$movie) {
            abort(404);
        }

        return view('movies.show', [
            'movie' => $movie,
        ]);
    }
}
