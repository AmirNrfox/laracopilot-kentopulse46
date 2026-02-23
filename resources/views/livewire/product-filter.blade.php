<div>
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar --}}
        <aside class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow p-5 sticky top-24">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="font-black text-gray-900">{{ app()->getLocale() === 'fa' ? 'فیلتر' : 'Filter' }}</h3>
                    <button wire:click="clearFilters" class="text-xs text-red-400 hover:text-red-600 font-medium">{{ app()->getLocale() === 'fa' ? 'پاک کردن' : 'Clear All' }}</button>
                </div>

                {{-- Search --}}
                <div class="mb-5">
                    <input type="text" wire:model.live.debounce.400ms="search"
                        placeholder="{{ app()->getLocale() === 'fa' ? 'جستجو...' : 'Search...' }}"
                        class="w-full border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500">
                </div>

                {{-- Categories --}}
                <div class="mb-5">
                    <h4 class="font-bold text-gray-700 text-sm mb-3">{{ app()->getLocale() === 'fa' ? 'دسته‌بندی' : 'Category' }}</h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model.live="selectedCategory" value="" class="accent-green-600 w-4 h-4">
                            <span class="text-sm text-gray-700">{{ app()->getLocale() === 'fa' ? 'همه دسته‌ها' : 'All Categories' }}</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model.live="selectedCategory" value="{{ $cat->slug }}" class="accent-green-600 w-4 h-4">
                            <span class="text-sm text-gray-700">{{ app()->getLocale() === 'fa' ? $cat->name_fa : $cat->name_en }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Brands --}}
                @if($brands->count())
                <div class="mb-5">
                    <h4 class="font-bold text-gray-700 text-sm mb-3">{{ app()->getLocale() === 'fa' ? 'برند' : 'Brand' }}</h4>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model.live="selectedBrand" value="" class="accent-green-600 w-4 h-4">
                            <span class="text-sm text-gray-700">{{ app()->getLocale() === 'fa' ? 'همه برندها' : 'All Brands' }}</span>
                        </label>
                        @foreach($brands as $brand)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model.live="selectedBrand" value="{{ $brand }}" class="accent-green-600 w-4 h-4">
                            <span class="text-sm">{{ $brand }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Price --}}
                <div class="mb-5">
                    <h4 class="font-bold text-gray-700 text-sm mb-3">{{ app()->getLocale() === 'fa' ? 'محدوده قیمت (تومان)' : 'Price Range (Toman)' }}</h4>
                    <div class="space-y-2">
                        <input type="number" wire:model.live.debounce.500ms="minPrice" placeholder="{{ app()->getLocale() === 'fa' ? 'حداقل' : 'Min' }}" class="w-full border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <input type="number" wire:model.live.debounce.500ms="maxPrice" placeholder="{{ app()->getLocale() === 'fa' ? 'حداکثر' : 'Max' }}" class="w-full border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                </div>

                {{-- Checkboxes --}}
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="onSaleOnly" class="accent-green-600 w-4 h-4 rounded">
                        <span class="text-sm">{{ app()->getLocale() === 'fa' ? 'فقط تخفیف‌دار' : 'On Sale Only' }}</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="inStockOnly" class="accent-green-600 w-4 h-4 rounded">
                        <span class="text-sm">{{ app()->getLocale() === 'fa' ? 'فقط موجود' : 'In Stock Only' }}</span>
                    </label>
                </div>
            </div>
        </aside>

        {{-- Products --}}
        <div class="flex-1">
            <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                <div class="text-gray-500 text-sm">
                    <span wire:loading.remove>{{ $products->total() }} {{ app()->getLocale() === 'fa' ? 'محصول' : 'products' }}</span>
                    <span wire:loading class="flex items-center gap-2 text-green-600">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                        {{ app()->getLocale() === 'fa' ? 'در حال بارگذاری...' : 'Loading...' }}
                    </span>
                </div>
                <select wire:model.live="sortBy" class="border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="newest">{{ app()->getLocale() === 'fa' ? 'جدیدترین' : 'Newest' }}</option>
                    <option value="price_asc">{{ app()->getLocale() === 'fa' ? 'ارزان‌ترین' : 'Cheapest' }}</option>
                    <option value="price_desc">{{ app()->getLocale() === 'fa' ? 'گران‌ترین' : 'Most Expensive' }}</option>
                    <option value="popular">{{ app()->getLocale() === 'fa' ? 'محبوب‌ترین' : 'Most Popular' }}</option>
                </select>
            </div>

            <div wire:loading.class="opacity-50" class="transition-opacity">
                @if($products->isEmpty())
                <div class="text-center py-20">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-500">{{ app()->getLocale() === 'fa' ? 'محصولی یافت نشد' : 'No products found' }}</h3>
                    <button wire:click="clearFilters" class="mt-4 text-green-600 hover:underline text-sm">{{ app()->getLocale() === 'fa' ? 'پاک کردن فیلترها' : 'Clear Filters' }}</button>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    @include('partials.product-card', compact('product', 'paymentEnabled', 'whatsappNumber'))
                    @endforeach
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
