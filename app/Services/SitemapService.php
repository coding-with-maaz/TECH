<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapService
{
    protected $siteUrl;
    protected $cacheDuration;

    public function __construct()
    {
        $this->siteUrl = rtrim(config('app.url', url('/')), '/');
        $this->cacheDuration = config('sitemap.cache_duration', 3600); // 1 hour default
    }

    /**
     * Get all sitemap URLs organized by type
     */
    public function getAllUrls(): array
    {
        return Cache::remember('sitemap_all_urls', $this->cacheDuration, function () {
            return [
                'static' => $this->getStaticPages(),
                'articles' => $this->getArticlesUrls(),
                'categories' => $this->getCategoriesUrls(),
                'tags' => $this->getTagsUrls(),
            ];
        });
    }

    /**
     * Get static pages (home, about, dmca, etc.)
     */
    public function getStaticPages(): array
    {
        $pages = [
            [
                'loc' => route('home'),
                'lastmod' => $this->getSiteLastModified(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('articles.index'),
                'lastmod' => $this->getArticlesLastModified(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('categories.index'),
                'lastmod' => $this->getCategoriesLastModified(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('series.index'),
                'lastmod' => $this->getSiteLastModified(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('tags.index'),
                'lastmod' => $this->getTagsLastModified(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('about'),
                'lastmod' => $this->getSiteLastModified(),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('contact'),
                'lastmod' => $this->getSiteLastModified(),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('privacy'),
                'lastmod' => $this->getSiteLastModified(),
                'changefreq' => 'yearly',
                'priority' => '0.3',
            ],
            [
                'loc' => route('terms'),
                'lastmod' => $this->getSiteLastModified(),
                'changefreq' => 'yearly',
                'priority' => '0.3',
            ],
        ];

        return $pages;
    }

    /**
     * Get all article URLs
     */
    public function getArticlesUrls(): array
    {
        $articles = Article::published()
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        $urls = [];
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => route('articles.show', $article->slug),
                'lastmod' => $this->formatDate($article->updated_at),
                'changefreq' => $this->getArticleChangeFreq($article),
                'priority' => $this->getArticlePriority($article),
            ];
        }

        return $urls;
    }

    /**
     * Get all category URLs
     */
    public function getCategoriesUrls(): array
    {
        $categories = Category::where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        $urls = [];
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('categories.show', $category->slug),
                'lastmod' => $this->formatDate($category->updated_at),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        return $urls;
    }

    /**
     * Get all tag URLs
     */
    public function getTagsUrls(): array
    {
        $tags = Tag::whereNotNull('slug')
            ->has('articles')
            ->orderBy('updated_at', 'desc')
            ->get();

        $urls = [];
        foreach ($tags as $tag) {
            $urls[] = [
                'loc' => route('tags.show', $tag->slug),
                'lastmod' => $this->formatDate($tag->updated_at),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        return $urls;
    }

    /**
     * Get sitemap index (for multiple sitemaps)
     */
    public function getSitemapIndex(): array
    {
        return [
            [
                'loc' => route('sitemap.static'),
                'lastmod' => $this->getSiteLastModified(),
            ],
            [
                'loc' => route('sitemap.articles'),
                'lastmod' => $this->getArticlesLastModified(),
            ],
            [
                'loc' => route('sitemap.categories'),
                'lastmod' => $this->getCategoriesLastModified(),
            ],
            [
                'loc' => route('sitemap.tags'),
                'lastmod' => $this->getTagsLastModified(),
            ],
        ];
    }

    /**
     * Get single sitemap by type
     */
    public function getSitemapByType(string $type): array
    {
        return match ($type) {
            'static' => $this->getStaticPages(),
            'articles' => $this->getArticlesUrls(),
            'categories' => $this->getCategoriesUrls(),
            'tags' => $this->getTagsUrls(),
            default => [],
        };
    }

    /**
     * Get all URLs in a single array (for main sitemap)
     */
    public function getAllUrlsFlat(): array
    {
        $all = $this->getAllUrls();
        return array_merge(
            $all['static'],
            $all['articles'],
            $all['categories'],
            $all['tags']
        );
    }

    /**
     * Get article change frequency based on article attributes
     */
    protected function getArticleChangeFreq(Article $article): string
    {
        // Featured articles change more frequently
        if ($article->is_featured) {
            return 'daily';
        }

        // Recent articles change more frequently
        if ($article->published_at && $article->published_at->gt(now()->subMonths(3))) {
            return 'weekly';
        }

        return 'monthly';
    }

    /**
     * Get article priority based on article attributes
     */
    protected function getArticlePriority(Article $article): string
    {
        // Featured articles have higher priority
        if ($article->is_featured) {
            return '0.9';
        }

        // Popular articles (high views) have higher priority
        if ($article->views > 1000) {
            return '0.8';
        }

        // Recent articles have higher priority
        if ($article->published_at && $article->published_at->gt(now()->subMonths(6))) {
            return '0.7';
        }

        return '0.6';
    }

    /**
     * Format date for sitemap (W3C format)
     */
    protected function formatDate($date): string
    {
        if (!$date) {
            return Carbon::now()->toW3cString();
        }

        return Carbon::parse($date)->toW3cString();
    }

    /**
     * Get site last modified date
     */
    protected function getSiteLastModified(): string
    {
        return Carbon::now()->toW3cString();
    }

    /**
     * Get articles last modified date
     */
    protected function getArticlesLastModified(): string
    {
        $latest = Article::published()
            ->orderBy('updated_at', 'desc')
            ->first();
        
        return $latest ? $this->formatDate($latest->updated_at) : $this->getSiteLastModified();
    }

    /**
     * Get categories last modified date
     */
    protected function getCategoriesLastModified(): string
    {
        $latest = Category::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->first();
        
        return $latest ? $this->formatDate($latest->updated_at) : $this->getSiteLastModified();
    }

    /**
     * Get tags last modified date
     */
    protected function getTagsLastModified(): string
    {
        $latest = Tag::has('articles')
            ->orderBy('updated_at', 'desc')
            ->first();
        
        return $latest ? $this->formatDate($latest->updated_at) : $this->getSiteLastModified();
    }

    /**
     * Clear sitemap cache
     */
    public function clearCache(): void
    {
        Cache::forget('sitemap_all_urls');
    }
}

