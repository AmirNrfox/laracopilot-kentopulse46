@extends('layouts.app')
@section('title', '500 - ' . (app()->getLocale() === 'fa' ? 'خطای سرور' : 'Server Error'))
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="text-center">
        <div class="text-8xl font-black text-gray-200 mb-4">500</div>
        <div class="text-6xl mb-6">⚙️</div>
        <h1 class="text-3xl font-black text-gray-800 mb-3">{{ $isFa ? 'خطای داخلی سرور' : 'Internal Server Error' }}</h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">{{ $isFa ? 'مشکلی پیش آمده. تیم ما در حال بررسی است. لطفاً کمی صبر کنید.' : 'Something went wrong. Our team is investigating. Please try again shortly.' }}</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('home') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl">🏠 {{ $isFa ? 'صفحه اصلی' : 'Go Home' }}</a>
            {{-- Replaced: style="background:#25D366" → .btn-whatsapp --}}
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '989123456789') }}" target="_blank"
               class="btn-whatsapp font-bold py-3 px-8 rounded-xl">💬 {{ $isFa ? 'پشتیبانی' : 'Support' }}</a>
        </div>
    </div>
</div>
@endsection
