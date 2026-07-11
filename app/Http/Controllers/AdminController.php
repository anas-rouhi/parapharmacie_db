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

        $produits = Produit::all();
        $categories = Category::all();

        /**
         * 📊 حساب الأرباح الصافية (Bénéfice Net) بناءً على الفترة المحددة
         */
        $totalBenefice = $totalRevenu * 0.30;

        /**
         * 📈 تجهيز بيانات المبيانات (Chart.js) للأشهر الـ 6 الأخيرة للطلبيات المقبولة فقط
         */
        $salesData = Order::select(
            DB::raw('SUM(total) as total_sales'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->whereIn('status', ['valide', 'livre'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"), DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'asc')
            ->get();

        $chartLabels = [];
        $chartSales = [];
        $chartProfits = [];

        foreach ($salesData as $data) {
            $chartLabels[] = $data->month;
            $chartSales[] = (float)$data->total_sales;
            $chartProfits[] = (float)($data->total_sales * 0.30);
        }

        // إيلا كانت الداتابيز خاوية من المبيعات الحقيقية، كنعمروا بيانات تجريبية باش المبيان يجي عامر
        if (empty($chartLabels)) {
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun'];
            $chartSales = [4200, 5800, 7100, 6400, 8900, $totalRevenu > 0 ? $totalRevenu : 12000];
            $chartProfits = [1260, 1740, 2130, 1920, 2670, $totalBenefice > 0 ? $totalBenefice : 3600];
        }

        return view('admin.dashboard', compact(
            'produits',
            'totalProduits',
            'totalCategories',
            'stockLimite',
            'produitsCritiques',
            'totalCommandes',
            'totalRevenu',
            'totalBenefice',
            'categories',
            'chartLabels',
            'chartSales',
            'chartProfits',
            'dateDebut',
            'dateFin'
        ));
    }
    

    /**
     * عرض صفحة المستخدمين (الموظفين والزوار)
     */
    public function usersIndex()
    {
        $staff_members = User::where('role', 'client')
            ->where('id', '!=', auth()->id())
            ->latest()
            ->get();

        $visiteurs_acheteurs = User::where('role', 'visiteur')
            ->withCount('orders')
            ->latest()
            ->get();

        return view('admin.users.index', compact('staff_members', 'visiteurs_acheteurs'));
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
