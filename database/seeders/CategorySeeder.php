<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Plats Principaux',        'description' => 'Nos plats chauds cuisinés avec soin'],
            ['name' => 'Spécialités Guinéennes',   'description' => 'Les grands classiques de la cuisine guinéenne'],
            ['name' => 'Grillades & Brochettes',   'description' => 'Viandes et poissons grillés au charbon de bois'],
            ['name' => 'Entrées & Salades',         'description' => 'Pour commencer votre repas en beauté'],
            ['name' => 'Boissons',                  'description' => 'Jus naturels, boissons fraîches et chaudes'],
            ['name' => 'Desserts',                  'description' => 'Pour finir sur une note sucrée'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insertOrIgnore([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('  Catégories créées : ' . count($categories));
    }
}
