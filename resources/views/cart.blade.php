<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Mon Panier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-white border-b border-gray-100 shadow-sm py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold text-green-600 tracking-tight">
                PARA<span class="text-blue-600">SANTE</span>
            </a>
            <a href="/" class="text-sm font-semibold text-gray-600 hover:text-green-600 transition flex items-center">
                ← Continuer mes achats
            </a>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-500 text-white p-4 rounded-xl font-bold text-sm shadow animate-pulse">
                {{ session('success') }}
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-500 text-white p-4 rounded-xl font-bold text-sm shadow">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 tracking-tight">Votre Panier de Mégaphasie</h1>

        @if(count($panier) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    @foreach($panier as $id => $details)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 transition hover:shadow-md">
                            
                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                @if($details['image'])
                                    <img src="{{ asset('images/products/' . $details['image']) }}" alt="{{ $details['nom'] }}" class="w-20 h-20 object-cover rounded-xl border shadow-sm">
                                @else
                                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs">Pas d'image</div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $details['nom'] }}</h3>
                                    <p class="text-green-600 font-bold text-sm mt-1">{{ $details['prix'] }} DH <span class="text-gray-400 font-normal text-xs">/ Unité</span></p>
                                    @if(isset($details['buy_type']) && $details['buy_type'] === 'pack')
                                        <span class="inline-block bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1 uppercase tracking-wide">🎁 Offre Pack</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-6">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider hidden sm:inline">Quantité :</span>
                                    
                                    <div class="flex items-center bg-gray-100 p-1 rounded-xl border border-gray-200 shadow-sm">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantite'] - 1 }}">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white text-gray-600 hover:text-red-600 rounded-lg font-bold shadow-sm hover:bg-gray-50 active:scale-95 transition" {{ $details['quantite'] <= 1 ? 'disabled style=opacity:0.4;cursor:not-allowed;' : '' }}>
                                                —
                                            </button>
                                        </form>

                                        <span class="w-10 text-center font-extrabold text-gray-800 text-sm">
                                            {{ $details['quantite'] }}
                                        </span>

                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantite'] + 1 }}">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white text-gray-600 hover:text-green-600 rounded-lg font-bold shadow-sm hover:bg-gray-50 active:scale-95 transition">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="text-right min-w-[90px]">
                                    <span class="text-xl font-black text-gray-950 tracking-tight">
                                        {{ $details['prix'] * $details['quantite'] }} DH
                                    </span>
                                </div>

                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 p-2.5 rounded-xl hover:bg-red-50 transition active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 h-fit sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Résumé de la commande</h2>
                    
                    <div class="space-y-3 pb-6 border-b border-gray-100">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Sous-total</span>
                            <span class="font-semibold">{{ $totalGeneral }} DH</span>
                        </div>
                        @if($remise > 0)
                            <div class="flex justify-between text-red-600 text-sm font-medium">
                                <span>Remise Coupon ({{ $remise }}%)</span>
                                <span>-{{ $totalGeneral - $totalApresRemise }} DH</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Livraison</span>
                            <span class="text-green-600 font-bold">Gratuite</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center py-4 mb-6">
                        <span class="text-lg font-bold text-gray-900">Total Global</span>
                        <span class="text-2xl font-black text-green-600">
                            {{ $remise > 0 ? $totalApresRemise : $totalGeneral }} DH
                        </span>
                    </div>

                    <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
                        @csrf
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Informations de livraison</h3>
                        
                        <div>
                            <input type="text" name="nom_complet" placeholder="Nom complet" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition" required>
                        </div>
                        <div>
                            <input type="tel" name="telephone" placeholder="Numéro de téléphone" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition" required>
                        </div>
                        <div>
                            <textarea name="adresse" placeholder="Adresse complète de livraison" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-xl font-bold text-center block shadow-lg hover:bg-green-700 hover:shadow-xl active:scale-[0.99] transition tracking-wide">
                            Confirmer et Commander
                        </button>
                    </form>
                </div>

            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-xl mx-auto">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium mb-6">Votre panier est actuellement vide.</p>
                <a href="/" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow">
                    Découvrir nos produits
                </a>
            </div>
        @endif
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12 mt-24">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 ParaSante. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>