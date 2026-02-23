@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'ورود به حساب' : 'Login')
@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-700 to-green-900 p-8 text-white text-center">
                <div class="text-5xl mb-3">💪</div>
                <h1 class="text-2xl font-black">{{ $isFa ? 'ورود به حساب کاربری' : 'Sign In' }}</h1>
                <p class="text-green-200 text-sm mt-1">{{ $isFa ? 'خوش آمدید!' : 'Welcome back!' }}</p>
            </div>
            <div class="p-8">
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5">❌ {{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'ایمیل' : 'Email' }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500 @error('email') border-red-400 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'رمز عبور' : 'Password' }}</label>
                            <input type="password" name="password" required
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500">
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 accent-green-600">
                            <span class="text-sm text-gray-600">{{ $isFa ? 'مرا به خاطر بسپار' : 'Remember me' }}</span>
                        </label>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-3.5 rounded-xl transition-colors">
                            {{ $isFa ? '🔐 ورود' : '🔐 Sign In' }}
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 mt-6">
                    {{ $isFa ? 'حساب ندارید؟' : "Don't have an account?" }}
                    <a href="{{ route('register') }}" class="text-green-600 hover:underline font-bold">
                        {{ $isFa ? 'ثبت نام کنید' : 'Register' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
