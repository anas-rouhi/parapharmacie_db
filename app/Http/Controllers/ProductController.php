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
    // 🔢 عدد المنتجات اللي كيبانو ف الصفحة الرئيسية (الباقي كيمشي للـ Boutique)
    private const HOME_PRODUCTS_LIMIT = 8;

    public function index(Request $request)
    {
        $categories = Category::all();

        // الصفحة الرئيسية كتعرض غير 8 منتجات (Aperçu). الفلتر الكامل + البحث كاين ف /boutique
        $categoryId = $request->query('category');

        $produits = $this->filteredProductsQuery($categoryId)
            ->latest()
            ->take(self::HOME_PRODUCTS_LIMIT)
            ->get();

        // العدد الإجمالي (باش نعرفو واش نبينو زر "Voir plus")
        $totalProduits = $this->filteredProductsQuery($categoryId)->count();

        // ⚡ كنجيبو أول برودوي عليه تخفيض فلاش ومازال الوقت ديالو ما تسالا
        $flashProduct = Produit::where('is_flash_sale', true)
            ->where('flash_sale_end', '>', now())
            ->first();

        return view('home', compact('produits', 'categories', 'flashProduct', 'totalProduits'));
    }

    /**
     * Query de base : produits en stock + filtre catégorie optionnel.
     */
    private function filteredProductsQuery($categoryId = null)
    {
        $query = Produit::with('categorie')->where('stock', '>', 0);

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        return $query;
    }

    /**
     * ⚡ AJAX : Filtrer par catégorie sans recharger la page (Home "Filtrer par").
     * Retourne le HTML de la grille (8 produits max) + le total.
     */
    public function filterAjax(Request $request)
    {
        $categoryId = $request->query('category');

        $produits = $this->filteredProductsQuery($categoryId)
            ->latest()
            ->take(self::HOME_PRODUCTS_LIMIT)
            ->get();

        $total = $this->filteredProductsQuery($categoryId)->count();

        return response()->json([
            'html'  => view('products._cards', compact('produits'))->render(),
            'total' => $total,
            'shown' => $produits->count(),
        ]);
    }

    /**
     * 🛒 BOUTIQUE : page dédiée type e-commerce.
     * Recherche libre (nom/description), filtre catégorie, tri, fourchette de prix, pagination.
     */
    public function boutique(Request $request)
    {
        $categories = Category::all();

        $query = Produit::with('categorie')->where('stock', '>', 0);

        // 🔎 Recherche libre : nom OU description OU nom de catégorie
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($qb) use ($search) {
                $qb->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('categorie', function ($c) use ($search) {
                        $c->where('nom', 'LIKE', "%{$search}%");
                    });
            });
        }

        // 🏷️ Filtre catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 💰 Fourchette de prix
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', (float) $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', (float) $request->prix_max);
        }

        // ↕️ Tri
        switch ($request->get('sort')) {
            case 'prix_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'prix_desc':
                $query->orderBy('prix', 'desc');
                break;
            case 'nom':
                $query->orderBy('nom', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $produits = $query->paginate(12)->withQueryString();

        return view('boutique', compact('produits', 'categories'));
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
    /**
     * Page dédiée : formulaire d'ajout d'un produit.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.produits-create', compact('categories'));
    }

    public function list(Request $request)
    {
        $query = Produit::with('categorie');

        // 🔎 Recherche par nom / description
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nom', 'LIKE', "%{$q}%")
                    ->orWhere('description', 'LIKE', "%{$q}%");
            });
        }

        // 🏷️ Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 📦 Filtre par état du stock
        if ($request->stock === 'rupture') {
            $query->where('stock', '<=', 0);
        } elseif ($request->stock === 'critique') {
            $query->whereBetween('stock', [1, 3]);
        } elseif ($request->stock === 'ok') {
            $query->where('stock', '>', 3);
        }

        $produits = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.produits', compact('produits', 'categories'));
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

        return redirect()->route('admin.produits')->with('success', 'Le produit a été ajouté avec succès au catalogue !');
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

        $request->validate([
            'nom'         => 'required|string|max:255',
            'prix'        => 'required|numeric|min:0',
            'prix_achat'  => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'nullable|integer|min:0',
            'image'       => 'nullable|image',
        ]);

        // Gestion de l'image (on remplace l'ancienne uniquement si une nouvelle est envoyée)
        $imageName = $produit->image;
        if ($request->hasFile('image')) {
            if ($produit->image && file_exists(public_path('images/products/' . $produit->image))) {
                unlink(public_path('images/products/' . $produit->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        // 🐛 Correction importante : on ne touche PLUS aux champs Flash/Pack ici.
        // Avant, `is_flash_sale => $request->is_flash_sale ?? 0` (absent de ce formulaire) remettait
        // la valeur à 0 et vidait prix_flash / flash_sale_end / pack_products :
        // modifier un produit SUPPRIMAIT silencieusement son offre flash.
        // Les offres se gèrent désormais sur leur page dédiée (admin.flash.index).
        $produit->update([
            'nom'         => $request->nom,
            'description' => $request->description,
            'prix'        => $request->prix,
            'prix_achat'  => $request->prix_achat ?? $produit->prix_achat,
            'category_id' => $request->category_id,
            'image'       => $imageName,
            'stock'       => $request->stock ?? 0,
        ]);

        return redirect()->route('admin.produits')->with('success', 'Le produit a été modifié avec succès !');
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
        return redirect()->route('admin.flash.index')->with('success', "L'offre flash a été enregistrée avec succès !");
    }
}
