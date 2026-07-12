<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Produit;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * لوحة التحكم الرئيسية والإحصائيات والمبيانات مع فيلتر التواريخ الإحترافي
     */
    public function dashboard(Request $request)
    {
        $totalProduits = Produit::count();
        $totalCategories = Category::count();

        // نجيبو العدد والسميات ديال المنتجات اللي قربت تسالي
        $produitsCritiques = Produit::where('stock', '<=', 3)->get(['id', 'nom', 'stock']);        $stockLimite = $produitsCritiques->count();

        // 📅 لقط تواريخ الفيلتر (إيلا كانوا خاويين كياخذ الديفولت من أول الشهر لليوم)
        $dateDebut = $request->input('date_debut', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // حساب عدد الطلبيات الإجمالي ف هاد الفترة المحددة
        $totalCommandes = Order::whereBetween('created_at', [
            Carbon::parse($dateDebut)->startOfDay(),
            Carbon::parse($dateFin)->endOfDay()
        ])->count();

        // 🔥 التعديل: نحسبو إجمالي المبيعات المحصورة بين التواريخ وللطلبيات المقبولة (valide) أو المشحونة (livre)
        $totalRevenu = Order::whereIn('status', ['valide', 'livre'])
            ->whereBetween('created_at', [
                Carbon::parse($dateDebut)->startOfDay(),
                Carbon::parse($dateFin)->endOfDay()
            ])
            ->sum('total');

        // ⚡ Compteur d'offres flash actives (le détail est sur sa page dédiée : admin.flash.index)
        $offresActivesCount = Produit::where('is_flash_sale', 1)
            ->where('flash_sale_end', '>', now())
            ->count();

        /**
         * 📊 حساب الأرباح الصافية (Bénéfice Net) بناءً على الفترة المحددة
         */
        $totalBenefice = $totalRevenu * 0.30;

        /**
         * 📈 تجهيز بيانات المبيانات (Chart.js) للأشهر الـ 6 الأخيرة للطلبيات المقبولة فقط
         */
        // 🐛 Correction : on groupe par ANNÉE-MOIS (et non par '%b' seul, qui fusionnait
        // le même mois de deux années différentes et cassait l'ordre au passage d'année).
        $salesData = Order::select(
            DB::raw('SUM(total) as total_sales'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym")
        )
            ->whereIn('status', ['valide', 'livre'])
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym', 'asc')
            ->pluck('total_sales', 'ym');

        // On construit une série complète de 6 mois : les mois sans vente valent 0
        // (plus de données inventées quand la base est vide).
        $chartLabels = [];
        $chartSales = [];
        $chartProfits = [];

        Carbon::setLocale('fr');

        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $cle = $mois->format('Y-m');
            $ventes = (float) ($salesData[$cle] ?? 0);

            $chartLabels[] = ucfirst($mois->translatedFormat('M Y'));
            $chartSales[] = round($ventes, 2);
            $chartProfits[] = round($ventes * 0.30, 2);
        }

        return view('admin.dashboard', compact(
            'totalProduits',
            'totalCategories',
            'stockLimite',
            'produitsCritiques',
            'totalCommandes',
            'totalRevenu',
            'totalBenefice',
            'offresActivesCount',
            'chartLabels',
            'chartSales',
            'chartProfits',
            'dateDebut',
            'dateFin'
        ));
    }

    /**
     * ⚡ Page dédiée : Offres Flash & Packs (liste + configuration)
     */
    public function flashOffers(Request $request)
    {
        $query = Produit::where('is_flash_sale', 1)
            ->select('id', 'nom', 'prix', 'prix_flash', 'flash_sale_end', 'pack_products', 'image');

        // 🔎 Recherche par nom
        if ($request->filled('q')) {
            $query->where('nom', 'LIKE', '%' . $request->q . '%');
        }

        // 🏷️ Filtre par état
        if ($request->etat === 'active') {
            $query->where('flash_sale_end', '>', now());
        } elseif ($request->etat === 'expiree') {
            $query->where(function ($sub) {
                $sub->where('flash_sale_end', '<=', now())
                    ->orWhereNull('flash_sale_end');
            });
        }

        $offresFlash = $query->orderByDesc('flash_sale_end')
            ->paginate(10)
            ->withQueryString();

        // Statistiques
        $totalOffres    = Produit::where('is_flash_sale', 1)->count();
        $offresActives  = Produit::where('is_flash_sale', 1)->where('flash_sale_end', '>', now())->count();
        $offresExpirees = $totalOffres - $offresActives;

        // (Le formulaire est désormais sur sa page dédiée : admin.flash.create)
        return view('admin.flash.index', compact(
            'offresFlash',
            'totalOffres',
            'offresActives',
            'offresExpirees'
        ));
    }

    /**
     * ⚡ Page dédiée : formulaire de création / modification d'une offre flash.
     * ?product_id=X → mode "Modifier" (pré-remplit le produit et ses items de pack).
     */
    public function flashCreate(Request $request)
    {
        $produits = Produit::select('id', 'nom', 'prix', 'is_flash_sale', 'prix_flash', 'flash_sale_end')
            ->orderBy('nom')
            ->get();

        $selectedId = $request->query('product_id');

        // Coche les produits déjà inclus dans le pack de l'offre en cours de modification
        $packItems = [];
        if ($selectedId) {
            $offre = Produit::select('pack_products')->find($selectedId);
            $packItems = $offre ? (json_decode($offre->pack_products ?? '[]', true) ?: []) : [];
        }

        return view('admin.flash.create', compact('produits', 'selectedId', 'packItems'));
    }
    

    /**
     * عرض صفحة المستخدمين (الموظفين والزوار)
     */
    public function usersIndex(Request $request)
    {
        $recherche = $request->input('q');

        // 🔎 Filtre de recherche appliqué aux deux listes (nom ou email)
        $filtre = function ($query) use ($recherche) {
            if (!empty($recherche)) {
                $query->where(function ($sub) use ($recherche) {
                    $sub->where('name', 'LIKE', "%{$recherche}%")
                        ->orWhere('email', 'LIKE', "%{$recherche}%");
                });
            }
        };

        // Deux paginateurs sur la même page → noms de page distincts
        $staff_members = User::where('role', 'client')
            ->where('id', '!=', auth()->id())
            ->tap($filtre)
            ->latest()
            ->paginate(10, ['*'], 'staff_page')
            ->withQueryString();

        $visiteurs_acheteurs = User::where('role', 'visiteur')
            ->withCount('orders')
            ->tap($filtre)
            ->latest()
            ->paginate(10, ['*'], 'clients_page')
            ->withQueryString();

        return view('admin.users.index', compact('staff_members', 'visiteurs_acheteurs', 'recherche'));
    }

    /**
     * إضافة موظف جديد (client) من الداش بورد
     */
    public function storeClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        return redirect()->back()->with('success', 'Le membre du personnel (Staff) a été ajouté avec succès !');
    }

    /**
     * تعديل بيانات حساب (موظف أو زائر)
     */
    public function updateClient(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'telephone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Les informations ont été modifiées avec succès !');
    }

    /**
     * حذف حساب (موظف أو زائر)
     */
    public function destroyClient($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Le compte a été supprimé avec succès !');
    }

    /**
     * إضافة تصنيف جديد عبر الأجاكس
     */
    public function ajaxStoreCategory(Request $request)
    {
        // 1. الـ Validation على الحقل 'nom' كيفما كاين ف الـ Modal عندك
        $request->validate([
            'nom' => 'required|string|unique:categories,nom'
        ]);

        // 2. الحفظ المباشر بـ Eloquent (بما أن الـ $fillable فيه 'nom' راه غايدوز)
        $category = \App\Models\Category::create([
            'nom' => $request->nom
        ]);

        // 3. ضروري نرجعو هاد الـ JSON بظبط حيت الـ JavaScript كيقرا 'id' و 'nom' باش يحطهم ف الـ Select
        return response()->json([
            'success' => true,
            'id'      => $category->id,
            'nom'     => $category->nom
        ]);
    }

    /**
     * Vérifier s'il y a de nouvelles commandes (Ajax Polling)
     */
    public function checkNewOrders()
    {
        $nouvelleCommande = \App\Models\Order::where('status', 'en_attente')
            ->where('created_at', '>=', now()->subSeconds(15))
            ->first();

        if ($nouvelleCommande) {
            return response()->json([
                'nouvelle' => true,
                'client' => $nouvelleCommande->nom_complet,
                'total' => number_format($nouvelleCommande->total, 2) . ' DH'
            ]);
        }

        return response()->json(['nouvelle' => false]);
    }

    public function viewLogs()
    {
        $logs = \App\Models\AuditLog::latest()->paginate(15);
        return view('admin.logs', compact('logs'));
    }

    public function exportPDFReport()
    {
        $totalRevenu = Order::whereIn('status', ['valide', 'livre'])->sum('total');
        $totalBenefice = $totalRevenu * 0.30;
        $totalCommandes = Order::count();
        $commandesLivrees = Order::where('status', 'livre')->count();

        $recentOrders = Order::whereIn('status', ['valide', 'livre'])
            ->latest()
            ->take(8)
            ->get();

        $data = [
            'date' => now()->format('d/m/Y H:i'),
            'totalRevenu' => $totalRevenu,
            'totalBenefice' => $totalBenefice,
            'totalCommandes' => $totalCommandes,
            'commandesLivrees' => $commandesLivrees,
            'recentOrders' => $recentOrders
        ];

        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        return $pdf->download('Rapport_Performance_ParaAdmin.pdf');
    }

    /**
     * تغيير كلمة السر للأدمن الحالي
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'new_password.required' => 'Le nouveau mot de passe est obligatoire.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ]);

        $user = auth()->user();

        // التأكد واش المودباس القديم صحيح
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // تحديث كلمة السر الجديدة
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Votre mot de passe a été modifié avec succès !');
    }
    // 1. دالة حفظ الرسالة (كتخدم بـ AJAX باش الصفحة ما تفرشش)
    public function storeMessage(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'sujet' => $request->sujet ?? 'Contact General',
            'message' => $request->message,
        ]);

        return response()->json(['success' => 'Votre message a été envoyé avec succès !']);
    }

    // 2. دالة عرض الرسائل ف الـ Admin
    public function messagesIndex()
    {
        // غا نجيبو الرسائل الجديدة هي الأولى
        $messages = Message::latest()->paginate(10);
        return view('admin.messages', compact('messages'));
    }

    // 3. دالة تحديد الرسالة كمقروءة
    public function markMessageAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => true]);
        return back()->with('success', 'Message marqué comme lu.');
    }

    // 4. دالة حذف الرسالة
    public function destroyMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return back()->with('success', 'Message supprimé avec succès.');
    }
}
