<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;
    protected $seoService;

    public function __construct(ArticleService $articleService, SeoService $seoService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of articles
     */
    public function index(Request $request)
    {
        $perPage = 15;
        $articles = Article::published()
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $featuredArticles = $this->articleService->getFeaturedArticles(5);
        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);

        return view('articles.index', [
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'seo' => $this->seoService->forArticlesIndex(),
        ]);
    }

    /**
     * Display the specified article
     */
    public function show($slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->with(['category', 'author', 'tags', 'comments' => function($query) {
                $query->approved()->with('replies');
            }])
            ->firstOrFail();

        // Increment views
        $article->incrementViews();

        $relatedArticles = $this->articleService->getRelatedArticles($article, 5);
        $featuredArticles = $this->articleService->getFeaturedArticles(5);
        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);

        return view('articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'featuredArticles' => $featuredArticles,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'seo' => $this->seoService->forArticle($article),
        ]);
    }
}

