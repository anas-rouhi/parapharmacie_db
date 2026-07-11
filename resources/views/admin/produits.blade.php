@extends('layouts.admin')

@section('title', 'ParaAdmin | Catalogue des Produits')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Catalogue des Produits</h2>
            <p class="text-gray-500 text-sm mt-1">Gérez le catalogue, les prix et les niveaux de stock.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-md shadow-green-100 duration-200 text-sm">
            + Ajouter un produit
        </a>
    </div>

    <div class="mb-6 max-w-md">
        <input type="text" id="tableSearch" onkeyup="filterProductsTable()" placeholder="🔍 Rechercher un produit..." class="w-full p-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 text-gray-900 outline-none text-sm transition shadow-sm">
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="productsTable">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Image</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Nom</th>
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
                            <td class="p-5 font-extrabold text-gray-900 text-sm">{{ number_format($produit->prix, 2) }} DH</td>
                            <td class="p-5 text-sm">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $produit->stock > 5 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    {{ $produit->stock }} unités
                                </span>
                            </td>
                            <td class="p-5 text-center flex justify-center gap-2">
                                <a href="{{ route('admin.produits.edit', $produit->id) }}" class="text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white p-2 rounded-xl transition duration-200">
                                    ✏️
                                </a>
                                
                                <form action="{{ route('admin.produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-600 hover:text-white p-2 rounded-xl transition duration-200">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 italic">Aucun produit trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterProductsTable() {
            const input = document.getElementById("tableSearch");
            const filter = input.value.toUpperCase();
            const table = document.getElementById("productsTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection