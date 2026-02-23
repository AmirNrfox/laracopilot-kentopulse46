<div>
    @if(empty($cart))
    <div class="text-center py-20">
        <div class="text-8xl mb-6">🛒</div>
        <h2 class="text-2xl font-bold text-gray-600 mb-4">{{ app()->getLocale() === 'fa' ? 'سبد خرید شما خالی است' : 'Your cart is empty' }}</h2>
        <a href="{{ route('products.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl">{{ app()->getLocale() === 'fa' ? '🛍️ مشاهده محصولات' : '🛍️ Browse Products' }}</a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart as $key => $item)
            <div class="bg-white rounded-2xl shadow p-5 flex gap-5 items-start">
                <div class="w-24 h-24 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ $item['image'] }}" alt="" class="w-full h-full object-contain p-2" onerror="this.style.display='none'">
                </div>
                <div class="flex-1">
                    <a href="{{ route('products.show', $item['slug']) }}" class="font-bold text-gray-900 hover:text-green-600">
                        {{ app()->getLocale() === 'fa' ? $item['name_fa'] : $item['name_en'] }}
                    </a>
                    @if($item['variant_info_fa'])
                        <div class="text-sm text-gray-500 mt-1">{{ app()->getLocale() === 'fa' ? $item['variant_info_fa'] : $item['variant_info_en'] }}</div>
                    @endif
                    <div class="font-black text-green-600 mt-2">{{ number_format($item['price']) }} {{ app()->getLocale() === 'fa' ? 'تومان' : 'T' }}</div>
                </div>
                <div class="flex flex-col items-end gap-3">
                    <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})" class="px-3 py-1.5 hover:bg-gray-100 font-bold">−</button>
                        <span class="px-3 font-bold">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})" class="px-3 py-1.5 hover:bg-gray-100 font-bold">+</button>
                    </div>
                    <div class="font-black text-gray-900">{{ number_format($item['price'] * $item['quantity']) }}</div>
                    <button wire:click="removeItem('{{ $key }}')" class="text-red-400 hover:text-red-600 text-sm flex items-center gap-1">
                        🗑 {{ app()->getLocale() === 'fa' ? 'حذف' : 'Remove' }}
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="space-y-4">
            {{-- Coupon --}}
            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-bold mb-4">🎫 {{ app()->getLocale() === 'fa' ? 'کد تخفیف' : 'Coupon Code' }}</h3>
                @if(session('coupon'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-3 flex justify-between items-center">
                    <span class="font-mono font-bold text-green-700">{{ session('coupon')['code'] }}</span>
                    <button wire:click="removeCoupon" class="text-red-500 text-sm hover:underline">{{ app()->getLocale() === 'fa' ? 'حذف' : 'Remove' }}</button>
                </div>
                @else
                <div class="flex gap-2">
                    <input type="text" wire:model="couponCode" placeholder="{{ app()->getLocale() === 'fa' ? 'کد تخفیف' : 'Coupon Code' }}" class="flex-1 border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none uppercase" style="direction:ltr">
                    <button wire:click="applyCoupon" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-green-700 disabled:opacity-60">
                        {{ app()->getLocale() === 'fa' ? 'اعمال' : 'Apply' }}
                    </button>
                </div>
                @endif
                @if($couponMessage)
                <p class="text-sm mt-2 {{ $couponSuccess ? 'text-green-600' : 'text-red-500' }}">{{ $couponMessage }}</p>
                @endif
            </div>

            {{-- Summary --}}
            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-bold text-lg mb-5">{{ app()->getLocale() === 'fa' ? 'خلاصه سفارش' : 'Order Summary' }}</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ app()->getLocale() === 'fa' ? 'جمع کالاها' : 'Subtotal' }}</span>
                        <span class="font-bold">{{ number_format($subtotal) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-red-600">
                        <span>{{ app()->getLocale() === 'fa' ? 'تخفیف کوپن' : 'Coupon Discount' }}</span>
                        <span class="font-bold">-{{ number_format($discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ app()->getLocale() === 'fa' ? 'هزینه ارسال' : 'Shipping' }}</span>
                        <span class="font-bold {{ $shipping === 0 ? 'text-green-600' : '' }}">{{ $shipping > 0 ? number_format($shipping) : '🎁 ' . (app()->getLocale() === 'fa' ? 'رایگان' : 'Free') }}</span>
                    </div>
                    <div class="border-t-2 pt-3 flex justify-between text-lg">
                        <span class="font-black">{{ app()->getLocale() === 'fa' ? 'جمع کل' : 'Total' }}</span>
                        <span class="font-black text-green-600">{{ number_format($total) }} <span class="text-sm font-normal">{{ app()->getLocale() === 'fa' ? 'تومان' : 'T' }}</span></span>
                    </div>
                </div>
                <a href="{{ route('checkout.index') }}" class="block mt-5 bg-green-600 hover:bg-green-700 text-white font-black py-4 text-center rounded-xl transition-colors text-lg">
                    {{ app()->getLocale() === 'fa' ? 'ادامه خرید ←' : 'Proceed to Checkout →' }}
                </a>
                <a href="{{ route('products.index') }}" class="block mt-3 text-center text-sm text-gray-400 hover:text-gray-600">
                    {{ app()->getLocale() === 'fa' ? '← ادامه خرید' : '← Continue Shopping' }}
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
