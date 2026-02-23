<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $products   = Product::where('active', true)->select('slug', 'updated_at')->get();
        $categories = Category::where('active', true)->select('slug', 'updated_at')->get();

        $content = view('sitemap', compact('products', 'categories'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}