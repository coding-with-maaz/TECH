<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category_id',
        'author_id',
        'status',
        'views',
        'reading_time',
        'is_featured',
        'allow_comments',
        'published_at',
        'sort_order',
        'meta',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'views' => 'integer',
        'reading_time' => 'integer',
        'sort_order' => 'integer',
        'meta' => 'array',
    ];

    /**
     * Get the category that owns the article
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the author of the article
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get all tags for this article
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag')
            ->withTimestamps();
    }

    /**
     * Get all comments for this article
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    /**
     * Get all comments including replies
     */
    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get all bookmarks for this article
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get all views for this article
     */
    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    /**
     * Get all likes for this article
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ArticleLike::class);
    }

    /**
     * Get reading history for this article
     */
    public function readingHistory(): HasMany
    {
        return $this->hasMany(ReadingHistory::class);
    }

    /**
     * Get all revisions for this article
     */
    public function revisions(): HasMany
    {
        return $this->hasMany(ArticleRevision::class)->orderBy('revision_number', 'desc');
    }

    /**
     * Create a revision snapshot of the current article state
     */
    public function createRevision($createdBy = null, $changeSummary = null): ArticleRevision
    {
        $revisionNumber = $this->revisions()->max('revision_number') + 1;

        return ArticleRevision::create([
            'article_id' => $this->id,
            'created_by' => $createdBy ?? auth()->id(),
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'allow_comments' => $this->allow_comments,
            'published_at' => $this->published_at,
            'meta' => $this->meta,
            'change_summary' => $changeSummary,
            'revision_number' => $revisionNumber,
        ]);
    }

    /**
     * Check if article is bookmarked by user
     */
    public function isBookmarkedBy($userId): bool
    {
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }

    /**
     * Check if article is liked by user or IP
     */
    public function isLikedBy($userId = null, $ipAddress = null): bool
    {
        $query = $this->likes();
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($ipAddress) {
            $query->where('ip_address', $ipAddress);
        }
        return $query->exists();
    }

    /**
     * Get likes count
     */
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * Scope for published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Scope for featured articles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for category
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = $article->generateUniqueSlug();
            }
            if (empty($article->reading_time)) {
                $article->reading_time = $article->calculateReadingTime();
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = $article->generateUniqueSlug();
            }
            if ($article->isDirty('content')) {
                $article->reading_time = $article->calculateReadingTime();
            }
        });

        // Clear sitemap cache when article is saved or deleted
        static::saved(function ($article) {
            if (app()->bound(\App\Services\SitemapService::class)) {
                app(\App\Services\SitemapService::class)->clearCache();
            }
        });

        static::deleted(function ($article) {
            if (app()->bound(\App\Services\SitemapService::class)) {
                app(\App\Services\SitemapService::class)->clearCache();
            }
        });
    }

    /**
     * Generate a unique slug from the title.
     */
    public function generateUniqueSlug()
    {
        $slug = Str::slug($this->title);
        $originalSlug = $slug;
        $count = 1;

        while (static::withTrashed()->where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Calculate reading time in minutes
     */
    public function calculateReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $readingTime = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        return max(1, $readingTime); // Minimum 1 minute
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get the rendered content (decoded HTML)
     */
    public function getRenderedContentAttribute()
    {
        // Decode HTML entities if they exist, otherwise return as-is
        $content = $this->content;
        
        // Check if content is HTML-encoded
        if (strpos($content, '&lt;') !== false || strpos($content, '&gt;') !== false) {
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        
        return $content;
    }
}

