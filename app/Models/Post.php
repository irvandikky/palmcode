<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'status',
        'user_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the categories associated with the post.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Mutator to auto-generate slug from title if not provided.
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug']) || ($this->isDirty('title') && ! $this->isDirty('slug'))) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}
