@extends('layouts.app')
@section('title', '404 - ' . (app()->getLocale() === 'fa' ? 'صفحه یافت نشد' : 'Page Not Found'))
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="text-center">
        <div class="text-8xl font-black text-gray-200 mb-4">404</div>
        <div class="text-6xl mb-6">🔍</div>
        <h1 class="text-3xl font-black text-gray-800 mb-3">{{ $isFa ? 'صفحه یافت نشد' : 'Page Not Found' }}</h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            {{ $isFa ? 'صفحه‌ای که دنبالش می‌گردید وجود ندارد یا جابجا شده است.' : 'The page you are looking for does not exist or has been moved.' }}
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('home') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl">🏠 {{ $isFa ? 'صفحه اصلی' : 'Go Home' }}</a>
            <a href="{{ route('products.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl">🛍️ {{ $isFa ? 'محصولات' : 'Products' }}</a>
        </div>
    </div>
</div>
@endsection
