@extends('layouts.app')

@section('title', $product->name . ' | ' . (app()->getLocale() === 'fa' ? \App\Models\Setting::get('site_name_fa') : \App\Models\Setting::get('site_name_en')))
@section('meta_description', $product->short_description ?: ($product->name . ' - ' . $product->brand))
@section('meta_keywords', $product->name_fa . ', ' . $product->name_en . ', ' . $product->brand . ', مکمل ورزشی')
@section('og_title', $product->name)
@section('og_description', $product->short_description)
@section('og_image', $product->image_url)

@section('schema_markup')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ addslashes($product->name) }}",
    "description": "{{ addslashes($product->short_description) }}",
    "image": "{{ $product->image_url }}",
    "sku": "{{ $product->sku }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ $product->brand }}"
    },
    "offers": {
        "@type": "Offer",
        "price": "{{ $product->final_price }}",
        "priceCurrency": "IRR",
        "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "priceValidUntil": "{{ now()->addYear()->format('Y-m-d') }}",
        "seller": {
            "@type": "Organization",
            "name": "{{ app()->getLocale() === 'fa' ? \App\Models\Setting::get('site_name_fa', 'فروشگاه مکمل') : \App\Models\Setting::get('site_name_en', 'Supplement Store') }}"
        }
    }
    @if($product->reviews->count())
    ,"aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ number_format($product->average_rating, 1) }}",
        "reviewCount": "{{ $product->reviews->count() }}",
        "bestRating": "5",
        "worstRating": "1"
    }
    ,"review": [
        @foreach($product->reviews->take(5) as $review)
        {
            "@type": "Review",
            "author": { "@type": "Person", "name": "{{ addslashes($review->name) }}" },
            "datePublished": "{{ $review->created_at->format('Y-m-d') }}",
            "reviewBody": "{{ addslashes($review->comment) }}",
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "{{ $review->rating }}",
                "bestRating": "5"
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
    @endif
}
</script>
@endsection

@section('content')
@php
    $isFa = app()->getLocale() === 'fa';
    $locale = app()->getLocale();
@endphp
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-8" aria-label="breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-green-600">{{ $isFa ? 'خانه' : 'Home' }}</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-green-600">{{ $isFa ? 'محصولات' : 'Products' }}</a>
        @if($product->category)
        <span>/</span>
        <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-green-600">{{ $isFa ? $product->category->name_fa : $product->category->name_en }}</a>
        @endif
        <span>/</span>
        <span class="text-gray-900 dark:text-gray-200 font-medium truncate">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        {{-- Images --}}
        <div>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl overflow-hidden h-96 flex items-center justify-center mb-4 relative group">
                <img id="main-image" src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="max-h-full max-w-full object-contain p-8 transition-all duration-500 group-hover:scale-105"
                     onerror="this.src='data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"200\" height=\"200\"><rect fill=\"%23f3f4f6\" width=\"200\" height=\"200\"/><text x=\"50%25\" y=\"50%25\" text-anchor=\"middle\" dy=\".3em\" font-size=\"60\">💪</text></svg>'">
                {{-- Wishlist on product page --}}
                <div class="absolute top-4 {{ $isFa ? 'left' : 'right' }}-4">
                    @livewire('wishlist-button', ['productId' => $product->id])
                </div>
            </div>
            @if($product->images->count())
            <div class="flex gap-3 overflow-x-auto pb-2">
                <button onclick="setImage('{{ $product->image_url }}')" class="w-20 h-20 rounded-xl border-2 border-green-500 overflow-hidden flex-shrink-0 focus:outline-none hover:border-green-600 transition-colors">
                    <img src="{{ $product->image_url }}" class="w-full h-full object-contain p-2">
                </button>
                @foreach($product->images as $img)
                <button onclick="setImage('{{ asset('storage/' . $img->image) }}')" class="w-20 h-20 rounded-xl border-2 border-transparent hover:border-green-400 overflow-hidden flex-shrink-0 focus:outline-none focus:border-green-500 transition-colors">
                    <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-contain p-2">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            @if($product->brand)
            <div class="text-green-600 dark:text-green-400 font-bold text-sm uppercase tracking-widest mb-2">{{ $product->brand }}</div>
            @endif
            <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100 mb-3 leading-tight">{{ $product->name }}</h1>

            {{-- Rating summary --}}
            @if($product->reviews->count())
            <div class="flex items-center gap-3 mb-4">
                <div class="flex text-yellow-400 text-lg">
                    @for($i=1;$i<=5;$i++)
                    <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                    @endfor
                </div>
                <span class="text-gray-500 dark:text-gray-400 text-sm">({{ $product->reviews->count() }} {{ $isFa ? 'نظر' : 'reviews' }}) · {{ number_format($product->average_rating, 1) }}/5</span>
            </div>
            @endif

            @if($product->short_description)
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">{{ $product->short_description }}</p>
            @endif

            {{-- Price block --}}
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 mb-6">
                @if($product->sale_price)
                <div class="flex items-baseline gap-3 flex-wrap">
                    <span class="text-3xl font-black text-red-600">{{ number_format($product->sale_price) }}</span>
                    <span class="text-gray-500 dark:text-gray-400">{{ $isFa ? 'تومان' : 'Toman' }}</span>
                    <span class="text-gray-400 line-through text-lg">{{ number_format($product->price) }}</span>
                    <span class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-black px-2 py-1 rounded-full">
                        %{{ round((($product->price - $product->sale_price) / $product->price) * 100) }} {{ $isFa ? 'تخفیف' : 'OFF' }}
                    </span>
                </div>
                @else
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ number_format($product->price) }}</span>
                    <span class="text-gray-500 dark:text-gray-400">{{ $isFa ? 'تومان' : 'Toman' }}</span>
                </div>
                @endif
                <div class="mt-3 flex items-center gap-2 text-sm {{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-500' }}">
                    <span>{{ $product->stock > 0 ? '✅' : '❌' }}</span>
                    <span class="font-medium">{{ $product->stock > 0 ? ($isFa ? 'موجود در انبار' : 'In Stock') : ($isFa ? 'ناموجود' : 'Out of Stock') }}</span>
                    @if($product->stock > 0 && $product->stock <= 10)
                    <span class="text-orange-500">({{ $isFa ? 'فقط ' . $product->stock . ' عدد' : 'Only ' . $product->stock . ' left' }})</span>
                    @endif
                </div>
            </div>

            {{-- Add to cart / WhatsApp --}}
            @if($paymentEnabled)
                @livewire('add-to-cart', ['product' => $product])
                <div class="mt-3">
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($whatsappMsg . ' - ' . $product->name) }}" target="_blank"
                        class="w-full flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold py-3 px-8 rounded-2xl text-sm transition-all">
                        <span>💬</span> {{ $isFa ? 'مشاوره واتس‌اپ' : 'WhatsApp Consultation' }}
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-3 text-amber-800 dark:text-amber-300 text-sm text-center">
                        ⚠️ {{ $isFa ? 'پرداخت آنلاین موقتاً غیرفعال است. لطفاً از واتس‌اپ سفارش دهید.' : 'Online payment is temporarily disabled. Please order via WhatsApp.' }}
                    </div>
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($whatsappMsg . ' - ' . $product->name) }}" target="_blank"
                        class="w-full flex items-center justify-center gap-3 font-black py-5 px-8 rounded-2xl text-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg btn-whatsapp-lg">
                        <span class="text-3xl">💬</span>
                        {{ $isFa ? 'خرید / مشاوره از واتس‌اپ' : 'Buy / Consult via WhatsApp' }}
                    </a>
                </div>
            @endif

            {{-- Product details --}}
            <div class="border-t dark:border-gray-700 mt-6 pt-6 grid grid-cols-2 gap-3 text-sm text-gray-600 dark:text-gray-400">
                @if($product->sku)<div><span class="text-gray-400">SKU:</span> <span class="font-mono">{{ $product->sku }}</span></div>@endif
                @if($product->weight)<div><span class="text-gray-400">{{ $isFa ? 'وزن' : 'Weight' }}:</span> {{ $product->weight }} kg</div>@endif
                @if($product->category)<div><span class="text-gray-400">{{ $isFa ? 'دسته‌بندی' : 'Category' }}:</span> <a href="{{ route('category.show', $product->category->slug) }}" class="text-green-600 hover:underline">{{ $isFa ? $product->category->name_fa : $product->category->name_en }}</a></div>@endif
            </div>
        </div>
    </div>

    {{-- Description Tabs --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 mb-12" x-data="{ tab: 'desc' }">
        <div class="flex gap-4 mb-6 border-b dark:border-gray-700">
            <button @click="tab='desc'"
                    :class="tab==='desc' ? 'border-b-2 border-green-600 text-green-700 dark:text-green-400 font-bold' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="pb-3 text-sm transition-colors">
                {{ $isFa ? 'توضیحات محصول' : 'Description' }}
            </button>
            @if($product->reviews->count())
            <button @click="tab='reviews'"
                    :class="tab==='reviews' ? 'border-b-2 border-green-600 text-green-700 dark:text-green-400 font-bold' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="pb-3 text-sm transition-colors">
                {{ $isFa ? 'نظرات' : 'Reviews' }} ({{ $product->reviews->count() }})
            </button>
            @endif
        </div>
        <div x-show="tab==='desc'" class="prose max-w-none text-gray-600 dark:text-gray-300 leading-relaxed text-sm">
            @if($product->description)
                {{ $product->description }}
            @else
                <p class="text-gray-400 italic">{{ $isFa ? 'توضیحاتی موجود نیست.' : 'No description available.' }}</p>
            @endif
        </div>
        @if($product->reviews->count())
        <div x-show="tab==='reviews'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($product->reviews as $review)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ mb_substr($review->name, 0, 1) }}</div>
                        <div>
                            <div class="font-bold text-sm dark:text-gray-200">{{ $review->name }}</div>
                            <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="text-yellow-400">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ $review->comment }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Review Form --}}
    <div class="mb-12">
        <h2 class="text-2xl font-black mb-6 dark:text-gray-100">💬 {{ $isFa ? 'ثبت نظر' : 'Write a Review' }}</h2>
        @livewire('review-form', ['productId' => $product->id])
    </div>

    {{-- Related --}}
    @if($related->count())
    <div>
        <h2 class="text-2xl font-black mb-8 dark:text-gray-100">{{ $isFa ? 'محصولات مشابه' : 'Related Products' }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $rp)
            @include('partials.product-card', ['product' => $rp, 'paymentEnabled' => $paymentEnabled, 'whatsappNumber' => $whatsappNumber])
            @endforeach
        </div>
    </div>
    @endif
</div>

@section('scripts')
<script>
function setImage(src) {
    var img = document.getElementById('main-image');
    img.style.opacity = '0';
    img.style.transform = 'scale(0.95)';
    setTimeout(function() {
        img.src = src;
        img.style.opacity = '1';
        img.style.transform = 'scale(1)';
    }, 150);
}
document.addEventListener('DOMContentLoaded', function() {
    var img = document.getElementById('main-image');
    if (img) {
        img.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
    }
});
</script>
@endsection
@endsection
