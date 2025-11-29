<?php

namespace App\View\Composers;

use App\Models\SeoPage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class SeoComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Determine the page key based on the current route
        $pageKey = $this->determinePageKey();
        
        if ($pageKey) {
            $seoPage = SeoPage::getByPageKey($pageKey);
            $view->with('seoPage', $seoPage);
        } else {
            $view->with('seoPage', null);
        }
    }

    /**
     * Determine the page key based on the current route
     */
    protected function determinePageKey(): ?string
    {
        $routeName = Route::currentRouteName();
        
        if (!$routeName) {
            return null;
        }

        // Skip admin routes - no SEO needed for admin pages
        if (str_starts_with($routeName, 'admin.')) {
            return null;
        }

        // Map route names to page keys (only public routes)
        $routeToPageKey = [
            'home' => 'home',
            'movies.index' => 'movies.index',
            'movies.show' => 'movies.show',
            'tv-shows.index' => 'tv-shows.index',
            'tv-shows.show' => 'tv-shows.show',
            'cast.index' => 'cast.index',
            'cast.show' => 'cast.show',
            'search' => 'search',
            'dmca' => 'dmca',
            'about' => 'about',
            'completed' => 'completed',
            'upcoming' => 'upcoming',
        ];

        return $routeToPageKey[$routeName] ?? null;
    }
}

