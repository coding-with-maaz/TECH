<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'download_link',
        'quality',
        'description',
        'poster',
        'article_id',
        'category_id',
        'is_active',
        'redirect_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'redirect_count' => 'integer',
    ];

    /**
     * Get the associated article (if specific article is set)
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the category for article selection
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Increment redirect count
     */
    public function incrementRedirects()
    {
        $this->increment('redirect_count');
    }
}
