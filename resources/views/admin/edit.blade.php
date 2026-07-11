<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaAdmin | Modifier Produit</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen w-full flex flex-col md:flex-row text-gray-950 antialiased overflow-x-hidden">

    <aside class="w-64 bg-white text-gray-900 p-6 hidden md:flex flex-col flex-shrink-0 border-r border-gray-200 shadow-sm min-h-screen">
        <h1 class="text-2xl font-black text-green-600 mb-10 tracking-widest uppercase">
            ParaAdmin
        </h1>
        
        <nav class="space-y-2 flex-1">
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-50 transition duration-150">
                <span>📊</span> Tableau de bord
            </a>
            <a href="{{ route('admin.produits') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-base font-bold bg-green-600 text-white shadow-md shadow-green-100 transition duration-150">
                <span>📦</span> Mes Produits
            </a>
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-50 transition duration-150">
                <span>🛒</span> Commandes
            </a>
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-50 transition duration-150">
                <span>👥</span> Utilisateurs
            </a>
            
            <div class="pt-6 mt-6 border-t border-gray-100">
                <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-base font-semibold text-gray-500 hover:bg-gray-50 transition duration-150">
                    <span>🔒</span> Journal d'Audit
                </a>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 w-full min-h-screen">
        
        <header class="bg-white border-b border-gray-200 py-5 px-8 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest">ESPACE ADMINISTRATION</h2>
                <p class="text-sm font-semibold text-gray-500 mt-0.5">Modifier les détails du produit sélectionné</p>
            </div>
        </header>

        <main class="p-6 md:p-10 flex-1 bg-gray-50/50 flex items-center justify-center">
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-200/60 w-full max-w-2xl transition-all">
                <h3 class="text-2xl font-black text-gray-900 mb-6 tracking-tight">
                    Modifier le produit : <span class="text-green-600 font-black">{{ $produit->nom }}</span>
                </h3>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-bold mb-6">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Nom du produit</label>
                        <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 focus:outline-none font-semibold text-base text-gray-800 bg-gray-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 focus:outline-none font-semibold text-base text-gray-800 bg-gray-50/50">{{ old('description', $produit->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Prix (DH)</label>
                            <input type="number" name="prix" step="0.01" value="{{ old('prix', $produit->prix) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 focus:outline-none font-bold text-base text-gray-800 bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $produit->stock) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 focus:outline-none font-bold text-base text-gray-800 bg-gray-50/50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Catégorie</label>
                        <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 focus:outline-none font-bold text-base text-gray-800 bg-gray-50/50 cursor-pointer">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $produit->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Image du produit</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer mb-4">
                        
                        @if($produit->image)
                            <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-2xl border border-gray-200/60 w-fit">
                                <img src="{{ asset('images/products/' . $produit->image) }}" class="w-14 h-14 object-cover rounded-xl shadow-sm">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Image actuelle</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.produits') }}" class="w-1/3 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3.5 rounded-xl font-bold transition text-base text-center block">
                            Annuler
                        </a>
                        <button type="submit" class="w-2/3 bg-green-600 text-white py-3.5 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-600/20 text-base cursor-pointer">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>