@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'سفارشات من' : 'My Orders')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-black mb-8">📦 {{ $isFa ? 'سفارشات من' : 'My Orders' }}</h1>

    @if($orders->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl shadow">
        <div class="text-6xl mb-4">📦</div>
        <h3 class="text-xl font-bold text-gray-500 mb-4">{{ $isFa ? 'هنوز سفارشی ندارید' : 'No orders yet' }}</h3>
        <a href="{{ route('products.index') }}" class="bg-green-600 text-white font-bold py-3 px-8 rounded-xl inline-block">
            🛍️ {{ $isFa ? 'شروع خرید' : 'Start Shopping' }}
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-2xl shadow p-5">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div>
                    <div class="font-mono font-black text-green-700 text-lg">{{ $order->order_number }}</div>
                    <div class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('Y/m/d H:i') }}</div>
                </div>
                <div class="text-left">
                    <div class="font-black text-xl">{{ number_format($order->total) }}<span class="text-sm font-normal text-gray-500 mr-1">{{ $isFa ? 'ت' : 'T' }}</span></div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' :
                           ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')) }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
            <div class="border-t mt-4 pt-4 flex flex-wrap items-center justify-between gap-2">
                <div class="text-sm text-gray-600">
                    <span class="{{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-orange-500' }} font-medium">
                        {{ $order->payment_status === 'paid' ? '✅ ' . ($isFa ? 'پرداخت شده' : 'Paid') : '⏳ ' . ($isFa ? 'در انتظار پرداخت' : 'Unpaid') }}
                    </span>
                </div>
                <a href="{{ route('orders.show', $order->id) }}" class="text-green-600 hover:underline text-sm font-bold">
                    {{ $isFa ? 'مشاهده جزئیات ←' : '→ View Details' }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
