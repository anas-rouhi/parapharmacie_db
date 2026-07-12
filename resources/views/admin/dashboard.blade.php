@extends('layouts.admin')

@section('title', 'ParaAdmin | Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-8">

        {{-- 🐛 Corrigé : ce bloc était placé HORS de @section('content') → il ne s'affichait jamais. --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl font-semibold text-sm shadow-sm">
                <p class="font-black mb-2 uppercase tracking-wide">❌ Il y a des erreurs dans le formulaire :</p>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ═══ EN-TÊTE ═══ --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-emerald-600 to-teal-600 p-6 md:p-8 rounded-3xl shadow-lg shadow-emerald-600/20">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl md:text-3xl font-black text-white tracking-tight">Bienvenue, {{ Auth::user()->name }}</h2>
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider border border-white/20">
                        {{ Auth::user()->role }}
                    </span>
                </div>
                <p class="text-emerald-50 text-xs font-semibold mt-1.5">
                    Voici l'activité de votre parapharmacie du
                    {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}.
                </p>
            </div>
            <a href="{{ route('admin.reports.exportPdf') }}" class="inline-flex items-center gap-2 bg-white text-emerald-700 hover:bg-emerald-50 text-xs font-black px-5 py-3 rounded-xl shadow-md transition duration-200 shrink-0">
                <span>📊</span> Télécharger le Rapport PDF
            </a>
        </div>

        {{-- ═══ ALERTE STOCK (inline, non bloquante) ═══
             🐛 Corrigé : la vue testait $produitsAlerte (jamais transmis par le contrôleur),
             donc cette bannière ne s'affichait jamais → d'où l'ancien popup bloquant. --}}
        @if($produitsCritiques->count() > 0)
            <div class="bg-amber-50 border border-amber-200 border-l-4 border-l-amber-500 p-5 rounded-2xl shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-start gap-3 flex-1">
                        <span class="text-xl mt-0.5">⚠️</span>
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-amber-950 uppercase tracking-wide">
                                {{ $produitsCritiques->count() }} produit{{ $produitsCritiques->count() > 1 ? 's' : '' }} presque épuisé{{ $produitsCritiques->count() > 1 ? 's' : '' }}
                            </h4>
                            <div class="mt-2.5 flex flex-wrap gap-2">
                                @foreach($produitsCritiques as $p)
                                    <span class="inline-flex items-center bg-white border border-amber-200 text-amber-900 px-3 py-1 rounded-xl text-xs font-bold">
                                        📦 {{ $p->nom }}
                                        <span class="ml-2 bg-amber-500 text-white px-1.5 py-0.5 rounded-lg text-[10px] font-black">
                                            {{ $p->stock }} restants
                                        </span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button onclick="openStockOrderModal()" class="shrink-0 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-md cursor-pointer border-none">
                        📋 Préparer le Bon de Commande
                    </button>
                </div>
            </div>
        @endif

        {{-- ═══ FILTRE DE PÉRIODE ═══ --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                <div class="w-full md:flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date Début</label>
                    <input type="date" name="date_debut" value="{{ $dateDebut }}" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 font-semibold text-gray-700 outline-none">
                </div>
                <div class="w-full md:flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date Fin</label>
                    <input type="date" name="date_fin" value="{{ $dateFin }}" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 font-semibold text-gray-700 outline-none">
                </div>
                <div class="w-full md:w-auto flex gap-2">
                    <button type="submit" class="flex-1 md:flex-none bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition duration-200 shadow-md shadow-emerald-600/20 cursor-pointer border-none">
                        🔍 Filtrer
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-sm px-4 py-2.5 rounded-xl transition duration-200 text-center flex items-center justify-center">
                        🔄
                    </a>
                </div>
            </form>
        </div>

        {{-- ═══ KPI (une seule grille homogène) ═══ --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            @php
                $kpis = [
                    ['label' => 'Produits',        'value' => $totalProduits,                            'icon' => '📦', 'color' => 'emerald'],
                    ['label' => 'Catégories',      'value' => $totalCategories,                          'icon' => '🏷️', 'color' => 'sky'],
                    ['label' => 'Stock critique',  'value' => $stockLimite,                              'icon' => '⚠️', 'color' => $stockLimite > 0 ? 'orange' : 'gray'],
                    ['label' => 'Commandes',       'value' => $totalCommandes,                           'icon' => '🛒', 'color' => 'indigo'],
                    ['label' => "Chiffre d'aff.",  'value' => number_format($totalRevenu, 2) . ' DH',    'icon' => '💰', 'color' => 'violet'],
                    ['label' => 'Bénéfice (est.)', 'value' => number_format($totalBenefice, 2) . ' DH',  'icon' => '📈', 'color' => 'teal'],
                ];
                $palette = [
                    'emerald' => ['bg-emerald-50', 'text-emerald-600'],
                    'sky'     => ['bg-sky-50', 'text-sky-600'],
                    'orange'  => ['bg-orange-50', 'text-orange-600'],
                    'gray'    => ['bg-gray-100', 'text-gray-400'],
                    'indigo'  => ['bg-indigo-50', 'text-indigo-600'],
                    'violet'  => ['bg-violet-50', 'text-violet-600'],
                    'teal'    => ['bg-teal-50', 'text-teal-600'],
                ];
            @endphp

            @foreach($kpis as $kpi)
                @php [$kpiBg, $kpiText] = $palette[$kpi['color']]; @endphp
                <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <span class="h-9 w-9 {{ $kpiBg }} {{ $kpiText }} rounded-xl flex items-center justify-center text-base">{{ $kpi['icon'] }}</span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $kpi['label'] }}</p>
                    <p class="text-xl xl:text-2xl font-black text-gray-900 mt-1 truncate">{{ $kpi['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- ═══ RACCOURCIS (la gestion complète est sur les pages dédiées) ═══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <a href="{{ route('admin.produits.create') }}"
               class="flex items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md hover:border-emerald-200 transition duration-200 group">
                <div class="flex items-center gap-4">
                    <span class="h-11 w-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg shrink-0">➕</span>
                    <div>
                        <p class="text-sm font-black text-gray-800">Ajouter un produit</p>
                        <p class="text-xs text-gray-400 font-semibold mt-0.5">Enrichir le catalogue de la boutique</p>
                    </div>
                </div>
                <span class="text-xs font-black text-gray-500 group-hover:text-emerald-600 transition flex items-center gap-1.5 shrink-0">
                    Créer
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>

            <a href="{{ route('admin.flash.index') }}"
               class="flex items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md hover:border-amber-200 transition duration-200 group">
                <div class="flex items-center gap-4">
                    <span class="h-11 w-11 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg shrink-0">⚡</span>
                    <div>
                        <p class="text-sm font-black text-gray-800">Offres Flash & Packs</p>
                        <p class="text-xs text-gray-400 font-semibold mt-0.5">
                            @if($offresActivesCount > 0)
                                <span class="text-emerald-600 font-bold">{{ $offresActivesCount }} offre{{ $offresActivesCount > 1 ? 's' : '' }} active{{ $offresActivesCount > 1 ? 's' : '' }}</span> sur la boutique
                            @else
                                Aucune offre active pour le moment
                            @endif
                        </p>
                    </div>
                </div>
                <span class="text-xs font-black text-gray-500 group-hover:text-amber-600 transition flex items-center gap-1.5 shrink-0">
                    Gérer
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
        </div>

        {{-- ═══ GRAPHIQUE ═══ --}}
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-200/60">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-6">
                <div>
                    <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                        <span>📊</span> Analyse des Ventes & Bénéfices
                    </h3>
                    <p class="text-xs text-gray-400 font-medium mt-1">Évolution sur les 6 derniers mois (commandes validées &amp; livrées)</p>
                </div>
                <div class="flex gap-4 text-xs font-bold mt-2 sm:mt-0">
                    <span class="flex items-center gap-1.5 text-violet-600">
                        <span class="h-3 w-3 rounded-full bg-violet-500 block"></span> Chiffre d'Affaires
                    </span>
                    <span class="flex items-center gap-1.5 text-emerald-600">
                        <span class="h-3 w-3 rounded-full bg-emerald-500 block"></span> Bénéfice Net
                    </span>
                </div>
            </div>
            <div class="h-72">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>


        <div id="stockOrderModal" class="fixed inset-0 bg-gray-900/60 hidden flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-3xl shadow-xl max-w-2xl w-full mx-4 border border-gray-200 max-h-[85vh] flex flex-col">
                <h3 class="text-lg font-black text-gray-900 mb-2 flex items-center gap-2">
                    📋 Préparer les Quantités à Commander
                </h3>
                <p class="text-xs text-gray-500 mb-4">Saisissez les quantités désirées pour chaque produit en alerte avant de lancer l'impression.</p>
                
                <div class="overflow-y-auto flex-1 pr-1 space-y-3" id="modal_stock_list">
                    </div>

                <div class="flex justify-end gap-2 mt-6 border-t border-gray-100 pt-4">
                    <button type="button" onclick="closeStockOrderModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-4 rounded-xl transition text-sm cursor-pointer border-none">Annuler</button>
                    <button type="button" onclick="printConfiguredStockReport()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition text-sm flex items-center gap-1.5 cursor-pointer border-none shadow-md">
                        🖨️ Imprimer le Bon
                    </button>
                </div>
            </div>
        </div>
        
    </div>


    {{-- SweetAlert2 est déjà chargé par le layout (partials.confirm-dialog) — plus de double chargement. --}}

    <script>

        // 🌟 وظائف الـ Modal الجديدة والمطورة للـ Bon de Commande
        const produitsCritiquesGlobal = {!! json_encode($produitsCritiques ?? []) !!};

        function openStockOrderModal() {
            const listContainer = document.getElementById('modal_stock_list');
            listContainer.innerHTML = ''; // تنظيف القائمة

            if(produitsCritiquesGlobal.length === 0) {
                Swal.fire('Parfait !', 'Aucun produit en rupture de stock.', 'success');
                return;
            }

            // رسم المنتجات والـ inputs وسط الـ Modal ديناميكياً
            produitsCritiquesGlobal.forEach((prod, index) => {
                let productID = prod.id || prod.id_produit || 'N/A';
                listContainer.innerHTML += `
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-2xl gap-3">
                        <div>
                            <span class="text-[10px] font-mono font-bold text-gray-400 block">#PROD-${productID}</span>
                            <span class="text-sm font-bold text-gray-800">${prod.nom}</span>
                            <span class="text-xs text-red-500 font-semibold block mt-0.5">Stock actuel: ${prod.stock} pcs</span>
                        </div>
                        <div class="w-full sm:w-auto">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Qté à commander</label>
                            <input type="number" id="qte_order_${index}" data-id="${productID}" data-nom="${prod.nom}" data-stock="${prod.stock}" min="1" value="20" class="w-full sm:w-28 border border-gray-300 rounded-xl px-3 py-1.5 text-sm font-bold text-gray-800 outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>
                `;
            });

            document.getElementById('stockOrderModal').classList.remove('hidden');
        }

        function closeStockOrderModal() {
            document.getElementById('stockOrderModal').classList.add('hidden');
        }

        // دالة الطباعة الاحترافية اللي كتاخد القيم اللي دخل الـ Admin دابا بلا ما تقلب الصفحة لليسر
        function printConfiguredStockReport() {
            let htmlContent = `
                <html>
                <head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
                    <title>Bon de Commande - Signalement Stock</title>
                    <style>
                        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #333; padding: 40px; }
                        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #22c55e; padding-bottom: 20px; }
                        .header h1 { color: #22c55e; margin: 0; font-size: 28px; }
                        .header p { color: #666; margin: 5px 0 0 0; }
                        .date { text-align: right; margin-bottom: 20px; font-weight: bold; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                        th { background-color: #f8fafc; color: #1e293b; }
                        tr:nth-child(even) { background-color: #fdfdfd; }
                        .critical { color: #dc2626; font-weight: bold; }
                        .order-qty { color: #16a34a; font-weight: bold; font-size: 15px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>📋 BON DE COMMANDE / ALERTE STOCK</h1>
                        <p>Système de Gestion ParaPharmacie - PARAADMIN</p>
                    </div>
                    <div class="date">Fait le : ${new Date().toLocaleDateString('fr-FR')}</div>
                    <p>Veuillez trouver ci-dessous les détails des quantités de réapprovisionnement configurées :</p>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Produit</th>
                                <th>Stock Actuel</th>
                                <th>Quantité à Commander</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            produitsCritiquesGlobal.forEach((prod, index) => {
                const inputElement = document.getElementById(`qte_order_${index}`);
                const qtyToOrder = inputElement ? inputElement.value : 0;
                let productID = prod.id || prod.id_produit || 'N/A';

                htmlContent += `
                    <tr>
                        <td>#${productID}</td>
                        <td><b>${prod.nom}</b></td>
                        <td class="critical">${prod.stock} pcs</td>
                        <td class="order-qty">+ ${qtyToOrder} pcs</td>
                    </tr>
                `;
            });

            htmlContent += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;

            // فتح نافذة طباعة مخفية ومباشرة بدون التأثير على الصفحة الأم
            let printWindow = window.open('', '_blank');
            printWindow.document.write(htmlContent);
            printWindow.document.close();
            
            // تشغيل الطبع المباشر وإغلاق النافذة المنبثقة تلقائياً
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);

            closeStockOrderModal();
        }

        document.addEventListener("DOMContentLoaded", function() {
            // ℹ️ L'ancien popup bloquant "Alertes Stock Critique" a été supprimé :
            // il fallait cliquer "D'accord" à CHAQUE chargement. L'alerte est désormais
            // affichée en bannière (non bloquante) directement dans la page.

            // Chart.js Configuration
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: "Chiffre d'Affaires",
                            data: {!! json_encode($chartSales) !!},
                            backgroundColor: '#8b5cf6',
                            borderRadius: 6,
                            barPercentage: 0.6,
                            categoryPercentage: 0.65
                        },
                        {
                            label: 'Bénéfice Net',
                            data: {!! json_encode($chartProfits) !!},
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                            barPercentage: 0.6,
                            categoryPercentage: 0.65
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (c) => `${c.dataset.label} : ${Number(c.raw).toLocaleString('fr-FR', {minimumFractionDigits: 2})} DH`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: (v) => v.toLocaleString('fr-FR') + ' DH',
                                font: { size: 11 },
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11, weight: 'bold' }, color: '#64748b' }
                        }
                    }
                }
            });
        });

    </script>
@endsection