@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-between mt-6">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-lg">{{ app()->getLocale() === 'fa' ? 'قبلی' : 'Previous' }}</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ app()->getLocale() === 'fa' ? 'قبلی' : 'Previous' }}</a>
        @endif
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ app()->getLocale() === 'fa' ? 'بعدی' : 'Next' }}</a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-lg">{{ app()->getLocale() === 'fa' ? 'بعدی' : 'Next' }}</span>
        @endif
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-600">
                {{ app()->getLocale() === 'fa' ? 'نمایش' : 'Showing' }}
                <span class="font-bold">{{ $paginator->firstItem() }}</span>
                {{ app()->getLocale() === 'fa' ? 'تا' : 'to' }}
                <span class="font-bold">{{ $paginator->lastItem() }}</span>
                {{ app()->getLocale() === 'fa' ? 'از' : 'of' }}
                <span class="font-bold">{{ $paginator->total() }}</span>
                {{ app()->getLocale() === 'fa' ? 'نتیجه' : 'results' }}
            </p>
        </div>
        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-xl overflow-hidden gap-1">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 rounded-lg cursor-default">{{ app()->getLocale() === 'fa' ? '←' : '←' }}</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-green-50 hover:text-green-700 transition-colors">←</a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg">{{ $element }}</span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-2 text-sm font-black text-white bg-green-600 border border-green-600 rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-green-50 hover:text-green-700 transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-green-50 hover:text-green-700 transition-colors">→</a>
                @else
                    <span class="px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 rounded-lg cursor-default">→</span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
