@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'پرداخت موفق' : 'Payment Successful')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-2xl mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl shadow-xl p-10 text-center">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-5xl">✅</span>
        </div>
        <h1 class="text-3xl font-black text-gray-900 mb-3">
            {{ $isFa ? 'پرداخت موفق!' : 'Payment Successful!' }}
        </h1>
        <p class="text-gray-600 mb-2">
            {{ $isFa ? 'سفارش شما با موفقیت ثبت و پرداخت آن تأیید شد.' : 'Your order has been placed and payment confirmed.' }}
        </p>
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 my-6 text-right">
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="text-gray-500">{{ $isFa ? 'شماره سفارش:' : 'Order Number:' }}</div>
                <div class="font-mono font-black text-green-700">{{ $order->order_number }}</div>
                <div class="text-gray-500">{{ $isFa ? 'مبلغ پرداختی:' : 'Amount Paid:' }}</div>
                <div class="font-black text-gray-900">{{ number_format($order->total) }} {{ $isFa ? 'تومان' : 'Toman' }}</div>
                @if($order->transaction_id)
                <div class="text-gray-500">{{ $isFa ? 'کد پیگیری:' : 'Transaction ID:' }}</div>
                <div class="font-mono text-sm">{{ $order->transaction_id }}</div>
                @endif
                <div class="text-gray-500">{{ $isFa ? 'وضعیت:' : 'Status:' }}</div>
                <div class="text-green-600 font-bold">{{ $order->status_label }}</div>
            </div>
        </div>

        {{-- Items --}}
        @if($order->items->count())
        <div class="text-right mb-6">
            <h3 class="font-bold text-gray-800 mb-3">{{ $isFa ? 'اقلام سفارش' : 'Order Items' }}</h3>
            <div class="space-y-2">
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm bg-gray-50 rounded-xl px-4 py-2">
                    <span>{{ $item->product_name }}{{ $item->variant_info ? ' - ' . $item->variant_info : '' }} × {{ $item->quantity }}</span>
                    <span class="font-bold">{{ number_format($item->total) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('orders.my') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl transition-colors">
                📦 {{ $isFa ? 'پیگیری سفارشات' : 'Track My Orders' }}
            </a>
            <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl transition-colors">
                🏠 {{ $isFa ? 'بازگشت به فروشگاه' : 'Back to Store' }}
            </a>
        </div>
    </div>
</div>
@endsection
