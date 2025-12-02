<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Services\ArticleService;
use App\Services\SeoService;

class SeriesController extends Controller
{
    protected $articleService;
    protected $seoService;

    public function __construct(ArticleService $articleService, SeoService $seoService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of series
     */
    public function index()
    {
        $series = Series::where('is_active', true)
            ->withCount('articles')
            ->orderBy('sort_order', 'asc')
            ->orderBy('title', 'asc')
            ->get();

        return view('series.index', [
            'series' => $series,
            'seo' => $this->seoService->forSeriesIndex(),
        ]);
    }

    /**
     * Display articles in a specific series
     */
    public function show($slug)
    {
        $series = Series::where('slug', $slug)
            ->where('is_active', true)
            ->with(['articles' => function($query) {
                $query->published()->orderBy('series_order', 'asc');
            }, 'author'])
            ->firstOrFail();

        return view('series.show', [
            'series' => $series,
            'seo' => $this->seoService->forSeries($series),
        ]);
    }
}
