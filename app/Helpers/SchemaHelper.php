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
            'name' => $data['name'] ?? 'Nazaara Circle',
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
            'name' => $data['name'] ?? 'Nazaara Circle',
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

    /**
     * Generate FAQPage schema
     */
    public static function faqPage(array $data): array
    {
        $faqItems = [];
        foreach ($data['faqs'] ?? [] as $faq) {
            $faqItems[] = [
                '@type' => 'Question',
                'name' => $faq['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'] ?? '',
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems,
        ];
    }

    /**
     * Generate Review/Rating schema
     */
    public static function review(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Review',
            'itemReviewed' => [
                '@type' => $data['item_type'] ?? 'Article',
                'name' => $data['item_name'] ?? '',
                'url' => $data['item_url'] ?? '',
            ],
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => $data['rating'] ?? 5,
                'bestRating' => $data['best_rating'] ?? 5,
                'worstRating' => $data['worst_rating'] ?? 1,
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $data['author_name'] ?? 'Anonymous',
            ],
        ];

        if (isset($data['review_body'])) {
            $schema['reviewBody'] = $data['review_body'];
        }

        if (isset($data['date_published'])) {
            $schema['datePublished'] = $data['date_published'];
        }

        return $schema;
    }

    /**
     * Generate AggregateRating schema
     */
    public static function aggregateRating(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'AggregateRating',
            'ratingValue' => $data['rating_value'] ?? 0,
            'bestRating' => $data['best_rating'] ?? 5,
            'worstRating' => $data['worst_rating'] ?? 1,
            'ratingCount' => $data['rating_count'] ?? 0,
            'reviewCount' => $data['review_count'] ?? 0,
        ];
    }

    /**
     * Generate Person schema
     */
    public static function person(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $data['name'] ?? '',
        ];

        if (isset($data['url'])) {
            $schema['url'] = $data['url'];
        }

        if (isset($data['image'])) {
            $schema['image'] = $data['image'];
        }

        if (isset($data['description'])) {
            $schema['description'] = $data['description'];
        }

        if (isset($data['same_as']) && is_array($data['same_as'])) {
            $schema['sameAs'] = $data['same_as'];
        }

        if (isset($data['job_title'])) {
            $schema['jobTitle'] = $data['job_title'];
        }

        return $schema;
    }

    /**
     * Generate LocalBusiness schema (for Local SEO)
     */
    public static function localBusiness(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $data['name'] ?? '',
            'url' => $data['url'] ?? url('/'),
        ];

        if (isset($data['address'])) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $data['address']['street'] ?? '',
                'addressLocality' => $data['address']['city'] ?? '',
                'addressRegion' => $data['address']['region'] ?? '',
                'postalCode' => $data['address']['postal_code'] ?? '',
                'addressCountry' => $data['address']['country'] ?? '',
            ];
        }

        if (isset($data['phone'])) {
            $schema['telephone'] = $data['phone'];
        }

        if (isset($data['price_range'])) {
            $schema['priceRange'] = $data['price_range'];
        }

        return $schema;
    }
}

