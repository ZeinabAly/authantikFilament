@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center items-center space-x-2 my-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-2 py-2 text-[#1A1F2C] bg-white rounded-full border border-gray-300 cursor-not-allowed">
            <x-icon name="angle-left" fill="#ccc"/>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-3 text-blue-600 bg-white rounded-full border border-blue-300 hover:bg-blue-50">
                <x-icon name="angle-left" fill="#ccc"/>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Element --}}
            @if (is_string($element))
                <span class="px-2 py-2 text-gray-700 bg-white rounded-full border border-gray-300">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="px-4 py-2 text-white bg-[#1a1f2c] rounded-full">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-[#1a1f2c] bg-white rounded-full border border-[#1a1f2c] hover:bg-[#1a1f2c] hover:text-white">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-2 text-[#1a1f2c] bg-white rounded-full border border-[#1a1f2c] hover:bg-blue-50">
            <x-icon name="angle-right" fill="#ccc"/>
            </a>
        @else
            <span class="px-2 py-2 text-gray-500 bg-white rounded-full border border-gray-300 cursor-not-allowed">
            <x-icon name="angle-right" fill="#ccc"/>
            </span>
        @endif
    </nav>
@endif