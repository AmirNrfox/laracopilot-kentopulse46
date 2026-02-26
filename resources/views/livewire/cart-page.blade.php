<div>
    @php $isFa = app()->getLocale() === 'fa'; @endphp
    @if(empty($cart))
    <div class="text-center py-20">
        <div class="text-8xl mb-6">🛒</div>
        <h2 class="text-2xl font-bold text-gray-600 dark:text-gray-300 mb-4">{{ $isFa ? 'سبد خرید شما خالی است' : 'Your cart is empty' }}</h2>
        <p class="text-gray-400 mb-8">{{ $isFa ? 'محصولات موردنظر خود را اضافه کنید.' : 'Add some products to get started.' }}</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl transition-colors">{{ $isFa ? '🛍️ مشاهده محصولات' : '🛍️ Browse Products' }}</a>
    </div>
    @else

    {{-- Free shipping progress bar --}}
    @php
        $freeMin = (int) \App\Models\Setting::get('free_shipping_min', 1000000);
        $progress = $subtotal >= $freeMin ? 100 : round(($subtotal / $freeMin) * 100);
        $remaining = max(0, $freeMin - $subtotal);
    @endphp
    @if($shipping > 0 && $freeMin > 0)
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-2xl p-4 mb-6">
        <div class="flex justify-between text-sm mb-2">
            <span class="text-green-700 dark:text-green-400 font-bold">
                🚚 {{ $isFa ? 'تا ارسال رایگان' : 'Until free shipping' }}:
                {{ number_format($remaining) }} {{ $isFa ? 'تومان' : 'T' }}
            </span>
            <span class="text-green-600 dark:text-green-400 font-bold">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-green-100 dark:bg-green-900/50 rounded-full h-2.5">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
        </div>
    </div>
    @elseif($shipping === 0)
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl p-4 mb-6 text-center text-green-700 dark:text-green-400 font-bold text-sm">
        🎉 {{ $isFa ? 'تبریک! ارسال رایگان برای شما فعال است.' : 'Congrats! Free shipping is active for you.' }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart as $key => $item)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 flex gap-5 items-start transition-all duration-300 hover:shadow-md">
                <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ $item['image'] }}" alt="" class="w-full h-full object-contain p-2" onerror="this.style.display='none'">
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('products.show', $item['slug']) }}" class="font-bold text-gray-900 dark:text-gray-100 hover:text-green-600 dark:hover:text-green-400 line-clamp-2">
                        {{ $isFa ? $item['name_fa'] : $item['name_en'] }}
                    </a>
                    @if($item['variant_info_fa'])
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $isFa ? $item['variant_info_fa'] : $item['variant_info_en'] }}</div>
                    @endif
                    <div class="font-black text-green-600 dark:text-green-400 mt-2">{{ number_format($item['price']) }} {{ $isFa ? 'تومان' : 'T' }}</div>
                </div>
                <div class="flex flex-col items-end gap-3 flex-shrink-0">
                    <div class="flex items-center border-2 border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden">
                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                class="px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 font-bold dark:text-gray-200 transition-colors">−</button>
                        <span class="px-3 font-bold dark:text-gray-200 min-w-[2rem] text-center">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                class="px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 font-bold dark:text-gray-200 transition-colors">+</button>
                    </div>
                    <div class="font-black text-gray-900 dark:text-gray-100 text-sm">{{ number_format($item['price'] * $item['quantity']) }}</div>
                    <button wire:click="removeItem('{{ $key }}')" wire:loading.attr="disabled"
                            class="text-red-400 hover:text-red-600 text-sm flex items-center gap-1 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ $isFa ? 'حذف' : 'Remove' }}
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="space-y-4">
            {{-- Coupon --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h3 class="font-bold mb-4 dark:text-gray-200">🎫 {{ $isFa ? 'کد تخفیف' : 'Coupon Code' }}</h3>
                @if(session('coupon'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-3 flex justify-between items-center">
                    <span class="font-mono font-bold text-green-700 dark:text-green-400">{{ session('coupon')['code'] }}</span>
                    <button wire:click="removeCoupon" class="text-red-500 text-sm hover:underline">{{ $isFa ? 'حذف' : 'Remove' }}</button>
                </div>
                @else
                <div class="flex gap-2">
                    <input type="text" wire:model="couponCode"
                           placeholder="{{ $isFa ? 'کد تخفیف' : 'Coupon Code' }}"
                           class="flex-1 border-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none uppercase input-ltr"
                           wire:keydown.enter="applyCoupon">
                    <button wire:click="applyCoupon" wire:loading.attr="disabled"
                            class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-green-700 disabled:opacity-60 transition-colors">
                        {{ $isFa ? 'اعمال' : 'Apply' }}
                    </button>
                </div>
                @endif
                @if($couponMessage)
                <p class="text-sm mt-2 {{ $couponSuccess ? 'text-green-600 dark:text-green-400' : 'text-red-500' }}">{{ $couponMessage }}</p>
                @endif
            </div>

            {{-- Summary --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h3 class="font-bold text-lg mb-5 dark:text-gray-200">{{ $isFa ? 'خلاصه سفارش' : 'Order Summary' }}</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ $isFa ? 'جمع کالاها' : 'Subtotal' }}</span>
                        <span class="font-bold dark:text-gray-200">{{ number_format($subtotal) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-red-600 dark:text-red-400">
                        <span>{{ $isFa ? 'تخفیف کوپن' : 'Coupon Discount' }}</span>
                        <span class="font-bold">-{{ number_format($discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ $isFa ? 'هزینه ارسال' : 'Shipping' }}</span>
                        <span class="font-bold {{ $shipping === 0 ? 'text-green-600 dark:text-green-400' : 'dark:text-gray-200' }}">
                            {{ $shipping > 0 ? number_format($shipping) : '🎁 ' . ($isFa ? 'رایگان' : 'Free') }}
                        </span>
                    </div>
                    <div class="border-t-2 dark:border-gray-700 pt-3 flex justify-between text-lg">
                        <span class="font-black dark:text-gray-200">{{ $isFa ? 'جمع کل' : 'Total' }}</span>
                        <span class="font-black text-green-600 dark:text-green-400">{{ number_format($total) }} <span class="text-sm font-normal">{{ $isFa ? 'تومان' : 'T' }}</span></span>
                    </div>
                </div>
                <a href="{{ route('checkout.index') }}"
                   class="block mt-5 bg-green-600 hover:bg-green-700 text-white font-black py-4 text-center rounded-xl transition-colors text-lg shadow-lg shadow-green-500/20">
                    {{ $isFa ? 'ادامه خرید ←' : 'Proceed to Checkout →' }}
                </a>
                <a href="{{ route('products.index') }}" class="block mt-3 text-center text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    {{ $isFa ? '← ادامه خرید' : '← Continue Shopping' }}
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
