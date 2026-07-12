@extends('layouts.admin')

@section('title', 'ParaAdmin | Ajouter un produit')

@section('content')
<div class="space-y-6">

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl font-semibold text-sm shadow-sm">
            <p class="font-black mb-2 uppercase tracking-wide">❌ Il y a des erreurs dans le formulaire :</p>
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
            <h2 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight">Ajouter un produit</h2>
            <p class="text-gray-500 text-sm mt-1">Renseignez les informations du nouvel article du catalogue.</p>
        </div>
        <a href="{{ route('admin.produits') }}" class="shrink-0 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 px-4 py-2.5 rounded-xl font-bold transition text-xs flex items-center gap-2 shadow-sm">
            ← Retour au catalogue
        </a>
    </div>

    <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        @csrf

        {{-- ═══ COLONNE PRINCIPALE ═══ --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2.5">
                <span class="h-8 w-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-sm shrink-0">📦</span>
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide">Informations du produit</h3>
            </div>

            <div class="p-6 space-y-5">
                {{-- Nom --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nom du produit</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Ex : Crème hydratante SVR"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-900 font-medium text-sm transition">
                </div>

                {{-- Catégorie + Stock --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catégorie</label>
                        <div class="flex gap-2">
                            <select id="category_select" name="category_id" required
                                    class="flex-1 min-w-0 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                                <option value="">Sélectionner...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openCategoryModal()" title="Nouvelle catégorie"
                                    class="shrink-0 w-11 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-sm transition border-none cursor-pointer text-lg">+</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Stock disponible</label>
                        <input type="number" name="stock" min="0" value="{{ old('stock') }}" required placeholder="0"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-900 font-bold text-sm transition">
                    </div>
                </div>

                {{-- Prix --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Prix d'achat (DH)</label>
                        <input type="number" step="0.01" min="0" id="prix_achat" name="prix_achat" value="{{ old('prix_achat') }}" required placeholder="0.00"
                               oninput="calculerMarge()"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-900 font-bold text-sm transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Prix de vente (DH)</label>
                        <input type="number" step="0.01" min="0" id="prix_vente" name="prix" value="{{ old('prix') }}" required placeholder="0.00"
                               oninput="calculerMarge()"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-900 font-bold text-sm transition">
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Composition, bienfaits, mode d'emploi..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none text-gray-900 font-medium text-sm transition resize-none">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ═══ COLONNE LATÉRALE ═══ --}}
        <div class="space-y-6">

            {{-- Image --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="h-8 w-8 bg-sky-50 text-sky-600 rounded-lg flex items-center justify-center text-sm shrink-0">🖼️</span>
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide">Image</h3>
                </div>

                <div class="p-6">
                    <label for="image_input" class="block cursor-pointer">
                        <div id="image_dropzone" class="border-2 border-dashed border-gray-200 rounded-xl aspect-square flex flex-col items-center justify-center text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition bg-gray-50/50 overflow-hidden relative">
                            <img id="image_preview" class="hidden absolute inset-0 w-full h-full object-cover" alt="">
                            <div id="image_placeholder" class="px-4">
                                <span class="text-3xl block mb-2">📁</span>
                                <p class="text-xs font-bold text-gray-600">Cliquez pour choisir</p>
                                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">JPG, PNG, WEBP</p>
                            </div>
                        </div>
                    </label>
                    <input type="file" id="image_input" name="image" accept="image/*" class="hidden" onchange="previsualiserImage(this)">
                    <p id="image_name" class="text-[11px] text-gray-400 font-semibold mt-2 text-center truncate"></p>
                </div>
            </div>

            {{-- Marge (calcul live) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="h-8 w-8 bg-violet-50 text-violet-600 rounded-lg flex items-center justify-center text-sm shrink-0">📈</span>
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide">Marge</h3>
                </div>
                <div class="p-6">
                    <p class="text-3xl font-black text-gray-900" id="marge_val">— DH</p>
                    <p class="text-xs font-bold mt-1.5" id="marge_pct">Renseignez les deux prix.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5 space-y-2.5">
                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-black shadow-md shadow-emerald-600/20 transition uppercase tracking-wider text-xs border-none cursor-pointer active:scale-[0.98]">
                    ✓ Enregistrer le produit
                </button>
                <a href="{{ route('admin.produits') }}"
                   class="block text-center w-full text-xs font-bold text-gray-500 hover:bg-gray-100 px-6 py-3 rounded-xl transition">
                    Annuler
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Modal : nouvelle catégorie (AJAX) --}}
<div id="categoryModal" class="fixed inset-0 bg-gray-900/60 hidden items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-2xl shadow-xl max-w-sm w-full mx-4 border border-gray-200">
        <h3 class="text-base font-black text-gray-900 mb-4">Ajouter une catégorie</h3>
        <input type="text" id="new_category_name" placeholder="Nom de la catégorie"
               class="border border-gray-200 rounded-xl w-full py-3 px-4 bg-gray-50 text-gray-700 mb-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-semibold text-sm">
        <p id="modal_error" class="text-red-500 text-xs hidden mb-2 font-bold"></p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeCategoryModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition border-none text-xs cursor-pointer">Annuler</button>
            <button type="button" onclick="submitCategoryAjax()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl transition border-none text-xs cursor-pointer">Ajouter</button>
        </div>
    </div>
</div>

<script>
    // 📈 Marge calculée en direct
    function calculerMarge() {
        const achat = parseFloat(document.getElementById('prix_achat').value);
        const vente = parseFloat(document.getElementById('prix_vente').value);
        const val   = document.getElementById('marge_val');
        const pct   = document.getElementById('marge_pct');

        if (isNaN(achat) || isNaN(vente) || achat <= 0) {
            val.textContent = '— DH';
            val.className = 'text-3xl font-black text-gray-900';
            pct.textContent = 'Renseignez les deux prix.';
            pct.className = 'text-xs font-bold mt-1.5 text-gray-400';
            return;
        }

        const marge = vente - achat;
        val.textContent = marge.toFixed(2) + ' DH';

        if (marge > 0) {
            val.className = 'text-3xl font-black text-emerald-600';
            pct.textContent = `✓ +${Math.round((marge / achat) * 100)}% sur le prix d'achat`;
            pct.className = 'text-xs font-bold mt-1.5 text-emerald-600';
        } else {
            val.className = 'text-3xl font-black text-red-600';
            pct.textContent = '⚠️ Vous vendez à perte !';
            pct.className = 'text-xs font-bold mt-1.5 text-red-600';
        }
    }

    // 🖼️ Aperçu de l'image
    function previsualiserImage(input) {
        const file = input.files && input.files[0];
        if (!file) return;

        const img = document.getElementById('image_preview');
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        document.getElementById('image_placeholder').classList.add('hidden');
        document.getElementById('image_name').textContent = file.name;
    }

    // ➕ Nouvelle catégorie
    function openCategoryModal() {
        const m = document.getElementById('categoryModal');
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.getElementById('modal_error').classList.add('hidden');
    }

    function closeCategoryModal() {
        const m = document.getElementById('categoryModal');
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.getElementById('new_category_name').value = '';
        document.getElementById('modal_error').classList.add('hidden');
    }

    function submitCategoryAjax() {
        const name = document.getElementById('new_category_name').value.trim();
        const errorElement = document.getElementById('modal_error');

        if (!name) {
            errorElement.textContent = "⚠️ Le nom de la catégorie est requis.";
            errorElement.classList.remove('hidden');
            return;
        }

        fetch("{{ route('admin.categories.ajaxStore') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ nom: name })
        })
        .then(res => { if (!res.ok) throw res; return res.json(); })
        .then(data => {
            if (data.success || data.id) {
                const select = document.getElementById('category_select');
                const option = document.createElement('option');
                option.value = data.id;
                option.text = data.nom;
                option.selected = true;
                select.add(option);
                closeCategoryModal();

                Swal.fire({
                    title: 'Succès !',
                    text: 'La catégorie a été ajoutée.',
                    icon: 'success',
                    confirmButtonColor: '#10b981'
                });
            } else {
                errorElement.textContent = "⚠️ " + (data.message || "Erreur lors de l'ajout.");
                errorElement.classList.remove('hidden');
            }
        })
        .catch(async (err) => {
            try {
                const d = await err.json();
                errorElement.textContent = "⚠️ " + (d.message || "Cette catégorie existe déjà.");
            } catch (e) {
                errorElement.textContent = "⚠️ Une erreur est survenue.";
            }
            errorElement.classList.remove('hidden');
        });
    }
</script>
@endsection
