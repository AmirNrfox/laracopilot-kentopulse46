<div class="bg-white rounded-2xl shadow p-8">
    <h3 class="text-xl font-black mb-6">✍️ {{ app()->getLocale() === 'fa' ? 'ثبت نظر' : 'Write a Review' }}</h3>

    @if($submitted)
        <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-green-700 font-medium">{{ $message }}</div>
    @else
        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() === 'fa' ? 'نام شما' : 'Your Name' }} *</label>
                    <input type="text" wire:model="name" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ app()->getLocale() === 'fa' ? 'امتیاز' : 'Rating' }} *</label>
                    <div class="flex gap-1">
                        @for($i=1; $i<=5; $i++)
                        <button type="button" wire:click="setRating({{ $i }})"
                            class="text-3xl transition-transform hover:scale-110 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-200' }}">
                            ★
                        </button>
                        @endfor
                    </div>
                    @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() === 'fa' ? 'نظر شما' : 'Your Review' }} *</label>
                <textarea wire:model="comment" rows="4"
                    class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500 @error('comment') border-red-400 @enderror"
                    placeholder="{{ app()->getLocale() === 'fa' ? 'تجربه استفاده از این محصول را بنویسید...' : 'Share your experience...' }}"></textarea>
                @error('comment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button wire:click="submit" wire:loading.attr="disabled"
                class="bg-green-600 hover:bg-green-700 disabled:opacity-60 text-white font-bold py-3 px-8 rounded-xl transition-colors flex items-center gap-2">
                <span wire:loading.remove wire:target="submit">{{ app()->getLocale() === 'fa' ? '📝 ثبت نظر' : '📝 Submit Review' }}</span>
                <span wire:loading wire:target="submit">{{ app()->getLocale() === 'fa' ? 'در حال ثبت...' : 'Submitting...' }}</span>
            </button>
        </div>
    @endif
</div>
