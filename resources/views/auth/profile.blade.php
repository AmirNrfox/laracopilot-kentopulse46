@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'پروفایل من' : 'My Profile')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-black mb-8">👤 {{ $isFa ? 'پروفایل من' : 'My Profile' }}</h1>

    <div class="bg-white rounded-2xl shadow p-8">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            @foreach($errors->all() as $e)<div>❌ {{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'نام کامل *' : 'Full Name *' }}</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'ایمیل' : 'Email' }}</label>
                    <input type="email" value="{{ $user->email }}" disabled
                        class="w-full border-2 rounded-xl px-4 py-3 bg-gray-50 text-gray-400" dir="ltr">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'شماره موبایل' : 'Phone' }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div class="border-t pt-5">
                    <p class="text-sm text-gray-500 mb-4">{{ $isFa ? 'برای تغییر رمز عبور پر کنید، در غیر این صورت خالی بگذارید' : 'Fill to change password, leave empty otherwise' }}</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'رمز عبور جدید' : 'New Password' }}</label>
                            <input type="password" name="password"
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'تکرار رمز عبور' : 'Confirm Password' }}</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                    </div>
                </div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-black py-3 px-8 rounded-xl transition-colors">
                    💾 {{ $isFa ? 'ذخیره تغییرات' : 'Save Changes' }}
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('orders.my') }}" class="bg-white rounded-xl shadow px-6 py-4 flex items-center gap-3 hover:shadow-md transition-shadow">
            <span class="text-2xl">📦</span>
            <span class="font-bold text-sm">{{ $isFa ? 'سفارشات من' : 'My Orders' }}</span>
        </a>
    </div>
</div>
@endsection
