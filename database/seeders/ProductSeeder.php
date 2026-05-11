<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit; // Zid had l-star

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Exemple dyal produit
        Produit::create([
            'name' => 'Doliprane 1000mg',
            'price' => 15.50,
            'description' => 'Paracétamol pour adultes',
            'stock' => 100,
            'category' => 'Médicaments'
        ]);

        Produit::create([
            'name' => 'Vitamin C',
            'price' => 45.00,
            'description' => 'Complément alimentaire',
            'stock' => 50,
            'category' => 'Vitamines'
        ]);
    }
}
