<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaBoutique | Mon Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/60 text-slate-900 min-h-screen flex flex-col antialiased">

    <!-- Premium Navbar with Glassmorphism (Identique) -->
    <nav class="bg-white/80 border-b border-slate-100 shadow-sm sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="h-9 w-9 rounded-xl bg-emerald-600 flex items-center justify-center font-extrabold text-white shadow-md shadow-emerald-600/20 group-hover:bg-emerald-500 transition">🌱</div>
                <span class="text-xl font-extrabold text-slate-800 tracking-tight">Para<span class="text-emerald-600">Boutique</span></span>
            </a>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('client.commandes') }}" class="flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-600 transition bg-slate-50 hover:bg-emerald-50 px-3 py-2 rounded-xl border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Espace Commandes
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

    <!-- Main Workspace Cohesive Layout -->
    <main class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8 flex-1 w-full">
        
        <!-- Left Sidebar: Cohesive Customer Profile Card (Ddik l3iba li 3la liser) -->
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
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block px-3 mb-2">Navigation</span>
                <a href="{{ route('client.commandes') }}" class="flex items-center text-xs font-bold text-slate-700 hover:text-emerald-600 p-3 rounded-xl hover:bg-white hover:shadow-sm border border-transparent hover:border-slate-100 transition duration-200">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="ml-2.5">Historique des commandes</span>
                </a>
            </div>
        </div>

        <!-- Right Content: Profile Modification Forms -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Page Header Header -->
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Gestion du <span class="text-emerald-600">Profil</span></h1>
                <p class="text-xs text-slate-400 mt-1">Mettez à jour vos informations personnelles, sécurisez votre compte ou gérez vos accès.</p>
            </div>

            <!-- Profile Forms Space -->
            <div class="space-y-6">
                
                <!-- SECTION 1: INFORMATIONS PERSONNELLES -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 transition duration-200 hover:shadow-md">
                    <div class="max-w-xl">
                        <div class="mb-6 flex items-center gap-3 border-b border-slate-50 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">👤</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Informations du compte</h3>
                                <p class="text-[11px] text-slate-400">Modifier votre nom d'affichage et votre adresse e-mail.</p>
                            </div>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- SECTION 2: SÉCURITÉ / MOT DE PASSE -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 transition duration-200 hover:shadow-md">
                    <div class="max-w-xl">
                        <div class="mb-6 flex items-center gap-3 border-b border-slate-50 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">🔒</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Sécurité du compte</h3>
                                <p class="text-[11px] text-slate-400">Assurez-vous que votre compte utilise un mot de passe long et sécurisé.</p>
                            </div>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- SECTION 3: SUPPRESSION DU COMPTE (Danger Zone) -->
                <div class="bg-rose-50/20 rounded-3xl border border-rose-100/60 p-6 sm:p-8 transition duration-200">
                    <div class="max-w-xl">
                        <div class="mb-6 flex items-center gap-3 border-b border-rose-100/40 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm font-bold">⚠️</div>
                            <div>
                                <h3 class="text-sm font-bold text-rose-800">Zone de danger</h3>
                                <p class="text-[11px] text-rose-400/80">Action irréversible. Toutes vos données seront définitivement effacées.</p>
                            </div>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Clean Footer -->
    <footer class="bg-slate-900 text-slate-400 py-6 mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs font-medium">
            <p>&copy; 2026 ParaBoutique. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>