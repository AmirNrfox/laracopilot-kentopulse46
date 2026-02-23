<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', app()->getLocale() === 'fa' ? \App\Models\Setting::get('seo_title_fa', 'فروشگاه مکمل ورزشی') : \App\Models\Setting::get('seo_title_en', 'Supplement Store'))</title>
    <meta name="description" content="@yield('meta_description', app()->getLocale() === 'fa' ? \App\Models\Setting::get('seo_description_fa', '') : \App\Models\Setting::get('seo_description_en', ''))">
    <meta name="keywords"      content="@yield('meta_keywords', \App\Models\Setting::get('seo_keywords', ''))">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title"       content="@yield('title')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="website">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Custom CSS (all extracted inline styles) --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    {{-- Alpine.js for interactive components --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Analytics (if configured) --}}
    @php $gaId = \App\Models\Setting::get('google_analytics_id'); @endphp
    @if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
    @endif

    {{-- Schema Markup slot --}}
    @yield('schema_markup')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

{{-- ── Navigation ──────────────────────────────────────────────────────────── --}}
@php
    $isFa       = app()->getLocale() === 'fa';
    $siteName   = $isFa ? \App\Models\Setting::get('site_name_fa', 'فروشگاه مکمل') : \App\Models\Setting::get('site_name_en', 'Supplement Store');
    $wNumber    = \App\Models\Setting::get('whatsapp_number', '989123456789');
    $pEnabled   = \App\Models\Setting::get('payment_enabled', '1');
@endphp
<nav class="bg-white border-b shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-black text-xl text-green-700">
                <span class="text-2xl">💪</span>
                <span class="hidden sm:inline">{{ $siteName }}</span>
            </a>

            {{-- Search (Livewire) --}}
            <div class="flex-1 max-w-xs mx-4 hidden md:block">
                @livewire('product-search')
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                {{-- Language switcher --}}
                <a href="{{ route('lang.switch', $isFa ? 'en' : 'fa') }}"
                   class="text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-200 hover:border-green-400 hover:text-green-700 transition-colors">
                    {{ $isFa ? 'EN' : 'FA' }}
                </a>

                {{-- WhatsApp quick link --}}
                <a href="https://wa.me/{{ $wNumber }}" target="_blank"
                   class="btn-whatsapp hidden sm:flex items-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl">
                    💬 {{ $isFa ? 'مشاوره' : 'Consult' }}
                </a>

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative">
                    <span class="text-2xl">🛒</span>
                    @livewire('cart-counter')
                </a>

                {{-- User menu --}}
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-9 h-9 rounded-full avatar-gradient flex items-center justify-center text-white font-black text-sm">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute {{ $isFa ? 'left' : 'right' }}-0 mt-2 w-44 bg-white rounded-2xl shadow-xl border py-2 z-50">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">👤 {{ $isFa ? 'پروفایل' : 'Profile' }}</a>
                        <a href="{{ route('orders.my') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">📦 {{ $isFa ? 'سفارشات' : 'Orders' }}</a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-right px-4 py-2 text-sm text-red-500 hover:bg-red-50">🚪 {{ $isFa ? 'خروج' : 'Logout' }}</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-green-700 hover:underline">
                    {{ $isFa ? 'ورود' : 'Login' }}
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<div class="bg-green-50 border-b border-green-200 text-green-700 text-sm px-4 py-2 text-center">
    ✅ {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="bg-red-50 border-b border-red-200 text-red-700 text-sm px-4 py-2 text-center">
    ❌ {{ session('error') }}
</div>
@endif

{{-- Main Content --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- ── Footer ───────────────────────────────────────────────────────────────── --}}
@php
    $instagram = \App\Models\Setting::get('instagram', '');
    $telegram  = \App\Models\Setting::get('telegram', '');
    $phone     = \App\Models\Setting::get('site_phone', '');
    $email     = \App\Models\Setting::get('site_email', '');
    $address   = $isFa ? \App\Models\Setting::get('site_address_fa', '') : \App\Models\Setting::get('site_address_en', '');
@endphp
<footer class="bg-gray-900 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-2 font-black text-xl text-green-400 mb-4">
                <span>💪</span><span>{{ $siteName }}</span>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed">
                {{ $isFa ? 'فروش مکمل‌های ورزشی اصل با ضمانت کیفیت و ارسال سریع.' : 'Selling authentic sports supplements with quality guarantee and fast shipping.' }}
            </p>
        </div>
        <div>
            <h4 class="font-black mb-4 text-green-400">{{ $isFa ? 'دسترسی سریع' : 'Quick Links' }}</h4>
            <div class="space-y-2 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="block hover:text-white">{{ $isFa ? 'صفحه اصلی' : 'Home' }}</a>
                <a href="{{ route('products.index') }}" class="block hover:text-white">{{ $isFa ? 'محصولات' : 'Products' }}</a>
                <a href="{{ route('cart.index') }}" class="block hover:text-white">{{ $isFa ? 'سبد خرید' : 'Cart' }}</a>
                @guest <a href="{{ route('login') }}" class="block hover:text-white">{{ $isFa ? 'ورود' : 'Login' }}</a>@endguest
            </div>
        </div>
        <div>
            <h4 class="font-black mb-4 text-green-400">{{ $isFa ? 'تماس با ما' : 'Contact' }}</h4>
            <div class="space-y-2 text-sm text-gray-400">
                @if($phone)<div>📞 {{ $phone }}</div>@endif
                @if($email)<div>📧 {{ $email }}</div>@endif
                @if($address)<div>📍 {{ $address }}</div>@endif
            </div>
        </div>
        <div>
            <h4 class="font-black mb-4 text-green-400">{{ $isFa ? 'شبکه اجتماعی' : 'Social Media' }}</h4>
            <div class="flex gap-3">
                @if($instagram)<a href="{{ $instagram }}" target="_blank" class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center hover:bg-white/20 transition-colors">📸</a>@endif
                @if($telegram)<a href="{{ $telegram }}" target="_blank" class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center hover:bg-white/20 transition-colors">✈️</a>@endif
                <a href="https://wa.me/{{ $wNumber }}" target="_blank" class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center hover:bg-white/20 transition-colors">💬</a>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-800 py-6 text-center text-gray-500 text-sm">
        <p>© {{ date('Y') }} {{ $siteName }}. {{ $isFa ? 'تمام حقوق محفوظ است.' : 'All rights reserved.' }}</p>
        <p class="mt-1">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="text-green-400 hover:underline">LaraCopilot</a></p>
    </div>
</footer>

@livewireScripts
@yield('scripts')
</body>
</html>
