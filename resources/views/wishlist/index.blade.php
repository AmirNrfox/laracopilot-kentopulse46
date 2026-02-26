@extends('layouts.app')

@section('title', $isFa ? 'علاقه‌مندی‌های من' : 'My Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-black text-gray-900">
            ❤️ {{ $isFa ? 'علاقه‌مندی‌های من' : 'My Wishlist' }}
        </h1>
        <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-800 font-medium text-sm">
            {{ $isFa ? '← ادامه خرید' : '← Continue Shopping' }}
        </a>
    </div>

    @if($wishlistItems->isEmpty())
    <div class="text-center py-20">
        <div class="text-8xl mb-6">🤍</div>
        <h2 class="text-2xl font-bold text-gray-600 mb-4">
            {{ $isFa ? 'لیست علاقه‌مندی‌های شما خالی است' : 'Your wishlist is empty' }}
        </h2>
        <p class="text-gray-400 mb-8">
            {{ $isFa ? 'محصولات موردعلاقه‌تان را ذخیره کنید و بعداً خرید کنید.' : 'Save products you love and buy them later.' }}
        </p>
        <a href="{{ route('products.index') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl transition-colors">
            🛍️ {{ $isFa ? 'مشاهده محصولات' : 'Browse Products' }}
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($wishlistItems as $item)
            @if($item->product)
                @include('partials.product-card', [
                    'product' => $item->product,
                    'paymentEnabled' => $paymentEnabled,
                    'whatsappNumber' => $whatsappNumber,
                ])
            @endif
        @endforeach
    </div>
    @endif
</div>
@endsection
