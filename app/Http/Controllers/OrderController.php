<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

use Illuminate\Support\Facades\Session;
class OrderController extends Controller
{
    public function index()
    {
        // Kan-jebdou les commandes b l-user dialhom b "with" bach n-s-r-3o l-q-r-a-y-a
        $commandes = \App\Models\Order::with(['user', 'items'])->latest()->get();
        return view('admin.commandes', compact('commandes'));
    }
    public function valider($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->status = 'valide';
        $order->save();

        return back()->with('success', 'Commande validée avec succès!');
    }
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->back()->with('error', 'السلة خاوية');

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['prix'] * $item['qty']);
        }

        // هنا حل الخطأ ديال 1364: زدنا 'prix'
        $order = Order::create([
            'user_id' => auth()->id() ?? 1,
            'total'   => $total,
            'prix'    => $total,
            'status'  => 'en_attente'
        ]);

        foreach ($cart as $item) {
            // باش تحيد الخط الأحمر تحت id:
            // تأكد بلي $item هي Array ماشي Object
            // وبلي الـ Model OrderItem فيه $fillable
            \App\Models\OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'], // هنا الـ id ديال المنتج
                'quantity'   => $item['qty'],
                'price'      => $item['prix']
            ]);

            $product = \App\Models\Produit::find($item['id']);
            if ($product) $product->decrement('stock', $item['qty']);
        }

        session()->forget('cart');
        return redirect()->route('confirmation')->with('success', 'تم الطلب!');
    }
}
