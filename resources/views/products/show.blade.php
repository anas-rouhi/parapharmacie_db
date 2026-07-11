<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | {{ $produit->nom }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="text-2xl font-extrabold text-green-600 tracking-tight">PARA<span class="text-blue-600">SANTE</span></a>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="relative flex items-center text-gray-700 hover:text-green-600 transition p-2 bg-gray-50 hover:bg-green-50 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        @if(session('panier') && count(session('panier')) > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white animate-bounce">
                                @php $item_count = 0; foreach(session('panier') as $details) { $item_count += $details['quantite']; } @endphp
                                {{ $item_count }}
                            </span>
                        @else
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-gray-300 text-[10px] font-bold text-gray-600">0</span>
                        @endif
                    </a>
                    <a href="/" class="text-sm font-semibold text-gray-600 hover:text-green-600 transition flex items-center gap-1 bg-gray-100 px-4 py-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Boutique
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- المحتوى الرئيسي للمنتج -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-6 md:p-12">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- جهة الصورة -->
                <div class="lg:w-1/2">
                    <div class="bg-gray-50 rounded-2xl overflow-hidden h-[450px] flex items-center justify-center relative border border-gray-100 shadow-inner group">
                        @if($produit->image)
                            <img src="{{ asset('images/products/' . $produit->image) }}" alt="{{ $produit->nom }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <span class="text-gray-400 italic">Image non disponible</span>
                        @endif
                        <span class="absolute top-4 left-4 bg-green-500 text-white text-xs px-3 py-1 rounded-md font-bold uppercase tracking-wider shadow">Nouveau</span>
                    </div>
                </div>

                <!-- جهة المعلومات -->
                <div class="lg:w-1/2 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-green-700 uppercase tracking-widest bg-green-50 px-3 py-1 rounded-full border border-green-100">
                            {{ $produit->categorie->nom ?? 'Parapharmacie' }}
                        </span>
                        
                        <h1 class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $produit->nom }}</h1>
                        
                        <!-- عرض النجوم الإجمالية للمنتج -->
                        <div class="flex items-center mt-2 space-x-2">
                            <div class="flex text-yellow-400 text-lg">
                                @for($i = 1; $i <= 5; $i++)
                                    {!! $i <= round($moyenneNotes) ? '&#9733;' : '&#9734;' !!}
                                @endfor
                            </div>
                            <span class="text-xs font-semibold text-gray-500">({{ $produit->avis->count() }} avis clients)</span>
                        </div>
                        
                        <div class="mt-4 bg-gray-50 p-4 rounded-xl border border-gray-100 inline-block">
                            <span class="text-3xl font-black text-green-600" id="base-price" data-price="{{ $produit->prix }}">{{ $produit->prix }} DH</span>
                        </div>

                        <hr class="my-6 border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Description :</h3>
                        <p class="text-gray-600 mt-2 text-sm leading-relaxed">{{ $produit->description ?? 'Aucune description disponible.' }}</p>
                    </div>

                    <!-- علبة التحكم في الشراء والكمية -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                        @if($produit->stock > 0)
                            <form action="{{ route('cart.add', $produit->id) }}" method="GET">
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <div class="flex items-center border border-gray-300 rounded-xl bg-white overflow-hidden shadow-sm h-14 w-full sm:w-auto">
                                        <button type="button" onclick="decrementQty()" class="w-12 text-gray-600 hover:bg-gray-100 h-full font-black text-xl flex items-center justify-center">-</button>
                                        <input type="number" id="quantity-input" name="quantite" value="1" class="w-12 text-center font-bold text-gray-800 bg-transparent pointer-events-none focus:outline-none">
                                        <button type="button" onclick="incrementQty({{ $produit->stock }})" class="w-12 text-gray-600 hover:bg-gray-100 h-full font-black text-xl flex items-center justify-center">+</button>
                                    </div>
                                    <button type="submit" class="w-full h-14 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg transition">
                                        Ajouter au panier (<span id="total-price">{{ $produit->prix }} DH</span>)
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== قسم مراجعات العملاء والنجوم (الجديد) ==================== -->
        <div class="mt-12 bg-white rounded-3xl p-6 md:p-12 border border-gray-100 shadow-sm grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- جهة عرض التعليقات القديمة -->
            <div class="lg:col-span-2 space-y-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    💬 Avis des clients ({{ $produit->avis->count() }})
                </h3>

                @if($produit->avis->count() > 0)
                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                        @foreach($produit->avis as $av)
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $av->nom_client }}</h4>
                                        <span class="text-[10px] text-gray-400">{{ $av->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-yellow-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            {!! $i <= $av->note ? '&#9733;' : '&#9734;' !!}
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 text-xs mt-2 leading-relaxed">{{ $av->commentaire }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 italic bg-gray-50 p-6 rounded-2xl text-center border border-dashed border-gray-200">Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
                @endif
            </div>

            <!-- فورم إضافة تعليق جديد -->
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 h-fit shadow-sm">
                <h4 class="font-bold text-gray-800 text-base mb-4">Donner votre avis</h4>

                <form action="{{ route('products.avis.store', $produit->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Votre Nom :</label>
                            <input type="text" name="nom_client" required class="w-full bg-white border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:border-green-500 font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Note (Étoiles) :</label>
                            <select name="note" required class="w-full bg-white border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:border-green-500 font-bold text-yellow-500">
                                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                <option value="3">⭐⭐⭐ (3/5)</option>
                                <option value="2">⭐⭐ (2/5)</option>
                                <option value="1">⭐ (1/5)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Votre Commentaire :</label>
                            <textarea name="commentaire" rows="3" required class="w-full bg-white border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:border-green-500 font-medium"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold text-xs shadow transition">
                            Soumettre l'avis
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- المنتجات المقترحة -->
        @if($produitsSimilaires->count() > 0)
            <div class="mt-16">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-600 rounded-full block"></span> Vous pourriez aussi aimer :
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($produitsSimilaires as $simil)
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md p-4 flex flex-col justify-between">
                            <a href="{{ route('products.show', $simil->id) }}">
                                <div class="h-40 bg-gray-50 rounded-xl overflow-hidden mb-3">
                                    @if($simil->image) <img src="{{ asset('images/products/' . $simil->image) }}" class="h-full w-full object-cover"> @endif
                                </div>
                                <h4 class="font-bold text-gray-800 truncate text-sm">{{ $simil->nom }}</h4>
                                <span class="text-sm font-black text-gray-900 block mt-1">{{ $simil->prix }} DH</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <script>
        const basePrice = parseFloat(document.getElementById('base-price').getAttribute('data-price'));
        const qtyInput = document.getElementById('quantity-input');
        const totalPriceLabel = document.getElementById('total-price');

        function updatePrice() {
            totalPriceLabel.innerText = (basePrice * parseInt(qtyInput.value)).toFixed(2) + ' DH';
        }
        function incrementQty(maxStock) { if (parseInt(qtyInput.value) < maxStock) { qtyInput.value = parseInt(qtyInput.value) + 1; updatePrice(); } }
        function decrementQty() { if (parseInt(qtyInput.value) > 1) { qtyInput.value = parseInt(qtyInput.value) - 1; updatePrice(); } }
    </script>
    <script>
    // تفعيل الـ Toast Notification الاحترافي
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // 1. يلا تـزاد المنتج للسلة بنجاح
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @endif

    // 2. يلا تـزاد تعليق بنجاح
    @if(session('success_avis'))
        Swal.fire({
            icon: 'success',
            title: 'Merci pour votre avis !',
            text: "{{ session('success_avis') }}",
            confirmButtonColor: '#16a34a'
        });
    @endif
</script>
</body>
</html>