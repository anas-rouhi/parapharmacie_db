<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50/60 min-h-screen flex flex-col antialiased text-slate-800">

    <!-- NAV -->
    <x-site-header />

    <!-- HEADER + RECHERCHE -->
    <header class="bg-gradient-to-br from-emerald-600 via-teal-600 to-emerald-700 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 bottom-0 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="max-w-7xl mx-auto px-6 py-12 relative z-10">
            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-white/15 text-white uppercase tracking-widest backdrop-blur">
                <i class="fa-solid fa-store"></i> Notre Boutique
            </span>
            <h1 class="text-3xl md:text-4xl font-black text-white mt-4 tracking-tight">Trouvez le produit parfait pour vous</h1>
            <p class="text-emerald-50 text-sm mt-2 font-medium">Recherchez parmi tous nos produits certifiés — par nom, catégorie ou besoin.</p>

            <!-- Barre de recherche + filtres (GET) -->
            <form method="GET" action="{{ route('boutique') }}" class="mt-6 bg-white rounded-2xl p-3 shadow-xl border border-white/20 flex flex-col lg:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit, une marque, un besoin..."
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white transition text-sm font-semibold text-slate-800">
                </div>

                <select name="category" class="lg:w-48 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 transition text-sm font-semibold text-slate-700">
                    <option value="">Toutes catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->nom }}</option>
                    @endforeach
                </select>

                <select name="sort" class="lg:w-44 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 transition text-sm font-semibold text-slate-700">
                    <option value="">Trier par</option>
                    <option value="recent" @selected(request('sort') == 'recent')>Plus récents</option>
                    <option value="prix_asc" @selected(request('sort') == 'prix_asc')>Prix croissant</option>
                    <option value="prix_desc" @selected(request('sort') == 'prix_desc')>Prix décroissant</option>
                    <option value="nom" @selected(request('sort') == 'nom')>Nom (A-Z)</option>
                </select>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl text-sm transition shadow-md active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> Rechercher
                </button>
            </form>

            <!-- Fourchette de prix (optionnel) — même formulaire via un second bloc -->
            <form method="GET" action="{{ route('boutique') }}" class="mt-3 flex flex-wrap items-center gap-2 text-white/90">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <span class="text-[11px] font-bold uppercase tracking-wider mr-1"><i class="fa-solid fa-sliders text-xs"></i> Prix :</span>
                <input type="number" name="prix_min" value="{{ request('prix_min') }}" placeholder="Min" min="0"
                       class="w-24 px-3 py-2 bg-white/90 rounded-lg text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-white/50">
                <span class="text-white/70 text-xs">—</span>
                <input type="number" name="prix_max" value="{{ request('prix_max') }}" placeholder="Max" min="0"
                       class="w-24 px-3 py-2 bg-white/90 rounded-lg text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-white/50">
                <button type="submit" class="bg-white/15 hover:bg-white/25 backdrop-blur text-white text-xs font-bold px-4 py-2 rounded-lg transition">Appliquer</button>
                @if(request()->hasAny(['q','category','sort','prix_min','prix_max']))
                    <a href="{{ route('boutique') }}" class="text-xs font-bold text-white/90 hover:text-white underline ml-1">Réinitialiser</a>
                @endif
            </form>
        </div>
    </header>

    <!-- RÉSULTATS -->
    <main class="max-w-7xl mx-auto w-full px-6 py-10 flex-grow">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    @if(request('q'))
                        Résultats pour « {{ request('q') }} »
                    @else
                        Tous nos produits
                    @endif
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-semibold">{{ $produits->total() }} produit{{ $produits->total() > 1 ? 's' : '' }} trouvé{{ $produits->total() > 1 ? 's' : '' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @include('products._cards')
        </div>

        @if($produits->hasPages())
            <div class="mt-14 flex flex-col items-center gap-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    Affichage {{ $produits->firstItem() }}–{{ $produits->lastItem() }} sur {{ $produits->total() }} produits
                </p>
                {{ $produits->onEachSide(1)->links('vendor.pagination.parasante') }}
            </div>
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 text-xs mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="inline-flex items-center gap-2">
                <div class="h-7 w-7 rounded-lg bg-emerald-600 flex items-center justify-center font-bold text-white text-xs">🌱</div>
                <span class="text-base font-black tracking-tight text-white">PARA<span class="text-emerald-500">SANTE</span></span>
            </div>
            <p>&copy; {{ date('Y') }} ParaSante. Tous droits réservés.</p>
        </div>
    </footer>

    @include('products._quickview')

</body>
</html>
