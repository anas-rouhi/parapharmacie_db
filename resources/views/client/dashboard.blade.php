<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaStaff | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 min-h-screen flex flex-col md:flex-row text-slate-900">

    <!-- Sidebar: Modern Tech & Clean Look for Staff -->
    <aside class="w-64 bg-slate-900 text-white p-6 hidden md:flex flex-col justify-between flex-shrink-0 border-r border-slate-800 shadow-xl">
        <div>
            <div class="flex items-center gap-3 mb-10 px-2">
                <div class="h-8 w-8 rounded-lg bg-emerald-500 flex items-center justify-center font-bold text-white shadow-lg shadow-emerald-500/30">P</div>
                <h1 class="text-xl font-extrabold tracking-tight text-white">Para<span class="text-emerald-400">Staff</span></h1>
            </div>
            
            <nav class="space-y-1">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4 block mb-2">Navigation</span>
                <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl font-semibold transition-all duration-200 bg-emerald-600 text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-500">
                    <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Espace Produits
                </a>
            </nav>
        </div>
        
        <!-- Quick Footer Info for Staff -->
        <div class="bg-slate-800/50 border border-slate-800 p-4 rounded-xl text-center">
            <p class="text-xs text-slate-400">Session Sécurisée</p>
            <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-medium bg-emerald-400/10 text-emerald-400">Terminal 01</span>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-slate-100 p-6 flex justify-between items-center shadow-sm sticky top-0 z-40 backdrop-blur-md bg-white/95">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold text-slate-700">Espace Travail : {{ Auth::user()->name }}</h2>
                    <span class="bg-amber-50 border border-amber-200 text-amber-700 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">Gestionnaire Stock</span>
                </div>
                <p class="text-xs text-slate-400 mt-0.5">Flux opérationnel et inventaire en temps réel</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group flex items-center gap-2 bg-slate-50 hover:bg-rose-50 text-slate-600 hover:text-rose-600 px-4 py-2.5 rounded-xl font-bold transition-all duration-200 text-xs border border-slate-100 hover:border-rose-100 cursor-pointer">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Déconnexion
                </button>
            </form>
        </header>

        <!-- Main Body -->
        <main class="p-6 md:p-10 flex-1 overflow-y-auto">
            
            <!-- Quick KPI Cards with subtle lift animation -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Produits Référencés</span>
                        <span class="text-3xl font-extrabold text-slate-800 block mt-1 tracking-tight">{{ $produits->count() }}</span>
                    </div>
                    <div class="h-12 w-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Alertes Rupture Stock (≤3)</span>
                        <span class="text-3xl font-extrabold text-rose-600 block mt-1 tracking-tight">{{ $produits->where('stock', '<=', 3)->count() }}</span>
                    </div>
                    <div class="h-12 w-12 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center {{ $produits->where('stock', '<=', 3)->count() > 0 ? 'animate-pulse' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Global Success Session Alert -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl text-sm font-semibold mb-6 flex items-center gap-2 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0x"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Dashboard Split Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Action Form Panel (Left) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 lg:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Nouveau Produit</h3>
                    </div>

                    <form action="{{ route('staff.produits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nom du produit</label>
                            <input type="text" name="nom" required placeholder="Ex: Paracétamol 500mg" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 focus:outline-none text-sm bg-slate-50/50 transition">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Prix d'Achat (DH)</label>
                                <input type="number" name="prix_achat" step="0.01" required placeholder="0.00" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Prix de Vente (DH)</label>
                                <input type="number" name="prix" step="0.01" required placeholder="0.00" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Catégorie</label>
                                <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50 cursor-pointer transition">
                                    <option value="">Sélectionner</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Stock Initial</label>
                                <input type="number" name="stock" required placeholder="10" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Description</label>
                            <textarea name="description" rows="2" placeholder="Indications, dosage..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50 transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Fiche Image</label>
                            <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-slate-800 transition-all duration-200 shadow-md shadow-slate-900/10 mt-2 text-sm cursor-pointer">
                            Ajouter au Stock
                        </button>
                    </form>
                </div>

                <!-- Stock Table Panel (Right) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden lg:col-span-2">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            Inventaire Permanent du Stock
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aperçu</th>
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Désignation</th>
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Catégorie</th>
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">P. Achat</th>
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">P. Vente</th>
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">État Stock</th>
                                    <th class="p-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Actions</th>
                                </tr>
                            </table>
                        <div class="max-h-[500px] overflow-y-auto">
                            <table class="w-full text-left border-collapse">
                            <tbody class="divide-y divide-slate-100">
                                @forelse($produits as $prod)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4 w-16">
                                        @if($prod->image)
                                            <img src="{{ asset('images/products/' . $prod->image) }}" class="w-10 h-10 object-cover rounded-xl shadow-sm border border-slate-100">
                                        @else
                                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] text-slate-400 font-medium">No pic</div>
                                        @endif
                                    </td>
                                    <td class="p-4 font-semibold text-slate-800 text-sm">{{ $prod->nom }}</td>
                                    <td class="p-4 text-xs text-slate-500">
                                        <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-semibold">{{ $prod->categorie->nom ?? 'N/A' }}</span>
                                    </td>
                                    <td class="p-4 font-medium text-slate-400 text-xs text-center">{{ number_format($prod->prix_achat, 2) }} DH</td>
                                    <td class="p-4 font-bold text-slate-800 text-sm text-center">{{ number_format($prod->prix, 2) }} DH</td>
                                    <td class="p-4 text-center">
                                        @if($prod->stock <= 3)
                                            <span class="bg-rose-50 border border-rose-100 text-rose-600 px-2.5 py-1 rounded-full text-[11px] font-bold flex items-center justify-center gap-1 max-w-[100px] mx-auto">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                                {{ $prod->stock }} Critique
                                            </span>
                                        @else
                                            <span class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full text-[11px] font-bold inline-block">
                                                {{ $prod->stock }} unités
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" 
                                                    onclick="openEditModal({{ json_encode($prod) }})" 
                                                    class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition cursor-pointer" title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('staff.produits.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit de l\'inventaire ?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer" title="Supprimer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-sm text-slate-400 italic">Aucun produit trouvé dans le stock.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Modal with modern backdrop blur -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-md z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300 mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span class="bg-blue-50 text-blue-600 p-1.5 rounded-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </span>
                    Ajuster la Fiche Produit
                </h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-xl font-bold cursor-pointer">&times;</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Désignation Produit</label>
                    <input type="text" id="edit_nom" name="nom" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">P. Achat (DH)</label>
                        <input type="number" id="edit_prix_achat" name="prix_achat" step="0.01" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">P. Vente (DH)</label>
                        <input type="number" id="edit_prix" name="prix" step="0.01" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Catégorie</label>
                        <select id="edit_category_id" name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Quantité Réelle</label>
                        <input type="number" id="edit_stock" name="stock" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Description</label>
                    <textarea id="edit_description" name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:outline-none text-sm bg-slate-50/50"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nouvel aperçu image (Optionnel)</label>
                    <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 rounded-xl font-bold transition text-sm cursor-pointer">
                        Annuler
                    </button>
                    <button type="submit" class="w-2/3 bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-slate-800 transition shadow-md text-sm cursor-pointer">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts (Keep functionality completely intact) -->
    <script>
        function openEditModal(product) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            
            form.action = `/staff/produits/${product.id}/update`;
            
            document.getElementById('edit_nom').value = product.nom;
            document.getElementById('edit_prix').value = product.prix;
            document.getElementById('edit_prix_achat').value = product.prix_achat ? product.prix_achat : 0;
            document.getElementById('edit_category_id').value = product.category_id;
            document.getElementById('edit_stock').value = product.stock;
            document.getElementById('edit_description').value = product.description ? product.description : '';

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

</body>
</html>