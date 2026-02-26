@extends('layouts.app')

@section('title', app()->getLocale() === 'fa' ? \App\Models\Setting::get('seo_title_fa', 'فروشگاه مکمل ورزشی | خرید مکمل اصل') : \App\Models\Setting::get('seo_title_en', 'Sports Supplement Store | Buy Original Supplements'))
@section('meta_description', app()->getLocale() === 'fa' ? \App\Models\Setting::get('seo_description_fa', '') : \App\Models\Setting::get('seo_description_en', ''))
@section('meta_keywords', \App\Models\Setting::get('seo_keywords', ''))

@section('schema_markup')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ app()->getLocale() === 'fa' ? \App\Models\Setting::get('site_name_fa','فروشگاه مکمل') : \App\Models\Setting::get('site_name_en','Supplement Store') }}",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ route('products.search') }}?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endsection

@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp

{{-- ══ HERO ══ --}}
{{-- Replaced: style="background:linear-gradient(135deg,#0f2027 0%,#1a4731 50%,#0f2027 100%)" → .bg-hero --}}
<section class="bg-hero relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        {{-- Replaced: style="background:rgba(74,222,128,...) / rgba(34,211,238,... )" → Tailwind bg-green-400/20 --}}
        <div class="absolute top-20 w-72 h-72 bg-green-400/20 rounded-full filter blur-3xl {{ $isFa ? 'left-10' : 'right-10' }}"></div>
        <div class="absolute bottom-10 w-96 h-96 bg-blue-400/20 rounded-full filter blur-3xl {{ $isFa ? 'right-10' : 'left-10' }}"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 text-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/30 rounded-full px-4 py-2 text-green-300 text-sm mb-6">
                    ⚡ {{ $isFa ? 'مکمل‌های ورزشی اصل و تضمینی' : 'Authentic & Guaranteed Sports Supplements' }}
                </div>
                <h1 class="text-4xl lg:text-6xl font-black leading-tight mb-6">
                    {{ $isFa ? 'به هدفت' : 'Reach Your' }}<br>
                    {{-- Replaced: style="background:linear-gradient(to right,#4ade80,#22d3ee);-webkit-background-clip:text..." → .text-gradient-green-cyan --}}
                    <span class="text-gradient-green-cyan">
                        {{ $isFa ? 'برس! 💪' : 'Goal! 💪' }}
                    </span>
                </h1>
                <p class="text-gray-300 text-lg leading-relaxed mb-8">
                    {{ $isFa ? 'بهترین مکمل‌های ورزشی با ضمانت اصالت، قیمت مناسب و ارسال سریع.' : 'Best sports supplements with authenticity guarantee, competitive prices and fast delivery.' }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}"
                       class="bg-green-500 hover:bg-green-400 text-white font-black py-4 px-8 rounded-2xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-green-500/30">
                        🛍️ {{ $isFa ? 'مشاهده محصولات' : 'View Products' }}
                    </a>
                    @if(!$paymentEnabled)
                    {{-- Replaced: style="background:#25D366" → .btn-whatsapp --}}
                    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank"
                       class="btn-whatsapp flex items-center gap-2 font-bold py-4 px-8 rounded-2xl">
                        💬 {{ $isFa ? 'مشاوره واتس‌اپ' : 'WhatsApp Consult' }}
                    </a>
                    @endif
                </div>
                <div class="flex gap-8 mt-10">
                    <div class="text-center">
                        <div class="text-3xl font-black text-green-400">+500</div>
                        <div class="text-gray-400 text-sm mt-1">{{ $isFa ? 'محصول' : 'Products' }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-cyan-400">+10K</div>
                        <div class="text-gray-400 text-sm mt-1">{{ $isFa ? 'مشتری راضی' : 'Happy Customers' }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-yellow-400">100%</div>
                        <div class="text-gray-400 text-sm mt-1">{{ $isFa ? 'اصل تضمینی' : 'Authentic' }}</div>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex justify-center">
                <div class="relative">
                    {{-- Replaced: style="background:linear-gradient(... )" on decorative circles → .hero-circle-outer / .hero-circle-inner --}} 
                    <div class="hero-circle-outer w-80 h-80 rounded-full flex items-center justify-center">
                        <div class="hero-circle-inner w-60 h-60 rounded-full flex items-center justify-center">
                            <span class="text-9xl">💪</span>
                        </div>
                    </div>
                    <div class="absolute -top-4 bg-yellow-400 text-gray-900 font-black px-3 py-1 rounded-full text-sm shadow-lg {{ $isFa ? '-left-4' : '-right-4' }}">
                        {{ $isFa ? 'ارسال رایگان' : 'Free Shipping' }}
                    </div>
                    <div class="absolute -bottom-4 bg-green-500 text-white font-black px-3 py-1 rounded-full text-sm shadow-lg {{ $isFa ? '-right-4' : '-left-4' }}">
                        {{ $isFa ? '۱۰٪ تخفیف اول' : '10% First Order' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Trust Badges --}}
<section class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-3 p-2"><span class="text-3xl">🚚</span><div><div class="font-bold text-sm text-gray-900">{{ $isFa ? 'ارسال سریع' : 'Fast Delivery' }}</div><div class="text-xs text-gray-500">{{ $isFa ? '۱-۳ روز کاری' : '1-3 business days' }}</div></div></div>
            <div class="flex items-center gap-3 p-2"><span class="text-3xl">🔒</span><div><div class="font-bold text-sm text-gray-900">{{ $isFa ? 'پرداخت امن' : 'Secure Payment' }}</div><div class="text-xs text-gray-500">{{ $isFa ? 'درگاه زرین‌پال' : 'ZarinPal Gateway' }}</div></div></div>
            <div class="flex items-center gap-3 p-2"><span class="text-3xl">✅</span><div><div class="font-bold text-sm text-gray-900">{{ $isFa ? 'ضمانت اصالت' : 'Authenticity Guarantee' }}</div><div class="text-xs text-gray-500">{{ $isFa ? '۱۰۰٪ اصل' : '100% Original' }}</div></div></div>
            <div class="flex items-center gap-3 p-2"><span class="text-3xl">💬</span><div><div class="font-bold text-sm text-gray-900">{{ $isFa ? 'پشتیبانی ۲۴/۷' : '24/7 Support' }}</div><div class="text-xs text-gray-500">{{ $isFa ? 'واتس‌اپ و تلفن' : 'WhatsApp & Phone' }}</div></div></div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-gray-900">{{ $isFa ? 'دسته‌بندی محصولات' : 'Product Categories' }}</h2>
            <p class="text-gray-500 mt-2">{{ $isFa ? 'هر آنچه برای تمرین بهتر نیاز داری' : 'Everything you need for better training' }}</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php $catIcons = ['protein'=>'🥤','creatine'=>'💊','pre-workout'=>'⚡','vitamins'=>'🌿','amino-acids'=>'🔬','fat-burners'=>'🔥']; @endphp
            @foreach($categories as $cat)
            <a href="{{ route('category.show', $cat->slug) }}"
               class="group bg-white rounded-2xl p-5 text-center shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-green-200">
                <div class="text-4xl mb-3">{{ $catIcons[$cat->slug] ?? '💪' }}</div>
                <div class="font-bold text-sm text-gray-800">{{ $isFa ? $cat->name_fa : $cat->name_en }}</div>
                <div class="text-xs text-gray-400 mt-1">{{ $cat->products_count }} {{ $isFa ? 'محصول' : 'products' }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-black text-gray-900">⭐ {{ $isFa ? 'محصولات ویژه' : 'Featured Products' }}</h2>
                <p class="text-gray-500 mt-1">{{ $isFa ? 'پرفروش‌ترین و محبوب‌ترین مکمل‌ها' : 'Best-selling supplements' }}</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-800 font-medium text-sm">{{ $isFa ? 'همه محصولات ←' : '→ All Products' }}</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', compact('product', 'paymentEnabled', 'whatsappNumber'))
            @endforeach
        </div>
    </div>
</section>

{{-- WhatsApp CTA (payment disabled) --}}
@if(!$paymentEnabled)
{{-- Replaced: style="background:linear-gradient(135deg,#1da851,#25D366)" → .bg-whatsapp-gradient --}}
<section class="bg-whatsapp-gradient py-16 text-white">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <div class="text-6xl mb-4">💬</div>
        <h2 class="text-4xl font-black mb-4">{{ $isFa ? 'خرید از طریق واتس‌اپ' : 'Buy via WhatsApp' }}</h2>
        <p class="text-green-100 text-lg mb-8">{{ $isFa ? 'برای سفارش و مشاوره رایگان با ما در واتس‌اپ در تماس باشید' : 'Contact us on WhatsApp for orders and free consultation' }}</p>
        {{-- Replaced: style="background:..." on large CTA → .btn-whatsapp-lg --}}
        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank"
           class="btn-whatsapp-lg inline-flex items-center gap-3 font-black py-5 px-10 rounded-2xl text-xl shadow-2xl">
            <span class="text-3xl">💬</span>
            {{ $isFa ? 'ارتباط در واتس‌اپ' : 'Contact on WhatsApp' }}
        </a>
    </div>
</section>
@endif

{{-- Sale Products --}}
@if($saleProducts->count())
<section class="py-14 bg-red-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-black text-gray-900 mb-10">🔥 {{ $isFa ? 'تخفیف ویژه' : 'Special Offers' }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($saleProducts as $product)
                @include('partials.product-card', compact('product', 'paymentEnabled', 'whatsappNumber'))
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Why Us --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12"><h2 class="text-3xl font-black">{{ $isFa ? 'چرا ما؟' : 'Why Choose Us?' }}</h2></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all">
                <div class="text-5xl mb-4">🏆</div>
                <h3 class="text-xl font-bold mb-3">{{ $isFa ? 'برندهای معتبر' : 'Trusted Brands' }}</h3>
                <p class="text-gray-500">{{ $isFa ? 'تنها برندهای معتبر جهانی مانند Optimum Nutrition، Dymatize' : 'Only globally trusted brands like Optimum Nutrition, Dymatize' }}</p>
            </div>
            <div class="text-center p-8 rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all">
                <div class="text-5xl mb-4">💰</div>
                <h3 class="text-xl font-bold mb-3">{{ $isFa ? 'بهترین قیمت' : 'Best Prices' }}</h3>
                <p class="text-gray-500">{{ $isFa ? 'قیمت‌های رقابتی با تخفیف‌های دوره‌ای و کوپن‌های ویژه' : 'Competitive prices with periodic discounts and special coupons' }}</p>
            </div>
            <div class="text-center p-8 rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all">
                <div class="text-5xl mb-4">🚀</div>
                <h3 class="text-xl font-bold mb-3">{{ $isFa ? 'ارسال سریع' : 'Fast Shipping' }}</h3>
                <p class="text-gray-500">{{ $isFa ? 'بسته‌بندی اختصاصی و ارسال در کمتر از ۷۲ ساعت' : 'Special packaging and delivery in less than 72 hours' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12"><h2 class="text-3xl font-black">💬 {{ $isFa ? 'نظرات مشتریان' : 'Customer Reviews' }}</h2></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow">
                <div class="flex text-yellow-400 text-xl mb-3">★★★★★</div>
                <p class="text-gray-600 leading-relaxed mb-4">"{{ $isFa ? 'پروتئین گلد استاندارد که خریدم کاملاً اصل بود. بسته‌بندی عالی و ارسال سریع!' : 'The Gold Standard protein was completely authentic. Excellent packaging and fast shipping!' }}"</p>
                <div class="flex items-center gap-3">
                    {{-- Replaced: style="background:linear-gradient(...)" → .avatar-gradient --}}
                    <div class="w-10 h-10 avatar-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">{{ $isFa ? 'ع' : 'A' }}</div>
                    <div class="font-bold">{{ $isFa ? 'علی محمدی' : 'Ali M.' }}</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow">
                <div class="flex text-yellow-400 text-xl mb-3">★★★★★</div>
                <p class="text-gray-600 leading-relaxed mb-4">"{{ $isFa ? 'کراتین با کیفیت خوب و قیمت مناسب. پشتیبانی واتس‌اپ هم خیلی سریع جواب داد.' : 'Good quality creatine at reasonable price. WhatsApp support responded very quickly.' }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 avatar-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">{{ $isFa ? 'س' : 'S' }}</div>
                    <div class="font-bold">{{ $isFa ? 'سارا احمدی' : 'Sara A.' }}</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow">
                <div class="flex text-yellow-400 text-xl mb-3">★★★★★</div>
                <p class="text-gray-600 leading-relaxed mb-4">"{{ $isFa ? 'از این فروشگاه چندین بار خرید کردم. همیشه محصولات اصل و قیمت‌ها رقابتی بود.' : 'Bought multiple times. Always authentic products and competitive prices.' }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 avatar-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">{{ $isFa ? 'ر' : 'R' }}</div>
                    <div class="font-bold">{{ $isFa ? 'رضا کریمی' : 'Reza K.' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
