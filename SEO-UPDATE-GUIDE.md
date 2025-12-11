# SEO Update Guide

## Commands Created

### 1. Update All Page SEO Settings
```bash
php artisan seo:update-all --force
```

This command updates SEO settings for all pages with TECHNAZAARA branding:
- Home Page
- Articles Listing
- Categories Listing
- Tags Listing
- Search Page
- About Page
- Contact Page
- Privacy Policy
- Terms of Service

**Features:**
- Updates meta titles, descriptions, keywords
- Updates Open Graph tags
- Updates Twitter Card tags
- Updates canonical URLs
- Updates schema markup (JSON-LD)
- Updates hreflang tags
- Sets all pages to active

**Options:**
- `--force` - Force update even if SEO already exists

### 2. Update Website Name
```bash
php artisan app:update-name
```

This command updates the website name from "Nazaaracircle" to "TECHNAZAARA" across:
- All PHP files
- All Blade templates
- CSS files
- JavaScript files
- Database seeders
- .env file (APP_NAME)

**Options:**
- `--old=Nazaaracircle` - Old name to replace (default: Nazaaracircle)
- `--new=TECHNAZAARA` - New name (default: TECHNAZAARA)

## What Was Updated

### SEO Settings
All pages now have:
- ✅ Meta Title: "TECHNAZAARA - Latest Technology News & Tutorials" (or page-specific)
- ✅ Meta Description: Updated with TECHNAZAARA branding
- ✅ Meta Keywords: Technology, programming, web development, etc.
- ✅ Open Graph Tags: Complete OG tags with TECHNAZAARA branding
- ✅ Twitter Cards: Summary large image cards
- ✅ Canonical URLs: Proper canonical URLs for each page
- ✅ Schema Markup: JSON-LD structured data for home page
- ✅ Hreflang Tags: Language tags (currently English only)

### Website Name
Updated in 31 files:
- Controllers and Services
- Views (Blade templates)
- Database seeders
- CSS files
- Configuration files

## Home Page SEO Details

The home page now has these exact settings:

**Basic Meta Tags:**
- Title: `TECHNAZAARA - Latest Technology News & Tutorials`
- Description: `Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights. Learn from expert articles and tutorials.`
- Keywords: `technology, programming, web development, tutorials, tech news, coding, software development, AI, machine learning`
- Robots: `index, follow`

**Open Graph:**
- Title: `TECHNAZAARA - Latest Technology News & Tutorials`
- Type: `website`
- Description: `Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights.`
- Image: `https://nazaaracircle.com/icon.png`
- URL: `https://nazaaracircle.com`

**Twitter Card:**
- Type: `summary_large_image`
- Title: `TECHNAZAARA - Latest Technology News & Tutorials`
- Description: `Stay updated with the latest technology news, programming tutorials, web development guides, and tech insights.`
- Image: `https://nazaaracircle.com/icon.png`

**Schema Markup:**
```json
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "TECHNAZAARA",
    "url": "https://nazaaracircle.com",
    "potentialAction": {
        "@type": "SearchAction",
        "target": {
            "@type": "EntryPoint",
            "urlTemplate": "https://nazaaracircle.com/search?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
    }
}
```

## Verification

After running the commands, verify:

1. **Check SEO in database:**
   ```bash
   php artisan tinker
   # Then run:
   \App\Models\PageSeo::all()->pluck('page_key', 'meta_title');
   ```

2. **Check website name:**
   ```bash
   # Check .env
   grep APP_NAME .env
   
   # Should show: APP_NAME="TECHNAZAARA"
   ```

3. **View a page in browser:**
   - Check page source
   - Verify meta tags
   - Check Open Graph tags
   - Verify Twitter Card tags

## Production Deployment

When deploying to production:

1. **Update SEO settings:**
   ```bash
   php artisan seo:update-all --force
   ```

2. **Update website name (if needed):**
   ```bash
   php artisan app:update-name
   ```

3. **Clear caches:**
   ```bash
   php artisan optimize:clear
   php artisan config:clear
   ```

4. **Verify:**
   ```bash
   php artisan diagnose
   ```

## Manual Updates

If you need to manually update SEO for a specific page:

1. Go to Admin Panel → SEO Settings
2. Select the page you want to update
3. Edit the SEO fields
4. Save changes

The system will automatically:
- Clear caches
- Update sitemap
- Refresh view cache

## Notes

- All SEO settings are stored in the `page_seos` database table
- SEO settings take priority over default controller SEO
- Schema markup is stored as JSON in the database
- Hreflang tags are stored as JSON array
- All pages are set to `is_active = true` by default

## Troubleshooting

**Issue: SEO not showing on pages**
- Clear caches: `php artisan optimize:clear`
- Check if page SEO is active: `is_active = true`
- Verify page key matches route name

**Issue: Website name not updated**
- Check .env file: `APP_NAME="TECHNAZAARA"`
- Clear config cache: `php artisan config:clear`
- Restart application if using process manager

**Issue: Schema markup not rendering**
- Check JSON format in database
- Verify schema_markup field is valid JSON
- Check browser console for JSON errors

