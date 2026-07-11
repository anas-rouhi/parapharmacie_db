@extends('layouts.admin')

@section('title', 'ParaAdmin | Utilisateurs & Clients')

@section('content')
    <div class="space-y-12">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Gestion des Comptes</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl font-semibold shadow-md mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <h3 class="text-xl font-bold text-gray-800">1. Personnel de l'établissement (Staff / Clients gérants)</h3>
                <span class="bg-blue-50 text-blue-700 text-xs font-black px-3 py-1 rounded-full border border-blue-100 uppercase tracking-wider">Gestionnaires</span>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200/60">
                <h4 class="text-sm font-bold text-gray-700 mb-4">➕ Ajouter un nouveau membre de staff (Accès Dashboard Staff)</h4>
                <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @csrf
                    <input type="text" name="name" required placeholder="Nom du staff" class="p-3.5 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition shadow-sm">
                    <input type="email" name="email" required placeholder="Email professionnel" class="p-3.5 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition shadow-sm">
                    <input type="text" name="telephone" placeholder="Téléphone (Optionnel)" class="p-3.5 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition shadow-sm">
                    <input type="password" name="password" required placeholder="Mot de passe" class="p-3.5 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition shadow-sm">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3.5 rounded-xl font-bold hover:bg-green-700 transition shadow-md shadow-green-100 duration-200 text-sm">Enregistrer le Staff</button>
                </form>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/80 border-b border-gray-100">
                            <tr>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Nom</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Rôle</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($staff_members as $staff)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="p-5 font-bold text-gray-800 text-sm">{{ $staff->name }}</td>
                                    <td class="p-5 text-gray-600 text-sm font-semibold">{{ $staff->email }}</td>
                                    <td class="p-5 text-gray-500 text-sm">{{ $staff->telephone ?? 'Non spécifié' }}</td>
                                    <td class="p-5 text-sm">
                                        <span class="bg-purple-50 text-purple-700 border border-purple-100 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">{{ $staff->role }}</span>
                                    </td>
                                    <td class="p-5 text-center flex justify-center gap-2">
                                        <button onclick="openEditModal({{ $staff->id }}, '{{ addslashes($staff->name) }}', '{{ $staff->email }}', '{{ $staff->telephone }}')" class="text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white p-2 rounded-xl transition duration-200 font-bold text-sm">✏️ Modifier</button>
                                        <form action="{{ route('admin.users.delete', $staff->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce membre ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-600 hover:text-white p-2 rounded-xl transition duration-200 font-bold text-sm">🗑️ Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <h3 class="text-xl font-bold text-gray-800">2. Clients de la boutique (Visiteurs / Acheteurs)</h3>
                <span class="bg-green-50 text-green-700 text-xs font-black px-3 py-1 rounded-full border border-green-100 uppercase tracking-wider">Acheteurs</span>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/80 border-b border-gray-100">
                            <tr>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Client</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Commandes passées</th>
                                <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($visiteurs_acheteurs as $client)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="p-5 font-bold text-gray-800 text-sm">{{ $client->name }}</td>
                                    <td class="p-5 text-gray-600 text-sm font-semibold">{{ $client->email }}</td>
                                    <td class="p-5 text-gray-500 text-sm">{{ $client->telephone ?? 'Non spécifié' }}</td>
                                    <td class="p-5 text-center">
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $client->orders_count > 0 ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-gray-100 text-gray-400' }}">
                                            🛒 {{ $client->orders_count }} Commande(s)
                                        </span>
                                    </td>
                                    <td class="p-5 text-center flex justify-center gap-2">
                                        <button onclick="openEditModal({{ $client->id }}, '{{ addslashes($client->name) }}', '{{ $client->email }}', '{{ $client->telephone }}')" class="text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white p-2 rounded-xl transition duration-200 font-bold text-sm">✏️ Modifier</button>
                                        <form action="{{ route('admin.users.delete', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce client ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-600 hover:text-white p-2 rounded-xl transition duration-200 font-bold text-sm">🗑️ Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-400 italic">Aucun client inscrit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-950/40 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full mx-4 border border-gray-100">
            <h3 class="text-xl font-black text-gray-800 mb-6 tracking-tight">Modifier les informations</h3>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Nom complet</label>
                    <input type="text" id="edit_name" name="name" required class="w-full p-3 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Adresse Email</label>
                    <input type="email" id="edit_email" name="email" required class="w-full p-3 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition">
                </div>
                <div id="phone_field_wrapper">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Téléphone</label>
                    <input type="text" id="edit_telephone" name="telephone" class="w-full p-3 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Nouveau mot de passe (Optionnel)</label>
                    <input type="password" name="password" class="w-full p-3 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500 bg-white transition" placeholder="Laisser vide pour ne pas changer">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-100 hover:bg-gray-200 px-5 py-2.5 rounded-xl text-sm font-bold transition duration-150">Annuler</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-green-100 transition duration-150">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openEditModal(id, name, email, telephone) {
        document.getElementById('editForm').action = "/admin/users/" + id + "/update";
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_telephone').value = (telephone === 'null' || telephone === '') ? '' : telephone;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() { 
        document.getElementById('editModal').classList.add('hidden'); 
    }
    </script>
@endsection