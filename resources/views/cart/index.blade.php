<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Mon Panier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 min-h-screen flex flex-col antialiased">

    <x-site-header />

    @if(session('success'))
        <div class="max-w-7xl mx-auto w-full px-6 mt-6 animate-fade-in">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl font-semibold text-sm shadow-sm flex items-center gap-3">
                <span class="p-1 rounded-lg bg-emerald-500 text-white">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto w-full px-6 mt-6 animate-fade-in">
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl font-semibold text-sm shadow-sm flex items-center gap-3">
                <span class="p-1 rounded-lg bg-rose-500 text-white">✕</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto w-full px-6 py-10 flex-grow">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    Mon Panier 
                    <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold shadow-inner">
                        {{ count($panier) }} {{ count($panier) > 1 ? 'articles' : 'article' }}
                    </span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Gérez vos articles et finalisez votre commande en toute sécurité.</p>
            </div>
        </div>

        @if(count($panier) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="lg:col-span-2 space-y-4">
                    @foreach($panier as $id => $details)
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-5 transition-all duration-300 hover:shadow-md hover:border-slate-200/60">
                            
                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                @if(isset($details['image']) && $details['image'])
                                    <div class="relative group shrink-0">
                                        <img src="{{ asset('images/products/' . $details['image']) }}" alt="{{ $details['nom'] }}" class="w-20 h-20 object-cover rounded-xl border border-slate-100 bg-slate-50">
                                    </div>
                                @endif
                                <div class="space-y-0.5">
                                    <h3 class="text-base font-bold text-slate-800 hover:text-emerald-600 transition-colors">{{ $details['nom'] }}</h3>
                                    <p class="text-xs font-semibold text-slate-400">Prix unitaire: <span class="text-slate-600 font-bold">{{ $details['prix'] }} DH</span></p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-6 border-t sm:border-t-0 pt-4 sm:pt-0 border-slate-50">
                                
                                <div class="flex items-center bg-slate-50 p-1 rounded-xl border border-slate-200/60 shadow-inner">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $details['quantite'] - 1 }}">
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white text-slate-600 rounded-lg font-bold shadow-sm hover:bg-slate-100 hover:text-emerald-600 transition cursor-pointer active:scale-95" {{ $details['quantite'] <= 1 ? 'disabled style=opacity:0.3;cursor:not-allowed;' : '' }}>
                                            –
                                        </button>
                                    </form>

                                    <span class="w-9 text-center font-bold text-slate-800 text-sm">
                                        {{ $details['quantite'] }}
                                    </span>

                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $details['quantite'] + 1 }}">
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white text-slate-600 rounded-lg font-bold shadow-sm hover:bg-slate-100 hover:text-emerald-600 transition cursor-pointer active:scale-95">
                                            +
                                        </button>
                                    </form>
                                </div>

                                <div class="text-right min-w-[85px]">
                                    <span class="font-extrabold text-slate-900 text-base">
                                        {{ $details['prix'] * $details['quantite'] }} DH
                                    </span>
                                </div>

                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-50 text-rose-500 p-2.5 rounded-xl hover:bg-rose-100 hover:text-rose-600 transition cursor-pointer active:scale-95" title="Supprimer l'article">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-6 sticky top-24">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight">Résumé & Validation</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Complétez vos coordonnées pour valider la commande.</p>
                    </div>
                    
                    <div class="bg-slate-50/80 p-4 rounded-xl space-y-3 border border-slate-100 shadow-inner">
                        <div class="flex justify-between text-slate-500 text-xs font-semibold">
                            <span>Sous-total</span>
                            <span class="font-bold text-slate-800">{{ $totalGeneral }} DH</span>
                        </div>

                    @if(session()->has('coupon'))                            <div class="flex justify-between text-rose-600 text-xs font-bold bg-rose-50/60 p-2 rounded-lg border border-rose-100/40">
                                <span class="flex items-center gap-1">🏷️ Coupon
                                    @if($couponType == 'pourcentage')
                                    ({{ $couponValeurRaw }}%)
                                    @else
                                    ({{ $couponValeurRaw }} DH)
                                    @endif
                                </span>
                                <span>-{{ $valeurRemise }} DH</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center pt-2.5 border-t border-slate-200/60">
                            <span class="font-bold text-slate-900 text-sm">Total à payer</span>
                            <span class="text-lg font-black text-emerald-600">
                               {{ session()->has('coupon')
                                ? $totalApresRemise
                                : $totalGeneral }} DH
                            </span>
                        </div>
                    </div>

                    @if(session()->has('coupon'))                        <div class="bg-emerald-50/60 border border-emerald-100 p-3 rounded-xl flex justify-between items-center">
                            <span class="text-[11px] text-emerald-700 font-bold flex items-center gap-1.5">🎉 Coupon Appliqué !</span>
                            <form action="{{ route('coupon.remove') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="text-[11px] font-extrabold text-rose-500 hover:text-rose-700 transition cursor-pointer">Retirer</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('coupon.apply') }}" method="POST" class="flex gap-2">
                            @csrf
                            <div class="relative flex-1">
                                <input type="text" name="coupon_code" placeholder="🎁 CODE PROMO (EX: PARA20)" class="w-full pl-3.5 pr-2 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white transition text-xs font-bold tracking-wider uppercase" required>
                            </div>
                            <button type="submit" class="bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-black transition-colors shadow-sm cursor-pointer active:scale-95">
                                Appliquer
                            </button>
                        </form>
                    @endif

                    <hr class="border-slate-100">

                    <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-600 tracking-wide uppercase">Nom Complet</label>
                            <input type="text" name="nom_complet" placeholder="Ex: Ahmed Alaoui" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white transition text-xs font-semibold text-slate-800" required>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-600 tracking-wide uppercase">Numéro de Téléphone</label>
                            <input type="tel" name="telephone" placeholder="Ex: 0612345678" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white transition text-xs font-semibold text-slate-800" required>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-600 tracking-wide uppercase">Adresse de Livraison</label>
                            <textarea name="adresse" placeholder="N°, Rue, Quartier, Ville..." class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white transition text-xs font-semibold text-slate-800" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="w-full mt-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-3.5 rounded-xl text-xs shadow-md shadow-emerald-600/10 hover:shadow-xl hover:shadow-emerald-600/20 transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 active:scale-[0.98]">
                            <span>Confirmer et Commander</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 max-w-xl mx-auto shadow-sm my-12 transition-all duration-300 hover:shadow-md">
                <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mx-auto mb-5 border border-slate-100/60">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800 tracking-tight">Votre panier est vide</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mt-2 mb-6 leading-relaxed">Il semblerait que vous n'ayez pas encore ajouté de produits. Explorez notre parapharmacie pour trouver votre bonheur.</p>
                <a href="/" class="inline-flex bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition shadow-md shadow-emerald-600/10 hover:shadow-lg hover:shadow-emerald-600/20 active:scale-95 cursor-pointer">
                    Découvrir nos produits
                </a>
            </div>
        @endif
    </main>

    <x-site-footer />

</body>
</html>