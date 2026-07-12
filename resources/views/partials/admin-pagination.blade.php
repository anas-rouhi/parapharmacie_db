{{-- Pagination admin réutilisable : @include('partials.admin-pagination', ['paginator' => $produits]) --}}
@if($paginator->hasPages())
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Affichage {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} sur {{ $paginator->total() }}
        </p>
        {{ $paginator->onEachSide(1)->links('vendor.pagination.parasante') }}
    </div>
@endif
