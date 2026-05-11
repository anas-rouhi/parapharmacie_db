<?php


namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hna kan-initializew l-variables dialna b smiyat s-h-a-h
        $totalProduits = Produit::count();
        $totalCommandes = Order::count();
        $totalRevenu = Order::sum('prix');
        $categories = Category::all();

        // Hna kan-siftohom l-View b smiyat m-qadin
        return view('admin.dashboard', [
            'totalProduits'  => $totalProduits,
            'totalCommandes' => $totalCommandes,
            'totalRevenu'    => $totalRevenu,
            'categories'     => $categories
        ]);
    }
}