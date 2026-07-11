<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation ديال البيانات
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone'   => 'required|string|max:20',
            'adresse'     => 'required|string',
            'email'       => Auth::check() ? 'nullable|email' : 'required|email',
        ]);

        $panier = session('panier', []);
        if (empty($panier)) {
            return redirect()->route('home')->with('error', 'Votre panier est vide !');
        }

        // 2. Validation ديال الـ Stock
        foreach ($panier as $id => $details) {
            $produit = Produit::find($id);
            if (!$produit || $produit->stock < $details['quantite']) {
                return redirect()->route('cart.index')->with('error', "Désolé, le produit {$details['nom']} n'a pas assez de stock.");
            }
        }

        $total = 0;
        foreach ($panier as $details) {
            $total += $details['prix'] * $details['quantite'];
        }

        try {
            // 3. إنشاء الطلبية وحفظها في جدول orders
            $commande = new Order();
            $commande->user_id     = Auth::check() ? Auth::id() : null;
            $commande->nom_complet = $request->nom_complet;
            $commande->telephone   = $request->telephone;
            $commande->adresse     = $request->adresse;
            $commande->total       = $total;
            $commande->status      = 'en_attente';
            $commande->save();

            // 4. تنقيس الـ Stock + حفظ السلعة ف جدول order_items
            foreach ($panier as $id => $details) {
                $produit = Produit::find($id);
                if ($produit) {
                    $produit->stock = $produit->stock - $details['quantite'];
                    if ($produit->stock < 0) {
                        $produit->stock = 0;
                    }
                    $produit->save();

                    \App\Models\OrderItem::create([
                        'order_id'   => $commande->id,
                        'product_id' => $id,
                        'quantity'   => $details['quantite'],
                        'price'      => $details['prix'],
                    ]);
                }
            }

            session()->forget('panier');

            return redirect()->route('confirmation', ['id' => $commande->id])->with('success', 'Votre commande a été validée avec succès !');
        } catch (\Exception $e) {
            return dd("Erreur réelle : " . $e->getMessage());
        }
    }

    // 1. عرض جميع الطلبيات ف لوحة التحكم
    public function index()
    {
        $commandes = Order::latest()->get();
        return view('admin.commandes', compact('commandes'));
    }

    // 2. 🔥 تحديث الـ Statut بمرونة وإدارة الستوك والمالية ذكياً
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:en_attente,valide,livre,annule'
        ]);

        $commande = Order::findOrFail($id);
        $ancienStatus = $commande->status;
        $nouveauStatus = $request->status;

        // إيلا تحولات الكوموند لـ إلغاء (annule) وهي كانت ديجا مقبولة أو ف الانتظار ➔ نرجعو السلعة للستوك
        if ($nouveauStatus == 'annule' && $ancienStatus != 'annule') {
            // كنجيبو كاع السلعة لي فهاد الكوموند من جدول order_items
            $items = \App\Models\OrderItem::where('order_id', $commande->id)->get();
            foreach ($items as $item) {
                $produit = Produit::find($item->product_id);
                if ($produit) {
                    $produit->stock = $produit->stock + $item->quantity; // ترجيع الستوك
                    $produit->save();
                }
            }
        }

        // إيلا رجعنا الكوموند من إلغاء (annule) لـ حالة نشطة (valide/en_attente) ➔ نردوها ونعاودو ننقصو الستوك
        if ($ancienStatus == 'annule' && $nouveauStatus != 'annule') {
            $items = \App\Models\OrderItem::where('order_id', $commande->id)->get();
            foreach ($items as $item) {
                $produit = Produit::find($item->product_id);
                if ($produit) {
                    $produit->stock = $produit->stock - $item->quantity; // تنقيص الستوك عاوتاني
                    if ($produit->stock < 0) {
                        $produit->stock = 0;
                    }
                    $produit->save();
                }
            }
        }

        $commande->status = $nouveauStatus;
        $commande->save();

        return redirect()->back()->with('success', 'Statut de la commande mis à jour avec succès !');
    }

    // 3. دالة حذف الطلبية نهائياً
    public function delete($id)
    {
        // 1. كنجيبو الطلبية اللي بغينا نمسحوها عن طريق الـ id ديالها
        $commande = \App\Models\Order::findOrFail($id);

        // ملاحظة: يلا كان الـ Model عندك مسمي Commande ماشي Order، بَدّلْها لفوق لـ Commande::findOrFail($id);

        // 2. كنمسحوها ديريكت
        $commande->delete();

        // 3. كنرجعو بـ ميساج ديال النجاح
        return redirect()->back()->with('success', 'La commande a été supprimée avec succès !');
    }

    public function downloadFacture($id)
    {
        $commande = Order::with('items.produit')->findOrFail($id);
        $data = [
            'commande' => $commande,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('facture', $data);
        return $pdf->download('facture_Express_' . $commande->id . '.pdf');
    }
}
