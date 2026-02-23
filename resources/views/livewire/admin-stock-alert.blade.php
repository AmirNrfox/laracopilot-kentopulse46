<div>
    @if($lowStockProducts->isNotEmpty())
    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-2xl">⚠️</span>
            <h4 class="font-bold text-orange-800">{{ app()->getLocale() === 'fa' ? 'محصولات کم موجودی' : 'Low Stock Products' }} ({{ $lowStockProducts->count() }})</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($lowStockProducts as $product)
            <div class="bg-white rounded-lg p-3 flex justify-between items-center">
                <div>
                    <div class="font-medium text-sm">{{ $product->name_fa }}</div>
                    <div class="text-xs text-gray-400">{{ $product->brand }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-{{ $product->stock === 0 ? 'red' : 'orange' }}-600 font-black text-lg">{{ $product->stock }}</span>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline text-xs">{{ app()->getLocale() === 'fa' ? 'ویرایش' : 'Edit' }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
