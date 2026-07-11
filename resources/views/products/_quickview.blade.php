{{-- Modal "Aperçu rapide" partagé + logique JS (openQuickView / closeQuickViewModal) --}}
<div id="quickViewModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 md:p-8 shadow-2xl relative transform scale-95 transition-transform duration-300 flex flex-col md:flex-row gap-6 max-h-[90vh] overflow-y-auto">
        <button onclick="closeQuickViewModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-50 h-8 w-8 rounded-full flex items-center justify-center transition z-10">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="md:w-1/2 bg-gray-50 rounded-2xl overflow-hidden flex items-center justify-center p-4 border border-gray-100 h-64 md:h-auto">
            <img id="qv-image" src="" alt="" class="max-h-full max-w-full object-contain rounded-xl">
            <div id="qv-no-image" class="hidden text-gray-400 italic text-xs">Image non disponible</div>
        </div>

        <div class="md:w-1/2 flex flex-col justify-between">
            <div>
                <span id="qv-stock-badge" class="inline-block text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md mb-3"></span>
                <h2 id="qv-nom" class="text-xl font-extrabold text-gray-900 leading-tight"></h2>
                <p id="qv-prix" class="text-2xl font-black text-green-600 my-3"></p>
                <hr class="border-gray-100 my-3">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Description :</p>
                <p id="qv-description" class="text-xs text-gray-500 leading-relaxed max-h-32 overflow-y-auto pr-1"></p>
            </div>
            <div class="mt-6">
                <a id="qv-add-btn" href="#" class="w-full bg-gray-900 text-white font-bold py-3.5 rounded-xl hover:bg-green-600 transition shadow-md flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                    <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function openQuickView(nom, prix, imageSrc, description, actionUrl, stock) {
        document.getElementById('qv-nom').innerText = nom;
        document.getElementById('qv-prix').innerText = prix + ' DH';
        document.getElementById('qv-description').innerText = description ? description : 'Aucune description disponible pour ce produit.';
        document.getElementById('qv-add-btn').setAttribute('href', actionUrl);

        const imgEl = document.getElementById('qv-image');
        const noImgEl = document.getElementById('qv-no-image');
        if (imageSrc) {
            imgEl.src = imageSrc; imgEl.alt = nom;
            imgEl.classList.remove('hidden'); noImgEl.classList.add('hidden');
        } else {
            imgEl.classList.add('hidden'); noImgEl.classList.remove('hidden');
        }

        const badge = document.getElementById('qv-stock-badge');
        badge.className = "inline-block text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md mb-3";
        if (parseInt(stock) <= 0) {
            badge.innerText = "Rupture"; badge.classList.add('bg-red-600', 'text-white');
        } else if (parseInt(stock) <= 3) {
            badge.innerText = "Stock Limité (" + stock + ")"; badge.classList.add('bg-orange-500', 'text-white', 'animate-pulse');
        } else {
            badge.innerText = "En Stock"; badge.classList.add('bg-blue-500', 'text-white');
        }

        const modal = document.getElementById('quickViewModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeQuickViewModal() {
        const modal = document.getElementById('quickViewModal');
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
