<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Replaced all inline style attributes → custom CSS classes --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
        {{-- Replaced: style="background-image:linear-gradient(to right,#15803d,#14532d)" → .bg-admin-header --}}
        <div class="bg-admin-header p-8 text-white text-center">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3 text-4xl">💪</div>
            <h1 class="text-2xl font-black">پنل مدیریت</h1>
            <p class="text-green-200 text-sm mt-1">فروشگاه مکمل ورزشی</p>
        </div>
        <div class="p-8">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5">❌ {{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="input-ltr w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500 text-sm"
                            placeholder="admin@supplement.store">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
                        <input type="password" name="password" required
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500 text-sm"
                            placeholder="••••••••">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-3.5 rounded-xl transition-colors text-lg">
                        🔐 ورود به پنل
                    </button>
                </div>
            </form>
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-700">
                <div class="font-bold mb-1">🔑 اطلاعات ورود آزمایشی:</div>
                <div>ایمیل: <code class="bg-blue-100 px-1 rounded">admin@supplement.store</code></div>
                <div>رمز: <code class="bg-blue-100 px-1 rounded">admin123</code></div>
            </div>
        </div>
    </div>
    <p class="text-center text-gray-500 text-xs mt-4">Made with ❤️ by <a href="https://laracopilot.com" target="_blank" class="text-green-400 hover:underline">LaraCopilot</a></p>
</div>
</body>
</html>
