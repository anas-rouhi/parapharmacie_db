<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // لستة ديال الأصناف الاحترافية الخاصة بـ Parapharmacie
        $categories = [
            ['nom' => 'Soin Visage'],
            ['nom' => 'Soin Cheveux'],
            ['nom' => 'Corps & Bain'],
            ['nom' => 'Solaire'],
            ['nom' => 'Bébé & Maman'],
            ['nom' => 'Compléments Alimentaires'],
            ['nom' => 'Hygiène Dentaire'],
            ['nom' => 'Matériel Médical']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
