<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter] flex">

    @if(session('success'))
<div class="flex items-center p-4 mb-8 text-green-800 border-t-4 border-green-300 bg-green-50 rounded-2xl shadow-sm">
    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div class="ml-3 text-sm font-bold tracking-tight">
        {{ session('success') }}
    </div>
</div>
@endif

    <aside class="w-64 min-h-screen bg-gray-900 text-white p-6 hidden md:block">
        <h1 class="text-2xl font-bold text-green-500 mb-10 text-center">ParaAdmin</h1>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded text-gray-400 hover:bg-gray-800 hover:text-white transition">Tableau de bord</a>
            <a href="{{ route('admin.produits') }}" class="block py-2.5 px-4 rounded bg-green-600 text-white font-medium">Mes Produits</a>
            <a href="{{ route('admin.commandes') }}" class="block py-2.5 px-4 rounded text-gray-400 hover:bg-gray-800 hover:text-white transition">Commandes</a>
            <a href="#" class="block py-2.5 px-4 rounded text-gray-400 hover:bg-gray-800 hover:text-white transition">Profil</a>
        </nav>
    </aside>
    

    <main class="flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Mes Produits</h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-600 transition"> + Ajouter un produit</a>
        </header>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Image</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Nom</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Prix</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Stock</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($produits as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-center">
                            @if($item->image)
                                <img src="{{ asset('images/products/' . $item->image) }}" class="w-12 h-12 object-cover rounded-lg shadow-sm mx-auto">
                            @else
                                <span class="text-xs text-gray-300">Pas d'image</span>
                            @endif
                        </td>
                        <td class="p-4 font-semibold text-gray-800">{{ $item->nom }}</td>
                        <td class="p-4 text-green-600 font-bold">{{ $item->prix }} DH</td>
                        <td class="p-4 text-gray-500">{{ $item->stock }}</td>
                        <td class="p-4 text-right">
                            <button class="text-blue-500 hover:underline mr-3 text-sm font-bold">Modifier</button>
                            <button class="text-red-500 hover:underline text-sm font-bold">Supprimer</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-400 font-medium">Aucun produit trouvé dans votre parapharmacie.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>