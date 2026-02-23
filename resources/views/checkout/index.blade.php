@extends('layouts.app')
@section('title', app()->getLocale() === 'fa' ? 'تکمیل سفارش' : 'Checkout')

@section('content')
@php $isFa = app()->getLocale() === 'fa'; @endphp
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-black mb-8">🛒 {{ $isFa ? 'تکمیل سفارش' : 'Checkout' }}</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left: Form --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Contact Info --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-black text-lg mb-5">👤 {{ $isFa ? 'اطلاعات تماس' : 'Contact Info' }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'نام *' : 'First Name *' }}</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user?->name ? explode(' ', $user->name)[0] : '') }}" required
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('first_name') border-red-400 @enderror">
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'نام خانوادگی *' : 'Last Name *' }}</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('last_name') border-red-400 @enderror">
                        @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'ایمیل *' : 'Email *' }}</label>
                        <input type="email" name="email" value="{{ old('email', $user?->email) }}" required dir="ltr"
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'موبایل *' : 'Phone *' }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $user?->phone) }}" required
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-black text-lg mb-5">📍 {{ $isFa ? 'آدرس تحویل' : 'Shipping Address' }}</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'استان *' : 'Province *' }}</label>
                            <input type="text" name="province" value="{{ old('province') }}" required
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('province') border-red-400 @enderror">
                            @error('province')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'شهر *' : 'City *' }}</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('city') border-red-400 @enderror">
                            @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'آدرس کامل *' : 'Full Address *' }}</label>
                        <textarea name="address" rows="3" required
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none @error('address') border-red-400 @enderror">{{ old('address') }}</textarea>
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'کد پستی *' : 'Postal Code *' }}</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none max-w-xs @error('postal_code') border-red-400 @enderror">
                        @error('postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFa ? 'توضیحات (اختیاری)' : 'Notes (Optional)' }}</label>
                        <textarea name="notes" rows="2"
                            class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none"
                            placeholder="{{ $isFa ? 'مثلاً: زنگ نزنید، در پستی بگذارید' : 'e.g. Leave at door, do not ring' }}">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-black text-lg mb-5">💳 {{ $isFa ? 'روش پرداخت' : 'Payment Method' }}</h2>
                @if($paymentEnabled)
                <div class="space-y-3">
                    <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer border-green-500 bg-green-50">
                        <input type="radio" name="payment_method" value="zarinpal" checked class="w-5 h-5 accent-green-600">
                        <div>
                            <div class="font-bold">💳 {{ $isFa ? 'درگاه پرداخت آنلاین (زرین‌پال)' : 'Online Payment (ZarinPal)' }}</div>
                            <div class="text-xs text-gray-500">{{ $isFa ? 'پرداخت امن و سریع' : 'Secure and fast payment' }}</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer border-gray-200 hover:border-green-300">
                        <input type="radio" name="payment_method" value="whatsapp" class="w-5 h-5 accent-green-600">
                        <div>
                            <div class="font-bold">💬 {{ $isFa ? 'ثبت سفارش از طریق واتس‌اپ' : 'Order via WhatsApp' }}</div>
                            <div class="text-xs text-gray-500">{{ $isFa ? 'پس از ثبت، با واتس‌اپ پیگیری کنید' : 'After placing, follow up via WhatsApp' }}</div>
                        </div>
                    </label>
                </div>
                @else
                {{-- Payment disabled: only WhatsApp --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4 text-sm text-amber-800">
                    ⚠️ {{ $isFa ? 'درگاه پرداخت آنلاین موقتاً غیرفعال است. سفارش از طریق واتس‌اپ انجام می‌شود.' : 'Online payment is temporarily disabled. Orders are placed via WhatsApp.' }}
                </div>
                <input type="hidden" name="payment_method" value="whatsapp">
                <div class="flex items-center gap-4 p-4 border-2 border-green-500 rounded-xl bg-green-50">
                    <span class="text-3xl">💬</span>
                    <div>
                        <div class="font-bold">{{ $isFa ? 'ثبت سفارش از طریق واتس‌اپ' : 'Order via WhatsApp' }}</div>
                        <div class="text-xs text-gray-500">{{ $isFa ? 'پس از ثبت اطلاعات، شما به واتس‌اپ هدایت می‌شوید' : 'After submitting, you will be redirected to WhatsApp' }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Right: Order Summary --}}
        <div>
            <div class="bg-white rounded-2xl shadow p-6 sticky top-24">
                <h2 class="font-black text-lg mb-5">🧾 {{ $isFa ? 'خلاصه سفارش' : 'Order Summary' }}</h2>
                <div class="space-y-3 mb-5">
                    @foreach($cart as $item)
                    <div class="flex justify-between items-start text-sm">
                        <div class="flex-1 {{ $isFa ? 'ml-2' : 'mr-2' }}">
                            <div class="font-medium line-clamp-1">{{ $isFa ? $item['name_fa'] : $item['name_en'] }}</div>
                            @if($item['variant_info_fa'])
                                <div class="text-gray-400 text-xs">{{ $isFa ? $item['variant_info_fa'] : $item['variant_info_en'] }}</div>
                            @endif
                            <div class="text-gray-400 text-xs">× {{ $item['quantity'] }}</div>
                        </div>
                        <div class="font-bold flex-shrink-0">{{ number_format($item['price'] * $item['quantity']) }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ $isFa ? 'جمع کالاها' : 'Subtotal' }}</span>
                        <span class="font-bold">{{ number_format($subtotal) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-red-600">
                        <span>{{ $isFa ? 'تخفیف' : 'Discount' }}</span>
                        <span class="font-bold">-{{ number_format($discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ $isFa ? 'هزینه ارسال' : 'Shipping' }}</span>
                        <span class="font-bold {{ $shipping === 0 ? 'text-green-600' : '' }}">{{ $shipping > 0 ? number_format($shipping) : '🎁 ' . ($isFa ? 'رایگان' : 'Free') }}</span>
                    </div>
                    <div class="flex justify-between text-lg border-t pt-3">
                        <span class="font-black">{{ $isFa ? 'جمع کل' : 'Total' }}</span>
                        <span class="font-black text-green-600">{{ number_format($total) }} <span class="text-sm font-normal">{{ $isFa ? 'ت' : 'T' }}</span></span>
                    </div>
                </div>

                @if($paymentEnabled)
                <button type="submit" class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-black py-4 rounded-xl text-lg transition-colors shadow-lg shadow-green-500/20">
                    💳 {{ $isFa ? 'ادامه و پرداخت' : 'Continue to Payment' }}
                </button>
                @else
                <button type="submit" class="w-full mt-5 font-black py-4 rounded-xl text-lg transition-all text-white shadow-lg"
                    style="background:linear-gradient(135deg,#1da851,#25D366)">
                    💬 {{ $isFa ? 'ثبت سفارش واتس‌اپ' : 'Place WhatsApp Order' }}
                </button>
                @endif

                <a href="{{ route('cart.index') }}" class="block mt-3 text-center text-sm text-gray-400 hover:text-gray-600">
                    {{ $isFa ? '← بازگشت به سبد خرید' : '← Back to Cart' }}
                </a>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
