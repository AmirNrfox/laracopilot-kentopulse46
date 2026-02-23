<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'type',
        'value_fa', 'value_en',
        'price_modifier', 'stock',
        'sku', 'active',
    ];

    protected $casts = [
        'price_modifier' => 'integer',
        'stock'          => 'integer',
        'active'         => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Localized value.
     */
    public function getValueAttribute(): string
    {
        return app()->getLocale() === 'en'
            ? ($this->value_en ?: $this->value_fa)
            : ($this->value_fa ?: $this->value_en);
    }
}