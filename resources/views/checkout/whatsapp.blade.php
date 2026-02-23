@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'ثبت سفارش واتس‌اپ' : 'WhatsApp Order')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-xl p-10 text-center">
            <div class="text-7xl mb-5">💬</div>
            <h1 class="text-3xl font-black text-gray-900 mb-3">{{ $isFa ? 'سفارش ثبت شد!' : 'Order Placed!' }}</h1>
            <p class="text-gray-600 mb-2">{{ $isFa ? 'سفارش شما با موفقیت ثبت شد.' : 'Your order has been successfully registered.' }}</p>
            @if($order)
            <div class="bg-gray-50 rounded-xl px-4 py-3 mb-6">
                <span class="text-sm text-gray-500">{{ $isFa ? 'شماره سفارش:' : 'Order number:' }}</span>
                <span class="font-mono font-black text-green-700 mr-2">{{ $order->order_number }}</span>
            </div>
            @endif
            <p class="text-gray-600 mb-8">
                {{ $isFa ? 'برای پیگیری و نهایی کردن سفارش خود، روی دکمه زیر کلیک کنید تا به واتس‌اپ هدایت شوید.' : 'Click the button below to be redirected to WhatsApp to finalize your order.' }}
            </p>
            {{-- Replaced: style="background:linear-gradient(135deg,#1da851,#25D366)" → .btn-whatsapp-lg --}}
            <a href="{{ $whatsappUrl }}" target="_blank"
               class="btn-whatsapp-lg inline-flex items-center gap-3 font-black py-5 px-10 rounded-2xl text-xl shadow-2xl">
                <span class="text-3xl">💬</span>
                {{ $isFa ? 'ادامه در واتس‌اپ' : 'Continue on WhatsApp' }}
            </a>
            <div class="mt-8">
                <a href="{{ route('home') }}" class="text-green-600 hover:underline text-sm">{{ $isFa ? '← بازگشت به فروشگاه' : '← Back to Store' }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
