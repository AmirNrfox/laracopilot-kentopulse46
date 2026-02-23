<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $query = Order::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('payment_status')) $query->where('payment_status', $request->payment_status);
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('order_number', 'like', "%$q%")
                    ->orWhere('first_name', 'like', "%$q%")
                    ->orWhere('last_name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $order = Order::with(['items.product', 'user', 'coupon'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        Order::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'وضعیت سفارش بروزرسانی شد ✅');
    }
}