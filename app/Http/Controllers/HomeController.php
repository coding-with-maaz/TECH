<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $articleService;
    protected $seoService;

    public function __construct(ArticleService $articleService, SeoService $seoService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        // Verify view exists before processing data (helps with production debugging)
        if (!view()->exists('home')) {
            \Log::error('Home view not found', [
                'view_paths' => view()->getFinder()->getPaths(),
                'expected_path' => resource_path('views/home.blade.php'),
                'file_exists' => file_exists(resource_path('views/home.blade.php')),
            ]);
            
            abort(500, 'Home view not found. Please run: php artisan views:check home');
        }
        
        $perPage = 12;
        
        // Get latest articles
        $articles = Article::published()
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Get featured articles
        $featuredArticles = $this->articleService->getFeaturedArticles(5);
        
        // Get popular articles
        $popularArticles = $this->articleService->getPopularArticles(5);
        
        // Get categories
        $categories = $this->articleService->getCategoriesWithCounts();
        
        // Get popular tags
        $popularTags = $this->articleService->getPopularTags(10);

        return view('home', [
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'popularArticles' => $popularArticles,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'seo' => $this->seoService->forHome(),
        ]);
    }
}
