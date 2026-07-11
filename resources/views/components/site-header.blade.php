{{--
    En-tête réutilisable pour tout le site : <x-site-header />
    Auto-suffisant (icônes SVG inline + logo emoji) — ne dépend d'aucune librairie externe.
    La barre de recherche envoie vers la Boutique (fonctionne sur toutes les pages).
--}}
@php
    $panierItems = 0;
    foreach (session('panier', []) as $d) {
        $panierItems += $d['quantite'] ?? 0;
    }

    $isHome    = request()->routeIs('home');
    $isApropos = request()->routeIs('pages.apropos');
    $isSav     = request()->routeIs('pages.sav');
    $isContact = request()->routeIs('pages.contact');

    $linkBase   = 'relative py-1 transition font-bold';
    $linkOn     = 'text-emerald-600';
    $linkOff    = 'text-gray-600 hover:text-emerald-600';
@endphp

<nav class="bg-white/80 backdrop-blur-xl border-b border-emerald-500/10 sticky top-0 z-40 shadow-[0_2px_20px_-5px_rgba(16,185,129,0.12)]">
    <div class="h-[3px] w-full bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-600"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center gap-4">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 group">
                <span class="h-11 w-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-xl shadow-lg shadow-emerald-600/25 group-hover:scale-105 group-hover:shadow-emerald-600/40 transition duration-300">
                    🌱
                </span>
                <span class="text-2xl font-black tracking-tight leading-none">
                    <span class="text-slate-900">PARA</span><span class="text-emerald-600">SANTE</span>
                </span>
            </a>

            {{-- MENU --}}
            <div class="hidden lg:flex items-center gap-6 text-sm flex-shrink-0">
                <a href="{{ route('home') }}" class="{{ $linkBase }} {{ $isHome ? $linkOn : $linkOff }}">
                    Accueil
                    <span class="absolute -bottom-0.5 left-0 h-0.5 bg-emerald-500 transition-all duration-300 {{ $isHome ? 'w-full' : 'w-0' }}"></span>
                </a>
                <a href="{{ route('pages.apropos') }}" class="{{ $linkBase }} {{ $isApropos ? $linkOn : $linkOff }} group">
                    À Propos
                    <span class="absolute -bottom-0.5 left-0 h-0.5 bg-emerald-500 transition-all duration-300 {{ $isApropos ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="{{ route('pages.sav') }}" class="{{ $linkBase }} {{ $isSav ? $linkOn : $linkOff }} group">
                    Service SAV
                    <span class="absolute -bottom-0.5 left-0 h-0.5 bg-emerald-500 transition-all duration-300 {{ $isSav ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="{{ route('pages.contact') }}" class="{{ $linkBase }} {{ $isContact ? $linkOn : $linkOff }} group">
                    Contact
                    <span class="absolute -bottom-0.5 left-0 h-0.5 bg-emerald-500 transition-all duration-300 {{ $isContact ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
            </div>

            {{-- RECHERCHE (→ Boutique) --}}
            <form action="{{ route('boutique') }}" method="GET" class="flex-1 max-w-md mx-2 relative hidden md:block">
                <div class="flex items-center bg-slate-50/60 border border-slate-200/80 rounded-full focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-100 focus-within:bg-white transition duration-300 shadow-inner">
                    <span class="pl-4 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </span>
                    <input type="text" name="q" id="live-search-input" autocomplete="off"
                           value="{{ request('q') }}"
                           placeholder="Rechercher un produit, une marque..."
                           class="w-full py-2.5 px-3 text-xs text-slate-700 bg-transparent rounded-full focus:outline-none placeholder:text-slate-400">
                </div>
                <div id="search-results-dropdown"
                     class="hidden absolute left-0 right-0 mt-3 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-slate-100 max-h-96 overflow-y-auto z-50 divide-y divide-slate-50">
                </div>
            </form>

            {{-- ACTIONS : panier + compte --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('cart.index') }}" class="relative flex items-center text-gray-700 hover:text-emerald-600 transition p-2.5 bg-gray-50 border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/60 rounded-full hover:scale-110 duration-300 group" title="Mon panier">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:rotate-12 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if($panierItems > 0)
                        <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-[10px] font-black text-white shadow-md shadow-emerald-500/30">
                            {{ $panierItems }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="hidden sm:flex items-center gap-2 bg-gray-50/80 p-1 rounded-full border border-gray-200/60 backdrop-blur-md">
                        <span class="text-xs font-bold text-gray-700 pl-2">👋 {{ auth()->user()->name }}</span>
                        <a href="{{ route('client.commandes') }}" class="text-[10px] font-black text-gray-600 hover:text-emerald-600 bg-white border border-gray-200 px-3 py-1.5 rounded-full transition-all uppercase tracking-wider">
                            📦 Commandes
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                            @csrf
                            <button type="submit" class="text-[10px] font-black text-red-600 hover:text-white bg-red-50 hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-500 px-3 py-1.5 rounded-full transition-all uppercase tracking-wider border-none cursor-pointer">
                                Quitter
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="hidden sm:inline text-xs font-bold text-gray-600 hover:text-emerald-600 transition">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-[11px] font-black px-5 py-2.5 rounded-full hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-500/20 transform hover:scale-105 duration-200 uppercase tracking-wider">
                            S'inscrire
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</nav>

{{-- 🔎 Recherche instantanée (dropdown de suggestions) — active sur TOUTES les pages --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('live-search-input');
        const resultsDropdown = document.getElementById('search-results-dropdown');
        if (!searchInput || !resultsDropdown) return;

        let debounce;
        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            clearTimeout(debounce);

            if (query.length < 2) {
                resultsDropdown.innerHTML = '';
                resultsDropdown.classList.add('hidden');
                return;
            }

            debounce = setTimeout(() => {
                fetch(`{{ route('products.liveSearch') }}?q=${encodeURIComponent(query)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(products => {
                    resultsDropdown.innerHTML = '';

                    if (!products || products.length === 0) {
                        resultsDropdown.innerHTML = `<div class="p-4 text-center text-sm text-slate-400 font-medium">Aucun produit trouvé</div>`;
                        resultsDropdown.classList.remove('hidden');
                        return;
                    }

                    products.forEach(product => {
                        const imageSrc = product.image ? `/images/products/${product.image}` : '/images/default-product.png';
                        const item = document.createElement('a');
                        item.href = `/product/${product.id}`;
                        item.className = 'flex items-center gap-4 p-3 hover:bg-slate-50 transition duration-150 group';
                        item.innerHTML = `
                            <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                                <img src="${imageSrc}" alt="${product.nom}" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-slate-800 truncate group-hover:text-emerald-600 transition">${product.nom}</h4>
                                <p class="text-xs font-bold text-emerald-600 mt-0.5">${product.prix} DH</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-emerald-500 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        `;
                        resultsDropdown.appendChild(item);
                    });

                    resultsDropdown.classList.remove('hidden');
                })
                .catch(() => resultsDropdown.classList.add('hidden'));
            }, 200);
        });

        // Fermer le dropdown si on clique en dehors
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !resultsDropdown.contains(e.target)) {
                resultsDropdown.classList.add('hidden');
            }
        });
    });
</script>
