<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'coupon_id',
        'status', 'payment_status', 'payment_method',
        'first_name', 'last_name', 'email', 'phone',
        'address', 'city', 'province', 'postal_code', 'notes',
        'subtotal', 'discount', 'shipping', 'total',
        'transaction_id',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'discount' => 'integer',
        'shipping' => 'integer',
        'total'    => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Human-readable status label (bilingual).
     */
    public function getStatusLabelAttribute(): string
    {
        $fa = app()->getLocale() === 'fa';
        return match ($this->status) {
            'pending'    => $fa ? '⏳ در انتظار' : '⏳ Pending',
            'processing' => $fa ? '🔄 در حال پردازش' : '🔄 Processing',
            'shipped'    => $fa ? '🚚 ارسال شده' : '🚚 Shipped',
            'delivered'  => $fa ? '✅ تحویل داده شده' : '✅ Delivered',
            'cancelled'  => $fa ? '❌ لغو شده' : '❌ Cancelled',
            default      => $this->status,
        };
    }
}