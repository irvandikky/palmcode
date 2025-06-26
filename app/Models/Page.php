<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'status',
    ];

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
