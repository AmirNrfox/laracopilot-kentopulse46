<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value',
        'min_order', 'max_uses', 'used_count',
        'active', 'expires_at',
    ];

    protected $casts = [
        'value'      => 'float',
        'min_order'  => 'integer',
        'max_uses'   => 'integer',
        'used_count' => 'integer',
        'active'     => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Check whether this coupon is currently valid.
     */
    public function isValid(): bool
    {
        if (!$this->active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        return true;
    }

    /**
     * Calculate the discount amount for a given subtotal.
     */
    public function calculateDiscount(int $subtotal): int
    {
        if ($this->type === 'percent') {
            return (int) round($subtotal * ($this->value / 100));
        }
        // fixed
        return (int) min($this->value, $subtotal);
    }
}