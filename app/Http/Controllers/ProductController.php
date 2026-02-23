<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Products index now handled by Livewire ProductFilter component
        $categories = Category::where('active', true)->orderBy('sort_order')->get();
        $brands     = Product::where('active', true)->whereNotNull('brand')->distinct()->pluck('brand');
        $sort       = $request->get('sort', 'newest');

        return view('products.index', compact('categories', 'brands', 'sort'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('active', true)
            ->with(['category', 'images', 'variants', 'reviews.user'])
            ->firstOrFail();

        $product->increment('views');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->take(4)
            ->get();

        $paymentEnabled = Setting::get('payment_enabled', '1');
        $whatsappNumber = Setting::get('whatsapp_number', '989123456789');
        $locale         = app()->getLocale();
        $whatsappMsg    = $locale === 'en'
            ? Setting::get('whatsapp_message_en', 'Hello, I want to consult about your products')
            : Setting::get('whatsapp_message_fa', 'سلام، می‌خواهم درباره محصولات مشاوره بگیرم');

        return view('products.show', compact('product', 'related', 'paymentEnabled', 'whatsappNumber', 'whatsappMsg'));
    }

    public function category($slug)
    {
        $category   = Category::where('slug', $slug)->where('active', true)->firstOrFail();
        $products   = Product::where('category_id', $category->id)
            ->where('active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        $categories = Category::where('active', true)->orderBy('sort_order')->get();

        $paymentEnabled = Setting::get('payment_enabled', '1');
        $whatsappNumber = Setting::get('whatsapp_number', '989123456789');

        return view('products.category', compact('category', 'products', 'categories', 'paymentEnabled', 'whatsappNumber'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }
}