<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    /**
     * Generate robots.txt dynamically
     */
    public function index(): Response
    {
        // Use current request URL to work in both local and production
        // Use url() helper which automatically respects the current request including port
        $siteUrl = rtrim(url('/'), '/');
        $siteName = config('app.name', 'Nazaaracircle');
        
        $content = "# ============================================\n";
        $content .= "# Robots.txt for {$siteName}\n";
        $content .= "# Generated dynamically at " . now()->toDateTimeString() . "\n";
        $content .= "# ============================================\n\n";
        
        // Global rules for all search engines
        $content .= "# Global Rules - All Search Engines\n";
        $content .= "User-agent: *\n";
        $content .= "Allow: /\n\n";
        
        // Explicitly allow important content sections
        $content .= "# Explicit Allow Rules for Better Crawling\n";
        $content .= "Allow: /articles/\n";
        $content .= "Allow: /categories/\n";
        $content .= "Allow: /tags/\n";
        $content .= "Allow: /series/\n";
        $content .= "Allow: /profile/\n";
        $content .= "Allow: /amp/\n";
        $content .= "Allow: /*.xml\n"; // Allow all XML files (sitemaps, feeds, etc.)
        $content .= "Allow: /*.css\n";
        $content .= "Allow: /*.js\n";
        $content .= "Allow: /*.jpg\n";
        $content .= "Allow: /*.jpeg\n";
        $content .= "Allow: /*.png\n";
        $content .= "Allow: /*.gif\n";
        $content .= "Allow: /*.webp\n";
        $content .= "Allow: /*.svg\n";
        $content .= "Allow: /*.ico\n";
        $content .= "Allow: /*.woff\n";
        $content .= "Allow: /*.woff2\n";
        $content .= "Allow: /*.ttf\n";
        $content .= "Allow: /*.eot\n\n";
        
        // Disallow sensitive areas
        $content .= "# ============================================\n";
        $content .= "# Disallow Rules - Private/Sensitive Areas\n";
        $content .= "# ============================================\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /dashboard\n";
        $content .= "Disallow: /author/\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /_debugbar/\n";
        $content .= "Disallow: /storage/\n";
        $content .= "Disallow: /vendor/\n";
        $content .= "Disallow: /node_modules/\n";
        $content .= "Disallow: /.env\n";
        $content .= "Disallow: /.git/\n";
        $content .= "Disallow: /bootstrap/cache/\n";
        $content .= "Disallow: /config/\n";
        $content .= "Disallow: /database/\n";
        $content .= "Disallow: /resources/\n";
        $content .= "Disallow: /routes/\n";
        $content .= "Disallow: /tests/\n";
        $content .= "Disallow: /app/\n\n";
        
        // Disallow search and filter pages (these are noindex)
        $content .= "# Disallow Search and Filter Pages\n";
        $content .= "# These pages are typically noindex and don't need crawling\n";
        $content .= "Disallow: /search?\n";
        $content .= "Disallow: /search?*\n";
        $content .= "Disallow: /*?page=\n";
        $content .= "Disallow: /*?sort=\n";
        $content .= "Disallow: /*?filter=\n";
        $content .= "Disallow: /*?search=\n";
        $content .= "Disallow: /*?q=\n";
        $content .= "Disallow: /*?ref=\n";
        $content .= "Disallow: /*?utm_*\n";
        $content .= "Disallow: /*?fbclid=\n";
        $content .= "Disallow: /*?gclid=\n\n";
        
        // Disallow authenticated user-specific pages
        $content .= "# Disallow User-Specific Pages (Requires Authentication)\n";
        $content .= "Disallow: /bookmarks\n";
        $content .= "Disallow: /activity\n";
        $content .= "Disallow: /profile/edit\n";
        $content .= "Disallow: /email/verify\n";
        $content .= "Disallow: /logout\n\n";
        
        // Specific rules for major search engines
        $content .= "# ============================================\n";
        $content .= "# Specific Rules for Major Search Engines\n";
        $content .= "# ============================================\n\n";
        
        $content .= "# Google Bot - Full Access (Recommended)\n";
        $content .= "User-agent: Googlebot\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /dashboard\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /_debugbar/\n";
        $content .= "Crawl-delay: 0\n\n";
        
        $content .= "# Google Image Bot\n";
        $content .= "User-agent: Googlebot-Image\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n\n";
        
        $content .= "# Google Mobile Bot\n";
        $content .= "User-agent: Googlebot-Mobile\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n\n";
        
        $content .= "# Bing Bot\n";
        $content .= "User-agent: Bingbot\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /dashboard\n";
        $content .= "Disallow: /api/\n";
        $content .= "Crawl-delay: 0\n\n";
        
        $content .= "# Yandex Bot\n";
        $content .= "User-agent: Yandex\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Crawl-delay: 1\n\n";
        
        $content .= "# Baidu Bot\n";
        $content .= "User-agent: Baiduspider\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Crawl-delay: 2\n\n";
        
        // Block bad bots (optional - uncomment if needed)
        $content .= "# ============================================\n";
        $content .= "# Block Bad Bots (Optional - Uncomment if needed)\n";
        $content .= "# ============================================\n";
        $content .= "# User-agent: AhrefsBot\n";
        $content .= "# Disallow: /\n\n";
        $content .= "# User-agent: SemrushBot\n";
        $content .= "# Disallow: /\n\n";
        $content .= "# User-agent: DotBot\n";
        $content .= "# Disallow: /\n\n";
        
        // Sitemaps section - Comprehensive list
        $content .= "# ============================================\n";
        $content .= "# Sitemaps - All Available Sitemaps\n";
        $content .= "# ============================================\n";
        $content .= "# Main Sitemap (All URLs in one file)\n";
        $content .= "Sitemap: {$siteUrl}/sitemap.xml\n\n";
        
        $content .= "# Sitemap Index (Index of all sitemaps)\n";
        $content .= "Sitemap: {$siteUrl}/sitemap/index.xml\n\n";
        
        $content .= "# Individual Sitemaps by Content Type\n";
        $content .= "Sitemap: {$siteUrl}/sitemap/static.xml\n";
        $content .= "Sitemap: {$siteUrl}/sitemap/articles.xml\n";
        $content .= "Sitemap: {$siteUrl}/sitemap/categories.xml\n";
        $content .= "Sitemap: {$siteUrl}/sitemap/tags.xml\n\n";
        
        // Additional notes
        $content .= "# ============================================\n";
        $content .= "# Notes for Search Engines\n";
        $content .= "# ============================================\n";
        $content .= "# - This site uses dynamic sitemap generation\n";
        $content .= "# - Sitemaps are updated automatically when content changes\n";
        $content .= "# - Last updated: " . now()->toDateTimeString() . "\n";
        $content .= "# - Cache duration: " . (config('sitemap.cache_duration', 3600) / 60) . " minutes\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain')
            ->header('Cache-Control', 'public, max-age=3600, must-revalidate') // Cache for 1 hour with revalidation
            ->header('Last-Modified', gmdate('D, d M Y H:i:s', time()) . ' GMT')
            ->header('ETag', md5($content)); // ETag for cache validation
    }
}

