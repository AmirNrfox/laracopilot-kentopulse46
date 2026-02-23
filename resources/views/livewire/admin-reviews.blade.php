<div>
    @section('page-title', 'مدیریت نظرات')
    <div class="flex gap-3 mb-6">
        <button wire:click="$set('filter','pending')" @class(['px-4 py-2 rounded-xl font-medium text-sm transition-colors', 'bg-yellow-100 text-yellow-700' => $filter==='pending', 'bg-gray-100 text-gray-600 hover:bg-gray-200' => $filter!=='pending'])>⏳ {{ app()->getLocale() === 'fa' ? 'در انتظار تأیید' : 'Pending' }}</button>
        <button wire:click="$set('filter','approved')" @class(['px-4 py-2 rounded-xl font-medium text-sm transition-colors', 'bg-green-100 text-green-700' => $filter==='approved', 'bg-gray-100 text-gray-600 hover:bg-gray-200' => $filter!=='approved'])>✅ {{ app()->getLocale() === 'fa' ? 'تأیید شده' : 'Approved' }}</button>
        <button wire:click="$set('filter','all')" @class(['px-4 py-2 rounded-xl font-medium text-sm transition-colors', 'bg-blue-100 text-blue-700' => $filter==='all', 'bg-gray-100 text-gray-600 hover:bg-gray-200' => $filter!=='all'])>📋 {{ app()->getLocale() === 'fa' ? 'همه' : 'All' }}</button>
    </div>

    <div class="space-y-4">
        @forelse($reviews as $review)
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">{{ mb_substr($review->name, 0, 1) }}</div>
                        <div>
                            <div class="font-bold text-sm">{{ $review->name }}</div>
                            <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-yellow-400 text-sm">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                    </div>
                    <div class="text-gray-600 text-sm mb-2">{{ $review->comment }}</div>
                    @if($review->product)
                    <div class="text-xs text-gray-400">
                        {{ app()->getLocale() === 'fa' ? 'محصول' : 'Product' }}: 
                        <span class="font-medium text-gray-600">{{ $review->product->name_fa }}</span>
                    </div>
                    @endif
                </div>
                <div class="flex gap-2 {{ app()->getLocale() === 'fa' ? 'mr-4' : 'ml-4' }}">
                    @if(!$review->approved)
                    <button wire:click="approve({{ $review->id }})" class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                        ✅ {{ app()->getLocale() === 'fa' ? 'تأیید' : 'Approve' }}
                    </button>
                    @endif
                    <button wire:click="reject({{ $review->id }})" class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors" onclick="return confirm('{{ app()->getLocale() === 'fa' ? 'حذف شود؟' : 'Delete?' }}')">
                        🗑 {{ app()->getLocale() === 'fa' ? 'حذف' : 'Delete' }}
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <div class="text-4xl mb-2">💬</div>
            <p>{{ app()->getLocale() === 'fa' ? 'نظری یافت نشد' : 'No reviews found' }}</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $reviews->links() }}</div>
</div>
