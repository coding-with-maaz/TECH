<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cast extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'profile_path',
        'biography',
        'birthday',
        'birthplace',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    /**
     * Get all content (movies/TV shows) this cast member is in
     */
    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'content_cast')
            ->withPivot('character', 'order')
            ->withTimestamps()
            ->orderByPivot('order', 'asc');
    }

    /**
     * Search casts by name
     */
    public static function searchByName(string $query)
    {
        return static::where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->get();
    }
}
