<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $articleService;
    protected $seoService;

    public function __construct(ArticleService $articleService, SeoService $seoService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return view('search.index', [
                'articles' => collect([]),
                'query' => '',
                'categories' => $this->articleService->getCategoriesWithCounts(),
                'popularTags' => $this->articleService->getPopularTags(10),
                'seo' => $this->seoService->forSearch(),
            ]);
        }

        $articles = $this->articleService->searchArticles($query, 15);
        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);

        return view('search.index', [
            'articles' => $articles,
            'query' => $query,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'seo' => $this->seoService->forSearch($query),
        ]);
    }
}
