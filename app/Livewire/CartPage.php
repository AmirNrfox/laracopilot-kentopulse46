<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Setting;
use Livewire\Component;

class CartPage extends Component
{
    public array $cart = [];
    public string $couponCode = '';
    public string $couponMessage = '';
    public bool $couponSuccess = false;
    public int $subtotal = 0;
    public int $discount = 0;
    public int $shipping = 0;
    public int $total = 0;

    public function mount(): void
    {
        $this->loadCart();
    }

    private function loadCart(): void
    {
        $this->cart     = session('cart', []);
        $couponData     = session('coupon');
        $this->subtotal = collect($this->cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $this->discount = 0;

        if ($couponData) {
            $coupon = Coupon::where('code', $couponData['code'])->first();
            if ($coupon && $coupon->isValid()) {
                $this->discount = $coupon->calculateDiscount($this->subtotal);
            }
        }

        $freeMin        = (int) Setting::get('free_shipping_min', 1000000);
        $shippingCost   = (int) Setting::get('shipping_cost', 50000);
        $this->shipping = ($this->subtotal - $this->discount) >= $freeMin ? 0 : $shippingCost;
        $this->total    = $this->subtotal - $this->discount + $this->shipping;
    }

    public function updateQuantity(string $key, int $qty): void
    {
        $cart = session('cart', []);
        if (isset($cart[$key])) {
            if ($qty <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $qty;
            }
        }
        session(['cart' => $cart]);
        $this->loadCart();
        $this->dispatch('cartUpdated', count($cart));
    }

    public function removeItem(string $key): void
    {
        $cart = session('cart', []);
        unset($cart[$key]);
        session(['cart' => $cart]);
        $this->loadCart();
        $this->dispatch('cartUpdated', count($cart));
    }

    public function applyCoupon(): void
    {
        $coupon = Coupon::where('code', strtoupper(trim($this->couponCode)))->first();

        if (!$coupon || !$coupon->isValid()) {
            $this->couponMessage = app()->getLocale() === 'fa' ? '❌ کد تخفیف نامعتبر است' : '❌ Invalid coupon code';
            $this->couponSuccess = false;
            return;
        }

        if ($this->subtotal < $coupon->min_order) {
            $this->couponMessage = app()->getLocale() === 'fa'
                ? '❌ حداقل خرید ' . number_format($coupon->min_order) . ' تومان است'
                : '❌ Minimum order is ' . number_format($coupon->min_order) . ' Toman';
            $this->couponSuccess = false;
            return;
        }

        session(['coupon' => ['code' => $coupon->code, 'id' => $coupon->id]]);
        $this->couponMessage = app()->getLocale() === 'fa' ? '✅ کد تخفیف اعمال شد' : '✅ Coupon applied';
        $this->couponSuccess = true;
        $this->loadCart();
    }

    public function removeCoupon(): void
    {
        session()->forget('coupon');
        $this->couponCode    = '';
        $this->couponMessage = '';
        $this->couponSuccess = false;
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}