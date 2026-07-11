<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Avis;
use App\Models\Order;

class ProductController extends Controller
{
    /**
     * 1. L-PAGE RA'ISIYA (HOME) + LA RECHERCHE IHTIRAFIYA
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        // 1. كنجيبو الكويري مع الـ relation ديال الكاتيبوري
        $query = Produit::with('categorie');

        // 🟢 شرط أساسي: كنجيبو غير المنتجات اللي متوفرة ف الـ Stock
        $query->where('stock', '>', 0);

        // 2️⃣ الفيلتر بالكاتيبوري (إيلا كليكاو على شي كاتيبوري)
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // 3️⃣ الفيلتر بالبحث (ديال الـ 8 د الـ Besoins أو أي خانة بحث)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // 4️⃣ 🌟 السطر المصلوح: كنجيبو النتيجة من الـ $query المفلتر نيت ومرتب من الأحدث
        $produits = $query->latest()->get();

        // ⚡ كنجيبو أول برودوي عليه تخفيض فلاش ومازال الوقت ديالو ما تسالا
        $flashProduct = Produit::where('is_flash_sale', true)
            ->where('flash_sale_end', '>', now())
            ->first();

        // كنصيفطو كاع المتغيرات بسلامة للـ view
        return view('home', compact('produits', 'categories', 'flashProduct'));
    }
    /**
     * Live Search via AJAX for Home Page
     */
    public function liveSearch(Request $request)
    {
        $searchTerm = $request->get('q');

        // إذا كانت الخانة خاوية، كترجع قائمة خاوية
        if (empty($searchTerm)) {
            return response()->json([]);
        }

        // كنجيبو فقط الاسم، الثمن، الصورة، والـ ID باش يكون الـ Performance خفيف وسريع
        $produits = Produit::where('nom', 'like', '%' . $searchTerm . '%')
            ->orWhere('description', 'like', '%' . $searchTerm . '%')
            ->select('id', 'nom', 'prix', 'image')
            ->take(6) // غنعرضو أقصى حد 6 ديال البرودويات ف البحث الفوري باش يبقا الديزاين مجموع
            ->get();

        // إرجاع النتيجة كـ JSON ديريكت لـ JavaScript
        return response()->json($produits);
    }
    /**
     * Diagnostic Peau basé 100% sur les Categories
     */
    public function diagnosticSkin(Request $request)
    {
        // هنا غايتوصل بالـ IDs (مثلا: type = 1 و problem = 3)
        $typeCategoryId = $request->get('type');
        $problemCategoryId = $request->get('problem');

        // كنجيبو المنتجات اللي تابعة لإحدى هاد الكاتيكوريات بجوج
        $produits = Produit::whereIn('category_id', [$typeCategoryId, $problemCategoryId])
            ->select('id', 'nom', 'prix', 'image')
            ->take(4) // كنجيبو 4 برودويات باش يشكلوا روتين مختلط
            ->get();

        // صيفط النتيجة لـ JavaScript
        return response()->json($produits);
    }

    /**
     * 2. LISTE DES PRODUITS (DASHBOARD ADMIN)
     */
    public function list()
    {
        $produits = Produit::with('categorie')->latest()->get();
        return view('admin.produits', compact('produits'));
    }

    /**
     * 3. DASHBOARD DIAL L-STAFF / PERSONNEL (الموظف اللي كيسير السلعة والسطوك)
     */
    public function dashboard(Request $request)
    {
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');

        // 💡 هادي هي اللي كانت ناقصة وضورية للملف ديالك: كنجيبو كاع المنتجات باش تخدم الـ table والـ count
        $produits = Produit::with('categorie')->latest()->get();

        // الحسابات والتنبيهات اللي محتاجها السيستم
        $totalProduits = Produit::count();
        $totalCategories = Category::count();
        $stockLimite = Produit::where('stock', '<=', 3)->count();

        $produitsAlerte = Produit::where('stock', '<=', 3)->get();
        $produitsCritiques = Produit::where('stock', '<=', 3)->get();

        $totalCommandes = Order::count();
        $totalRevenu = 0;
        $totalBenefice = 0;
        $chartLabels = [];
        $chartSales = [];
        $chartProfits = [];
        $categories = Category::all();

        // التوجيه الصحيح والمباشر للمجلد والملف ديالك
        return view('client.dashboard', compact(
            'produits', // مررنا المتغير دبا باش الـ Blade يقراه بلا مشاكل
            'totalProduits',
            'totalCategories',
            'stockLimite',
            'produitsAlerte',
            'produitsCritiques',
            'dateDebut',
            'dateFin',
            'totalCommandes',
            'totalRevenu',
            'totalBenefice',
            'chartLabels',
            'chartSales',
            'chartProfits',
            'categories'
        ));
    }

    /**
     * 4. ROUTES DIAL VISITEUR (الزبون العادي اللي كيشوف غير طلبياتو فين وصلو)
     */
    public function userDashboard()
    {
        // التوجيه لملف mes-commandes لي كاين داخل مجلد client
        $commandes = Order::where('user_id', auth()->id())->latest()->get();
        return view('client.mes-commandes', compact('commandes'));
    }

    /**
     * 5. ENREGISTRER UN NOUVEAU PRODUIT (AJOUTER)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prix_achat' => 'required|numeric',
            'prix' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'image' => 'nullable',
            'quantite_flash_vendue' => 'nullable|integer',
            'flash_sale_end' => 'nullable|date',
            'is_flash_sale' => 'nullable|boolean',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        Produit::create([
            'nom'         => $request->nom,
            'description' => $request->description,
            'prix'        => $request->prix,
            'prix_achat'  => $request->prix_achat,
            'category_id' => $request->category_id,
            'image'       => $imageName,
            'stock'       => $request->stock ?? 0,

            'is_flash_sale'  => $request->is_flash_sale ?? 0,
            'prix_flash'     => $request->prix_flash,
            'flash_sale_end' => $request->flash_sale_end,
        ]);

        return back()->with('success', 'Le produit a été ajouté avec succès au stock !');
    }

    /**
     * 6. PAGE DE MODIFICATION (EDIT)
     */
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Category::all();

        // 🌟 السطر الجديد اللي زدنا: كيجيب فقط المعرف والاسم ديال المنتجات كاملين باش نختارو منهم مكونات الـ Pack
        $produits = Produit::select('id', 'nom')->get();

        // هنا حافظنا على نفس الطريقة ديالك، وزدنا فقط $produits وسط الـ compact
        if (view()->exists('admin.produits.edit')) {
            return view('admin.produits.edit', compact('produit', 'categories', 'produits'));
        }

        return view('admin.edit', compact('produit', 'categories', 'produits'));
    }

    /**
     * 7. ENREGISTRER LES MODIFICATIONS (UPDATE) - ADMIN
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        // 1. الفاليداسيون نقية ومقادة بلا نقاط وبلا مشاكل
        $request->validate([
            'nom'            => 'required|string',
            'prix'           => 'required|numeric',
            'category_id'    => 'required',
            'is_flash_sale'  => 'nullable|boolean',
            'prix_flash'     => 'nullable|numeric',
            'flash_sale_end' => 'nullable',
            'pack_items'     => 'nullable|array',
        ]);

        // 2. تحويل الـ Checkboxes لـ JSON
        $packProductsJson = $request->has('pack_items') ? json_encode($request->pack_items) : json_encode([]);

        // 3. تسيير الصورة القديمة والجديدة
        $imageName = $produit->image;
        if ($request->hasFile('image')) {
            if ($produit->image && file_exists(public_path('images/products/' . $produit->image))) {
                unlink(public_path('images/products/' . $produit->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        // 4. الحفظ النهائي ف الداتابيز
        $produit->update([
            'nom'            => $request->nom,
            'description'    => $request->description,
            'prix'           => $request->prix,
            'category_id'    => $request->category_id,
            'image'          => $imageName,
            'stock'          => $request->stock ?? 0,

            // الخانات الجداد ديال الـ Flash Sale والـ Pack
            'is_flash_sale'  => $request->is_flash_sale ?? 0,
            'prix_flash'     => $request->prix_flash,
            'flash_sale_end' => $request->flash_sale_end,
            'pack_products'  => $packProductsJson,
        ]);

        // 5. التوجيه لصفحة المنتجات مع رسالة النجاح
        return redirect()->route('admin.produits')->with('success', 'Produit et Pack modifiés avec succès !');
    }

    /**
     * 8. SUPPRIMER UN PRODUIT (DESTROY)
     */
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->image && file_exists(public_path('images/products/' . $produit->image))) {
            unlink(public_path('images/products/' . $produit->image));
        }

        $produit->delete();

        return back()->with('success', 'Le produit a été supprimé avec succès !');
    }

    public function show($id)
    {
        // كنجيبو المنتج مع الـ relations ديالو
        $produit = Produit::with(['categorie', 'avis'])->findOrFail($id);

        // 🚨 حماية: إيلا كان المنتج مقضي ف الستوك (0 أو أقل) كيعطي 404 نيشان وميدخلش
        if ($produit->stock <= 0) {
            abort(404);
        }

        $moyenneNotes = $produit->avis->avg('note') ?? 0;

        // المنتجات المشابهة غايبانو فقط اللي فيهم الستوك كبر من 0
        $produitsSimilaires = Produit::where('category_id', $produit->category_id)
            ->where('id', '!=', $id)
            ->where('stock', '>', 0) // 👈 زدنا هاد الفيلتر هنا
            ->take(4)
            ->get();

        return view('products.show', compact('produit', 'produitsSimilaires', 'moyenneNotes'));
    }

    public function storeAvis(Request $request, $id)
    {
        $request->validate([
            'nom_client'  => 'required|string|max:100',
            'commentaire' => 'required|string|max:500',
            'note'        => 'required|integer|min:1|max:5',
        ]);

        Avis::create([
            'produit_id'  => $id,
            'nom_client'  => $request->nom_client,
            'commentaire' => $request->commentaire,
            'note'        => $request->note,
        ]);

        return redirect()->back()->with('success_avis', 'Votre avis a été ajouté avec succès !');
    }

    /**
     * STATFF UPDATE
     */
    public function updateStaff(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $request->validate([
            'nom'         => 'required|string|max:255',
            'prix'        => 'required|numeric',
            'prix_achat'  => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imageName = $produit->image;

        if ($request->hasFile('image')) {
            if ($produit->image && file_exists(public_path('images/products/' . $produit->image))) {
                unlink(public_path('images/products/' . $produit->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        $produit->update([
            'nom'         => $request->nom,
            'description' => $request->description,
            'prix'         => $request->prix,
            'prix_achat'  => $request->prix_achat,
            'category_id' => $request->category_id,
            'image'       => $imageName,
            'stock'       => $request->stock ?? 0,
        ]);

        return back()->with('success', 'Produit modifié avec succès !');
    }
    public function saveFlashSale(Request $request)
    {
        // 1. التحقق من أن الأدمن اختار برودوي رئيسي
        $request->validate([
            'product_id'     => 'required|exists:produits,id',
            'is_flash_sale'  => 'required|boolean',
            'prix_flash'     => 'nullable|numeric',
            'flash_sale_end' => 'nullable',
            'pack_items'     => 'nullable|array',
        ]);

        // 2. جلب المنتج اللي تختار ف الـ Dashboard
        $produit = Produit::findOrFail($request->product_id);

        // 3. تحويل الـ Checkboxes لـ JSON
        $packProductsJson = $request->has('pack_items') ? json_encode($request->pack_items) : json_encode([]);

        // 4. التحديث ف الداتابيز
        $produit->update([
            'is_flash_sale'  => $request->is_flash_sale,
            'prix_flash'     => $request->prix_flash,
            'flash_sale_end' => $request->flash_sale_end,
            'pack_products'  => $packProductsJson,
        ]);

        // 5. الرجوع مع ميساج ديال النجاح غايطلع ليك ف الشاشة
        return redirect()->back()->with('success', 'Le Pack Flash Sale a été configuré avec succès !');
    }
}
