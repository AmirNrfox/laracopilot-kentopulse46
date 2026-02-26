<button wire:click="toggle"
        title="{{ $inWishlist ? (app()->getLocale() === 'fa' ? 'حذف از علاقه‌مندی‌ها' : 'Remove from wishlist') : (app()->getLocale() === 'fa' ? 'افزودن به علاقه‌مندی‌ها' : 'Add to wishlist') }}"
        class="w-9 h-9 bg-white rounded-full shadow-md flex items-center justify-center transition-all duration-200 hover:scale-110 {{ $inWishlist ? 'text-red-500 border-2 border-red-200' : 'text-gray-400 border-2 border-transparent hover:border-red-200 hover:text-red-400' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
</button>
