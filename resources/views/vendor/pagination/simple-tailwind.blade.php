@if ($paginator->hasPages())
<nav class="flex justify-between items-center mt-6">
    @if ($paginator->onFirstPage())
        <span class="px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-xl cursor-default">{{ app()->getLocale() === 'fa' ? '← قبلی' : '← Prev' }}</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-green-50 hover:text-green-700 transition-colors">{{ app()->getLocale() === 'fa' ? '← قبلی' : '← Prev' }}</a>
    @endif
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-green-50 hover:text-green-700 transition-colors">{{ app()->getLocale() === 'fa' ? 'بعدی →' : 'Next →' }}</a>
    @else
        <span class="px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-xl cursor-default">{{ app()->getLocale() === 'fa' ? 'بعدی →' : 'Next →' }}</span>
    @endif
</nav>
@endif
