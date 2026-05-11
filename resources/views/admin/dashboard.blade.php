<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter] flex text-gray-900">

    <aside class="w-64 min-h-screen bg-gray-900 text-white p-6 hidden md:block">
        <h1 class="text-2xl font-bold text-green-500 mb-10 text-center uppercase tracking-widest">ParaAdmin</h1>
        <nav class="space-y-4">
    <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800' }}">Tableau de bord</a>
    <a href="{{ route('admin.produits') }}" class="block py-2.5 px-4 rounded {{ request()->routeIs('admin.produits') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800' }}">Mes Produits</a>
    <a href="{{ route('admin.commandes') }}" class="block py-2.5 px-4 rounded {{ request()->routeIs('admin.commandes') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800' }}">Commandes</a>
</nav>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Bienvenue, {{ Auth::user()->name }}</h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:bg-red-600 transition shadow-sm">Déconnexion</button>
            </form>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 border-l-4 border-l-green-500">
                <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Total Produits</p>
                <p class="text-3xl font-black text-gray-800 mt-2">{{ $totalProduits }}</p>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
                <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Commandes</p>
                <p class="text-3xl font-black text-gray-800 mt-2">{{ $totalCommandes }}</p>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 border-l-4 border-l-purple-500">
                <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Revenu</p>
                <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($totalRevenu, 2) }} DH</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <span class="bg-green-100 text-green-600 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                Ajouter un nouveau produit
            </h3>

           @if(session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-xl mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded-xl mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
            <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Nom du produit</label>
                    <input type="text" name="nom" placeholder="Ex: Vitamine C" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Prix (DH)</label>
                    <input type="number" name="prix" placeholder="0.00" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Catégorie du produit</label>
                    <select name="category_id" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none bg-white transition">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Stock disponible</label>
                    <input type="number" name="stock" placeholder="10" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Détails du produit..." class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Image du produit</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 text-center hover:border-green-400 transition">
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                    </div>
                </div>
                
                <div class="md:col-span-2 mt-4 text-right">
                    <button type="submit" class="bg-green-600 text-white px-12 py-4 rounded-2xl font-bold shadow-lg hover:bg-green-700 hover:shadow-xl transition-all duration-300">
                        Enregistrer le produit
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>