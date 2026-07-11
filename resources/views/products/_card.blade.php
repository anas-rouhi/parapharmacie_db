{{-- Carte produit réutilisable (Home, Boutique, réponse AJAX) — attend $item --}}
<div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition duration-300 flex flex-col justify-between relative">
    <div>
        <div class="h-52 bg-gray-50 relative overflow-hidden">
            <a href="{{ route('products.show', $item->id) }}" class="block h-full w-full">
                @if($item->image)
                    <img src="{{ asset('images/products/' . $item->image) }}" alt="{{ $item->nom }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-100">
                        <span class="text-xs italic font-semibold uppercase tracking-widest">Image non disponible</span>
                    </div>
                @endif
            </a>
            @if($item->created_at && $item->created_at->gt(now()->subDays(14)))
                <span class="absolute top-3 left-3 bg-green-500 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider z-10 shadow-sm">Nouveau</span>
            @endif

            @if($item->stock <= 0)
                <span class="absolute top-3 right-3 bg-red-600 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider z-10 shadow-sm">Rupture</span>
            @elseif($item->stock <= 3)
                <span class="absolute top-3 right-3 bg-orange-500 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider animate-pulse z-10 shadow-sm">Stock Limité ({{ $item->stock }})</span>
            @else
                <span class="absolute top-3 right-3 bg-emerald-500 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider z-10 shadow-sm">En Stock</span>
            @endif

            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center z-20">
                <button type="button"
                        onclick="openQuickView('{{ $item->nom }}', '{{ $item->prix }}', '{{ $item->image ? asset('images/products/' . $item->image) : '' }}', '{{ addslashes($item->description) }}', '{{ route('cart.add', $item->id) }}', '{{ $item->stock }}')"
                        class="bg-white/90 backdrop-blur text-gray-900 text-xs font-bold py-2.5 px-4 rounded-xl shadow-lg hover:bg-green-600 hover:text-white transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                    <i class="fa-solid fa-eye mr-1"></i> Aperçu rapide
                </button>
            </div>
        </div>

        <div class="p-6">
            <p class="text-[10px] text-green-600 font-extrabold uppercase tracking-widest mb-1.5">
                {{ $item->categorie->nom ?? 'Parapharmacie' }}
            </p>
            <a href="{{ route('products.show', $item->id) }}">
                <h3 class="text-base font-bold text-gray-800 group-hover:text-green-600 transition truncate">{{ $item->nom }}</h3>
            </a>
            <p class="text-xs text-gray-400 mt-2 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
        </div>
    </div>

    <div class="p-6 pt-0">
        <div class="mt-2 flex items-center justify-between border-t border-gray-50 pt-4">
            <span class="text-lg font-black text-gray-900">{{ $item->prix }} DH</span>

            <a href="{{ route('cart.add', $item->id) }}?buy_type=normal" class="bg-gray-900 text-white p-3 rounded-xl hover:bg-green-600 hover:shadow-lg hover:shadow-green-600/20 transition transform active:scale-95 duration-200 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>
        </div>
    </div>
</div>
