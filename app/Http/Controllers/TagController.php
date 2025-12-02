<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\ArticleService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $articleService;
    protected $seoService;

    public function __construct(ArticleService $articleService, SeoService $seoService)
    {
        $this->articleService = $articleService;
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of tags
     */
    public function index()
    {
        $tags = Tag::withCount('articles')
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(30);

        return view('tags.index', [
            'tags' => $tags,
            'seo' => $this->seoService->forTagsIndex(),
        ]);
    }

    /**
     * Display articles with a specific tag
     */
    public function show($slug, Request $request)
    {
        $tag = Tag::where('slug', $slug)
            ->firstOrFail();

        $perPage = 15;
        $articles = $this->articleService->getArticlesByTag($tag, $perPage);
        $articles->appends($request->query());

        $featuredArticles = $this->articleService->getFeaturedArticles(5);
        $categories = $this->articleService->getCategoriesWithCounts();
        $popularTags = $this->articleService->getPopularTags(10);

        return view('tags.show', [
            'tag' => $tag,
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'categories' => $categories,
            'popularTags' => $popularTags,
        ]);
    }
}

