<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $this->call([
            ProductSeeder::class,
        ]);
    }
}

//     public function run(): void
//     {
//         // User::factory(10)->create();

//         User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);
//     }  

// }
// \App\Models\User::create([
//     'name' => 'Admin Name',
//     'email' => 'admin@gmail.com',
//     'password' => bcrypt('password123'),
//     'role' => 'admin',
// ]);
