<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Parapharmacie')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter] min-h-screen flex flex-col md:flex-row text-gray-900">

    <aside class="w-64 bg-white text-gray-800 p-6 hidden md:flex flex-col justify-between flex-shrink-0 border-r border-green-100 shadow-sm h-screen sticky top-0">
    
    <div>
        <h1 class="text-2xl font-black text-green-600 mb-10 text-center uppercase tracking-widest">ParaAdmin</h1>
        
        <nav class="space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" 
               class="block py-3 px-4 rounded-xl font-semibold transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                📊 Tableau de bord
            </a>
            
            <a href="{{ route('admin.produits') }}" 
               class="block py-3 px-4 rounded-xl font-semibold transition duration-200 {{ request()->routeIs('admin.produits*') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                📦 Mes Produits
            </a>
            
            <a href="{{ route('admin.commandes') }}" 
               class="block py-3 px-4 rounded-xl font-semibold transition duration-200 {{ request()->routeIs('admin.commandes*') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                🛍️ Commandes
            </a>
            
            <!-- 🎟️ البارتي الجديدة د الـ Coupons زدناها هنا -->
            <a href="{{ route('admin.coupons.index') }}" 
               class="block py-3 px-4 rounded-xl font-semibold transition duration-200 {{ request()->routeIs('admin.coupons*') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                🎟️ Codes Promo
            </a>
            
            <a href="{{ route('admin.users.index') }}" 
               class="block py-3 px-4 rounded-xl font-semibold transition duration-200 {{ request()->routeIs('admin.users*') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                👥 Utilisateurs
            </a>

            <a href="{{ route('admin.messages.index') }}" 
                class="block py-3 px-4 rounded-xl font-semibold transition duration-200 {{ request()->routeIs('admin.messages*') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                ✉️ Messages Visiteurs 
            </a>
            
            <hr class="border-green-100 my-5">
            
            <a href="{{ route('admin.logs') }}" 
               class="block py-3 px-4 rounded-xl font-medium transition duration-200 text-sm {{ request()->routeIs('admin.logs') ? 'bg-red-50 text-red-600 font-bold' : 'text-gray-500 hover:bg-red-50 hover:text-red-600' }}">
                🔒 Journal d'Audit
            </a>
        </nav>
    </div>

    <div class="pt-4 border-t border-gray-100 bg-white">
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment vous déconnecter ?');">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-bold transition duration-200 shadow-sm cursor-pointer text-sm">
                🚪 Déconnexion
            </button>
        </form>
    </div>
    
</aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-gray-100 p-6 flex justify-between items-center">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Espace Administration</h2>
            <div class="flex items-center gap-4 text-sm font-semibold text-gray-700">
                <div class="flex items-center gap-1">
                    <span>👋 Administrateur</span>
                </div>
                <button onclick="openPasswordModal()" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-2.5 py-1.5 rounded-lg transition duration-200 cursor-pointer">
                    🔑 Modifier Mot de passe
                </button>
            </div>
        </header>

        @if(session('success'))
            <div class="mx-6 md:mx-10 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('current_password') || $errors->has('new_password'))
            <div class="mx-6 md:mx-10 mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-semibold">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main class="p-6 md:p-10 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    <!-- Modal Modification Mot de passe -->
    <div id="passwordModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">🔑 Modifier le mot de passe</h3>
                <button onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600 text-xl cursor-pointer">&times;</button>
            </div>

            <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Mot de passe actuel</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nouveau mot de passe</label>
                    <input type="password" name="new_password" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="new_password_confirmation" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:outline-none text-sm">
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closePasswordModal()" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-100 transition cursor-pointer">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold bg-green-600 hover:bg-green-700 text-white shadow-md shadow-green-100 transition cursor-pointer">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            }, 10);
        }

        function closePasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

</body>
</html>