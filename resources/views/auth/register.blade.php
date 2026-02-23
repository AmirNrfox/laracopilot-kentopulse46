@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'ثبت نام' : 'Register')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-700 to-green-900 p-8 text-white text-center">
                <div class="text-5xl mb-3">💪</div>
                <h1 class="text-2xl font-black">{{ $isFa ? 'ثبت نام' : 'Create Account' }}</h1>
                <p class="text-green-200 text-sm mt-1">{{ $isFa ? 'عضو خانواده ما شوید' : 'Join our community' }}</p>
            </div>
            <div class="p-8">
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5">
                    @foreach($errors->all() as $error)<div>❌ {{ $error }}</div>@endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'نام کامل *' : 'Full Name *' }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('name') border-red-400 @enderror">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'ایمیل *' : 'Email *' }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'شماره موبایل' : 'Phone' }}</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'رمز عبور *' : 'Password *' }}</label>
                            <input type="password" name="password" required
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('password') border-red-400 @enderror">
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'تکرار رمز عبور *' : 'Confirm Password *' }}</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-3.5 rounded-xl transition-colors">
                            {{ $isFa ? '✅ ثبت نام' : '✅ Create Account' }}
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 mt-6">
                    {{ $isFa ? 'قبلاً ثبت نام کرده‌اید؟' : 'Already have an account?' }}
                    <a href="{{ route('login') }}" class="text-green-600 hover:underline font-bold">
                        {{ $isFa ? 'وارد شوید' : 'Sign In' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
