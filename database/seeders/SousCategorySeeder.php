<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SousCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Récupération des catégories par nom
        $categories = DB::table('categories')->pluck('id', 'name');

        $sousCategories = [
            // Plats Principaux
            ['category' => 'Plats Principaux', 'name' => 'Riz & Céréales',    'description' => 'Riz blanc, riz gras, fonio...'],
            ['category' => 'Plats Principaux', 'name' => 'Sauces',             'description' => 'Sauce feuilles, arachide, gombo...'],
            ['category' => 'Plats Principaux', 'name' => 'Pâtes & Feuilleté',  'description' => 'Plats à base de pâtes et feuilletés'],

            // Spécialités Guinéennes
            ['category' => 'Spécialités Guinéennes', 'name' => 'Plats Traditionnels', 'description' => 'Les recettes de nos grands-mères'],
            ['category' => 'Spécialités Guinéennes', 'name' => 'Plat du Jour',         'description' => 'Notre suggestion du jour'],

            // Grillades & Brochettes
            ['category' => 'Grillades & Brochettes', 'name' => 'Viandes Grillées', 'description' => 'Poulet, bœuf, agneau au charbon'],
            ['category' => 'Grillades & Brochettes', 'name' => 'Poissons Grillés',  'description' => 'Poissons frais du jour'],
            ['category' => 'Grillades & Brochettes', 'name' => 'Brochettes',         'description' => 'Brochettes mixtes et marinées'],

            // Entrées & Salades
            ['category' => 'Entrées & Salades', 'name' => 'Salades',   'description' => 'Fraîches et légères'],
            ['category' => 'Entrées & Salades', 'name' => 'Soupes',    'description' => 'Soupes chaudes et réconfortantes'],
            ['category' => 'Entrées & Salades', 'name' => 'Amuse-bouches', 'description' => 'Petites bouchées à partager'],

            // Boissons
            ['category' => 'Boissons', 'name' => 'Jus Naturels',      'description' => 'Jus pressés et infusions locales'],
            ['category' => 'Boissons', 'name' => 'Boissons Fraîches',  'description' => 'Sodas, eau, limonades'],
            ['category' => 'Boissons', 'name' => 'Thé & Café',         'description' => 'Thé à la menthe, café Touba...'],

            // Desserts
            ['category' => 'Desserts', 'name' => 'Gâteaux',          'description' => 'Pâtisseries maison'],
            ['category' => 'Desserts', 'name' => 'Fruits & Glaces',  'description' => 'Fruits de saison et glaces artisanales'],
        ];

        foreach ($sousCategories as $sc) {
            $categoryId = $categories[$sc['category']] ?? null;
            if (!$categoryId) continue;

            DB::table('sous_categories')->insertOrIgnore([
                'category_id' => $categoryId,
                'name'        => $sc['name'],
                'slug'        => Str::slug($sc['name'] . '-' . Str::slug($sc['category'])),
                'description' => $sc['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('  Sous-catégories créées : ' . count($sousCategories));
    }
}
