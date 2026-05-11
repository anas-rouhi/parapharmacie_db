<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        // كنجيبو السلة من السيشن، إلا ما كانتش كنعطيوها Array خاوية
        $cart = session()->get('cart', []);

        // كنزيدو المنتج للسلة
        $cart[$id] = [
            'id'    => $produit->id,
            "nom" => $produit->nom,
            "prix" => $produit->prix,
            "qty" => 1
        ];

        // كنرجعو السلة للسيشن
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté!');    }
    public function index()
    {
        return view('cart'); // هادي كترجع لينا صفحة cart.blade.php
    }
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]); // هادي هي اللي كتحيد المنتج من الـ Array
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'تم حذف المنتج من السلة!');
    }
}