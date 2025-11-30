<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'page_key',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'meta_author',
        'meta_language',
        'meta_geo_region',
        'meta_geo_placename',
        'meta_geo_position_lat',
        'meta_geo_position_lon',
        'meta_revisit_after',
        'og_title',
        'og_description',
        'og_image',
        'og_url',
        'og_type',
        'og_locale',
        'og_site_name',
        'og_video_url',
        'og_video_duration',
        'og_video_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_site',
        'twitter_creator',
        'canonical_url',
        'hreflang_tags',
        'schema_markup',
        'additional_meta_tags',
        'breadcrumb_schema',
        'preconnect_domains',
        'dns_prefetch_domains',
        'enable_amp',
        'amp_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'enable_amp' => 'boolean',
        'schema_markup' => 'array',
        'breadcrumb_schema' => 'array',
        'additional_meta_tags' => 'array',
        'hreflang_tags' => 'array',
        'meta_geo_position_lat' => 'decimal:8',
        'meta_geo_position_lon' => 'decimal:8',
        'og_video_duration' => 'integer',
    ];

    /**
     * Get SEO data by page key
     */
    public static function getByPageKey($pageKey)
    {
        return static::where('page_key', $pageKey)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all available page keys by automatically detecting public routes
     */
    public static function getAvailablePageKeys()
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $publicPages = [];
        
        foreach ($routes as $route) {
            $routeName = $route->getName();
            
            // Skip admin routes and routes without names
            if (!$routeName || str_starts_with($routeName, 'admin.')) {
                continue;
            }
            
            // Skip API routes
            if (str_starts_with($routeName, 'api.')) {
                continue;
            }
            
            // Generate friendly page name from route name
            $pageName = self::generatePageName($routeName);
            $publicPages[$routeName] = $pageName;
        }
        
        // Sort by page name for better organization
        asort($publicPages);
        
        return $publicPages;
    }
    
    /**
     * Generate a friendly page name from route name
     */
    protected static function generatePageName(string $routeName): string
    {
        // Convert route name to readable format
        $name = str_replace(['.', '-', '_'], ' ', $routeName);
        $name = ucwords($name);
        
        // Special cases for better naming
        $replacements = [
            'Movies Index' => 'Movies List Page',
            'Movies Show' => 'Movie Detail Page',
            'Tv Shows Index' => 'TV Shows List Page',
            'Tv Shows Show' => 'TV Show Detail Page',
            'Cast Index' => 'Cast List Page',
            'Cast Show' => 'Cast Detail Page',
            'Dmca' => 'DMCA Page',
            'About' => 'About Us Page',
            'Completed' => 'Completed TV Shows Page',
            'Upcoming' => 'Upcoming Content Page',
            'Search' => 'Search Page',
            'Home' => 'Home Page',
        ];
        
        return $replacements[$name] ?? $name . ' Page';
    }
    
    /**
     * Get all public route names (excluding admin)
     */
    public static function getPublicRouteNames(): array
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $publicRoutes = [];
        
        foreach ($routes as $route) {
            $routeName = $route->getName();
            
            if (!$routeName || str_starts_with($routeName, 'admin.') || str_starts_with($routeName, 'api.')) {
                continue;
            }
            
            $publicRoutes[] = $routeName;
        }
        
        return $publicRoutes;
    }
}

