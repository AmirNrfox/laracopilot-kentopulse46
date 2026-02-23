<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id', 'name_fa', 'name_en', 'slug',
        'description_fa', 'description_en',
        'active', 'sort_order',
    ];

    protected $casts = [
        'active'     => 'boolean',
        'sort_order' => 'integer',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Localized name accessor.
     */
    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'en'
            ? ($this->name_en ?: $this->name_fa)
            : ($this->name_fa ?: $this->name_en);
    }

    /**
     * Localized description accessor.
     */
    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'en'
            ? ($this->description_en ?: $this->description_fa)
            : ($this->description_fa ?: $this->description_en);
    }
}