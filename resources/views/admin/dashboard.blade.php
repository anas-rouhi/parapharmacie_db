@extends('layouts.admin')

@section('title', 'ParaAdmin | Dashboard')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-6 font-semibold text-sm shadow-sm">
        <p class="font-black mb-2 uppercase tracking-wide">❌ Il y a des erreurs dans le formulaire :</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-12">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight">Bienvenue, {{ Auth::user()->name }}</h2>
                <span class="bg-red-50 text-red-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider border border-red-200/40 shadow-sm">
                    {{ Auth::user()->role }}
                </span>
            </div>
            <a href="{{ route('admin.reports.exportPdf') }}" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-black px-4 py-2.5 rounded-xl shadow-md shadow-gray-200 transition duration-200">
                <span>📊</span> Télécharger le Rapport PDF
            </a>
        </div>

        @if(isset($produitsAlerte) && $produitsAlerte->count() > 0)
            <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-3xl shadow-sm">
                <div class="flex items-start gap-3">
                    <span class="text-xl mt-0.5">⚠️</span>
                    <div class="flex-1">
                        <h4 class="text-base font-black text-amber-950 uppercase tracking-wide">
                            Attention: Produits presque épuisés !
                        </h4>
                        <p class="text-xs font-semibold text-amber-800 mt-0.5">
                            Les articles suivants ont atteint le niveau critique. Pensez à réapprovisionner le stock :
                        </p>
                        
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($produitsAlerte as $p)
                                <span class="inline-flex items-center bg-white border border-amber-200 text-amber-900 px-3 py-1 rounded-xl text-xs font-bold shadow-xs">
                                    📦 {{ $p->nom }} 
                                    <span class="ml-2 bg-amber-500 text-white px-1.5 py-0.5 rounded-lg text-[10px] font-black">
                                        {{ $p->stock }} restants
                                    </span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date Début :</label>
                    <input type="date" name="date_debut" value="{{ $dateDebut }}" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-green-500 font-semibold text-gray-700 outline-none">
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date Fin :</label>
                    <input type="date" name="date_fin" value="{{ $dateFin }}" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-green-500 font-semibold text-gray-700 outline-none">
                </div>
                <div class="w-full md:w-1/3 flex gap-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition duration-200 shadow-md cursor-pointer border-none">
                        🔍 Filtrer
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-sm px-4 py-3 rounded-xl transition duration-200 text-center flex items-center justify-center decoration-none">
                        🔄 Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm flex items-center justify-between transition hover:shadow-md">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Total Produits</span>
                    <span class="text-3xl font-black text-gray-800 block mt-2">{{ $totalProduits }}</span>
                </div>
                <div class="h-12 w-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 text-xl font-bold shadow-sm">📦</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm flex items-center justify-between transition hover:shadow-md">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Total Categories</span>
                    <span class="text-3xl font-black text-blue-600 block mt-2">{{ $totalCategories }}</span>
                </div>
                <div class="h-12 w-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-xl font-bold shadow-sm">🏷️</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm flex flex-col justify-between transition hover:shadow-md {{ $stockLimite > 0 ? 'border-l-4 border-l-orange-500' : '' }}">
                <div class="flex items-center justify-between w-full">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Stock Critique (&lt;=3)</span>
                        <span class="text-3xl font-black {{ $stockLimite > 0 ? 'text-orange-500 animate-pulse' : 'text-gray-800' }} block mt-2">{{ $stockLimite }}</span>
                    </div>
                    <div class="h-12 w-12 {{ $stockLimite > 0 ? 'bg-orange-50 text-orange-500' : 'bg-gray-100 text-gray-400' }} rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm">⚠️</div>
                </div>
                @if($stockLimite > 0)
                    <div class="mt-4 pt-2 border-t border-gray-100 w-full">
                        <button onclick="openStockOrderModal()" class="w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2.5 px-3 rounded-xl transition shadow-md flex items-center justify-center gap-1.5 cursor-pointer border-none">
                            📊 Préparer Bon de Commande
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200/60 border-l-4 border-l-blue-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Commandes (Période)</p>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ $totalCommandes }}</p>
                </div>
                <span class="text-2xl p-2 bg-gray-50 rounded-xl">🛒</span>
            </div>
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200/60 border-l-4 border-l-purple-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Chiffre d'Affaires</p>
                    <p class="text-3xl font-black text-purple-700 mt-2">{{ number_format($totalRevenu, 2) }} DH</p>
                </div>
                <span class="text-2xl p-2 bg-gray-50 rounded-xl">💰</span>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200/60 border-l-4 border-l-green-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Bénéfice Net (Est.)</p>
                    <p class="text-3xl font-black text-green-600 mt-2">{{ number_format($totalBenefice, 2) }} DH</p>
                </div>
                <span class="text-2xl p-2 bg-gray-50 rounded-xl">📈</span>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-200/60">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-6">
                <div>
                    <h3 class="text-xl font-black text-gray-800 flex items-center gap-2">
                        <span>📊</span> Analyse des Ventes & Bénéfices
                    </h3>
                    <p class="text-xs text-gray-400 font-medium mt-1">Rapports visuels de l'évolution financière de la parapharmacie</p>
                </div>
                <div class="flex gap-4 text-xs font-bold mt-2 sm:mt-0">
                    <span class="flex items-center gap-1.5 text-purple-600">
                        <span class="h-3 w-3 rounded-full bg-purple-500 block"></span> Chiffre d'Affaires
                    </span>
                    <span class="flex items-center gap-1.5 text-green-600">
                        <span class="h-3 w-3 rounded-full bg-green-500 block"></span> Bénéfice Net
                    </span>
                </div>
            </div>
            <div>
                <canvas id="analyticsChart" height="120"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-200/60">
            <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center">
                <span class="bg-green-100 text-green-600 p-2 rounded-xl mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                Ajouter un nouveau produit
            </h3>

            <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nom du produit</label>
                    <input type="text" name="nom" required placeholder="Nom du produit" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-gray-900 font-medium transition shadow-sm">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Prix d'achat (DH)</label>
                        <input type="number" step="0.01" name="prix_achat" required placeholder="Prix d'achat" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-gray-900 font-bold transition shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Prix de vente (DH)</label>
                        <input type="number" step="0.01" name="prix" required placeholder="Prix de vente" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-gray-900 font-bold transition shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Catégorie :</label>
                    <div class="flex gap-2">
                        <select id="category_select" name="category_id" class="bg-gray-50 border border-gray-200 rounded-xl w-full py-3.5 px-3 text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="openCategoryModal()" class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 rounded-xl shadow-md transition border-none cursor-pointer text-lg">+</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Stock disponible</label>
                    <input type="number" name="stock" required placeholder="Stock" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-gray-900 font-bold transition shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Détails du produit..." class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-gray-900 font-medium transition shadow-sm"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Image du produit</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 text-center hover:border-green-400 transition bg-gray-50/50">
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                    </div>
                </div>
                
                <div class="md:col-span-2 mt-4 text-right">
                    <button type="submit" class="bg-green-600 text-white px-12 py-4 rounded-2xl font-black shadow-lg shadow-green-100 hover:bg-green-700 hover:scale-[1.01] transition-all duration-300 uppercase tracking-wider text-sm border-none w-full md:w-auto cursor-pointer">Enregistrer le produit</button>
                </div>
            </form>
        </div>

       <div id="categoryModal" class="fixed inset-0 bg-gray-900/60 hidden flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-3xl shadow-xl max-w-sm w-full mx-4 border border-gray-200 animate-in fade-in zoom-in-95 duration-150">
                <h3 class="text-lg font-black text-gray-900 mb-4">Ajouter une nouvelle catégorie</h3>
                <input type="text" id="new_category_name" class="border border-gray-200 rounded-xl w-full py-3 px-4 bg-gray-50 text-gray-700 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500 font-semibold" placeholder="Nom de la catégorie">
                <p id="modal_error" class="text-red-500 text-xs hidden mb-2 font-bold">⚠️ </p>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCategoryModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-4 rounded-xl transition border-none text-sm cursor-pointer">Annuler</button>
                    <button type="button" onclick="submitCategoryAjax()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-xl transition border-none text-sm cursor-pointer">Ajouter</button>
                </div>
            </div>
        </div>

        <div id="stockOrderModal" class="fixed inset-0 bg-gray-900/60 hidden flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-3xl shadow-xl max-w-2xl w-full mx-4 border border-gray-200 max-h-[85vh] flex flex-col">
                <h3 class="text-lg font-black text-gray-900 mb-2 flex items-center gap-2">
                    📋 Préparer les Quantités à Commander
                </h3>
                <p class="text-xs text-gray-500 mb-4">Saisissez les quantités désirées pour chaque produit en alerte avant de lancer l'impression.</p>
                
                <div class="overflow-y-auto flex-1 pr-1 space-y-3" id="modal_stock_list">
                    </div>

                <div class="flex justify-end gap-2 mt-6 border-t border-gray-100 pt-4">
                    <button type="button" onclick="closeStockOrderModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-4 rounded-xl transition text-sm cursor-pointer border-none">Annuler</button>
                    <button type="button" onclick="printConfiguredStockReport()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition text-sm flex items-center gap-1.5 cursor-pointer border-none shadow-md">
                        🖨️ Imprimer le Bon
                    </button>
                </div>
            </div>
        </div>
        
    </div>

   <form id="flashSaleForm" action="{{ route('admin.products.flash.save') }}" method="POST" class="mt-6 p-6 bg-slate-50 rounded-2xl border border-slate-200 shadow-sm max-w-4xl mx-auto">
    @csrf

    <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
        <i class="fa-solid fa-bolt text-amber-500 animate-pulse"></i> Configuration Spécifique du Produit / Pack Flash
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="md:col-span-2">
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Choisir le Produit / Pack Principal</label>
            <select id="product_select" name="product_id" required onchange="updateFormAction(this.value)" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="" selected disabled>-- Sélectionner un produit --</option>
                @foreach($produits as $p)
                    <option value="{{ $p->id }}" 
                            data-flash="{{ $p->is_flash_sale ?? 0 }}" 
                            data-prix="{{ $p->prix_flash ?? '' }}" 
                            data-end="{{ $p->flash_sale_end ?? '' }}"
                            data-quantite-vendue="{{ $p->quantite_flash_vendue ?? 0 }}">
                        {{ $p->nom }} ({{ $p->prix }} DH)
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">ID du Produit Sélectionné</label>
            <input type="text" id="display_product_id" readonly placeholder="Aucun" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-100 font-mono font-bold text-center text-gray-700 outline-none">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Prix Spécial du Pack (DH)</label>
            <input type="number" step="0.01" id="prix_flash" name="prix_flash" required placeholder="Prix" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Quantité Flash / Vendue</label>
            <input type="number" id="quantite_flash_input" name="quantite_flash_vendue" placeholder="Quantité" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Statut de l'Offre</label>
            <select id="is_flash_sale" name="is_flash_sale" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 font-semibold">
                <option value="0">Désactiver (Normal)</option>
                <option value="1" selected>Activer (Flash Sale / Pack)</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Date de Fin de l'Offre</label>
            <input type="datetime-local" id="flash_sale_end" name="flash_sale_end" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>

    <div class="mt-5">
        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Sélectionner les produits inclus dans ce Pack :</label>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-40 overflow-y-auto p-3 bg-white rounded-xl border border-slate-200">
            @foreach($produits as $p)
                <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer p-1.5 rounded-lg hover:bg-slate-50 select-none">
                    <input type="checkbox" name="pack_items[]" value="{{ $p->nom }}" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300">
                    <span class="truncate">{{ $p->nom }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="mt-5 flex justify-end border-t border-slate-200 pt-4">
        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-black px-5 py-3 rounded-xl uppercase tracking-wider shadow-md transition transform active:scale-95 cursor-pointer duration-150">
            <i class="fa-solid fa-circle-check text-sm"></i>
            Confirmer la configuration
        </button>
    </div>
</form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function updateFormAction(productId) {
            // 1. كنعرضو الـ ID ف الحقل المخصص ليه باش يبان للـ Admin
            document.getElementById('display_product_id').value = productId ? productId : 'Aucun';

            const select = document.getElementById('product_select');
            const option = select.options[select.selectedIndex];
            
            if (option && productId) {
                if(document.getElementById('prix_flash')) {
                    document.getElementById('prix_flash').value = option.getAttribute('data-prix') || '';
                }
                if(document.getElementById('flash_sale_end')) {
                    document.getElementById('flash_sale_end').value = option.getAttribute('data-end') || '';
                }
                if(document.getElementById('quantite_flash_input')) {
                    document.getElementById('quantite_flash_input').value = option.getAttribute('data-quantite-vendue') || '0';
                }
                if(document.getElementById('is_flash_sale')) {
                    document.getElementById('is_flash_sale').value = option.getAttribute('data-flash') || '0';
                }
            }
        }

        // 🌟 وظائف الـ Modal الجديدة والمطورة للـ Bon de Commande
        const produitsCritiquesGlobal = {!! json_encode($produitsCritiques ?? []) !!};

        function openStockOrderModal() {
            const listContainer = document.getElementById('modal_stock_list');
            listContainer.innerHTML = ''; // تنظيف القائمة

            if(produitsCritiquesGlobal.length === 0) {
                Swal.fire('Parfait !', 'Aucun produit en rupture de stock.', 'success');
                return;
            }

            // رسم المنتجات والـ inputs وسط الـ Modal ديناميكياً
            produitsCritiquesGlobal.forEach((prod, index) => {
                let productID = prod.id || prod.id_produit || 'N/A';
                listContainer.innerHTML += `
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-2xl gap-3">
                        <div>
                            <span class="text-[10px] font-mono font-bold text-gray-400 block">#PROD-${productID}</span>
                            <span class="text-sm font-bold text-gray-800">${prod.nom}</span>
                            <span class="text-xs text-red-500 font-semibold block mt-0.5">Stock actuel: ${prod.stock} pcs</span>
                        </div>
                        <div class="w-full sm:w-auto">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Qté à commander</label>
                            <input type="number" id="qte_order_${index}" data-id="${productID}" data-nom="${prod.nom}" data-stock="${prod.stock}" min="1" value="20" class="w-full sm:w-28 border border-gray-300 rounded-xl px-3 py-1.5 text-sm font-bold text-gray-800 outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>
                `;
            });

            document.getElementById('stockOrderModal').classList.remove('hidden');
        }

        function closeStockOrderModal() {
            document.getElementById('stockOrderModal').classList.add('hidden');
        }

        // دالة الطباعة الاحترافية اللي كتاخد القيم اللي دخل الـ Admin دابا بلا ما تقلب الصفحة لليسر
        function printConfiguredStockReport() {
            let htmlContent = `
                <html>
                <head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
                    <title>Bon de Commande - Signalement Stock</title>
                    <style>
                        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #333; padding: 40px; }
                        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #22c55e; padding-bottom: 20px; }
                        .header h1 { color: #22c55e; margin: 0; font-size: 28px; }
                        .header p { color: #666; margin: 5px 0 0 0; }
                        .date { text-align: right; margin-bottom: 20px; font-weight: bold; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                        th { background-color: #f8fafc; color: #1e293b; }
                        tr:nth-child(even) { background-color: #fdfdfd; }
                        .critical { color: #dc2626; font-weight: bold; }
                        .order-qty { color: #16a34a; font-weight: bold; font-size: 15px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>📋 BON DE COMMANDE / ALERTE STOCK</h1>
                        <p>Système de Gestion ParaPharmacie - PARAADMIN</p>
                    </div>
                    <div class="date">Fait le : ${new Date().toLocaleDateString('fr-FR')}</div>
                    <p>Veuillez trouver ci-dessous les détails des quantités de réapprovisionnement configurées :</p>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Produit</th>
                                <th>Stock Actuel</th>
                                <th>Quantité à Commander</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            produitsCritiquesGlobal.forEach((prod, index) => {
                const inputElement = document.getElementById(`qte_order_${index}`);
                const qtyToOrder = inputElement ? inputElement.value : 0;
                let productID = prod.id || prod.id_produit || 'N/A';

                htmlContent += `
                    <tr>
                        <td>#${productID}</td>
                        <td><b>${prod.nom}</b></td>
                        <td class="critical">${prod.stock} pcs</td>
                        <td class="order-qty">+ ${qtyToOrder} pcs</td>
                    </tr>
                `;
            });

            htmlContent += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;

            // فتح نافذة طباعة مخفية ومباشرة بدون التأثير على الصفحة الأم
            let printWindow = window.open('', '_blank');
            printWindow.document.write(htmlContent);
            printWindow.document.close();
            
            // تشغيل الطبع المباشر وإغلاق النافذة المنبثقة تلقائياً
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);

            closeStockOrderModal();
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Alert Stock Critique Initial via SweetAlert2
            const produitsCritiques = {!! json_encode($produitsCritiques ?? []) !!};
            if (produitsCritiques.length > 0) {
                let listeProduits = '<ul style="text-align: left; max-height: 200px; overflow-y: auto; padding-left: 20px;">';
                produitsCritiques.forEach(prod => {
                    listeProduits += `<li style="margin-bottom: 8px; color: #dc2626;">❌ <b>${prod.nom}</b> (Reste: ${prod.stock} pcs)</li>`;
                });
                listeProduits += '</ul>';

                Swal.fire({
                    title: '⚠️ Alertes Stock Critique !',
                    html: `<p style="margin-bottom: 15px;">Les produits suivants sont presque en rupture de stock :</p>${listeProduits}`,
                    icon: 'warning',
                    confirmButtonColor: '#22c55e',
                    confirmButtonText: 'D’accord',
                    backdrop: `rgba(220, 38, 38, 0.1)`
                });
            }

            // Chart.js Configuration
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: "Chiffre d'Affaires",
                            data: {!! json_encode($chartSales) !!},
                            backgroundColor: '#3b82f6',
                            borderRadius: 6,
                            barPercentage: 0.5,
                            categoryPercentage: 0.6
                        },
                        {
                            label: 'Bénéfice Net',
                            data: {!! json_encode($chartProfits) !!},
                            backgroundColor: '#22c55e',
                            borderRadius: 6,
                            barPercentage: 0.5,
                            categoryPercentage: 0.6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        });


     // ==========================================
// 🌟 Modals Categories Functions (🔴 FINAL & CLEAN)
// ==========================================
function openCategoryModal() { 
    document.getElementById('categoryModal').classList.remove('hidden'); 
    document.getElementById('modal_error').classList.add('hidden');
}

function closeCategoryModal() { 
    document.getElementById('categoryModal').classList.add('hidden'); 
    document.getElementById('new_category_name').value = ''; 
    document.getElementById('modal_error').classList.add('hidden');
}

function submitCategoryAjax() {
    const name = document.getElementById('new_category_name').value.trim();
    const errorElement = document.getElementById('modal_error');
    
    // 1. الـ Validation ف الـ Frontend قبل ما يصيفط
    if(!name) {
        errorElement.textContent = "⚠️ Le nom de la catégorie est requis.";
        errorElement.classList.remove('hidden');
        return;
    }

    // 2. إرسال الـ الطلب بالـ Route الصحيح ديال الـ Controller
    fetch("{{ route('admin.categories.ajaxStore') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ nom: name })
    })
    .then(response => {
        if (!response.ok) {
            throw response;
        }
        return response.json();
    })
    .then(data => {
        if(data.success || data.id) {
            // 3. جلب الـ Select وزيادة الـ Option الجديدة ديناميكياً
            let select = document.getElementById('category_select');
            let option = document.createElement('option');
            option.value = data.id;
            option.text = data.nom;
            option.selected = true; // كترجع هي المعزولة ديريكت
            select.add(option);
            
            // 4. شد الـ Modal ونقي الـ Input
            closeCategoryModal();

            // 5. زواقة بـ SweetAlert2 مادام ملقم ف الباج
            Swal.fire({
                title: 'Succès !',
                text: 'La catégorie a été ajoutée avec succès.',
                icon: 'success',
                confirmButtonColor: '#22c55e'
            });
        } else {
            errorElement.textContent = "⚠️ " + (data.message || "Erreur lors de l'ajout.");
            errorElement.classList.remove('hidden');
        }
    })
    .catch(async (err) => {
        console.error("Erreur:", err);
        try {
            const errorData = await err.json();
            errorElement.textContent = "⚠️ " + (errorData.message || "Cette catégorie existe déjà.");
        } catch(e) {
            errorElement.textContent = "⚠️ Une erreur est survenue. Vérifiez le nom.";
        }
        errorElement.classList.remove('hidden');
    });
}
    </script>
@endsection