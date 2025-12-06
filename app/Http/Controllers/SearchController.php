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
        $categoryId = $request->get('category_id');
        $authorId = $request->get('author_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $articlesQuery = \App\Models\Article::published();

        // Search query
        if ($query) {
            $articlesQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            });
        }

        // Filter by category
        if ($categoryId) {
            $articlesQuery->where('category_id', $categoryId);
        }

        // Filter by author
        if ($authorId) {
            $articlesQuery->where('author_id', $authorId);
        }

        // Filter by date range
        if ($dateFrom) {
            $articlesQuery->whereDate('published_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $articlesQuery->whereDate('published_at', '<=', $dateTo);
        }

        $articles = $articlesQuery->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);
        $authors = \App\Models\User::where('is_author', true)->orWhere('role', 'author')->get();

        return view('search.index', [
            'articles' => $articles,
            'query' => $query,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'authors' => $authors,
            'selectedCategory' => $categoryId,
            'selectedAuthor' => $authorId,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'seo' => $this->seoService->forSearch($query),
        ]);
    }
}
