@extends('layouts.app')
@section('title', (app()->getLocale() === 'fa' ? 'جزئیات سفارش' : 'Order Details') . ' - ' . $order->order_number)
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-black">{{ $isFa ? 'جزئیات سفارش' : 'Order Details' }}</h1>
        <a href="{{ route('orders.my') }}" class="text-green-600 hover:underline text-sm">{{ $isFa ? '← سفارشات من' : '← My Orders' }}</a>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500">{{ $isFa ? 'شماره سفارش' : 'Order #' }}</div>
                <div class="font-mono font-black text-green-700">{{ $order->order_number }}</div>
            </div>
            <div>
                <div class="text-gray-500">{{ $isFa ? 'تاریخ' : 'Date' }}</div>
                <div class="font-bold">{{ $order->created_at->format('Y/m/d') }}</div>
            </div>
            <div>
                <div class="text-gray-500">{{ $isFa ? 'وضعیت' : 'Status' }}</div>
                <div class="font-bold">{{ $order->status_label }}</div>
            </div>
            <div>
                <div class="text-gray-500">{{ $isFa ? 'پرداخت' : 'Payment' }}</div>
                <div class="font-bold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-orange-500' }}">
                    {{ $order->payment_status === 'paid' ? ($isFa ? 'پرداخت شده' : 'Paid') : ($isFa ? 'در انتظار' : 'Pending') }}
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="font-black mb-4">{{ $isFa ? 'اقلام سفارش' : 'Order Items' }}</h2>
        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="flex justify-between items-start pb-4 border-b last:border-0 last:pb-0">
                <div>
                    <div class="font-medium">{{ $item->product_name }}</div>
                    @if($item->variant_info)
                        <div class="text-xs text-gray-500 mt-0.5">{{ $item->variant_info }}</div>
                    @endif
                    <div class="text-sm text-gray-500">× {{ $item->quantity }}</div>
                </div>
                <div class="font-black">{{ number_format($item->total) }}</div>
            </div>
            @endforeach
        </div>
        <div class="border-t mt-4 pt-4 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-gray-600">{{ $isFa ? 'جمع' : 'Subtotal' }}</span><span>{{ number_format($order->subtotal) }}</span></div>
            @if($order->discount > 0)<div class="flex justify-between text-red-600"><span>{{ $isFa ? 'تخفیف' : 'Discount' }}</span><span>-{{ number_format($order->discount) }}</span></div>@endif
            <div class="flex justify-between"><span class="text-gray-600">{{ $isFa ? 'ارسال' : 'Shipping' }}</span><span>{{ $order->shipping > 0 ? number_format($order->shipping) : ($isFa ? 'رایگان' : 'Free') }}</span></div>
            <div class="flex justify-between font-black text-lg border-t pt-2">
                <span>{{ $isFa ? 'جمع کل' : 'Total' }}</span>
                <span class="text-green-700">{{ number_format($order->total) }} {{ $isFa ? 'ت' : 'T' }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-black mb-4">{{ $isFa ? 'آدرس تحویل' : 'Shipping Address' }}</h2>
        <div class="text-sm text-gray-600 space-y-1">
            <div class="font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</div>
            <div>📞 {{ $order->phone }}</div>
            <div>📍 {{ $order->address }}</div>
            <div>{{ $order->city }}، {{ $order->province }} — {{ $order->postal_code }}</div>
        </div>
    </div>
</div>
@endsection
