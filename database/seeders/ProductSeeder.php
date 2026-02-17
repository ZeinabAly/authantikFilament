<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sousCategories = DB::table('sous_categories')->pluck('id', 'name');

        // Prix en Francs Guinéens (GNF)
        $products = [
            // ---- Riz & Céréales ----
            [
                'sousCategory' => 'Riz & Céréales',
                'name' => 'Riz gras au poulet',
                'short_description' => 'Riz cuit dans une sauce tomate parfumée avec poulet entier',
                'description' => 'Notre riz gras est préparé avec du riz local cuit lentement dans une sauce tomate maison, accompagné d\'un poulet fermier bien tendre. Un classique incontournable.',
                'regular_price' => 80000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => true,
            ],
            [
                'sousCategory' => 'Riz & Céréales',
                'name' => 'Riz blanc + sauce au choix',
                'short_description' => 'Riz blanc vapeur avec votre sauce préférée',
                'description' => 'Riz blanc cuit à la vapeur, servi avec une sauce au choix (feuilles de manioc, arachide ou gombo). Simple et savoureux.',
                'regular_price' => 60000, 'sale_price' => 50000,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Riz & Céréales',
                'name' => 'Fonio au poulet',
                'short_description' => 'Fonio traditionnel guinéen accompagné de poulet',
                'description' => 'Le fonio est la céréale ancestrale de Guinée. Léger et nutritif, il est préparé à la manière traditionnelle et accompagné de morceaux de poulet tendres.',
                'regular_price' => 70000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],

            // ---- Sauces ----
            [
                'sousCategory' => 'Sauces',
                'name' => 'Sauce Feuilles de Manioc',
                'short_description' => 'La sauce guinéenne par excellence avec viande de bœuf',
                'description' => 'Les feuilles de manioc pilées et cuites lentement avec du bœuf, de l\'huile de palme et des épices locales. Ce plat est le symbole de la cuisine guinéenne.',
                'regular_price' => 75000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Sauces',
                'name' => 'Sauce Arachide au poulet',
                'short_description' => 'Sauce crémeuse à base de pâte d\'arachide avec poulet',
                'description' => 'Une sauce onctueuse préparée avec de la pâte d\'arachide fraîche, de la tomate et du poulet. Riche en saveurs et très appréciée.',
                'regular_price' => 70000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => true,
            ],
            [
                'sousCategory' => 'Sauces',
                'name' => 'Sauce Gombo au poisson',
                'short_description' => 'Sauce gluante au gombo avec poisson frais',
                'description' => 'Le gombo frais cuit avec du poisson fumé et frais, des épices et de l\'huile de palme. Un plat très populaire en Guinée.',
                'regular_price' => 65000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Plats Traditionnels ----
            [
                'sousCategory' => 'Plats Traditionnels',
                'name' => 'Thiéboudienne',
                'short_description' => 'Le plat national sénégalais-guinéen au poisson',
                'description' => 'Riz cuit dans une sauce tomate riche avec poisson entier, légumes (carotte, navet, aubergine) et épices africaines. Un festin complet.',
                'regular_price' => 90000, 'sale_price' => 80000,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Plats Traditionnels',
                'name' => 'Yassa Poulet',
                'short_description' => 'Poulet mariné à l\'oignon et citron',
                'description' => 'Poulet mariné toute une nuit dans une sauce à l\'oignon caramélisé, jus de citron et moutarde. Grillé puis mijoté. Inoubliable.',
                'regular_price' => 85000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Plats Traditionnels',
                'name' => 'Mafé Bœuf',
                'short_description' => 'Ragoût de bœuf à la sauce arachide',
                'description' => 'Morceaux de bœuf fondants mijotés dans une riche sauce arachide avec légumes. Servi avec du riz blanc.',
                'regular_price' => 80000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Viandes Grillées ----
            [
                'sousCategory' => 'Viandes Grillées',
                'name' => 'Poulet grillé entier',
                'short_description' => 'Poulet fermier mariné et grillé au charbon de bois',
                'description' => 'Un poulet entier mariné dans nos épices maison pendant 12h, puis grillé lentement au charbon. Peau croustillante, chair juteuse. Servi avec attiéké ou pain.',
                'regular_price' => 120000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Viandes Grillées',
                'name' => 'Demi-poulet grillé',
                'short_description' => 'Demi poulet fermier grillé au charbon',
                'description' => 'La moitié d\'un poulet fermier marinée et grillée au charbon de bois. Idéal pour un repas complet.',
                'regular_price' => 65000, 'sale_price' => 55000,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Viandes Grillées',
                'name' => 'Côtelettes d\'agneau grillées',
                'short_description' => '4 côtelettes d\'agneau marinées aux épices',
                'description' => '4 côtelettes d\'agneau tendre marinées à l\'ail, au cumin et herbes fraîches. Grillées à la perfection. Servies avec légumes grillés.',
                'regular_price' => 150000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],

            // ---- Poissons Grillés ----
            [
                'sousCategory' => 'Poissons Grillés',
                'name' => 'Capitaine grillé',
                'short_description' => 'Poisson capitaine entier grillé au charbon',
                'description' => 'Le capitaine, poisson roi de nos eaux, grillé entier avec une marinade d\'épices et de citron. Servi avec du riz ou de l\'attiéké.',
                'regular_price' => 100000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Poissons Grillés',
                'name' => 'Sole grillée',
                'short_description' => 'Sole fraîche grillée, légère et savoureuse',
                'description' => 'Une sole entière fraîche, grillée avec beurre citronné, herbes et épices douces. Idéal pour un repas léger.',
                'regular_price' => 80000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Brochettes ----
            [
                'sousCategory' => 'Brochettes',
                'name' => 'Brochettes de bœuf (6 pièces)',
                'short_description' => '6 brochettes de bœuf marinées aux épices africaines',
                'description' => 'Des morceaux de bœuf tendres marinés dans un mélange d\'épices africaines, oignon et poivron. Grillés sur braise vive.',
                'regular_price' => 55000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Brochettes',
                'name' => 'Brochettes mixtes (bœuf + poulet)',
                'short_description' => 'Assortiment de brochettes bœuf et poulet',
                'description' => 'Un assortiment de 8 brochettes (4 bœuf + 4 poulet) pour les indécis ! Le meilleur des deux mondes.',
                'regular_price' => 75000, 'sale_price' => 65000,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],

            // ---- Salades ----
            [
                'sousCategory' => 'Salades',
                'name' => 'Salade verte maison',
                'short_description' => 'Salade fraîche avec légumes de saison',
                'description' => 'Une salade généreuse avec laitue, tomates, concombre, carottes râpées, œuf dur et notre vinaigrette maison au citron.',
                'regular_price' => 30000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Soupes ----
            [
                'sousCategory' => 'Soupes',
                'name' => 'Soupe de poisson',
                'short_description' => 'Soupe légère au poisson et légumes',
                'description' => 'Une soupe claire et parfumée au poisson frais, légumes et herbes. Légère, nutritive et réconfortante.',
                'regular_price' => 35000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Jus Naturels ----
            [
                'sousCategory' => 'Jus Naturels',
                'name' => 'Jus de Gingembre',
                'short_description' => 'Jus de gingembre frais légèrement sucré',
                'description' => 'Notre jus de gingembre fraîchement pressé, légèrement sucré au miel et citron. Rafraîchissant et tonifiant.',
                'regular_price' => 20000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Jus Naturels',
                'name' => 'Jus de Bissap',
                'short_description' => 'Infusion de fleurs d\'hibiscus rouge glacée',
                'description' => 'Notre bissap (fleurs d\'hibiscus) préparé à la manière guinéenne, légèrement sucré et servi bien frais. Riche en vitamine C.',
                'regular_price' => 18000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => true, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Jus Naturels',
                'name' => 'Jus de Tamarin',
                'short_description' => 'Jus acidulé au tamarin naturel',
                'description' => 'Le tamarin est préparé artisanalement et transformé en une boisson désaltérante légèrement sucrée. Un voyage gustatif.',
                'regular_price' => 18000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Jus Naturels',
                'name' => 'Jus de Ditakh',
                'short_description' => 'Jus de ditakh, fruit tropical de Guinée',
                'description' => 'Le ditakh est un fruit tropical rare, transformé en jus crémeux et naturellement sucré. Une vraie découverte !',
                'regular_price' => 22000, 'sale_price' => null,
                'stock_status' => 'outofstock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Boissons Fraîches ----
            [
                'sousCategory' => 'Boissons Fraîches',
                'name' => 'Eau minérale (50cl)',
                'short_description' => 'Eau minérale naturelle bien fraîche',
                'description' => 'Bouteille d\'eau minérale naturelle de 50cl, servie fraîche.',
                'regular_price' => 8000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],
            [
                'sousCategory' => 'Boissons Fraîches',
                'name' => 'Coca-Cola (33cl)',
                'short_description' => 'Coca-Cola bien frais',
                'description' => 'Canette de Coca-Cola 33cl servie glacée.',
                'regular_price' => 12000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Thé & Café ----
            [
                'sousCategory' => 'Thé & Café',
                'name' => 'Thé à la menthe',
                'short_description' => 'Thé vert à la menthe fraîche façon guinéenne',
                'description' => 'Notre thé à la menthe préparé à la manière guinéenne en 3 services : fort, moyen et sucré. Une cérémonie en soi.',
                'regular_price' => 15000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Gâteaux ----
            [
                'sousCategory' => 'Gâteaux',
                'name' => 'Gâteau au miel et noix de coco',
                'short_description' => 'Gâteau moelleux au miel local et noix de coco râpée',
                'description' => 'Un gâteau maison préparé avec du miel local de Kindia et de la noix de coco râpée. Moelleux et parfumé.',
                'regular_price' => 25000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],

            // ---- Fruits & Glaces ----
            [
                'sousCategory' => 'Fruits & Glaces',
                'name' => 'Salade de fruits tropicaux',
                'short_description' => 'Assortiment de fruits tropicaux de saison',
                'description' => 'Mangue, ananas, papaye, banane et pastèque coupés et présentés avec un filet de citron et du sucre glace.',
                'regular_price' => 20000, 'sale_price' => null,
                'stock_status' => 'instock', 'featured' => false, 'platDuJour' => false,
            ],
        ];

        foreach ($products as $product) {
            $sousCatId = $sousCategories[$product['sousCategory']] ?? null;
            if (!$sousCatId) continue;

            $slug = Str::slug($product['name']);
            // Évite les doublons de slug
            $count = DB::table('products')->where('slug', 'like', $slug . '%')->count();
            if ($count > 0) $slug .= '-' . ($count + 1);

            DB::table('products')->insertOrIgnore([
                'sousCategory_id'   => $sousCatId,
                'name'              => $product['name'],
                'slug'              => $slug,
                'short_description' => $product['short_description'],
                'description'       => $product['description'],
                'regular_price'     => $product['regular_price'],
                'sale_price'        => $product['sale_price'],
                'stock_status'      => $product['stock_status'],
                'featured'          => $product['featured'],
                'platDuJour'        => $product['platDuJour'],
                'quantity'          => rand(5, 50),
                'hidden_by_user'    => false,
                'created_at'        => now()->subDays(rand(1, 60)),
                'updated_at'        => now(),
            ]);
        }

        $this->command->info('  Produits créés : ' . count($products));
    }
}
