<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Wishlist;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name_fa', 'name_en', 'slug', 'brand', 'sku',
        'price', 'sale_price', 'stock', 'featured', 'active',
        'main_image', 'description_fa', 'description_en',
        'short_description_fa', 'short_description_en',
        'weight', 'views', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'price'      => 'integer',
        'sale_price' => 'integer',
        'stock'      => 'integer',
        'featured'   => 'boolean',
        'active'     => 'boolean',
        'weight'     => 'float',
        'views'      => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->where('active', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('approved', true)->latest();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Returns the effective selling price (sale_price if set, else price).
     */
    public function getFinalPriceAttribute(): int
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Returns URL of main product image (or a placeholder).
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->main_image) {
            return asset('storage/' . $this->main_image);
        }
        // SVG placeholder
        return 'data:image/svg+xml,' . rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#f3f4f6" width="200" height="200"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size="60">💪</text></svg>'
        );
    }

    /**
     * Localized product name.
     */
    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'en' ? ($this->name_en ?: $this->name_fa) : ($this->name_fa ?: $this->name_en);
    }

    /**
     * Localized short description.
     */
    public function getShortDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'en'
            ? ($this->short_description_en ?: $this->short_description_fa)
            : ($this->short_description_fa ?: $this->short_description_en);
    }

    /**
     * Localized full description.
     */
    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'en'
            ? ($this->description_en ?: $this->description_fa)
            : ($this->description_fa ?: $this->description_en);
    }

    /**
     * Average rating from approved reviews (0 if none).
     */
    public function getAverageRatingAttribute(): float
    {
        $reviews = $this->reviews;
        if ($reviews->isEmpty()) return 0.0;
        return round($reviews->avg('rating'), 1);
    }
}