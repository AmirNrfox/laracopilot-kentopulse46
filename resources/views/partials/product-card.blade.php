@php
    $locale   = app()->getLocale();
    $isFa     = $locale === 'fa';
    $name     = $isFa ? $product->name_fa : $product->name_en;
    $short    = $isFa ? $product->short_description_fa : $product->short_description_en;
    $pEnabled = $paymentEnabled ?? \App\Models\Setting::get('payment_enabled', '1');
    $wNumber  = $whatsappNumber  ?? \App\Models\Setting::get('whatsapp_number', '989123456789');
@endphp
<div class="bg-white rounded-2xl shadow hover:shadow-xl transition-all duration-300 overflow-hidden group border border-transparent hover:border-green-100 flex flex-col">

    {{-- Image --}}
    <div class="relative overflow-hidden bg-gray-50 h-52 flex-shrink-0">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 alt="{{ $name }}"
                 class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300"
                 loading="lazy"
                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'200\'%3E%3Crect fill=\'%23f3f4f6\' width=\'200\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'60\'%3E%F0%9F%92%AA%3C/text%3E%3C/svg%3E'">
        </a>
        @if($product->sale_price)
        <div class="absolute top-3 {{ $isFa ? 'right' : 'left' }}-3 bg-red-500 text-white text-xs font-black px-2 py-1 rounded-full">
            %{{ round((($product->price - $product->sale_price) / $product->price) * 100) }} {{ $isFa ? 'تخفیف' : 'OFF' }}
        </div>
        @endif
        @if($product->featured)
        <div class="absolute top-3 {{ $isFa ? 'left' : 'right' }}-3 bg-yellow-400 text-gray-900 text-xs font-black px-2 py-1 rounded-full">⭐</div>
        @endif
        @if($product->stock <= 0)
        <div class="absolute inset-0 bg-white/80 flex items-center justify-center">
            <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-bold">{{ $isFa ? 'ناموجود' : 'Out of Stock' }}</span>
        </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-1">
        @if($product->brand)
        <div class="text-xs text-green-600 font-bold uppercase tracking-wide mb-1">{{ $product->brand }}</div>
        @endif
        <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1 line-clamp-2">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-green-600 transition-colors">{{ $name }}</a>
        </h3>
        @if($short)
        <p class="text-gray-400 text-xs mb-3 line-clamp-1">{{ $short }}</p>
        @endif
        <div class="mt-auto flex items-end justify-between">
            <div>
                @if($product->sale_price)
                <div class="text-red-600 font-black text-base">{{ number_format($product->sale_price) }}<span class="text-xs font-normal text-gray-500 mr-1">{{ $isFa ? 'ت' : 'T' }}</span></div>
                <div class="text-gray-300 text-xs line-through">{{ number_format($product->price) }}</div>
                @else
                <div class="text-gray-900 font-black text-base">{{ number_format($product->price) }}<span class="text-xs font-normal text-gray-500 mr-1">{{ $isFa ? 'ت' : 'T' }}</span></div>
                @endif
            </div>
            @if($product->stock > 0)
                @if($pEnabled)
                <button onclick="Livewire.dispatch('addQuick', { productId: {{ $product->id }} })"
                    class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-2 px-3 rounded-xl transition-all duration-200 hover:scale-105 flex items-center gap-1">
                    🛒 {{ $isFa ? 'افزودن' : 'Add' }}
                </button>
                @else
                {{-- Replaced: style="background:#25D366" → .btn-whatsapp --}}
                <a href="https://wa.me/{{ $wNumber }}?text={{ urlencode($isFa ? 'سلام، می‌خواهم ' . $product->name_fa . ' را سفارش دهم' : 'Hello, I want to order ' . $product->name_en) }}"
                   target="_blank"
                   class="btn-whatsapp text-xs font-bold py-2 px-3 rounded-xl flex items-center gap-1">
                    💬 {{ $isFa ? 'سفارش' : 'Order' }}
                </a>
                @endif
            @endif
        </div>
    </div>
</div>
