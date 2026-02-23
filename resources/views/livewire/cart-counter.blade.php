<a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-green-600 transition-colors">
    <span class="text-2xl">🛒</span>
    @if($count > 0)
        <span class="absolute -top-2 {{ app()->getLocale() === 'fa' ? '-left-2' : '-right-2' }} bg-red-500 text-white text-xs font-black rounded-full w-5 h-5 flex items-center justify-center shadow">
            {{ $count > 9 ? '9+' : $count }}
        </span>
    @endif
</a>
