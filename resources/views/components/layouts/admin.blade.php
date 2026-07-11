<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ParaAdmin' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script>
        // Détection immédiate du thème pour éviter le flash blanc
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-[Inter] flex min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <aside class="w-64 bg-white dark:bg-gray-950 text-gray-800 dark:text-white p-6 hidden md:block flex-shrink-0 border-r border-gray-200 dark:border-gray-800 transition-colors duration-300">
        <h1 class="text-2xl font-bold text-green-500 mb-10 text-center uppercase tracking-widest">ParaAdmin</h1>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100 dark:shadow-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">Tableau de bord</a>
            <a href="{{ route('admin.produits') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 {{ request()->routeIs('admin.produits') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100 dark:shadow-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">Mes Produits</a>
            <a href="{{ route('admin.commandes') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 {{ request()->routeIs('admin.commandes') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100 dark:shadow-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">Commandes</a>
            <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-green-600 text-white font-bold shadow-md shadow-green-100 dark:shadow-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">Utilisateurs</a>
            <hr class="border-gray-200 dark:border-gray-800 my-4">
            <a href="{{ route('admin.logs') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 {{ request()->routeIs('admin.logs') ? 'bg-red-600 text-white font-semibold' : 'text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-red-500' }}">🔒 Journal d'Audit</a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
        <header class="bg-white dark:bg-gray-950 border-b border-gray-200 dark:border-gray-800 p-6 flex justify-between items-center transition-colors duration-300">
            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Espace Administration</h2>
            
            <button id="theme-toggle" class="p-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm">
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 17.95a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zm-2.122-10.6a1 1 0 011.414 0l.707.707a1 1 0 11-1.414 1.414l-.707-.707a1 1 0 010-1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path></svg>
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>
        </header>

        <main class="p-6 md:p-10 flex-1">
            {{ $slot }}
        </main>
    </div>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function updateIcons() {
            if (document.documentElement.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }
        updateIcons();

        themeToggleBtn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateIcons();
        });
    </script>
</body>
</html>