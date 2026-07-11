<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Produit;

class CartController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);

        $totalGeneral = 0;
        foreach ($panier as $details) {
            $totalGeneral += $details['prix'] * $details['quantite'];
        }

        $couponData = session()->get('coupon');

        $valeurRemise = 0;
        $couponType = 'pourcentage';
        $couponValeurRaw = 0;

        if (is_array($couponData)) {
            $couponType = $couponData['type'] ?? 'pourcentage';
            $couponValeurRaw = $couponData['valeur'] ?? 0;

            if ($couponType === 'pourcentage') {
                $valeurRemise = $totalGeneral * ($couponValeurRaw / 100);
            } else {
                $valeurRemise = $couponValeurRaw;
            }
        }

        if ($valeurRemise > $totalGeneral) {
            $valeurRemise = $totalGeneral;
        }

        $totalApresRemise = $totalGeneral - $valeurRemise;

        return view('cart.index', compact('panier', 'totalGeneral', 'totalApresRemise', 'couponType', 'couponValeurRaw', 'valeurRemise'));
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            session()->forget('coupon');
            return back()->with('error', 'Code coupon invalide.');
        }

        $total = 0;
        $panier = session()->get('panier', []);

        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        if ($coupon->date_expiration < now()->toDateString()) {
            session()->forget('coupon');
            return back()->with('error', 'Ce coupon est expiré.');
        }

        if (
            $coupon->limite_utilisation &&
            $coupon->total_utilisations >= $coupon->limite_utilisation
        ) {
            session()->forget('coupon');
            return back()->with('error', 'Ce coupon n’est plus disponible.');
        }

        if ($total < $coupon->montant_minimum) {
            session()->forget('coupon');
            return back()->with(
                'error',
                'Montant minimum : ' . $coupon->montant_minimum . ' DH'
            );
        }

        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'valeur' => $coupon->valeur,
        ]);

        return back()->with('success', 'Coupon appliqué avec succès.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon retiré !');
    }

    public function add(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->stock <= 0) {
            return redirect()->back()->with('error', 'Désolé, ce produit est en rupture de stock !');
        }

        $panier = session()->get('panier', []);
        $quantiteAcheter = $request->input('quantite', 1);
        $buyType = $request->input('buy_type', 'normal');

        $cartKey = $id . '_' . $buyType;

        if ($quantiteAcheter > $produit->stock) {
            return redirect()->back()->with('error', 'Désolé, la quantité demandée dépasse le stock disponible (' . $produit->stock . ' restants) !');
        }

        $subProducts = [];
        if ($buyType === 'pack' && $produit->is_flash_sale == 1) {
            $prixFinal = $produit->prix_flash;
            $nomAffichage = $produit->nom;

            if (!empty($produit->pack_products)) {
                $decoded = is_array($produit->pack_products) ? $produit->pack_products : json_decode($produit->pack_products, true);
                $subProducts = $decoded ?? [];
            }
        } else {
            $prixFinal = $produit->prix;
            $nomAffichage = $produit->nom;
        }

        if (isset($panier[$cartKey])) {
            if (($panier[$cartKey]['quantite'] + $quantiteAcheter) <= $produit->stock) {
                $panier[$cartKey]['quantite'] += $quantiteAcheter;
            } else {
                $panier[$cartKey]['quantite'] = $produit->stock;
            }
        } else {
            $panier[$cartKey] = [
                "id_produit"   => $produit->id,
                "nom"          => $nomAffichage,
                "quantite"     => $quantiteAcheter,
                "prix"         => $prixFinal,
                "image"        => $produit->image,
                "buy_type"     => $buyType,
                "sub_products" => $subProducts
            ];
        }

        session()->put('panier', $panier);
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès !');
    }

    public function remove($id)
    {
        $panier = session()->get('panier', []);
        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }
        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    public function checkout(Request $request)
    {
        $panier = session()->get('panier', []);
        if (empty($panier)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        $request->validate([
            'nom_complet' => 'required|string|max:100',
            'telephone'   => 'required|string|max:20',
            'adresse'     => 'required|string|max:255',
        ]);

        $totalGeneral = 0;
        foreach ($panier as $details) {
            $totalGeneral += $details['prix'] * $details['quantite'];
        }

        $valeurRemise = 0;
        if (session()->has('coupon')) {
            $couponType = session()->get('coupon.type', 'pourcentage');
            $couponValeurRaw = session()->get('coupon.valeur', 0);

            if ($couponType === 'pourcentage') {
                $valeurRemise = $totalGeneral * ($couponValeurRaw / 100);
            } else {
                $valeurRemise = $couponValeurRaw;
            }
        }

        $totalFinal = $totalGeneral - $valeurRemise;
        if ($totalFinal < 0) {
            $totalFinal = 0;
        }

        try {
            $commande = Order::create([
                'user_id'     => auth()->check() ? auth()->id() : null,
                'nom_complet' => $request->nom_complet,
                'telephone'   => $request->telephone,
                'adresse'     => $request->adresse,
                'total'       => $totalFinal,
                'status'      => 'en_attente',
            ]);

            foreach ($panier as $cartKey => $details) {
                $realProductId = isset($details['id_produit']) ? $details['id_produit'] : $cartKey;

                $produit = \App\Models\Produit::find($realProductId);
                if ($produit) {
                    $produit->stock = $produit->stock - $details['quantite'];
                    if ($produit->stock < 0) {
                        $produit->stock = 0;
                    }
                    $produit->save();

                    \App\Models\OrderItem::create([
                        'order_id'   => $commande->id,
                        'product_id' => $realProductId,
                        'quantity'   => $details['quantite'],
                        'price'      => $details['prix'],
                    ]);
                }
            }
            if (session()->has('coupon')) {
                Coupon::where('id', session('coupon.id'))
                    ->increment('total_utilisations');
            }

            session()->forget(['panier', 'coupon']);
            return redirect()->route('confirmation', ['id' => $commande->id])->with('success', 'Votre commande a été validée avec succès !');
        } catch (\Exception $e) {
            return dd("Erreur lors du checkout : " . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $panier = session()->get('panier', []);
        $quantite = intval($request->input('quantity', $request->input('quantite')));        if ($quantite <= 0 && isset($panier[$id])) {
            $quantite = $panier[$id]['quantite'] + 1;
        }

        if (isset($panier[$id]) && $quantite > 0) {
            $panier[$id]['quantite'] = $quantite;
            session()->put('panier', $panier);

            return redirect()->back()->with('success', 'Panier mis à jour !');
        }

        return redirect()->back()->with('error', 'Impossible de mettre à jour.');
    }
}
