<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter] flex">

    <aside class="w-64 min-h-screen bg-gray-900 text-white p-6 hidden md:block">
        <h1 class="text-2xl font-bold text-green-500 mb-10 text-center uppercase tracking-widest">ParaAdmin</h1>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded text-gray-400 hover:bg-gray-800 transition">Tableau de bord</a>
            <a href="{{ route('admin.produits') }}" class="block py-2.5 px-4 rounded text-gray-400 hover:bg-gray-800 transition">Mes Produits</a>
            <a href="{{ route('admin.commandes') }}" class="block py-2.5 px-4 rounded bg-green-600 text-white font-medium">Commandes</a>
            <a href="#" class="block py-2.5 px-4 rounded text-gray-400 hover:bg-gray-800 transition">Profil</a>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Gestion des Commandes</h2>
        </header>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-5 text-xs uppercase tracking-wider font-bold text-gray-500">Réf</th>
                        <th class="p-5 text-xs uppercase tracking-wider font-bold text-gray-500">Client</th>
                        <th class="p-5 text-xs uppercase tracking-wider font-bold text-gray-500">Produit</th>
                        <th class="p-5 text-xs uppercase tracking-wider font-bold text-gray-500">Total</th>
                        <th class="p-5 text-xs uppercase tracking-wider font-bold text-gray-500">Statut</th>
                        <th class="p-5 text-xs uppercase tracking-wider font-bold text-gray-500 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($commandes as $cmd)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 font-mono text-sm text-indigo-600">#{{ $cmd->id }}</td>
                        <td class="p-5 font-semibold text-gray-800">{{ $cmd->user->name ?? 'Client' }}</td>
                        <td class="p-5 text-gray-600">{{ $cmd->items->count() }} produit(s)</td>
                        <td class="p-5 font-bold text-gray-900">{{ number_format($cmd->total, 2) }} DH</td>
                        <td class="p-5">
                            <span class="px-3 py-1 rounded-lg text-xs font-black uppercase {{ $cmd->status == 'valide' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                {{ $cmd->status }}
                            </span>
                        </td>
                        
                        <td class="p-5 text-right">
                            @if($cmd->status == 'en_attente')
                                <form action="{{ route('admin.admin.commandes.valider', $cmd->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-700 transition">
                                        Valider
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs font-bold">Validée</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-400">Aucune commande trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>