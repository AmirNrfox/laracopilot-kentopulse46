<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private function merchantId(): string
    {
        return Setting::get('zarinpal_merchant_id', 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');
    }

    private function isSandbox(): bool
    {
        return Setting::get('zarinpal_sandbox', '1') == '1';
    }

    private function baseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://sandbox.zarinpal.com'
            : 'https://api.zarinpal.com';
    }

    public function pay()
    {
        if (!Setting::get('payment_enabled', '1')) {
            return redirect()->route('cart.index')
                ->with('error', app()->getLocale() === 'fa' ? 'درگاه پرداخت غیرفعال است' : 'Payment gateway is disabled');
        }

        $orderId = session('pending_order_id');
        if (!$orderId) return redirect()->route('cart.index');

        $order    = Order::findOrFail($orderId);
        $response = Http::post($this->baseUrl() . '/pg/v4/payment/request.json', [
            'merchant_id'  => $this->merchantId(),
            'amount'       => $order->total,
            'description'  => (app()->getLocale() === 'fa' ? 'پرداخت سفارش ' : 'Payment for order ') . $order->order_number,
            'callback_url' => route('payment.callback'),
            'metadata'     => ['email' => $order->email, 'mobile' => $order->phone],
        ]);

        $result = $response->json();

        if (isset($result['data']['code']) && $result['data']['code'] == 100) {
            $authority = $result['data']['authority'];
            $order->update(['transaction_id' => $authority]);
            $gatewayUrl = ($this->isSandbox()
                ? 'https://sandbox.zarinpal.com/pg/StartPay/'
                : 'https://www.zarinpal.com/pg/StartPay/')
                . $authority;
            return redirect($gatewayUrl);
        }

        return redirect()->route('payment.failed');
    }

    public function callback(Request $request)
    {
        if ($request->Status !== 'OK') {
            return redirect()->route('payment.failed');
        }

        $order = Order::where('transaction_id', $request->Authority)->first();
        if (!$order) return redirect()->route('payment.failed');

        $response = Http::post($this->baseUrl() . '/pg/v4/payment/verify.json', [
            'merchant_id' => $this->merchantId(),
            'amount'      => $order->total,
            'authority'   => $request->Authority,
        ]);

        $result = $response->json();

        if (isset($result['data']['code']) && in_array($result['data']['code'], [100, 101])) {
            $order->update([
                'payment_status' => 'paid',
                'status'         => 'processing',
                'transaction_id' => $result['data']['ref_id'] ?? $request->Authority,
            ]);
            session()->forget('pending_order_id');
            return redirect()->route('payment.success', $order->id);
        }

        return redirect()->route('payment.failed');
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        return view('payment.success', compact('order'));
    }

    public function failed()
    {
        return view('payment.failed');
    }
}