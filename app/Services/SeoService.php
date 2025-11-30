<?php

namespace App\Services;

use App\Models\Content;
use App\Models\Cast;
use Illuminate\Support\Facades\URL;

class SeoService
{
    /**
     * Generate Organization schema markup
     */
    public static function generateOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name', 'Nazaarabox'),
            'url' => url('/'),
            'logo' => asset('favicon.ico'),
            'description' => 'Watch and download your favorite movies and TV shows. Browse thousands of titles in high quality.',
            'sameAs' => [
                // Add social media links here if available
                // 'https://www.facebook.com/nazaarabox',
                // 'https://twitter.com/nazaarabox',
            ],
        ];
    }

    /**
     * Generate WebSite schema markup
     */
    public static function generateWebSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name', 'Nazaarabox'),
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search?q={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Generate Movie schema markup
     */
    public static function generateMovieSchema(Content $content): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Movie',
            'name' => $content->title,
            'description' => $content->description ?? '',
            'image' => $content->poster_path ? url($content->poster_path) : null,
            'datePublished' => $content->release_date ? $content->release_date->format('Y-m-d') : null,
            'url' => route('movies.show', $content->slug),
        ];

        // Add director
        if ($content->director) {
            $schema['director'] = [
                '@type' => 'Person',
                'name' => $content->director,
            ];
        }

        // Add actors
        if ($content->castMembers && $content->castMembers->count() > 0) {
            $schema['actor'] = $content->castMembers->take(10)->map(function ($cast) {
                return [
                    '@type' => 'Person',
                    'name' => $cast->name,
                    'url' => $cast->slug ? route('cast.show', $cast->slug) : null,
                ];
            })->toArray();
        }

        // Add duration
        if ($content->duration) {
            $schema['duration'] = 'PT' . $content->duration . 'M';
        }

        // Add rating
        if ($content->rating) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $content->rating,
                'bestRating' => 10,
                'worstRating' => 0,
            ];
        }

        // Add genre
        if ($content->genres && is_array($content->genres)) {
            $schema['genre'] = array_map(function ($genre) {
                return is_array($genre) ? ($genre['name'] ?? $genre) : $genre;
            }, $content->genres);
        }

        // Add country
        if ($content->country) {
            $schema['countryOfOrigin'] = [
                '@type' => 'Country',
                'name' => $content->country,
            ];
        }

        return array_filter($schema);
    }

    /**
     * Generate TVSeries schema markup
     */
    public static function generateTvSeriesSchema(Content $content): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TVSeries',
            'name' => $content->title,
            'description' => $content->description ?? '',
            'image' => $content->poster_path ? url($content->poster_path) : null,
            'datePublished' => $content->release_date ? $content->release_date->format('Y-m-d') : null,
            'url' => route('tv-shows.show', $content->slug),
        ];

        // Add number of seasons/episodes
        if ($content->episodes && $content->episodes->count() > 0) {
            $schema['numberOfEpisodes'] = $content->episodes->count();
        }

        // Add actors
        if ($content->castMembers && $content->castMembers->count() > 0) {
            $schema['actor'] = $content->castMembers->take(10)->map(function ($cast) {
                return [
                    '@type' => 'Person',
                    'name' => $cast->name,
                    'url' => $cast->slug ? route('cast.show', $cast->slug) : null,
                ];
            })->toArray();
        }

        // Add rating
        if ($content->rating) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $content->rating,
                'bestRating' => 10,
                'worstRating' => 0,
            ];
        }

        // Add genre
        if ($content->genres && is_array($content->genres)) {
            $schema['genre'] = array_map(function ($genre) {
                return is_array($genre) ? ($genre['name'] ?? $genre) : $genre;
            }, $content->genres);
        }

        // Add country
        if ($content->country) {
            $schema['countryOfOrigin'] = [
                '@type' => 'Country',
                'name' => $content->country,
            ];
        }

        return array_filter($schema);
    }

    /**
     * Generate VideoObject schema markup for movies/TV shows
     */
    public static function generateVideoObjectSchema(Content $content, string $type = 'movie'): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $content->title,
            'description' => $content->description ?? '',
            'thumbnailUrl' => $content->poster_path ? url($content->poster_path) : null,
            'uploadDate' => $content->release_date ? $content->release_date->format('Y-m-d') : null,
            'contentUrl' => route($type === 'movie' ? 'movies.show' : 'tv-shows.show', $content->slug),
        ];

        // Add duration
        if ($content->duration) {
            $schema['duration'] = 'PT' . $content->duration . 'M';
        }

        return array_filter($schema);
    }

    /**
     * Generate Person schema markup for cast
     */
    public static function generatePersonSchema(Cast $cast): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $cast->name,
            'url' => route('cast.show', $cast->slug),
        ];

        if ($cast->profile_path) {
            $schema['image'] = url($cast->profile_path);
        }

        if ($cast->bio) {
            $schema['description'] = $cast->bio;
        }

        // Add works (movies/TV shows they appeared in)
        if ($cast->contents && $cast->contents->count() > 0) {
            $schema['knowsAbout'] = $cast->contents->take(10)->map(function ($content) {
                return [
                    '@type' => $content->type === 'movie' ? 'Movie' : 'TVSeries',
                    'name' => $content->title,
                    'url' => $content->type === 'movie' 
                        ? route('movies.show', $content->slug)
                        : route('tv-shows.show', $content->slug),
                ];
            })->toArray();
        }

        return array_filter($schema);
    }

    /**
     * Generate BreadcrumbList schema markup
     */
    public static function generateBreadcrumbSchema(array $items): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        $position = 1;
        foreach ($items as $item) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return $schema;
    }

    /**
     * Generate Article schema markup for content pages
     */
    public static function generateArticleSchema(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'url' => $data['url'] ?? url()->current(),
            'datePublished' => $data['datePublished'] ?? now()->format('Y-m-d'),
            'dateModified' => $data['dateModified'] ?? now()->format('Y-m-d'),
        ];

        if (isset($data['image'])) {
            $schema['image'] = $data['image'];
        }

        if (isset($data['author'])) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $data['author'],
            ];
        }

        if (isset($data['publisher'])) {
            $schema['publisher'] = [
                '@type' => 'Organization',
                'name' => $data['publisher'],
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('favicon.ico'),
                ],
            ];
        }

        return array_filter($schema);
    }

    /**
     * Generate CollectionPage schema markup for listing pages
     */
    public static function generateCollectionPageSchema(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'url' => $data['url'] ?? url()->current(),
        ];

        if (isset($data['mainEntity'])) {
            $schema['mainEntity'] = [
                '@type' => 'ItemList',
                'numberOfItems' => $data['numberOfItems'] ?? 0,
                'itemListElement' => $data['mainEntity'] ?? [],
            ];
        }

        return array_filter($schema);
    }

    /**
     * Generate default meta tags for a page
     */
    public static function generateDefaultMetaTags(string $title, string $description, ?string $image = null): array
    {
        $url = url()->current();
        
        return [
            'meta_title' => $title,
            'meta_description' => $description,
            'og_title' => $title,
            'og_description' => $description,
            'og_image' => $image ?? asset('favicon.ico'),
            'og_url' => $url,
            'og_type' => 'website',
            'og_site_name' => config('app.name', 'Nazaarabox'),
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $image ?? asset('favicon.ico'),
            'canonical_url' => $url,
        ];
    }
}

