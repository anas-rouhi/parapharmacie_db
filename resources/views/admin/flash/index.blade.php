@extends('layouts.admin')

@section('title', 'ParaAdmin | Offres Flash & Packs')

@section('content')
<div class="space-y-8">

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl font-semibold text-sm shadow-sm">
            <p class="font-black mb-2 uppercase tracking-wide">❌ Erreurs dans le formulaire :</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ═══ EN-TÊTE ═══ --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight flex items-center gap-2">⚡ Offres Flash & Packs</h2>
            <p class="text-gray-500 text-sm mt-1">Créez et gérez les promotions affichées sur la boutique.</p>
        </div>
        <a href="{{ route('admin.flash.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-md shadow-emerald-600/20 text-sm">
            + Nouvelle offre
        </a>
    </div>

    {{-- ═══ STATS ═══ --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm">
            <span class="h-9 w-9 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-base mb-3">⚡</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total offres</p>
            <p class="text-2xl font-black text-gray-900 mt-1">{{ $totalOffres }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm">
            <span class="h-9 w-9 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-base mb-3">🟢</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Actives</p>
            <p class="text-2xl font-black text-emerald-600 mt-1">{{ $offresActives }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm">
            <span class="h-9 w-9 bg-gray-100 text-gray-400 rounded-xl flex items-center justify-center text-base mb-3">⏹</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Expirées</p>
            <p class="text-2xl font-black text-gray-500 mt-1">{{ $offresExpirees }}</p>
        </div>
    </div>

    {{-- ═══ FILTRES ═══ --}}
    <form method="GET" action="{{ route('admin.flash.index') }}" class="bg-white p-4 rounded-2xl border border-gray-200/60 shadow-sm flex flex-col md:flex-row gap-3 md:items-end">
        <div class="flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rechercher</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom du produit / pack..."
                   class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none font-semibold text-gray-700">
        </div>
        <div class="md:w-48">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">État</label>
            <select name="etat" class="w-full bg-gray-50 border border-gray-200 px-3 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none font-semibold text-gray-700">
                <option value="">Toutes</option>
                <option value="active" @selected(request('etat') == 'active')>🟢 Actives</option>
                <option value="expiree" @selected(request('etat') == 'expiree')>⏹ Expirées</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-md shadow-emerald-600/20 cursor-pointer border-none">
                🔍 Filtrer
            </button>
            @if(request()->hasAny(['q','etat']))
                <a href="{{ route('admin.flash.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-sm px-4 py-2.5 rounded-xl transition flex items-center">🔄</a>
            @endif
        </div>
    </form>

    {{-- ═══ LISTE DES OFFRES ═══ --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-black text-gray-800">Offres configurées</h3>
            <p class="text-xs text-gray-400 font-medium mt-1">Les promotions actuellement enregistrées.</p>
        </div>

        @if($offresFlash->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($offresFlash as $offre)
                    @php
                        $fin       = $offre->flash_sale_end ? \Carbon\Carbon::parse($offre->flash_sale_end) : null;
                        $expiree   = !$fin || $fin->isPast();
                        $remise    = ($offre->prix > 0 && $offre->prix_flash < $offre->prix)
                                        ? round((1 - $offre->prix_flash / $offre->prix) * 100)
                                        : null;
                        $packItems = json_decode($offre->pack_products ?? '[]', true) ?: [];
                    @endphp

                    <div class="p-5 md:px-6 flex flex-col lg:flex-row lg:items-center gap-4 hover:bg-gray-50/50 transition">
                        {{-- Produit --}}
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            @if($offre->image)
                                <img src="{{ asset('images/products/' . $offre->image) }}" class="w-12 h-12 rounded-xl object-cover border border-gray-100 shrink-0">
                            @else
                                <span class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-lg shrink-0">📦</span>
                            @endif
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $offre->nom }}</p>
                                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">
                                    @if(count($packItems))
                                        🎁 Pack de {{ count($packItems) }} produit{{ count($packItems) > 1 ? 's' : '' }}
                                    @else
                                        Produit seul
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Prix --}}
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-lg font-black text-gray-900">{{ number_format($offre->prix_flash, 2) }} DH</span>
                            @if($remise !== null)
                                <span class="text-xs text-gray-400 line-through font-semibold">{{ number_format($offre->prix, 2) }} DH</span>
                                <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">-{{ $remise }}%</span>
                            @else
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-black px-2 py-0.5 rounded-full"
                                      title="Le prix promo n'est pas inférieur au prix normal ({{ number_format($offre->prix, 2) }} DH) : aucune remise ne s'affichera sur le site.">
                                    ⚠️ Pas de remise
                                </span>
                            @endif
                        </div>

                        {{-- Échéance --}}
                        <div class="shrink-0 lg:w-52">
                            @if($fin)
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg {{ $expiree ? 'bg-gray-100 text-gray-500' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ $expiree ? '⏹ Expirée' : '🟢 Active' }}
                                    <span class="font-semibold opacity-75">· {{ $fin->format('d/m/Y H:i') }}</span>
                                </span>
                            @else
                                <span class="text-[11px] font-bold text-gray-400">Sans date de fin</span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2 shrink-0">
                            <a href="{{ route('admin.flash.create', ['product_id' => $offre->id]) }}"
                               class="text-xs font-bold bg-gray-100 hover:bg-gray-900 hover:text-white text-gray-700 px-3 py-2 rounded-xl transition flex items-center">
                                ✏️ Modifier
                            </a>

                            <form action="{{ route('admin.products.flash.save') }}" method="POST" class="inline m-0"
                                  data-confirm="L'offre flash sera retirée de la boutique (le produit reste en vente au prix normal)."
                                  data-confirm-title="Désactiver cette offre ?"
                                  data-confirm-btn="Oui, désactiver">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $offre->id }}">
                                <input type="hidden" name="is_flash_sale" value="0">
                                <button type="submit" class="text-xs font-bold bg-red-50 hover:bg-red-600 hover:text-white text-red-600 px-3 py-2 rounded-xl transition cursor-pointer border-none">
                                    ⏹ Désactiver
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-6 pb-6">
                @include('partials.admin-pagination', ['paginator' => $offresFlash])
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl">⚡</div>
                <p class="text-sm font-bold text-gray-500">Aucune offre trouvée</p>
                <p class="text-xs text-gray-400 mt-1">Configurez une promotion avec le formulaire ci-dessous.</p>
            </div>
        @endif
    </div>

</div>

@endsection
