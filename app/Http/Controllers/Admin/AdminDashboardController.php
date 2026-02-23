<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('payment_status', 'paid')->sum('total');
        $totalProducts = Product::count();
        $totalUsers    = User::where('role', 'user')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingReviews = Review::where('approved', false)->count();
        $recentOrders  = Order::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        $topProducts   = Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();

        // SQLite-compatible: strftime instead of DATE_FORMAT
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->selectRaw("strftime('%Y-%m', created_at) as month, SUM(total) as revenue, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 'totalUsers',
            'pendingOrders', 'pendingReviews', 'recentOrders', 'topProducts', 'monthlyRevenue'
        ));
    }
}