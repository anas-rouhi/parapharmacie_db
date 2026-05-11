<div class="max-w-5xl mx-auto py-12 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Votre Panier</h2>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-5 font-bold text-gray-600">Produit</th>
                    <th class="p-5 font-bold text-gray-600">Prix</th>
                    <th class="p-5 font-bold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart', []) as $id => $item)
                <tr class="border-b border-gray-50">
                    <td class="p-5 font-semibold text-gray-800">{{ $item['nom'] }}</td>
                    <td class="p-5 text-green-600 font-bold">{{ $item['prix'] }} DH</td>
                    <td class="p-5">
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 transition font-bold">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6 bg-gray-50 flex justify-end">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                    Valider la commande
                </button>
            </form>
        </div>
    </div>
    <head>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
</div>