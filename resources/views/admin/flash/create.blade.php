@extends('layouts.admin')

@section('title', 'ParaAdmin | Configurer une offre flash')

@section('content')
<div class="space-y-6">

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

    {{-- En-tête --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight flex items-center gap-2">
                ⚡ {{ $selectedId ? "Modifier l'offre" : 'Nouvelle offre flash' }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">Choisissez un produit, fixez son prix promo et sa date de fin.</p>
        </div>
        <a href="{{ route('admin.flash.index') }}" class="shrink-0 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 px-4 py-2.5 rounded-xl font-bold transition text-xs flex items-center gap-2 shadow-sm">
            ← Retour aux offres
        </a>
    </div>

    <form id="flashSaleForm" action="{{ route('admin.products.flash.save') }}" method="POST"
          class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        @csrf

        {{-- ═══ COLONNE PRINCIPALE ═══ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Détails de l'offre --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="h-8 w-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center text-sm shrink-0">⚡</span>
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide">Détails de l'offre</h3>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Produit --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Produit concerné</label>
                        <select id="product_select" name="product_id" required onchange="updateFormAction(this.value)"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                            <option value="" disabled @selected(!$selectedId)>Sélectionner un produit...</option>
                            @foreach($produits as $p)
                                <option value="{{ $p->id }}"
                                        @selected($selectedId == $p->id)
                                        data-nom="{{ $p->nom }}"
                                        data-flash="{{ $p->is_flash_sale ?? 0 }}"
                                        data-prix="{{ $p->prix_flash ?? '' }}"
                                        data-normal="{{ $p->prix }}"
                                        data-end="{{ $p->flash_sale_end ? \Carbon\Carbon::parse($p->flash_sale_end)->format('Y-m-d\TH:i') : '' }}">
                                    {{ $p->nom }} ({{ $p->prix }} DH)
                                </option>
                            @endforeach
                        </select>
                        <p id="prix_normal_hint" class="text-[11px] text-gray-400 font-semibold mt-2 hidden">
                            Prix normal du produit : <b id="prix_normal_val" class="text-gray-600"></b> DH
                        </p>
                    </div>

                    {{-- Prix promo + Fin --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Prix promo (DH)</label>
                            <input type="number" step="0.01" min="0" id="prix_flash" name="prix_flash" required placeholder="0.00"
                                   oninput="verifierRemise()"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-900 font-bold text-sm transition">
                            <p id="remise_warning" class="text-[11px] font-bold mt-2 hidden"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fin de l'offre</label>
                            <input type="datetime-local" id="flash_sale_end" name="flash_sale_end" required
                                   onchange="majApercu()"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-700 font-semibold text-sm transition">
                        </div>
                    </div>

                    {{-- Statut --}}
                    <div class="sm:w-1/2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Statut</label>
                        <select id="is_flash_sale" name="is_flash_sale"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                            <option value="1" selected>🟢 Activer l'offre</option>
                            <option value="0">⏹ Désactiver (prix normal)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Contenu du pack --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <span class="h-8 w-8 bg-violet-50 text-violet-600 rounded-lg flex items-center justify-center text-sm shrink-0">🎁</span>
                        <div>
                            <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide">Contenu du pack</h3>
                            <p class="text-[11px] text-gray-400 font-semibold">Optionnel — laissez vide pour un produit seul</p>
                        </div>
                    </div>
                    <input type="text" id="packSearch" onkeyup="filtrerPackItems()" placeholder="🔍 Filtrer..."
                           class="w-full sm:w-44 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 font-semibold">
                </div>

                <div class="p-6">
                    <div id="packItemsList" class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 max-h-64 overflow-y-auto pr-1">
                        @foreach($produits as $p)
                            <label class="pack-item flex items-center gap-2.5 text-xs font-medium text-gray-700 cursor-pointer px-3 py-2.5 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-100 transition select-none">
                                <input type="checkbox" name="pack_items[]" value="{{ $p->nom }}"
                                       @checked(in_array($p->nom, $packItems ?? []))
                                       onchange="majApercu()"
                                       class="rounded text-emerald-600 focus:ring-emerald-500 h-4 w-4 border-gray-300 shrink-0">
                                <span class="truncate">{{ $p->nom }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ COLONNE LATÉRALE : APERÇU ═══ --}}
        <div class="space-y-6 lg:sticky lg:top-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="h-8 w-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-sm shrink-0">👁️</span>
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide">Aperçu client</h3>
                </div>

                <div class="p-6">
                    {{-- Carte d'aperçu façon boutique --}}
                    <div class="rounded-2xl bg-gradient-to-br from-slate-900 to-indigo-950 p-5 text-white relative overflow-hidden">
                        <span class="inline-block bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider mb-3">⚡ Offre Flash</span>

                        <p id="apercu_nom" class="font-black text-base leading-tight truncate">—</p>

                        <div class="flex items-end gap-2 mt-3">
                            <span id="apercu_promo" class="text-2xl font-black">— DH</span>
                            <span id="apercu_normal" class="text-xs text-slate-400 line-through font-semibold mb-1 hidden"></span>
                        </div>

                        <span id="apercu_remise" class="hidden inline-block bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full mt-2"></span>

                        <p id="apercu_pack" class="text-[11px] text-amber-300 font-bold mt-3 hidden"></p>
                        <p id="apercu_fin" class="text-[11px] text-slate-400 font-semibold mt-3">Aucune date de fin</p>
                    </div>

                    <p class="text-[11px] text-gray-400 font-semibold mt-3 text-center">
                        Voici comment l'offre apparaîtra sur la boutique.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5 space-y-2.5">
                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-black shadow-md shadow-emerald-600/20 transition uppercase tracking-wider text-xs border-none cursor-pointer active:scale-[0.98]">
                    ✓ Enregistrer l'offre
                </button>
                <a href="{{ route('admin.flash.index') }}"
                   class="block text-center w-full text-xs font-bold text-gray-500 hover:bg-gray-100 px-6 py-3 rounded-xl transition">
                    Annuler
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function optionCourante() {
        const select = document.getElementById('product_select');
        return select.options[select.selectedIndex];
    }

    function updateFormAction(productId) {
        const option = optionCourante();
        if (!option || !productId) return;

        document.getElementById('prix_flash').value     = option.getAttribute('data-prix') || '';
        document.getElementById('flash_sale_end').value = option.getAttribute('data-end') || '';
        document.getElementById('is_flash_sale').value  = option.getAttribute('data-flash') || '1';

        document.getElementById('prix_normal_val').textContent = option.getAttribute('data-normal');
        document.getElementById('prix_normal_hint').classList.remove('hidden');

        verifierRemise();
    }

    // ⚠️ Avertit si le "prix promo" n'est pas inférieur au prix normal
    function verifierRemise() {
        const option = optionCourante();
        const warn   = document.getElementById('remise_warning');
        const promo  = parseFloat(document.getElementById('prix_flash').value);
        const normal = option ? parseFloat(option.getAttribute('data-normal')) : NaN;

        if (isNaN(promo) || isNaN(normal) || promo <= 0) {
            warn.classList.add('hidden');
        } else if (promo >= normal) {
            warn.textContent = `⚠️ Supérieur ou égal au prix normal (${normal} DH) — aucune remise affichée.`;
            warn.className = 'text-[11px] font-bold mt-2 text-amber-600';
            warn.classList.remove('hidden');
        } else {
            warn.textContent = `✓ Remise de ${Math.round((1 - promo / normal) * 100)}% pour le client.`;
            warn.className = 'text-[11px] font-bold mt-2 text-emerald-600';
            warn.classList.remove('hidden');
        }

        majApercu();
    }

    // 👁️ Aperçu en direct de la carte boutique
    function majApercu() {
        const option = optionCourante();
        const promo  = parseFloat(document.getElementById('prix_flash').value);
        const normal = option ? parseFloat(option.getAttribute('data-normal')) : NaN;
        const fin    = document.getElementById('flash_sale_end').value;

        document.getElementById('apercu_nom').textContent = option && option.value
            ? option.getAttribute('data-nom')
            : '—';

        document.getElementById('apercu_promo').textContent = !isNaN(promo) && promo > 0
            ? promo.toFixed(2) + ' DH'
            : '— DH';

        const elNormal = document.getElementById('apercu_normal');
        const elRemise = document.getElementById('apercu_remise');

        if (!isNaN(promo) && !isNaN(normal) && promo > 0 && promo < normal) {
            elNormal.textContent = normal.toFixed(2) + ' DH';
            elNormal.classList.remove('hidden');
            elRemise.textContent = '-' + Math.round((1 - promo / normal) * 100) + '%';
            elRemise.classList.remove('hidden');
        } else {
            elNormal.classList.add('hidden');
            elRemise.classList.add('hidden');
        }

        const nbPack = document.querySelectorAll('#packItemsList input[type=checkbox]:checked').length;
        const elPack = document.getElementById('apercu_pack');
        if (nbPack > 0) {
            elPack.textContent = `🎁 Pack de ${nbPack} produit${nbPack > 1 ? 's' : ''}`;
            elPack.classList.remove('hidden');
        } else {
            elPack.classList.add('hidden');
        }

        document.getElementById('apercu_fin').textContent = fin
            ? 'Se termine le ' + new Date(fin).toLocaleString('fr-FR', { dateStyle: 'short', timeStyle: 'short' })
            : 'Aucune date de fin';
    }

    function filtrerPackItems() {
        const terme = document.getElementById('packSearch').value.toLowerCase();
        document.querySelectorAll('#packItemsList .pack-item').forEach(el => {
            el.style.display = el.textContent.toLowerCase().includes(terme) ? '' : 'none';
        });
    }

    // Pré-remplit si on arrive en mode "Modifier"
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('product_select');
        if (select.value) updateFormAction(select.value);
        majApercu();
    });
</script>
@endsection
