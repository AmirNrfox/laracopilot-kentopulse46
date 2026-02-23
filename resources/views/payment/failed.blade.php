@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'پرداخت ناموفق' : 'Payment Failed')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-lg mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl shadow-xl p-10 text-center">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6"><span class="text-5xl">❌</span></div>
        <h1 class="text-3xl font-black text-gray-900 mb-3">{{ $isFa ? 'پرداخت ناموفق!' : 'Payment Failed!' }}</h1>
        <p class="text-gray-600 mb-8">{{ $isFa ? 'متأسفانه پرداخت شما تأیید نشد. سفارش شما ذخیره شده و می‌توانید مجدداً تلاش کنید.' : 'Unfortunately your payment was not confirmed. Your order is saved and you can try again.' }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('cart.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl">🔄 {{ $isFa ? 'تلاش مجدد' : 'Try Again' }}</a>
            {{-- Replaced: style="background:#25D366" → .btn-whatsapp --}}
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '989123456789') }}" target="_blank"
               class="btn-whatsapp font-bold py-3 px-8 rounded-xl">💬 {{ $isFa ? 'پشتیبانی واتس‌اپ' : 'WhatsApp Support' }}</a>
            <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl">🏠 {{ $isFa ? 'صفحه اصلی' : 'Home' }}</a>
        </div>
    </div>
</div>
@endsection
