<?php

namespace App\Services;

use App\Helpers\SchemaHelper;
use App\Models\PageSeo;
use App\Models\Article;
use App\Models\Category;
use App\Models\Series;
use App\Models\User;

class SeoService
{
    protected $siteName;
    protected $siteUrl;
    protected $defaultImage;
    protected $twitterHandle;
    protected $facebookAppId;

    public function __construct()
    {
        $this->siteName = config('app.name', 'TechBlog');
        $this->siteUrl = config('app.url', url('/'));
        $this->defaultImage = asset('favicon.ico');
        $this->twitterHandle = '@techblog'; // Update with your Twitter handle
        $this->facebookAppId = ''; // Add your Facebook App ID if available
    }

    /**
     * Generate SEO metadata for a page
     * Checks for admin-managed PageSeo first, then uses provided data or defaults
     */
    public function generate(array $data = [], ?string $pageKey = null): array
    {
        // Check for admin-managed PageSeo first (always get fresh data)
        if ($pageKey) {
            $pageSeo = PageSeo::getByPageKey($pageKey);
            if ($pageSeo && $pageSeo->is_active) {
                // Use PageSeo data and merge with any override data from controller
                return $this->fromPageSeo($pageSeo, $data);
            }
        }

        $title = $data['title'] ?? $this->siteName;
        $description = $data['description'] ?? 'Latest technology news, tutorials, and insights. Stay updated with the latest trends in programming, web development, AI, and more.';
        $keywords = $data['keywords'] ?? 'technology, programming, web development, tutorials, tech news, coding, software development';
        $image = $data['image'] ?? $this->defaultImage;
        $url = $data['url'] ?? url()->current();
        $type = $data['type'] ?? 'website';
        $publishedTime = $data['published_time'] ?? null;
        $modifiedTime = $data['modified_time'] ?? null;
        $author = $data['author'] ?? $this->siteName;
        $schema = $data['schema'] ?? null;
        $canonical = $data['canonical'] ?? $url;
        $robots = $data['robots'] ?? 'index, follow';
        $locale = $data['locale'] ?? 'en_US';
        $alternateLocales = $data['alternate_locales'] ?? [];

        // Ensure image is absolute URL
        if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
            $image = url($image);
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'type' => $type,
            'published_time' => $publishedTime,
            'modified_time' => $modifiedTime,
            'author' => $author,
            'schema' => $schema,
            'canonical' => $canonical,
            'robots' => $robots,
            'locale' => $locale,
            'alternate_locales' => $alternateLocales,
        ];
    }

    /**
     * Generate SEO from admin-managed PageSeo model
     */
    protected function fromPageSeo(PageSeo $pageSeo, array $overrideData = []): array
    {
        // Parse schema markup if exists
        $schema = null;
        if ($pageSeo->schema_markup) {
            $decoded = json_decode($pageSeo->schema_markup, true);
            $schema = is_array($decoded) ? [$decoded] : null;
        }

        // Build data array from PageSeo - prioritize PageSeo fields
        // Use meta_title directly, fallback to og_title only if meta_title is empty
        $title = !empty($pageSeo->meta_title) 
            ? $pageSeo->meta_title 
            : ($pageSeo->og_title ?? $this->siteName);
        
        $description = !empty($pageSeo->meta_description)
            ? $pageSeo->meta_description
            : ($pageSeo->og_description ?? '');
        
        $data = [
            'title' => $title,
            'description' => $description,
            'keywords' => $pageSeo->meta_keywords ?? '',
            'image' => $pageSeo->og_image ?? $pageSeo->twitter_image ?? $this->defaultImage,
            'url' => $pageSeo->og_url ?? url()->current(),
            'type' => $pageSeo->og_type ?? 'website',
            'canonical' => $pageSeo->canonical_url ?? url()->current(),
            'robots' => $pageSeo->meta_robots ?? 'index, follow',
            'schema' => $schema,
            'alternate_locales' => $pageSeo->hreflang_tags ?? [],
        ];

        // Only merge override data for fields that are truly missing (for dynamic content)
        foreach ($overrideData as $key => $value) {
            if (!array_key_exists($key, $data) || (empty($data[$key]) && $value !== null && $value !== '')) {
                $data[$key] = $value;
            }
        }

        // Set OG and Twitter fields from PageSeo (these should always use PageSeo values if set)
        if (!empty($pageSeo->og_title)) {
            $data['og_title'] = $pageSeo->og_title;
        }
        if (!empty($pageSeo->og_description)) {
            $data['og_description'] = $pageSeo->og_description;
        }

        // Generate without checking for PageSeo again (to avoid recursion)
        $title = $data['title'] ?? $this->siteName;
        $description = $data['description'] ?? '';
        $keywords = $data['keywords'] ?? '';
        $image = $data['image'] ?? $this->defaultImage;
        $url = $data['url'] ?? url()->current();
        $type = $data['type'] ?? 'website';
        $canonical = $data['canonical'] ?? $url;
        $robots = $data['robots'] ?? 'index, follow';
        $locale = $data['locale'] ?? 'en_US';
        $alternateLocales = $data['alternate_locales'] ?? [];
        $schema = $data['schema'] ?? null;

        // Ensure image is absolute URL
        if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
            $image = url($image);
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'type' => $type,
            'canonical' => $canonical,
            'robots' => $robots,
            'locale' => $locale,
            'alternate_locales' => $alternateLocales,
            'schema' => $schema,
            // Twitter Card specific fields from PageSeo
            'twitter_card' => $pageSeo->twitter_card ?? 'summary_large_image',
            'twitter_title' => $pageSeo->twitter_title ?? $title,
            'twitter_description' => $pageSeo->twitter_description ?? $description,
            'twitter_image' => $pageSeo->twitter_image ? (filter_var($pageSeo->twitter_image, FILTER_VALIDATE_URL) ? $pageSeo->twitter_image : url($pageSeo->twitter_image)) : $image,
            // OG specific fields
            'og_title' => $pageSeo->og_title ?? $title,
            'og_description' => $pageSeo->og_description ?? $description,
            'og_image' => $pageSeo->og_image ? (filter_var($pageSeo->og_image, FILTER_VALIDATE_URL) ? $pageSeo->og_image : url($pageSeo->og_image)) : $image,
        ];
    }

    /**
     * Generate SEO for home page
     */
    public function forHome(): array
    {
        return $this->generate([
            'title' => 'TechBlog - Latest Technology News & Tutorials',
            'description' => 'Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights. Learn from expert articles and tutorials.',
            'keywords' => 'technology, programming, web development, tutorials, tech news, coding, software development, AI, machine learning',
            'type' => 'website',
            'schema' => [
                SchemaHelper::website([
                    'name' => $this->siteName,
                    'url' => $this->siteUrl,
                    'search_url' => route('search') . '?q={search_term_string}',
                ]),
                SchemaHelper::organization([
                    'name' => $this->siteName,
                    'url' => $this->siteUrl,
                ]),
            ],
        ], 'home');
    }

    /**
     * Generate SEO for articles listing page
     */
    public function forArticlesIndex(): array
    {
        return $this->generate([
            'title' => 'Articles - Browse All Tech Articles | TechBlog',
            'description' => 'Browse our complete collection of technology articles, tutorials, and guides. Learn programming, web development, and stay updated with tech trends.',
            'keywords' => 'tech articles, programming tutorials, web development guides, technology news, coding tutorials',
            'type' => 'website',
            'schema' => [
                SchemaHelper::collectionPage([
                    'name' => 'Articles',
                    'url' => route('articles.index'),
                    'description' => 'Browse our complete collection of technology articles',
                ]),
            ],
        ], 'articles.index');
    }

    /**
     * Generate SEO for an article detail page
     */
    public function forArticle(Article $article): array
    {
        $title = $article->title;
        $description = $article->excerpt ?: substr(strip_tags($article->content), 0, 160);
        $publishedDate = $article->published_at ? $article->published_at->format('Y-m-d') : $article->created_at->format('Y-m-d');
        $modifiedDate = $article->updated_at->format('Y-m-d');
        
        // Get image
        $image = $article->featured_image 
            ? (filter_var($article->featured_image, FILTER_VALIDATE_URL) ? $article->featured_image : url($article->featured_image))
            : $this->defaultImage;
        
        // Get category
        $category = $article->category ? $article->category->name : null;
        
        // Get tags
        $tags = $article->tags->pluck('name')->toArray();
        
        // Get author
        $author = $article->author ? $article->author->name : $this->siteName;

        $url = route('articles.show', $article->slug);
        $keywords = implode(', ', array_merge([$title], $tags, [$category]));

        // Generate article schema
        $articleSchema = SchemaHelper::article([
            'headline' => $title,
            'description' => $description,
            'image' => $image,
            'url' => $url,
            'date_published' => $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String(),
            'date_modified' => $article->updated_at->toIso8601String(),
            'author' => [
                'name' => $author,
            ],
            'publisher' => [
                'name' => $this->siteName,
            ],
            'category' => $category,
            'keywords' => $tags,
        ]);

        return $this->generate([
            'title' => "{$title} | TechBlog",
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'type' => 'article',
            'published_time' => $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String(),
            'modified_time' => $article->updated_at->toIso8601String(),
            'author' => $author,
            'schema' => [$articleSchema],
        ]);
    }

    /**
     * Generate SEO for categories listing page
     */
    public function forCategoriesIndex(): array
    {
        return $this->generate([
            'title' => 'Categories - Browse Tech Categories | TechBlog',
            'description' => 'Browse articles by category. Find programming tutorials, web development guides, AI articles, and more technology topics.',
            'keywords' => 'tech categories, programming categories, web development, AI, machine learning, tutorials',
            'type' => 'website',
        ], 'categories.index');
    }

    /**
     * Generate SEO for a category page
     */
    public function forCategory(Category $category): array
    {
        $title = $category->name;
        $description = $category->description ?: "Browse articles in {$title} category. Latest technology articles, tutorials, and guides.";
        
        $url = route('categories.show', $category->slug);
        $keywords = "{$title}, tech articles, programming, tutorials, technology";

        return $this->generate([
            'title' => "{$title} - Tech Articles | TechBlog",
            'description' => $description,
            'keywords' => $keywords,
            'url' => $url,
            'type' => 'website',
            'schema' => [
                SchemaHelper::collectionPage([
                    'name' => $title,
                    'url' => $url,
                    'description' => $description,
                ]),
            ],
        ]);
    }

    /**
     * Generate SEO for series listing page
     */
    public function forSeriesIndex(): array
    {
        return $this->generate([
            'title' => 'Article Series - Browse Collections | TechBlog',
            'description' => 'Browse our curated article series and collections. Explore related articles organized into comprehensive series.',
            'keywords' => 'article series, collections, tech series, programming series, tutorial series',
            'type' => 'website',
        ], 'series.index');
    }

    /**
     * Generate SEO for a series page
     */
    public function forSeries(Series $series): array
    {
        $title = $series->title;
        $description = $series->description ?: "Browse articles in the {$title} series. A curated collection of related technology articles.";
        
        $url = route('series.show', $series->slug);
        $keywords = "{$title}, article series, tech series, programming series, tutorials";
        
        $image = $series->featured_image 
            ? (filter_var($series->featured_image, FILTER_VALIDATE_URL) ? $series->featured_image : url($series->featured_image))
            : $this->defaultImage;

        return $this->generate([
            'title' => "{$title} - Article Series | TechBlog",
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'type' => 'website',
            'schema' => [
                SchemaHelper::collectionPage([
                    'name' => $title,
                    'url' => $url,
                    'description' => $description,
                ]),
            ],
        ]);
    }

    /**
     * Generate SEO for a user profile page
     */
    public function forProfile(User $user): array
    {
        $title = $user->name;
        $description = $user->bio ?: "View {$user->name}'s profile. Articles, statistics, and more.";
        
        $url = route('profile.show', $user->username ?? $user->id);
        $keywords = "{$user->name}, author profile, tech articles, {$user->name} articles";
        
        $image = $user->avatar_url ?? $this->defaultImage;

        return $this->generate([
            'title' => "{$title} - Author Profile | TechBlog",
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'type' => 'profile',
        ]);
    }

    /**
     * Generate SEO for tags listing page
     */
    public function forTagsIndex(): array
    {
        return $this->generate([
            'title' => 'Tags - Browse All Tags | TechBlog',
            'description' => 'Browse articles by tags. Find articles about specific technologies, programming languages, and topics.',
            'keywords' => 'tags, tech tags, programming tags, technology topics',
            'type' => 'website',
        ], 'tags.index');
    }

    /**
     * Generate SEO for search page
     */
    public function forSearch($query = null): array
    {
        $title = $query ? "Search Results for '{$query}' - TechBlog" : 'Search Articles - TechBlog';
        $description = $query 
            ? "Search results for '{$query}'. Find technology articles, tutorials, and guides matching your search."
            : 'Search for technology articles, tutorials, and guides. Find what you need quickly.';

        return $this->generate([
            'title' => $title,
            'description' => $description,
            'keywords' => 'search, find articles, tech search, programming search',
            'type' => 'website',
            'robots' => 'noindex, follow', // Don't index search pages
        ], 'search');
    }

    /**
     * Generate SEO for static pages
     */
    public function forPage($pageKey, $title = null, $description = null): array
    {
        $pages = [
            'about' => [
                'title' => 'About Us - TechBlog',
                'description' => 'Learn more about TechBlog. Your destination for technology news, tutorials, and insights.',
            ],
            'contact' => [
                'title' => 'Contact Us - TechBlog',
                'description' => 'Get in touch with TechBlog. We\'d love to hear from you.',
            ],
            'privacy' => [
                'title' => 'Privacy Policy - TechBlog',
                'description' => 'Privacy policy and data protection information for TechBlog.',
            ],
            'terms' => [
                'title' => 'Terms of Service - TechBlog',
                'description' => 'Terms of service and usage policy for TechBlog.',
            ],
        ];

        $pageData = $pages[$pageKey] ?? [
            'title' => $title ?? ucfirst($pageKey) . ' - TechBlog',
            'description' => $description ?? '',
        ];

        return $this->generate([
            'title' => $title ?? $pageData['title'],
            'description' => $description ?? $pageData['description'],
            'type' => 'website',
        ], $pageKey);
    }

    /**
     * Get image URL (handles custom images)
     */
    protected function getImageUrl($path): string
    {
        if (!$path) {
            return $this->defaultImage;
        }

        // If it's already a full URL, return it
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Otherwise, treat as relative URL
        return url($path);
    }

    /**
     * Get Twitter handle
     */
    public function getTwitterHandle(): string
    {
        return $this->twitterHandle;
    }

    /**
     * Get Facebook App ID
     */
    public function getFacebookAppId(): string
    {
        return $this->facebookAppId;
    }

    /**
     * Get sitemap URL
     */
    public function getSitemapUrl(): string
    {
        return route('sitemap.index');
    }

    /**
     * Get sitemap index URL
     */
    public function getSitemapIndexUrl(): string
    {
        return route('sitemap.sitemap-index');
    }

    /**
     * Automatically detect and generate SEO based on current route
     */
    public function forCurrentRoute(): array
    {
        $routeName = request()->route()?->getName();
        
        if (!$routeName) {
            return $this->forHome();
        }

        // Map route names to page keys and methods
        $routeMap = [
            'home' => ['pageKey' => 'home', 'method' => 'forHome'],
            'articles.index' => ['pageKey' => 'articles.index', 'method' => 'forArticlesIndex'],
            'categories.index' => ['pageKey' => 'categories.index', 'method' => 'forCategoriesIndex'],
            'tags.index' => ['pageKey' => 'tags.index', 'method' => 'forTagsIndex'],
            'series.index' => ['pageKey' => 'series.index', 'method' => 'forSeriesIndex'],
            'search' => ['pageKey' => 'search', 'method' => 'forSearch'],
            'about' => ['pageKey' => 'about', 'method' => 'forPage'],
            'contact' => ['pageKey' => 'contact', 'method' => 'forPage'],
            'privacy' => ['pageKey' => 'privacy', 'method' => 'forPage'],
            'terms' => ['pageKey' => 'terms', 'method' => 'forPage'],
        ];

        if (isset($routeMap[$routeName])) {
            $config = $routeMap[$routeName];
            
            // Use specific method if available
            if ($config['method'] === 'forPage') {
                return $this->forPage($config['pageKey']);
            }
            
            // Call the specific method
            if (method_exists($this, $config['method'])) {
                return $this->{$config['method']}();
            }
        }

        // Fallback: try to use page key directly
        if (str_contains($routeName, '.')) {
            $pageKey = str_replace(['articles.', 'categories.', 'tags.'], ['articles.', 'categories.', 'tags.'], $routeName);
            return $this->generate([], $pageKey);
        }

        // Final fallback
        return $this->forHome();
    }
}

