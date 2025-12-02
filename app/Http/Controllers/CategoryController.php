<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ArticleService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $articleService;
    protected $seoService;

    public function __construct(ArticleService $articleService, SeoService $seoService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['articles' => function($query) {
                $query->published();
            }])
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
            'seo' => $this->seoService->forCategoriesIndex(),
        ]);
    }

    /**
     * Display articles in a specific category
     */
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $perPage = 15;
        $articles = $this->articleService->getArticlesByCategory($category, $perPage);
        $articles->appends($request->query());

        $featuredArticles = $this->articleService->getFeaturedArticles(5);
        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);

        return view('categories.show', [
            'category' => $category,
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'seo' => $this->seoService->forCategory($category),
        ]);
    }
}

