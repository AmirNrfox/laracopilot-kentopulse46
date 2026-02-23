<div>
    {{-- Variants --}}
    @if($product->variants->isNotEmpty())
        @foreach($product->variants->groupBy('type') as $type => $variants)
        <div class="mb-5">
            <label class="block font-bold text-gray-800 mb-3">
                {{ app()->getLocale() === 'fa'
                    ? (['flavor'=>'طعم','size'=>'سایز','weight'=>'وزن'][$type] ?? $type)
                    : ucfirst($type) }}
            </label>
            <div class="flex flex-wrap gap-2">
                @foreach($variants as $v)
                <button type="button"
                    wire:click="selectVariant({{ $v->id }})"
                    @class([
                        'px-4 py-2 rounded-xl border-2 text-sm font-medium transition-all duration-150',
                        'border-green-500 bg-green-50 text-green-700 shadow-sm' => $selectedVariantId === $v->id,
                        'border-gray-200 hover:border-green-300 text-gray-700' => $selectedVariantId !== $v->id,
                        'opacity-40 cursor-not-allowed' => $v->stock <= 0,
                    ])
                    {{ $v->stock <= 0 ? 'disabled' : '' }}>
                    {{ app()->getLocale() === 'fa' ? $v->value_fa : $v->value_en }}
                    @if($v->price_modifier > 0)
                        <span class="text-xs text-green-600">(+{{ number_format($v->price_modifier) }})</span>
                    @endif
                </button>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif

    {{-- Quantity --}}
    <div class="flex items-center gap-4 mb-6">
        <label class="font-bold text-gray-800">{{ app()->getLocale() === 'fa' ? 'تعداد' : 'Quantity' }}:</label>
        <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
            <button wire:click="decrementQty" type="button" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 font-bold text-lg transition-colors">−</button>
            <span class="w-12 text-center font-black text-lg">{{ $quantity }}</span>
            <button wire:click="incrementQty" type="button" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 font-bold text-lg transition-colors">+</button>
        </div>
        @if($product->stock <= 10 && $product->stock > 0)
            <span class="text-orange-500 text-sm font-medium">⚠️ {{ app()->getLocale() === 'fa' ? 'فقط ' . $product->stock . ' عدد باقی مانده' : 'Only ' . $product->stock . ' left' }}</span>
        @endif
    </div>

    {{-- Message --}}
    @if($message)
    <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium {{ $success ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
        {{ $message }}
    </div>
    @endif

    {{-- Add to Cart Button --}}
    @if($product->stock > 0)
    <button wire:click="addToCart" wire:loading.attr="disabled"
        class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-60 text-white font-black py-4 px-8 rounded-2xl text-lg transition-all duration-200 transform hover:scale-[1.02] shadow-lg shadow-green-500/20 flex items-center justify-center gap-2">
        <span wire:loading.remove wire:target="addToCart">🛒 {{ app()->getLocale() === 'fa' ? 'افزودن به سبد خرید' : 'Add to Cart' }}</span>
        <span wire:loading wire:target="addToCart" class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
            {{ app()->getLocale() === 'fa' ? 'در حال افزودن...' : 'Adding...' }}
        </span>
    </button>
    @else
    <button disabled class="w-full bg-gray-200 text-gray-500 font-black py-4 px-8 rounded-2xl text-lg cursor-not-allowed">
        {{ app()->getLocale() === 'fa' ? '❌ ناموجود' : '❌ Out of Stock' }}
    </button>
    @endif
</div>
