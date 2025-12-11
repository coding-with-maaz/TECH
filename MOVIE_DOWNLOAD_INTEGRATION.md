# Movie Download Integration Guide

## Overview
This system allows movie downloads to be processed through tech articles, showing a download overlay only when a valid token is present.

## How It Works

### 1. Movie Website Side
On your movie website (nazaarabox.com), add download buttons that link to:

```
https://nazaaracircle.com/go/{movie-slug}
```

**Example:**
```html
<a href="https://nazaaracircle.com/go/deadpool-wolverine" class="download-btn">
    DOWNLOAD 4K
</a>
```

### 2. Tech Blog Side (Automatic)
When a user clicks the download link:

1. **Route `/go/{slug}`** receives the request
2. Gets the movie from database by slug
3. Selects a tech article (priority: specific article → category → random)
4. Creates an encrypted token (30-minute expiration)
5. Redirects to: `/articles/{article-slug}?dl={token}`

### 3. Article Page Behavior

#### With Valid Token (`?dl=token`):
- ✅ Shows full-screen download overlay
- ✅ 30-second countdown
- ✅ Progress bar
- ✅ Auto-redirects to real download link (Mega/GDrive)
- ✅ AdSense ads still visible (earning revenue)

#### Without Token (Normal Visitors):
- ✅ Shows normal article only
- ✅ No download overlay
- ✅ Clean content for Google SEO
- ✅ AdSense ads visible

## Database Setup

### Movies Table
```php
Movie::create([
    'title' => 'Deadpool & Wolverine',
    'slug' => 'deadpool-wolverine',
    'download_link' => 'https://mega.nz/file/...', // Real download link
    'quality' => '4K HDR',
    'article_id' => null, // Optional: specific article
    'category_id' => null, // Optional: category-based selection
    'is_active' => true,
]);
```

## Article Selection Priority

1. **Specific Article** (`article_id` set): Uses that exact article
2. **Category-Based** (`category_id` set): Random article from that category
3. **Random**: Any random published article

## Token Security

- Tokens are encrypted using Laravel's `Crypt` facade
- 30-minute expiration
- Invalid/expired tokens = normal article view (no overlay)
- Each token is unique and cannot be reused

## Testing

### Test Download Flow:
1. Create a movie entry in database
2. Visit: `https://nazaaracircle.com/go/{movie-slug}`
3. Should redirect to article with `?dl=token`
4. Should show download overlay with countdown
5. After 30 seconds, redirects to download link

### Test Normal Article:
1. Visit: `https://nazaaracircle.com/articles/{article-slug}` (no `?dl` parameter)
2. Should show normal article only
3. No download overlay

## Configuration

No additional configuration needed. The system works automatically once:
- Movies table is migrated
- Movie entries exist in database
- Articles are published

## Notes

- Download overlay **ONLY** shows when valid token is present
- Normal visitors see clean articles (perfect for SEO)
- Google crawlers see normal content (no download overlay)
- All download traffic goes through tech articles (AdSense revenue)
- Tokens expire after 30 minutes for security

