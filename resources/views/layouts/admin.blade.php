<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | پنل مدیریت</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    {{-- ── Sidebar ──────────────────────────────────────────────────────── --}}
    <aside class="bg-admin-sidebar w-64 min-h-screen flex flex-col flex-shrink-0">
        {{-- Brand --}}
        <div class="p-6 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-white">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-2xl">💪</div>
                <div>
                    <div class="font-black text-sm">پنل مدیریت</div>
                    <div class="text-green-300 text-xs">فروشگاه مکمل</div>
                </div>
            </a>
        </div>

        {{-- Admin info --}}
        <div class="px-4 py-3 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 avatar-gradient rounded-full flex items-center justify-center text-white font-black text-sm">
                    {{ mb_substr(session('admin_user', 'A'), 0, 1) }}
                </div>
                <div>
                    <div class="text-white text-sm font-bold">{{ session('admin_user', 'Admin') }}</div>
                    <div class="text-green-300 text-xs">مدیر سیستم</div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 admin-sidebar-scroll overflow-y-auto">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',        'icon' => '📊', 'label' => 'داشبورد'],
                    ['route' => 'admin.products.index',   'icon' => '📦', 'label' => 'محصولات'],
                    ['route' => 'admin.categories.index', 'icon' => '🗂', 'label' => 'دسته‌بندی‌ها'],
                    ['route' => 'admin.orders.index',     'icon' => '🛒', 'label' => 'سفارشات'],
                    ['route' => 'admin.users.index',      'icon' => '👥', 'label' => 'کاربران'],
                    ['route' => 'admin.coupons.index',    'icon' => '🎟', 'label' => 'کوپن‌ها'],
                    ['route' => 'admin.reviews',          'icon' => '⭐', 'label' => 'نظرات'],
                    ['route' => 'admin.settings.index',   'icon' => '⚙️', 'label' => 'تنظیمات'],
                ];
            @endphp
            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                      {{ request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*')
                         ? 'bg-white/20 text-white font-bold'
                         : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                <span>{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
            @endforeach
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-300 hover:bg-white/10 hover:text-red-200 transition-all">
                    🚪 <span>خروج از پنل</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main Area ──────────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Top bar --}}
        <header class="bg-white border-b shadow-sm px-6 py-4 flex items-center justify-between sticky top-0 z-30">
            <h1 class="text-xl font-black text-gray-800">@yield('page-title', 'داشبورد')</h1>
            <div class="flex items-center gap-4">
                @livewire('admin-stock-alert')
                <a href="{{ route('home') }}" target="_blank"
                   class="text-xs text-gray-500 hover:text-green-700 border border-gray-200 px-3 py-1.5 rounded-lg">
                    🌐 مشاهده سایت
                </a>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('success'))
        <div class="bg-green-50 border-b border-green-200 text-green-700 text-sm px-6 py-2">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border-b border-red-200 text-red-700 text-sm px-6 py-2">❌ {{ session('error') }}</div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <footer class="text-center text-xs text-gray-400 py-4 border-t">
            © {{ date('Y') }} فروشگاه مکمل ورزشی — Made with ❤️ by
            <a href="https://laracopilot.com" target="_blank" class="text-green-600 hover:underline">LaraCopilot</a>
        </footer>
    </div>
</div>

@livewireScripts
@yield('scripts')
</body>
</html>
