<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" class="">
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
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')">
    @endif

    {{-- Dark mode init (before page renders to avoid flash) --}}
    <script>
        (function() {
            var saved = localStorage.getItem('darkMode');
            if (saved === 'true' || (saved === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Analytics --}}
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
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-200">

{{-- ── Navigation ──────────────────────────────────────────────────────────── --}}
@php
    $isFa       = app()->getLocale() === 'fa';
    $siteName   = $isFa ? \App\Models\Setting::get('site_name_fa', 'فروشگاه مکمل') : \App\Models\Setting::get('site_name_en', 'Supplement Store');
    $wNumber    = \App\Models\Setting::get('whatsapp_number', '989123456789');
    $pEnabled   = \App\Models\Setting::get('payment_enabled', '1');
@endphp
<nav class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 shadow-sm sticky top-0 z-50 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-black text-xl text-green-700 dark:text-green-400">
                <span class="text-2xl">💪</span>
                <span class="hidden sm:inline">{{ $siteName }}</span>
            </a>

            {{-- Search (Livewire) --}}
            <div class="flex-1 max-w-xs mx-4 hidden md:block">
                @livewire('product-search')
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Dark mode toggle --}}
                <button onclick="toggleDarkMode()" title="{{ $isFa ? 'تغییر پوسته' : 'Toggle theme' }}"
                        class="w-9 h-9 rounded-xl border border-gray-200 dark:border-gray-600 flex items-center justify-center hover:border-green-400 transition-colors dark:text-gray-300"
                        id="dark-toggle">
                    <span id="dark-icon">🌙</span>
                </button>

                {{-- Language switcher --}}
                <a href="{{ route('lang.switch', $isFa ? 'en' : 'fa') }}"
                   class="text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-green-400 hover:text-green-700 dark:text-gray-300 dark:hover:text-green-400 transition-colors">
                    {{ $isFa ? 'EN' : 'FA' }}
                </a>

                {{-- WhatsApp quick link --}}
                <a href="https://wa.me/{{ $wNumber }}" target="_blank"
                   class="btn-whatsapp hidden sm:flex items-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl">
                    💬 {{ $isFa ? 'مشاوره' : 'Consult' }}
                </a>

                {{-- Wishlist --}}
                <a href="{{ route('wishlist.index') }}" title="{{ $isFa ? 'علاقه‌مندی‌ها' : 'Wishlist' }}"
                   class="relative w-9 h-9 flex items-center justify-center text-gray-500 dark:text-gray-300 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </a>

                {{-- Cart --}}
                @livewire('cart-counter')

                {{-- User menu --}}
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-9 h-9 rounded-full avatar-gradient flex items-center justify-center text-white font-black text-sm">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute {{ $isFa ? 'left' : 'right' }}-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border dark:border-gray-700 py-2 z-50">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-200">👤 {{ $isFa ? 'پروفایل' : 'Profile' }}</a>
                        <a href="{{ route('orders.my') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-200">📦 {{ $isFa ? 'سفارشات' : 'Orders' }}</a>
                        <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-200">❤️ {{ $isFa ? 'علاقه‌مندی‌ها' : 'Wishlist' }}</a>
                        <hr class="my-1 dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-{{ $isFa ? 'right' : 'left' }} px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">🚪 {{ $isFa ? 'خروج' : 'Logout' }}</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-green-700 dark:text-green-400 hover:underline">
                    {{ $isFa ? 'ورود' : 'Login' }}
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition
     class="bg-green-50 dark:bg-green-900/30 border-b border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm px-4 py-2.5 flex items-center justify-between">
    <span>✅ {{ session('success') }}</span>
    <button @click="show = false" class="opacity-50 hover:opacity-100 text-lg leading-none">×</button>
</div>
@endif
@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-transition
     class="bg-red-50 dark:bg-red-900/30 border-b border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm px-4 py-2.5 flex items-center justify-between">
    <span>❌ {{ session('error') }}</span>
    <button @click="show = false" class="opacity-50 hover:opacity-100 text-lg leading-none">×</button>
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
                <a href="{{ route('home') }}" class="block hover:text-white transition-colors">{{ $isFa ? 'صفحه اصلی' : 'Home' }}</a>
                <a href="{{ route('products.index') }}" class="block hover:text-white transition-colors">{{ $isFa ? 'محصولات' : 'Products' }}</a>
                <a href="{{ route('wishlist.index') }}" class="block hover:text-white transition-colors">{{ $isFa ? 'علاقه‌مندی‌ها' : 'Wishlist' }}</a>
                <a href="{{ route('cart.index') }}" class="block hover:text-white transition-colors">{{ $isFa ? 'سبد خرید' : 'Cart' }}</a>
                @guest <a href="{{ route('login') }}" class="block hover:text-white transition-colors">{{ $isFa ? 'ورود' : 'Login' }}</a>@endguest
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
    </div>
</footer>

@livewireScripts
@yield('scripts')

<script>
function toggleDarkMode() {
    var html = document.documentElement;
    html.classList.toggle('dark');
    var isDark = html.classList.contains('dark');
    localStorage.setItem('darkMode', isDark);
    document.getElementById('dark-icon').textContent = isDark ? '☀️' : '🌙';
}
document.addEventListener('DOMContentLoaded', function() {
    var isDark = document.documentElement.classList.contains('dark');
    var icon = document.getElementById('dark-icon');
    if (icon) icon.textContent = isDark ? '☀️' : '🌙';
});
</script>
</body>
</html>
