{{-- Grille de cartes produits — attend $produits (collection ou paginator) --}}
@forelse($produits as $item)
    @include('products._card')
@empty
    <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
            <i class="fa-solid fa-face-frown text-3xl"></i>
        </div>
        <p class="text-gray-500 font-semibold text-lg">Aucun produit trouvé</p>
        <p class="text-sm text-gray-400 mt-1">Essayez d'autres mots clés ou catégories.</p>
    </div>
@endforelse
