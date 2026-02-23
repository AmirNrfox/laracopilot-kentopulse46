<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function myOrders()
    {
        if (!Auth::check()) return redirect()->route('login');

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.my', compact('orders'));
    }

    public function show($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}