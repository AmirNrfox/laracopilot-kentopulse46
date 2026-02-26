<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $wishlistItems = Wishlist::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            $sessionId = session()->getId();
            $wishlistItems = Wishlist::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        $isFa = app()->getLocale() === 'fa';
        $paymentEnabled = \App\Models\Setting::get('payment_enabled', '1');
        $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '989123456789');

        return view('wishlist.index', compact('wishlistItems', 'isFa', 'paymentEnabled', 'whatsappNumber'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = $request->product_id;

        if (Auth::check()) {
            $existing = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();
            if ($existing) {
                $existing->delete();
                $inWishlist = false;
            } else {
                Wishlist::create(['user_id' => Auth::id(), 'product_id' => $productId]);
                $inWishlist = true;
            }
        } else {
            $sessionId = session()->getId();
            $existing = Wishlist::where('session_id', $sessionId)->where('product_id', $productId)->first();
            if ($existing) {
                $existing->delete();
                $inWishlist = false;
            } else {
                Wishlist::create(['session_id' => $sessionId, 'product_id' => $productId]);
                $inWishlist = true;
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['in_wishlist' => $inWishlist]);
        }

        return back()->with('success', $inWishlist
            ? (app()->getLocale() === 'fa' ? 'به علاقه‌مندی‌ها اضافه شد ❤️' : 'Added to wishlist ❤️')
            : (app()->getLocale() === 'fa' ? 'از علاقه‌مندی‌ها حذف شد' : 'Removed from wishlist')
        );
    }
}
