<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace | ParaClient</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/60 text-slate-900 min-h-screen flex flex-col">

    <nav class="bg-white/80 border-b border-slate-100 shadow-sm sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="h-9 w-9 rounded-xl bg-emerald-600 flex items-center justify-center font-extrabold text-white shadow-md shadow-emerald-600/20 group-hover:bg-emerald-500 transition">🌱</div>
                <span class="text-xl font-extrabold text-slate-800 tracking-tight">Para<span class="text-emerald-600">Boutique</span></span>
            </a>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-600 transition bg-slate-50 hover:bg-emerald-50 px-3 py-2 rounded-xl border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Boutique
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2 rounded-xl text-xs font-bold transition border border-rose-100/50 cursor-pointer">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8 flex-1 w-full">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm h-fit overflow-hidden sticky top-24">
            <div class="p-6 text-center bg-gradient-to-b from-emerald-50/40 via-white to-white pb-6 border-b border-slate-100">
                <div class="w-20 h-20 bg-gradient-to-tr from-emerald-500 to-teal-400 text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 mb-2">Membre Privilège</span>
                <h2 class="text-lg font-extrabold text-slate-800 tracking-tight">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>
            </div>
            
            <div class="p-4 bg-slate-50/50">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block px-3 mb-2">Paramètres</span>
                <a href="{{ route('profile.edit') }}" class="flex items-center text-xs font-bold text-slate-700 hover:text-emerald-600 p-3 rounded-xl hover:bg-white hover:shadow-sm border border-transparent hover:border-slate-100 transition duration-200">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="ml-2.5">Gérer mon profil</span>
                </a>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Suivi de mes commandes</h1>
                    <p class="text-xs text-slate-400 mt-1">Consultez l'état d'avancement et l'historique de vos achats parapharmaceutiques.</p>
                </div>
                <span class="bg-slate-900 text-white font-extrabold px-3 py-1.5 rounded-xl text-xs tracking-tight shadow-sm shadow-slate-900/10">
                    {{ $commandes->count() }} Commande(s)
                </span>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                @if($commandes->isEmpty())
                    <div class="p-16 text-center max-w-sm mx-auto space-y-4">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto text-2xl">🛍️</div>
                        <h3 class="text-base font-bold text-slate-800">Aucun achat pour le moment</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">Votre panier attend d'être rempli avec nos meilleurs produits de soins et compléments.</p>
                        <a href="{{ route('home') }}" class="inline-block bg-emerald-600 text-white text-xs font-bold px-5 py-3 rounded-xl hover:bg-emerald-700 transition shadow-md shadow-emerald-600/10">
                            Parcourir le catalogue
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="p-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Référence</th>
                                    <th class="p-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Date d'achat</th>
                                    <th class="p-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Montant Total</th>
                                    <th class="p-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center" style="width: 340px;">Étape de livraison</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach($commandes as $commande)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="p-5 font-bold text-slate-800 text-sm">
                                        <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg">#CMD-{{ $commande->id }}</span>
                                    </td>
                                    <td class="p-5 text-xs font-semibold text-slate-500">{{ $commande->created_at->format('d M Y à H:i') }}</td>
                                    <td class="p-5 font-extrabold text-emerald-600 text-sm">{{ number_format($commande->total, 2) }} DH</td>
                                    
                                    <td class="p-5">
                                        @php
                                            $status = strtolower($commande->status);
                                            $step = 1; // 1 = Attente, 2 = Validé, 3 = Livré
                                            $isCancelled = false;

                                            if(in_array($status, ['valide', 'validée'])) {
                                                $step = 2;
                                            } elseif(in_array($status, ['livre', 'livrée'])) {
                                                $step = 3;
                                            } elseif(in_array($status, ['annule', 'annulée'])) {
                                                $isCancelled = true;
                                            }
                                        @endphp

                                        <div class="flex flex-col gap-3 mx-auto w-full max-w-[280px]">
                                            @if($isCancelled)
                                                <div class="bg-rose-50 border border-rose-100 text-rose-600 text-center py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-wider flex items-center justify-center gap-1.5 shadow-inner">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    Commande Annulée
                                                </div>
                                            @else
                                                <div class="relative flex items-center justify-between w-full px-2">
                                                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-0.5 bg-slate-100 z-0">
                                                        <div class="h-full bg-emerald-500 transition-all duration-500" style="width: {{ $step == 1 ? '0%' : ($step == 2 ? '50%' : '100%') }}"></div>
                                                    </div>

                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="h-5 w-5 rounded-full flex items-center justify-center border-2 text-[9px] font-bold transition-all duration-300 {{ $step >= 1 ? 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-white border-slate-200 text-slate-400' }}">
                                                            ✓
                                                        </div>
                                                        <span class="text-[9px] font-bold mt-1.5 {{ $step == 1 ? 'text-slate-800 font-extrabold' : 'text-slate-400' }}">Attente</span>
                                                    </div>

                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="h-5 w-5 rounded-full flex items-center justify-center border-2 text-[9px] font-bold transition-all duration-300 {{ $step >= 2 ? 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-white border-slate-200 text-slate-400' }}">
                                                            {{ $step >= 2 ? '✓' : '2' }}
                                                        </div>
                                                        <span class="text-[9px] font-bold mt-1.5 {{ $step == 2 ? 'text-emerald-600 font-extrabold' : 'text-slate-400' }}">Validée</span>
                                                    </div>

                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="h-5 w-5 rounded-full flex items-center justify-center border-2 text-[9px] font-bold transition-all duration-300 {{ $step == 3 ? 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-600/20' : 'bg-white border-slate-200 text-slate-400' }}">
                                                            {{ $step == 3 ? '✓' : '3' }}
                                                        </div>
                                                        <span class="text-[9px] font-bold mt-1.5 {{ $step == 3 ? 'text-blue-600 font-extrabold' : 'text-slate-400' }}">Livrée</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>

</body>
</html>