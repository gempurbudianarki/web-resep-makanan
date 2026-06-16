@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-charcoal-500">{{ $paginator->firstItem() }}</span>-<span class="font-semibold text-charcoal-500">{{ $paginator->lastItem() }}</span> dari <span class="font-semibold text-charcoal-500">{{ $paginator->total() }}</span> resep
        </p>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center text-gray-300 bg-white rounded-xl border border-gray-200 cursor-not-allowed text-sm">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center text-gray-600 bg-white rounded-xl border border-gray-200 hover:bg-cream-50 hover:border-amber-300 transition-all duration-200 text-sm">←</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-9 h-9 flex items-center justify-center text-gray-400 text-sm">...</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 flex items-center justify-center text-white bg-amber-400 rounded-xl shadow-sm text-sm font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center text-charcoal-500 bg-white rounded-xl border border-gray-200 hover:bg-cream-50 hover:border-amber-300 transition-all duration-200 text-sm font-medium">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center text-gray-600 bg-white rounded-xl border border-gray-200 hover:bg-cream-50 hover:border-amber-300 transition-all duration-200 text-sm">→</a>
            @else
                <span class="w-9 h-9 flex items-center justify-center text-gray-300 bg-white rounded-xl border border-gray-200 cursor-not-allowed text-sm">→</span>
            @endif
        </div>
    </nav>
@endif
