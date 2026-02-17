<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $this->call : méthode de Laravel pour appeler un seeder depuis un autre seeder.
        $this->call([
            RolesAndUsersSeeder::class,   // Rôles + utilisateurs (admin, manager, clients)
            SettingsSeeder::class,         // Paramètres du restaurant
            CategorySeeder::class,         // Catégories du menu
            SousCategorySeeder::class,     // Sous-catégories
            ProductSeeder::class,          // Produits du menu
            RestaurantTableSeeder::class,  // Tables du restaurant
            EmployeeSeeder::class,         // Employés
            CouponSeeder::class,           // Codes promo
            ReservationSeeder::class,      // Réservations
            OrderSeeder::class,            // Commandes + items + transactions
            DepenseSeeder::class,          // Dépenses
        ]);
    }
}
