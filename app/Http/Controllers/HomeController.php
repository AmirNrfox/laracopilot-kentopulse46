<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('active', true)
            ->where('featured', true)
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $categories = Category::where('active', true)
            ->withCount(['products' => function ($q) {
                $q->where('active', true);
            }])
            ->orderBy('sort_order')
            ->get();

        $newProducts = Product::where('active', true)
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $saleProducts = Product::where('active', true)
            ->whereNotNull('sale_price')
            ->with(['category'])
            ->take(4)
            ->get();

        $paymentEnabled = Setting::get('payment_enabled', '1');
        $whatsappNumber = Setting::get('whatsapp_number', '989123456789');

        return view('home', compact(
            'featuredProducts',
            'categories',
            'newProducts',
            'saleProducts',
            'paymentEnabled',
            'whatsappNumber'
        ));
    }
}