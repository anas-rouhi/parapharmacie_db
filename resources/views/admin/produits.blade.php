@extends('layouts.admin')

@section('title', 'ParaAdmin | Catalogue des Produits')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Catalogue des Produits</h2>
            <p class="text-gray-500 text-sm mt-1">Gérez le catalogue, les prix et les niveaux de stock.</p>
        </div>
        <a href="{{ route('admin.produits.create') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-700 transition shadow-md shadow-emerald-600/20 duration-200 text-sm">
            + Ajouter un produit
        </a>
    </div>

    {{-- 🔎 Filtres (côté serveur : l'ancienne recherche JS ne filtrait que les lignes visibles) --}}
    <form method="GET" action="{{ route('admin.produits') }}" class="bg-white p-4 rounded-2xl border border-gray-200/60 shadow-sm mb-6 flex flex-col md:flex-row gap-3 md:items-end">
        <div class="flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rechercher</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom ou description..."
                   class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none font-semibold text-gray-700">
        </div>
        <div class="md:w-52">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catégorie</label>
            <select name="category" class="w-full bg-gray-50 border border-gray-200 px-3 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none font-semibold text-gray-700">
                <option value="">Toutes</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:w-44">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Stock</label>
            <select name="stock" class="w-full bg-gray-50 border border-gray-200 px-3 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none font-semibold text-gray-700">
                <option value="">Tous</option>
                <option value="ok" @selected(request('stock') == 'ok')>En stock (&gt;3)</option>
                <option value="critique" @selected(request('stock') == 'critique')>Critique (1-3)</option>
                <option value="rupture" @selected(request('stock') == 'rupture')>Rupture (0)</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-md shadow-emerald-600/20 cursor-pointer border-none">
                🔍 Filtrer
            </button>
            @if(request()->hasAny(['q','category','stock']))
                <a href="{{ route('admin.produits') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-sm px-4 py-2.5 rounded-xl transition flex items-center">🔄</a>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Image</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Nom</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Catégorie</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Prix</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Stock</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($produits as $produit)
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="p-5 text-center">
                                @if($produit->image)
                                    <img src="{{ asset('images/products/' . $produit->image) }}" class="w-12 h-12 object-cover rounded-xl mx-auto border border-gray-100 shadow-sm">
                                @else
                                    <span class="text-gray-300 text-xl">📦</span>
                                @endif
                            </td>
                            <td class="p-5 font-bold text-gray-800 text-sm">{{ $produit->nom }}</td>
                            <td class="p-5 text-xs">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold">{{ $produit->categorie->nom ?? '—' }}</span>
                            </td>
                            <td class="p-5 font-extrabold text-gray-900 text-sm">{{ number_format($produit->prix, 2) }} DH</td>
                            <td class="p-5 text-sm">
                                @php
                                    $stockClass = $produit->stock <= 0
                                        ? 'bg-red-50 text-red-700'
                                        : ($produit->stock <= 3 ? 'bg-orange-50 text-orange-700' : 'bg-emerald-50 text-emerald-700');
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $stockClass }}">
                                    {{ $produit->stock }} unités
                                </span>
                            </td>
                            <td class="p-5">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.produits.edit', $produit->id) }}" class="text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white p-2 rounded-xl transition duration-200">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.produits.destroy', $produit->id) }}" method="POST" data-confirm="Ce produit sera définitivement retiré du catalogue." data-confirm-title="Supprimer ce produit ?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-600 hover:text-white p-2 rounded-xl transition duration-200 cursor-pointer border-none">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 italic">Aucun produit trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.admin-pagination', ['paginator' => $produits])
@endsection