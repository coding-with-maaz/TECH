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
        'og_title',
        'og_description',
        'og_image',
        'og_url',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'canonical_url',
        'schema_markup',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'schema_markup' => 'array',
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
     * Get all available page keys
     */
    public static function getAvailablePageKeys()
    {
        return [
            'home' => 'Home Page',
            'movies.index' => 'Movies List Page',
            'movies.show' => 'Movie Detail Page',
            'tv-shows.index' => 'TV Shows List Page',
            'tv-shows.show' => 'TV Show Detail Page',
            'cast.index' => 'Cast List Page',
            'cast.show' => 'Cast Detail Page',
            'search' => 'Search Page',
            'dmca' => 'DMCA Page',
            'about' => 'About Us Page',
            'completed' => 'Completed TV Shows Page',
            'upcoming' => 'Upcoming Page',
        ];
    }
}

