@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-center">
        <ul class="inline-flex items-center gap-1.5 bg-white/80 backdrop-blur p-2 rounded-2xl border border-gray-100 shadow-sm">

            {{-- Bouton Précédent --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true">
                    <span class="flex items-center justify-center h-10 w-10 rounded-xl text-gray-300 bg-gray-50 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                       class="flex items-center justify-center h-10 w-10 rounded-xl text-gray-600 bg-gray-50 hover:bg-green-600 hover:text-white transition duration-200 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                </li>
            @endif

            {{-- Numéros de page --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li aria-disabled="true">
                        <span class="flex items-center justify-center h-10 px-3 rounded-xl text-gray-400 font-bold text-sm">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <span class="flex items-center justify-center h-10 min-w-[2.5rem] px-3 rounded-xl bg-green-600 text-white font-black text-sm shadow-md shadow-green-600/25">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="flex items-center justify-center h-10 min-w-[2.5rem] px-3 rounded-xl text-gray-600 bg-gray-50 hover:bg-green-50 hover:text-green-700 font-bold text-sm transition duration-200 active:scale-95">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Bouton Suivant --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                       class="flex items-center justify-center h-10 w-10 rounded-xl text-gray-600 bg-gray-50 hover:bg-green-600 hover:text-white transition duration-200 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </li>
            @else
                <li aria-disabled="true">
                    <span class="flex items-center justify-center h-10 w-10 rounded-xl text-gray-300 bg-gray-50 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
