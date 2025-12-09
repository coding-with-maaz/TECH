<?php

namespace App\Console\Commands;

use App\Models\PageSeo;
use Illuminate\Console\Command;

class InitializeAllPageSeo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page-seo:init-all {--force : Force update existing configurations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize default SEO configurations for all available pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        $availablePages = PageSeo::getAvailablePageKeys();
        $existingPages = PageSeo::pluck('page_key')->toArray();
        
        $this->info('🚀 Initializing SEO configurations for all pages...');
        $this->newLine();
        
        $created = 0;
        $updated = 0;
        $skipped = 0;
        
        foreach ($availablePages as $pageKey => $pageName) {
            $existing = PageSeo::where('page_key', $pageKey)->first();
            
            if ($existing) {
                if ($force) {
                    $this->updatePageSeo($existing, $pageKey, $pageName);
                    $updated++;
                    $this->line("✅ Updated: {$pageName} ({$pageKey})");
                } else {
                    $skipped++;
                    $this->line("⏭️  Skipped: {$pageName} ({$pageKey}) - already exists");
                }
            } else {
                $this->createPageSeo($pageKey, $pageName);
                $created++;
                $this->line("✨ Created: {$pageName} ({$pageKey})");
            }
        }
        
        $this->newLine();
        $this->info("📊 Summary:");
        $this->line("   Created: {$created}");
        $this->line("   Updated: {$updated}");
        $this->line("   Skipped: {$skipped}");
        $this->newLine();
        
        if ($created > 0 || $updated > 0) {
            $this->info('✅ All page SEO configurations have been processed!');
        } else {
            $this->info('ℹ️  All pages are already configured. Use --force to update existing configurations.');
        }
        
        return 0;
    }

    /**
     * Create page SEO configuration
     */
    protected function createPageSeo(string $pageKey, string $pageName)
    {
        $siteUrl = config('app.url', url('/'));
        $siteName = config('app.name', 'Nazaaracircle');
        $defaults = $this->getDefaultsForPage($pageKey, $pageName, $siteUrl, $siteName);
        
        PageSeo::create($defaults);
    }

    /**
     * Update existing page SEO configuration
     */
    protected function updatePageSeo(PageSeo $pageSeo, string $pageKey, string $pageName)
    {
        $siteUrl = config('app.url', url('/'));
        $siteName = config('app.name', 'Nazaaracircle');
        $defaults = $this->getDefaultsForPage($pageKey, $pageName, $siteUrl, $siteName);
        
        // Update all fields with new defaults (force update)
        foreach ($defaults as $key => $value) {
            if ($key === 'page_key' || $key === 'is_active') {
                continue; // Skip these fields
            }
            
            // Always update URL-related fields to ensure they use the correct domain
            if (in_array($key, ['canonical_url', 'og_url']) || !empty($value)) {
                $pageSeo->$key = $value;
            }
        }
        
        $pageSeo->save();
    }

    /**
     * Get default SEO values for a specific page
     */
    protected function getDefaultsForPage(string $pageKey, string $pageName, string $siteUrl, string $siteName): array
    {
        $baseDefaults = [
            'page_key' => $pageKey,
            'page_name' => $pageName,
            'meta_robots' => 'index, follow',
            'og_type' => 'website',
            'twitter_card' => 'summary_large_image',
            'canonical_url' => $siteUrl . $this->getPagePath($pageKey),
            'is_active' => true,
        ];

        $pageSpecificDefaults = [
            'home' => [
                'meta_title' => "{$siteName} - Latest Technology News & Tutorials",
                'meta_description' => 'Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights. Learn from expert articles and tutorials.',
                'meta_keywords' => 'technology, programming, web development, tutorials, tech news, coding, software development, AI, machine learning',
                'og_title' => "{$siteName} - Latest Technology News & Tutorials",
                'og_description' => 'Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights.',
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl,
                'twitter_title' => "{$siteName} - Latest Technology News & Tutorials",
                'twitter_description' => 'Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights.',
                'twitter_image' => asset('icon.png'),
                'schema_markup' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebSite',
                    'name' => $siteName,
                    'url' => $siteUrl,
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => [
                            '@type' => 'EntryPoint',
                            'urlTemplate' => $siteUrl . '/search?q={search_term_string}'
                        ],
                        'query-input' => 'required name=search_term_string'
                    ]
                ], JSON_PRETTY_PRINT),
            ],
            'articles.index' => [
                'meta_title' => "Articles - Browse All Tech Articles | {$siteName}",
                'meta_description' => 'Browse our complete collection of technology articles, tutorials, and guides. Learn programming, web development, and stay updated with tech trends.',
                'meta_keywords' => 'tech articles, programming tutorials, web development guides, technology news, coding tutorials',
                'og_title' => "Articles - Browse All Tech Articles | {$siteName}",
                'og_description' => 'Browse our complete collection of technology articles, tutorials, and guides.',
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/articles',
                'twitter_title' => "Articles - Browse All Tech Articles | {$siteName}",
                'twitter_description' => 'Browse our complete collection of technology articles, tutorials, and guides.',
                'twitter_image' => asset('icon.png'),
            ],
            'categories.index' => [
                'meta_title' => "Categories - Browse Tech Categories | {$siteName}",
                'meta_description' => 'Browse articles by category. Find programming tutorials, web development guides, AI articles, and more technology topics.',
                'meta_keywords' => 'tech categories, programming categories, web development, AI, machine learning, tutorials',
                'og_title' => "Categories - Browse Tech Categories | {$siteName}",
                'og_description' => 'Browse articles by category. Find programming tutorials, web development guides, AI articles, and more.',
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/categories',
                'twitter_title' => "Categories - Browse Tech Categories | {$siteName}",
                'twitter_description' => 'Browse articles by category. Find programming tutorials, web development guides, AI articles, and more.',
                'twitter_image' => asset('icon.png'),
            ],
            'tags.index' => [
                'meta_title' => "Tags - Browse All Tags | {$siteName}",
                'meta_description' => 'Browse articles by tags. Find articles about specific technologies, programming languages, and topics.',
                'meta_keywords' => 'tags, tech tags, programming tags, technology topics',
                'og_title' => "Tags - Browse All Tags | {$siteName}",
                'og_description' => 'Browse articles by tags. Find articles about specific technologies, programming languages, and topics.',
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/tags',
                'twitter_title' => "Tags - Browse All Tags | {$siteName}",
                'twitter_description' => 'Browse articles by tags. Find articles about specific technologies, programming languages, and topics.',
                'twitter_image' => asset('icon.png'),
            ],
            'search' => [
                'meta_title' => "Search Articles | {$siteName}",
                'meta_description' => 'Search for technology articles, tutorials, and guides. Find exactly what you\'re looking for with our powerful search feature.',
                'meta_keywords' => 'search articles, search tutorials, find tech articles, article search',
                'og_title' => "Search Articles | {$siteName}",
                'og_description' => 'Search for technology articles, tutorials, and guides. Find exactly what you\'re looking for.',
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/search',
                'twitter_title' => "Search Articles | {$siteName}",
                'twitter_description' => 'Search for technology articles, tutorials, and guides. Find exactly what you\'re looking for.',
                'twitter_image' => asset('icon.png'),
                'meta_robots' => 'noindex, follow',
            ],
            'about' => [
                'meta_title' => "About Us | {$siteName}",
                'meta_description' => "Learn more about {$siteName}. Your destination for technology news, tutorials, and insights.",
                'meta_keywords' => 'about us, company information, mission, values, Nazaaracircle',
                'og_title' => "About Us | {$siteName}",
                'og_description' => "Learn more about {$siteName}. Your destination for technology news, tutorials, and insights.",
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/about',
                'twitter_title' => "About Us | {$siteName}",
                'twitter_description' => "Learn more about {$siteName}. Your destination for technology news, tutorials, and insights.",
                'twitter_image' => asset('icon.png'),
            ],
            'contact' => [
                'meta_title' => "Contact Us | {$siteName}",
                'meta_description' => "Get in touch with {$siteName}. We'd love to hear from you. Send us your questions, feedback, or suggestions.",
                'meta_keywords' => 'contact, contact us, get in touch, support, feedback',
                'og_title' => "Contact Us | {$siteName}",
                'og_description' => "Get in touch with {$siteName}. We'd love to hear from you.",
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/contact',
                'twitter_title' => "Contact Us | {$siteName}",
                'twitter_description' => "Get in touch with {$siteName}. We'd love to hear from you.",
                'twitter_image' => asset('icon.png'),
            ],
            'privacy' => [
                'meta_title' => "Privacy Policy | {$siteName}",
                'meta_description' => "Read our privacy policy to understand how we collect, use, and protect your personal information.",
                'meta_keywords' => 'privacy policy, data protection, privacy, personal information',
                'og_title' => "Privacy Policy | {$siteName}",
                'og_description' => "Read our privacy policy to understand how we collect, use, and protect your personal information.",
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/privacy',
                'twitter_title' => "Privacy Policy | {$siteName}",
                'twitter_description' => "Read our privacy policy to understand how we collect, use, and protect your personal information.",
                'twitter_image' => asset('icon.png'),
                'meta_robots' => 'noindex, follow',
            ],
            'terms' => [
                'meta_title' => "Terms of Service | {$siteName}",
                'meta_description' => "Read our terms of service to understand the rules and guidelines for using our website.",
                'meta_keywords' => 'terms of service, terms and conditions, usage policy, terms',
                'og_title' => "Terms of Service | {$siteName}",
                'og_description' => "Read our terms of service to understand the rules and guidelines for using our website.",
                'og_image' => asset('icon.png'),
                'og_url' => $siteUrl . '/terms',
                'twitter_title' => "Terms of Service | {$siteName}",
                'twitter_description' => "Read our terms of service to understand the rules and guidelines for using our website.",
                'twitter_image' => asset('icon.png'),
                'meta_robots' => 'noindex, follow',
            ],
        ];

        return array_merge(
            $baseDefaults,
            $pageSpecificDefaults[$pageKey] ?? []
        );
    }

    /**
     * Get the URL path for a page key
     */
    protected function getPagePath(string $pageKey): string
    {
        $paths = [
            'home' => '/',
            'articles.index' => '/articles',
            'categories.index' => '/categories',
            'tags.index' => '/tags',
            'search' => '/search',
            'about' => '/about',
            'contact' => '/contact',
            'privacy' => '/privacy',
            'terms' => '/terms',
        ];

        return $paths[$pageKey] ?? '/';
    }
}

