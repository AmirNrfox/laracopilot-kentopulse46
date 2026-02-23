@extends('layouts.app')
@section('title', (app()->getLocale() === 'fa' ? $category->name_fa : $category->name_en) . ' | ' . (app()->getLocale() === 'fa' ? \App\Models\Setting::get('site_name_fa', 'فروشگاه مکمل') : \App\Models\Setting::get('site_name_en', 'Supplement Store')))
@section('meta_description', app()->getLocale() === 'fa' ? $category->description_fa : $category->description_en)

@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-green-600">{{ $isFa ? 'خانه' : 'Home' }}</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-green-600">{{ $isFa ? 'محصولات' : 'Products' }}</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $isFa ? $category->name_fa : $category->name_en }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar --}}
        <aside class="lg:w-52 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow p-4">
                <h3 class="font-black text-gray-800 mb-4">{{ $isFa ? 'دسته‌بندی‌ها' : 'Categories' }}</h3>
                <div class="space-y-1">
                    @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm transition-colors
                               {{ $cat->id === $category->id ? 'bg-green-600 text-white font-bold' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                        <span>{{ $isFa ? $cat->name_fa : $cat->name_en }}</span>
                        <span class="text-xs opacity-60">{{ $cat->products_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-black">{{ $isFa ? $category->name_fa : $category->name_en }}</h1>
                <span class="text-gray-500 text-sm">{{ $products->total() }} {{ $isFa ? 'محصول' : 'products' }}</span>
            </div>
            @if($products->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl">
                <div class="text-5xl mb-3">🔍</div>
                <p class="text-gray-400">{{ $isFa ? 'محصولی یافت نشد' : 'No products found' }}</p>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $product)
                    @include('partials.product-card', compact('product', 'paymentEnabled', 'whatsappNumber'))
                @endforeach
            </div>
            <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
