<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Component;

class AddToCart extends Component
{
    public Product $product;
    public ?int $selectedVariantId = null;
    public int $quantity = 1;
    public string $message = '';
    public bool $success = false;

    public function mount(Product $product)
    {
        $this->product = $product;
        // Auto-select first variant if exists
        if ($product->variants->isNotEmpty()) {
            $this->selectedVariantId = $product->variants->first()->id;
        }
    }

    public function selectVariant(int $variantId): void
    {
        $this->selectedVariantId = $variantId;
    }

    public function incrementQty(): void
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrementQty(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(): void
    {
        $product = $this->product;
        $variant = $this->selectedVariantId ? ProductVariant::find($this->selectedVariantId) : null;

        if ($product->stock <= 0) {
            $this->message = app()->getLocale() === 'fa' ? 'این محصول موجود نیست' : 'This product is out of stock';
            $this->success = false;
            return;
        }

        $price = $product->final_price + ($variant ? $variant->price_modifier : 0);
        $key = $product->id . '_' . ($variant ? $variant->id : 'none');

        $cart = session('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $this->quantity;
        } else {
            $cart[$key] = [
                'product_id'     => $product->id,
                'variant_id'     => $variant ? $variant->id : null,
                'name_fa'        => $product->name_fa,
                'name_en'        => $product->name_en,
                'variant_info_fa' => $variant ? $this->variantLabel($variant, 'fa') : null,
                'variant_info_en' => $variant ? $this->variantLabel($variant, 'en') : null,
                'price'          => $price,
                'quantity'       => $this->quantity,
                'image'          => $product->image_url,
                'slug'           => $product->slug,
            ];
        }
        session(['cart' => $cart]);

        $this->message = app()->getLocale() === 'fa' ? '✅ به سبد خرید اضافه شد' : '✅ Added to cart';
        $this->success = true;
        $this->dispatch('cartUpdated', count($cart));
    }

    private function variantLabel(ProductVariant $v, string $locale): string
    {
        $typeLabel = [
            'flavor' => ['fa' => 'طعم', 'en' => 'Flavor'],
            'size'   => ['fa' => 'سایز', 'en' => 'Size'],
            'weight' => ['fa' => 'وزن', 'en' => 'Weight'],
        ][$v->type] ?? ['fa' => $v->type, 'en' => $v->type];

        return $typeLabel[$locale] . ': ' . ($locale === 'fa' ? $v->value_fa : $v->value_en);
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}