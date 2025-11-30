<?php

namespace App\View\Composers;

use App\Models\SeoPage;
use App\Models\Content;
use App\Models\Cast;
use App\Services\SeoService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class SeoComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Skip admin routes - no SEO needed for admin pages
        $routeName = Route::currentRouteName();
        if (!$routeName || str_starts_with($routeName, 'admin.')) {
            $view->with('seoPage', null);
            $view->with('dynamicSchema', []);
            return;
        }

        // Get base SEO page data
        $seoPage = SeoPage::getByPageKey($routeName);
        
        // Handle dynamic content pages (movies.show, tv-shows.show, cast.show)
        $dynamicSchema = $this->generateDynamicSchema($view, $routeName, $seoPage);
        
        // Enhance SEO page with dynamic data if available, or create default SEO
        if ($seoPage && !empty($dynamicSchema)) {
            $seoPage = $this->enhanceSeoPageWithDynamicData($seoPage, $view, $routeName);
        } elseif (!$seoPage) {
            // Generate default SEO for pages without configured SEO
            $seoPage = $this->generateDefaultSeo($view, $routeName);
        }
        
        $view->with('seoPage', $seoPage);
        $view->with('dynamicSchema', $dynamicSchema);
    }

    /**
     * Generate dynamic schema markup based on page content
     */
    protected function generateDynamicSchema(View $view, string $routeName, ?SeoPage $seoPage): array
    {
        $schemas = [];
        
        // Always add Organization and WebSite schemas
        $schemas[] = SeoService::generateOrganizationSchema();
        $schemas[] = SeoService::generateWebSiteSchema();
        
        // Generate content-specific schemas
        $viewData = $view->getData();
        
        // Movie detail page
        if ($routeName === 'movies.show' && isset($viewData['content']) && $viewData['content'] instanceof Content) {
            $content = $viewData['content'];
            $schemas[] = SeoService::generateMovieSchema($content);
            $schemas[] = SeoService::generateVideoObjectSchema($content, 'movie');
            
            // Generate breadcrumb
            $breadcrumbs = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'Movies', 'url' => route('movies.index')],
                ['name' => $content->title, 'url' => route('movies.show', $content->slug)],
            ];
            $schemas[] = SeoService::generateBreadcrumbSchema($breadcrumbs);
        }
        
        // TV Show detail page
        if ($routeName === 'tv-shows.show' && isset($viewData['content']) && $viewData['content'] instanceof Content) {
            $content = $viewData['content'];
            $schemas[] = SeoService::generateTvSeriesSchema($content);
            $schemas[] = SeoService::generateVideoObjectSchema($content, 'tv');
            
            // Generate breadcrumb
            $breadcrumbs = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'TV Shows', 'url' => route('tv-shows.index')],
                ['name' => $content->title, 'url' => route('tv-shows.show', $content->slug)],
            ];
            $schemas[] = SeoService::generateBreadcrumbSchema($breadcrumbs);
        }
        
        // Cast detail page
        if ($routeName === 'cast.show' && isset($viewData['cast']) && $viewData['cast'] instanceof Cast) {
            $cast = $viewData['cast'];
            $schemas[] = SeoService::generatePersonSchema($cast);
            
            // Generate breadcrumb
            $breadcrumbs = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'Cast', 'url' => route('cast.index')],
                ['name' => $cast->name, 'url' => route('cast.show', $cast->slug)],
            ];
            $schemas[] = SeoService::generateBreadcrumbSchema($breadcrumbs);
        }
        
        // Listing pages breadcrumbs
        if (in_array($routeName, ['movies.index', 'tv-shows.index', 'cast.index'])) {
            $pageNames = [
                'movies.index' => 'Movies',
                'tv-shows.index' => 'TV Shows',
                'cast.index' => 'Cast',
            ];
            $breadcrumbs = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => $pageNames[$routeName] ?? '', 'url' => url()->current()],
            ];
            $schemas[] = SeoService::generateBreadcrumbSchema($breadcrumbs);
        }
        
        // Home page breadcrumb
        if ($routeName === 'home') {
            $breadcrumbs = [
                ['name' => 'Home', 'url' => route('home')],
            ];
            $schemas[] = SeoService::generateBreadcrumbSchema($breadcrumbs);
        }
        
        return $schemas;
    }

    /**
     * Enhance SEO page with dynamic data from content
     */
    protected function enhanceSeoPageWithDynamicData(SeoPage $seoPage, View $view, string $routeName): SeoPage
    {
        $viewData = $view->getData();
        
        // For dynamic content pages, enhance meta tags if not set
        if ($routeName === 'movies.show' && isset($viewData['content']) && $viewData['content'] instanceof Content) {
            $content = $viewData['content'];
            
            if (!$seoPage->meta_title) {
                $seoPage->meta_title = $content->title . ' - Watch Online | ' . config('app.name');
            }
            if (!$seoPage->meta_description) {
                $seoPage->meta_description = $content->description ?? substr($content->title . ' - Watch and download in high quality.', 0, 160);
            }
            if (!$seoPage->og_image && $content->poster_path) {
                $seoPage->og_image = url($content->poster_path);
            }
            if (!$seoPage->og_type) {
                $seoPage->og_type = 'video.movie';
            }
        }
        
        if ($routeName === 'tv-shows.show' && isset($viewData['content']) && $viewData['content'] instanceof Content) {
            $content = $viewData['content'];
            
            if (!$seoPage->meta_title) {
                $seoPage->meta_title = $content->title . ' - Watch Online | ' . config('app.name');
            }
            if (!$seoPage->meta_description) {
                $seoPage->meta_description = $content->description ?? substr($content->title . ' - Watch all episodes in high quality.', 0, 160);
            }
            if (!$seoPage->og_image && $content->poster_path) {
                $seoPage->og_image = url($content->poster_path);
            }
            if (!$seoPage->og_type) {
                $seoPage->og_type = 'video.tv_show';
            }
        }
        
        if ($routeName === 'cast.show' && isset($viewData['cast']) && $viewData['cast'] instanceof Cast) {
            $cast = $viewData['cast'];
            
            if (!$seoPage->meta_title) {
                $seoPage->meta_title = $cast->name . ' - Biography & Filmography | ' . config('app.name');
            }
            if (!$seoPage->meta_description) {
                $seoPage->meta_description = $cast->bio ?? substr($cast->name . ' - Explore all movies and TV shows.', 0, 160);
            }
            if (!$seoPage->og_image && $cast->profile_path) {
                $seoPage->og_image = url($cast->profile_path);
            }
            if (!$seoPage->og_type) {
                $seoPage->og_type = 'profile';
            }
        }
        
        return $seoPage;
    }

    /**
     * Generate default SEO data for pages without configured SEO
     */
    protected function generateDefaultSeo(View $view, string $routeName): ?object
    {
        $viewData = $view->getData();
        $defaultSeo = new \stdClass();
        
        // Set default values based on route
        $defaults = [
            'home' => [
                'meta_title' => config('app.name', 'Nazaarabox') . ' - Watch Movies & TV Shows Online',
                'meta_description' => 'Watch and download your favorite movies and TV shows. Browse thousands of titles in high quality.',
            ],
            'movies.index' => [
                'meta_title' => 'Movies - Watch Online | ' . config('app.name', 'Nazaarabox'),
                'meta_description' => 'Browse our collection of movies. Watch and download in high quality.',
            ],
            'tv-shows.index' => [
                'meta_title' => 'TV Shows - Watch Online | ' . config('app.name', 'Nazaarabox'),
                'meta_description' => 'Browse our collection of TV shows. Watch all episodes in high quality.',
            ],
            'cast.index' => [
                'meta_title' => 'Cast & Actors - ' . config('app.name', 'Nazaarabox'),
                'meta_description' => 'Explore cast members and actors. Find all their movies and TV shows.',
            ],
        ];
        
        if (isset($defaults[$routeName])) {
            foreach ($defaults[$routeName] as $key => $value) {
                $defaultSeo->$key = $value;
            }
        }
        
        // For dynamic content pages, generate from content
        if ($routeName === 'movies.show' && isset($viewData['content']) && $viewData['content'] instanceof Content) {
            $content = $viewData['content'];
            $defaultSeo->meta_title = $content->title . ' - Watch Online | ' . config('app.name', 'Nazaarabox');
            $defaultSeo->meta_description = $content->description ?? substr($content->title . ' - Watch and download in high quality.', 0, 160);
            $defaultSeo->og_image = $content->poster_path ? url($content->poster_path) : null;
            $defaultSeo->og_type = 'video.movie';
        }
        
        if ($routeName === 'tv-shows.show' && isset($viewData['content']) && $viewData['content'] instanceof Content) {
            $content = $viewData['content'];
            $defaultSeo->meta_title = $content->title . ' - Watch Online | ' . config('app.name', 'Nazaarabox');
            $defaultSeo->meta_description = $content->description ?? substr($content->title . ' - Watch all episodes in high quality.', 0, 160);
            $defaultSeo->og_image = $content->poster_path ? url($content->poster_path) : null;
            $defaultSeo->og_type = 'video.tv_show';
        }
        
        if ($routeName === 'cast.show' && isset($viewData['cast']) && $viewData['cast'] instanceof Cast) {
            $cast = $viewData['cast'];
            $defaultSeo->meta_title = $cast->name . ' - Biography & Filmography | ' . config('app.name', 'Nazaarabox');
            $defaultSeo->meta_description = $cast->bio ?? substr($cast->name . ' - Explore all movies and TV shows.', 0, 160);
            $defaultSeo->og_image = $cast->profile_path ? url($cast->profile_path) : null;
            $defaultSeo->og_type = 'profile';
        }
        
        // Set common defaults
        $defaultSeo->og_url = url()->current();
        $defaultSeo->og_site_name = config('app.name', 'Nazaarabox');
        $defaultSeo->canonical_url = url()->current();
        $defaultSeo->twitter_card = 'summary_large_image';
        
        return $defaultSeo;
    }
}

