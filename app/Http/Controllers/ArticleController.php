<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;
use App\Services\SeoService;
use App\Services\DownloadTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleService;
    protected $seoService;
    protected $tokenService;

    public function __construct(ArticleService $articleService, SeoService $seoService, DownloadTokenService $tokenService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
        $this->tokenService = $tokenService;
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
    public function show(Request $request, $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->with(['category', 'author', 'tags', 'likes', 'series', 'comments' => function($query) {
                $query->approved()->with(['replies.user', 'user']);
            }])
            ->firstOrFail();
        
        // Load series articles if article belongs to a series
        $seriesArticles = null;
        $previousArticle = null;
        $nextArticle = null;
        $currentIndex = null;
        
        if ($article->series_id) {
            $seriesArticles = Article::published()
                ->where('series_id', $article->series_id)
                ->orderBy('series_order', 'asc')
                ->get(['id', 'title', 'slug', 'series_order']);
            
            $currentIndex = $seriesArticles->search(function($item) use ($article) {
                return $item->id === $article->id;
            });
            
            if ($currentIndex !== false) {
                if ($currentIndex > 0) {
                    $previousArticle = $seriesArticles[$currentIndex - 1];
                }
                if ($currentIndex < $seriesArticles->count() - 1) {
                    $nextArticle = $seriesArticles[$currentIndex + 1];
                }
            }
        }
        
        // Check if article is liked by current user/IP
        $isLiked = false;
        if (Auth::check()) {
            $isLiked = $article->isLikedBy(Auth::id());
        } else {
            $isLiked = $article->isLikedBy(null, request()->ip());
        }
        
        // Check if article is bookmarked by current user
        $isBookmarked = false;
        if (Auth::check()) {
            $isBookmarked = \App\Models\Bookmark::where('user_id', Auth::id())
                ->where('article_id', $article->id)
                ->exists();
        }

        // Increment views
        $article->incrementViews();

        $relatedArticles = $this->articleService->getRelatedArticles($article, 5);
        $featuredArticles = $this->articleService->getFeaturedArticles(5);
        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);

        // Check for download token - only show download overlay if valid token exists
        $downloadToken = $request->query('dl');
        $downloadLink = null;
        $hasValidToken = false;
        
        if ($downloadToken) {
            $downloadLink = $this->tokenService->getDownloadLink($downloadToken);
            // Only set hasValidToken if token is valid and download link was successfully decrypted
            $hasValidToken = !empty($downloadLink);
        }

        return view('articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'featuredArticles' => $featuredArticles,
            'categories' => $categories,
            'popularTags' => $popularTags,
            'isLiked' => $isLiked,
            'seriesArticles' => $seriesArticles,
            'previousArticle' => $previousArticle,
            'nextArticle' => $nextArticle,
            'currentSeriesIndex' => $currentIndex !== false ? $currentIndex + 1 : null,
            'totalSeriesArticles' => $seriesArticles ? $seriesArticles->count() : null,
            'isBookmarked' => $isBookmarked,
            'seo' => $this->seoService->forArticle($article),
            'downloadToken' => $downloadToken,
            'downloadLink' => $downloadLink,
            'hasValidToken' => $hasValidToken, // Only true if token exists and is valid
        ]);
    }
}

