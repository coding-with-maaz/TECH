<?php

namespace App\Helpers;

class SchemaHelper
{
    /**
     * Generate Organization schema
     */
    public static function organization(array $data = []): array
    {
        $defaults = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $data['name'] ?? 'Tech Blog',
            'url' => $data['url'] ?? url('/'),
            'logo' => $data['logo'] ?? url('/images/logo.png'),
            'sameAs' => $data['social_links'] ?? [],
        ];

        if (isset($data['contact_point'])) {
            $defaults['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $data['contact_point']['phone'] ?? '',
                'contactType' => $data['contact_point']['type'] ?? 'customer service',
            ];
        }

        return array_merge($defaults, $data);
    }

    /**
     * Generate Website schema
     */
    public static function website(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $data['name'] ?? 'Tech Blog',
            'url' => $data['url'] ?? url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $data['search_url'] ?? url('/search?q={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ], $data);
    }

    /**
     * Generate BreadcrumbList schema
     */
    public static function breadcrumbList(array $items): array
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'] ?? '',
                'item' => $item['url'] ?? '',
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }


    /**
     * Generate CollectionPage schema
     */
    public static function collectionPage(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $data['name'] ?? '',
            'url' => $data['url'] ?? '',
            'description' => $data['description'] ?? '',
        ];
    }

    /**
     * Generate Article schema
     */
    public static function article(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['headline'] ?? $data['name'] ?? '',
            'image' => $data['image'] ?? '',
            'description' => $data['description'] ?? '',
            'url' => $data['url'] ?? '',
            'datePublished' => $data['date_published'] ?? date('c'),
            'dateModified' => $data['date_modified'] ?? date('c'),
        ];

        if (isset($data['author'])) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => is_array($data['author']) ? ($data['author']['name'] ?? '') : $data['author'],
            ];
        }

        if (isset($data['publisher'])) {
            $schema['publisher'] = [
                '@type' => 'Organization',
                'name' => is_array($data['publisher']) ? ($data['publisher']['name'] ?? '') : $data['publisher'],
            ];
        }

        if (isset($data['category'])) {
            $schema['articleSection'] = is_array($data['category']) ? ($data['category']['name'] ?? '') : $data['category'];
        }

        if (isset($data['keywords'])) {
            $schema['keywords'] = is_array($data['keywords']) ? implode(', ', $data['keywords']) : $data['keywords'];
        }

        return $schema;
    }

    /**
     * Generate BlogPosting schema
     */
    public static function blogPosting(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $data['headline'] ?? $data['name'] ?? '',
            'image' => $data['image'] ?? '',
            'description' => $data['description'] ?? '',
            'url' => $data['url'] ?? '',
            'datePublished' => $data['date_published'] ?? date('c'),
            'dateModified' => $data['date_modified'] ?? date('c'),
        ];

        if (isset($data['author'])) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => is_array($data['author']) ? ($data['author']['name'] ?? '') : $data['author'],
            ];
        }

        if (isset($data['publisher'])) {
            $schema['publisher'] = [
                '@type' => 'Organization',
                'name' => is_array($data['publisher']) ? ($data['publisher']['name'] ?? '') : $data['publisher'],
            ];
        }

        return $schema;
    }
}

