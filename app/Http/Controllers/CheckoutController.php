<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    private function calcShipping(int $total): int
    {
        $freeMin = (int) Setting::get('free_shipping_min', 1000000);
        if ($total >= $freeMin) return 0;
        return (int) Setting::get('shipping_cost', 50000);
    }

    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $coupon   = session('coupon');
        $subtotal = (int) collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $discount = 0;

        if ($coupon) {
            $couponModel = Coupon::find($coupon['id']);
            if ($couponModel && $couponModel->isValid()) {
                $discount = (int) $couponModel->calculateDiscount($subtotal);
            }
        }

        $shipping       = $this->calcShipping($subtotal - $discount);
        $total          = $subtotal - $discount + $shipping;
        $paymentEnabled = Setting::get('payment_enabled', '1');
        $whatsappNumber = Setting::get('whatsapp_number', '989123456789');
        $user           = Auth::user();

        return view('checkout.index', compact(
            'cart', 'subtotal', 'discount', 'shipping', 'total',
            'paymentEnabled', 'whatsappNumber', 'user'
        ));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:20',
            'address'     => 'required|string',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $coupon   = session('coupon');
        $subtotal = (int) collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $discount = 0;
        $couponId = null;

        if ($coupon) {
            $couponModel = Coupon::find($coupon['id']);
            if ($couponModel && $couponModel->isValid()) {
                $discount = (int) $couponModel->calculateDiscount($subtotal);
                $couponId = $couponModel->id;
                $couponModel->increment('used_count');
            }
        }

        $shipping = $this->calcShipping($subtotal - $discount);
        $total    = $subtotal - $discount + $shipping;
        $locale   = app()->getLocale();

        $order = Order::create([
            'order_number'   => Order::generateOrderNumber(),
            'user_id'        => Auth::id(),
            'coupon_id'      => $couponId,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $request->get('payment_method', 'zarinpal'),
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'notes'          => $request->notes,
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'shipping'       => $shipping,
            'total'          => $total,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'],
                'variant_id'   => $item['variant_id'],
                'product_name' => $locale === 'en' ? $item['name_en'] : $item['name_fa'],
                'variant_info' => $locale === 'en' ? $item['variant_info_en'] : $item['variant_info_fa'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'total'        => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget(['cart', 'coupon']);
        session(['pending_order_id' => $order->id]);

        try {
            Mail::send('emails.order_placed', ['order' => $order], function ($m) use ($order) {
                $m->to($order->email)
                  ->subject(($order->payment_method === 'whatsapp' ? 'سفارش ثبت شد - ' : 'Order Placed - ') . $order->order_number);
            });
        } catch (\Exception $e) {}

        if ($request->get('payment_method') === 'whatsapp') {
            return redirect()->route('checkout.whatsapp');
        }

        return redirect()->route('payment.pay');
    }

    public function whatsapp()
    {
        $orderId = session('pending_order_id');
        $order   = $orderId ? Order::find($orderId) : null;
        $locale  = app()->getLocale();

        $whatsappNumber = Setting::get('whatsapp_number', '989123456789');
        $msg = $locale === 'en'
            ? Setting::get('whatsapp_message_en', 'Hello, I want to consult about your products')
            : Setting::get('whatsapp_message_fa', 'سلام، می‌خواهم درباره محصولات مشاوره بگیرم');

        if ($order) {
            $msg .= ($locale === 'en' ? ' - Order: ' : ' - سفارش: ') . $order->order_number;
        }

        $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($msg);
        return view('checkout.whatsapp', compact('whatsappUrl', 'order'));
    }
}