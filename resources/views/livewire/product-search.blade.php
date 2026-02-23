<div class="relative flex-1 max-w-lg" x-data="{ open: @entangle('showResults') }">
    <div class="flex w-full">
        <input type="text"
            wire:model.live.debounce.300ms="query"
            placeholder="{{ app()->getLocale() === 'fa' ? 'جستجو در محصولات...' : 'Search products...' }}"
            class="flex-1 border-2 border-gray-200 rounded-{{ app()->getLocale() === 'fa' ? 'r' : 'l' }}-xl px-4 py-2.5 focus:outline-none focus:border-green-500 text-sm"
            @focus="open = true"
            @click.away="open = false; $wire.closeResults()">
        <button type="button"
            x-on:click="window.location.href = '{{ route('products.search') }}?q=' + $wire.query"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-{{ app()->getLocale() === 'fa' ? 'l' : 'r' }}-xl transition-colors text-sm font-medium">
            🔍
        </button>
    </div>

    @if($showResults && count($results))
    <div class="absolute top-full {{ app()->getLocale() === 'fa' ? 'right' : 'left' }}-0 w-full bg-white shadow-2xl rounded-2xl mt-1 z-50 overflow-hidden border border-gray-100">
        @foreach($results as $r)
        <a href="{{ route('products.show', $r['slug']) }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-50 transition-colors border-b border-gray-50 last:border-0">
            <img src="{{ $r['image'] }}" alt="" class="w-10 h-10 object-contain rounded-lg bg-gray-50 p-1" onerror="this.src='data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\"><rect fill=\"%23f3f4f6\" width=\"40\" height=\"40\"/></svg>'">
            <div class="flex-1 min-w-0">
                <div class="font-medium text-sm text-gray-900 truncate">{{ $r['name'] }}</div>
                @if($r['brand'])
                    <div class="text-xs text-green-600">{{ $r['brand'] }}</div>
                @endif
            </div>
            <div class="text-sm font-black text-gray-900">{{ $r['price'] }}</div>
        </a>
        @endforeach
        <a href="{{ route('products.search') }}?q={{ urlencode($query) }}" class="block px-4 py-2.5 text-center text-sm text-green-600 hover:bg-green-50 font-medium">
            {{ app()->getLocale() === 'fa' ? 'مشاهده همه نتایج →' : 'View all results →' }}
        </a>
    </div>
    @endif
</div>
