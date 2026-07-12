@extends('layouts.admin')

@section('title', 'Gestion des Coupons Promo - ParaAdmin')

@section('content')
<div class="space-y-8">
    
    <!-- En-tête (Header د الصفحة) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-green-100/60 shadow-sm">
        <div>
            <h1 class="text-xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                🎟️ Codes de Réduction
            </h1>
            <p class="text-xs font-medium text-gray-400 mt-1">Créez et configurez les règles de promotion pour la parapharmacie.</p>
        </div>
        
        <!-- إحصائيات سريعة للـ Jury -->
        <div class="flex gap-3">
            <div class="bg-green-50 border border-green-200/50 px-4 py-2.5 rounded-xl text-center min-w-[110px]">
                <span class="block text-gray-400 text-[10px] font-bold uppercase tracking-wider">Coupons Actifs</span>
                <span class="text-base font-black text-green-600">
                    {{ $couponsActifs }}
                </span>            </div>
            <div class="bg-gray-50 border border-gray-200/60 px-4 py-2.5 rounded-xl text-center min-w-[110px]">
                <span class="block text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expirés / Pleins</span>
                <span class="text-base font-black text-gray-500">
                    {{ $couponsExpires }}
                </span>
            </div>
        </div>
    </div>

    <!-- Grid الرئيسي -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- اليسار: Formulaire de Création -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-5">
            <div>
                <h2 class="text-sm font-bold text-gray-800 tracking-tight">Ajouter un code promo</h2>
                <p class="text-[11px] text-gray-400 mt-0.5">Définissez les conditions d'utilisation.</p>
            </div>

            <!-- الفورم مربوط مع الـ Route الخاص بالإرسال -->
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase">Code unique</label>
                    <input type="text" name="code" placeholder="EX: BIO20" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition text-xs font-bold uppercase tracking-wider text-gray-800" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase">Type</label>
                        <select name="type" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition text-xs font-semibold text-gray-700" required>
                            <option value="pourcentage">Pourcentage (%)</option>
                            <option value="fixe">Fixe (DH)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase">Valeur</label>
                        <input type="number" name="valeur" placeholder="Ex: 20" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition text-xs font-bold text-gray-800" required min="1">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase">Achat Min (DH)</label>
                        <input type="number" name="montant_minimum" value="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition text-xs font-semibold text-gray-800" min="0">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase">Limite d'usage</label>
                        <input type="number" name="limite_utilisation" placeholder="Illimité" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition text-xs font-semibold text-gray-800" min="1">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase">Date d'expiration</label>
                    <input type="date" name="date_expiration" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:bg-white transition text-xs font-semibold text-gray-700" required>
                </div>

                <button type="submit" class="w-full mt-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl text-xs shadow-md shadow-green-100 transition duration-200 active:scale-95 cursor-pointer">
                    Créer le Coupon
                </button>
            </form>
        </div>

        <!-- اليمين: الجدول العصري لعرض البيانات الحاليّة -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h2 class="text-sm font-bold text-gray-800 tracking-tight">Liste des coupons disponibles</h2>

                {{-- 🔎 Filtres --}}
                <form method="GET" action="{{ route('admin.coupons.index') }}" class="flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Code..."
                           class="w-28 bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none font-bold uppercase text-gray-700">
                    <select name="etat" class="bg-gray-50 border border-gray-200 px-2 py-2 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none font-semibold text-gray-700">
                        <option value="">Tous</option>
                        <option value="actif" @selected(request('etat') == 'actif')>Actifs</option>
                        <option value="expire" @selected(request('etat') == 'expire')>Expirés</option>
                    </select>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3 py-2 rounded-xl transition cursor-pointer border-none">🔍</button>
                    @if(request()->hasAny(['q','etat']))
                        <a href="{{ route('admin.coupons.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs px-3 py-2 rounded-xl transition flex items-center">🔄</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 font-bold uppercase tracking-wider">
                            <th class="p-4">Code</th>
                            <th class="p-4">Valeur</th>
                            <th class="p-4">Condition min</th>
                            <th class="p-4">Utilisations</th>
                            <th class="p-4">Expiration</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                   <tbody class="divide-y divide-gray-50 font-semibold text-gray-600">
                        @forelse($coupons as $coupon)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-4 font-black text-gray-900 uppercase tracking-wide">{{ $coupon->code }}</td>
                                <td class="p-4 text-green-600 font-bold">
                                    {{ $coupon->valeur }}{{ $coupon->type == 'pourcentage' ? '%' : ' DH' }}
                                </td>
                                <td class="p-4">{{ $coupon->montant_minimum }} DH</td>
                                <td class="p-4 text-gray-400">
                                    {{ $coupon->total_utilisations }} / {{ $coupon->limite_utilisation ?? '∞' }}
                                </td>
                                <td class="p-4">
                                    {{ \Carbon\Carbon::parse($coupon->date_expiration)->format('d M Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" data-confirm="Ce code promo ne sera plus utilisable par les clients." data-confirm-title="Supprimer ce coupon ?" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 font-bold hover:text-red-700 text-[11px] cursor-pointer">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                    Aucun code promo disponible pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 pb-6">
                @include('partials.admin-pagination', ['paginator' => $coupons])
            </div>
        </div>

    </div>
</div>
@endsection