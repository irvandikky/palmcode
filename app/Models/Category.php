<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the posts that belong to the category.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Mutator to auto-generate slug from name if not provided.
     *
     * @param string $value
     * @return void
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug']) || ($this->isDirty('name') && ! $this->isDirty('slug'))) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}
