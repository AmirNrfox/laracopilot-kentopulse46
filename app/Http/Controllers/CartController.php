<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        // Now rendered by Livewire CartPage component
        return view('cart.index');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductVariant::findOrFail($request->variant_id) : null;
        $price   = $product->final_price + ($variant ? $variant->price_modifier : 0);
        $key     = $product->id . '_' . ($variant ? $variant->id : 'none');
        $cart    = $this->getCart();

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += (int) $request->quantity;
        } else {
            $cart[$key] = [
                'product_id'      => $product->id,
                'variant_id'      => $variant ? $variant->id : null,
                'name_fa'         => $product->name_fa,
                'name_en'         => $product->name_en,
                'variant_info_fa' => $variant ? ('طعم: ' . $variant->value_fa) : null,
                'variant_info_en' => $variant ? ('Flavor: ' . $variant->value_en) : null,
                'price'           => $price,
                'quantity'        => (int) $request->quantity,
                'image'           => $product->image_url,
                'slug'            => $product->slug,
            ];
        }
        $this->saveCart($cart);

        return response()->json(['success' => true, 'count' => count($cart)]);
    }

    public function update(Request $request)
    {
        $cart = $this->getCart();
        $key  = $request->key;
        if (isset($cart[$key])) {
            if ((int) $request->quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = (int) $request->quantity;
            }
        }
        $this->saveCart($cart);
        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $cart = $this->getCart();
        unset($cart[$request->key]);
        $this->saveCart($cart);
        return redirect()->route('cart.index');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $coupon = Coupon::where('code', strtoupper(trim($request->code)))->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->withErrors(['code' => app()->getLocale() === 'fa' ? 'کد تخفیف نامعتبر است' : 'Invalid coupon code']);
        }

        $cart     = $this->getCart();
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        if ($subtotal < $coupon->min_order) {
            return back()->withErrors(['code' => app()->getLocale() === 'fa'
                ? 'حداقل خرید برای این کوپن ' . number_format($coupon->min_order) . ' تومان است'
                : 'Minimum order for this coupon is ' . number_format($coupon->min_order) . ' Toman']);
        }

        session(['coupon' => ['code' => $coupon->code, 'id' => $coupon->id]]);
        return back()->with('success', app()->getLocale() === 'fa' ? 'کد تخفیف اعمال شد' : 'Coupon applied successfully');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', app()->getLocale() === 'fa' ? 'کد تخفیف حذف شد' : 'Coupon removed');
    }
}