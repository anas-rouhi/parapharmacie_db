<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-extrabold text-green-600 tracking-tight">
                        PARA<span class="text-blue-600">SANTE</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center flex-1 px-10">
                    <div class="w-full max-w-lg">
                        <input type="text" placeholder="Rechercher un produit..." class="w-full border-gray-200 rounded-full bg-gray-100 px-5 py-2 focus:ring-green-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-green-600 transition">Mon Compte</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-green-600 transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-md hover:bg-green-700 transition transform hover:scale-105">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <header class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    Prenez soin de <span class="text-green-600">votre santé</span> au quotidien
                </h1>
                <p class="mt-4 text-xl text-gray-500 max-w-2xl">
                    Découvrez notre large gamme de produits parapharmaceutiques sélectionnés par des experts pour votre bien-être.
                </p>
                <div class="mt-10">
                    <a href="#produits" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                        Voir les produits
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 mt-12 lg:mt-0 px-10">
                <div class="bg-green-100 rounded-3xl h-64 lg:h-80 flex items-center justify-center text-green-500 font-bold text-lg border-2 border-dashed border-green-300">
                    Image Parapharmacie Ici
                </div>
            </div>
        </div>
    </header>

    <main id="produits" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Nos Meilleurs Produits</h2>
            <a href="#" class="text-green-600 font-semibold hover:underline text-sm">Voir tout →</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($produits as $item)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gray-100 relative overflow-hidden">
                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                            @if($item->image)
                                <img src="{{ asset('images/products/' . $item->image) }}" 
                                    alt="{{ $item->nom }}" 
                                    class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-200">
                                    <span class="text-xs italic font-semibold uppercase tracking-widest">Image non disponible</span>
                                </div>
                            @endif
                            
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] px-2 py-1 rounded-md font-bold uppercase">Nouveau</span>
                        </div>
                        <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-md font-bold italic">Promo</span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Catégorie</p>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition truncate">{{ $item->nom }}</h3>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xl font-black text-gray-900">{{ $item->prix }} DH</span>
                            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-gray-900 text-white p-2 rounded-lg hover:bg-green-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-400">Aucun produit disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 ParaSante. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>