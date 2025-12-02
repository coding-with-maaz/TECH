<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'website',
        'twitter',
        'github',
        'linkedin',
        'is_author',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_author' => 'boolean',
        ];
    }

    /**
     * Get articles written by this user
     */
    public function articles()
    {
        return $this->hasMany(\App\Models\Article::class, 'author_id');
    }

    /**
     * Get bookmarks for this user
     */
    public function bookmarks()
    {
        return $this->hasMany(\App\Models\Bookmark::class);
    }

    /**
     * Get reading history for this user
     */
    public function readingHistory()
    {
        return $this->hasMany(\App\Models\ReadingHistory::class);
    }

    /**
     * Get article likes for this user
     */
    public function articleLikes()
    {
        return $this->hasMany(\App\Models\ArticleLike::class);
    }

    /**
     * Get comments by this user
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is author
     */
    public function isAuthor(): bool
    {
        return $this->is_author || $this->role === 'author' || $this->role === 'admin';
    }
}
