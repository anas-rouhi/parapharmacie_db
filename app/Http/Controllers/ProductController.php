<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('Home', compact('produits'));
    }

    // Dashboard dial l-ADMIN
    public function dashboard()
    {
        $categories = Category::all();
        return view('admin.dashboard', compact('categories'));
    }

    // Dashboard dial l-CLIENT
    public function userDashboard()
    {
        // T-akked belli f resources/views/ kayna ficher smiytha "dashboard.blade.php"
        return view('dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        Produit::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'category_id' => $request->category_id,
            'image' => $imageName,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->route('admin.produits')->with('success', 'Le produit a été ajouté.');
    }

    public function list()
    {
        $produits = Produit::all();
        return view('admin.produits', compact('produits'));
    }
}
