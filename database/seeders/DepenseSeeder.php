<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepenseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Ingrédients & Épicerie',
            'Viandes & Poissons',
            'Légumes & Fruits',
            'Boissons & Jus',
            'Gaz & Charbon',
            'Nettoyage & Entretien',
            'Salaires',
            'Électricité',
            'Eau',
            'Divers',
        ];

        $depenses = [];

        // Génération de dépenses sur les 45 derniers jours
        for ($d = 0; $d <= 44; $d++) {
            $date = now()->subDays($d)->toDateString();

            // 2 à 5 dépenses par jour
            $nbDepenses = rand(2, 5);
            for ($j = 0; $j < $nbDepenses; $j++) {
                $categorie = $categories[array_rand($categories)];
                $depenses[] = [
                    'description' => $this->getDescription($categorie),
                    'quantite'    => rand(1, 5),
                    'montant'     => $this->getMontant($categorie),
                    'date'        => $date,
                    'created_at'  => now()->subDays($d),
                    'updated_at'  => now()->subDays($d),
                ];
            }
        }

        DB::table('depenses')->insert($depenses);

        // Génération de rapports journaliers pour les 30 derniers jours
        for ($d = 1; $d <= 30; $d++) {
            $date = now()->subDays($d)->toDateString();

            $totalVentes   = DB::table('orders')
                ->whereDate('created_at', $date)
                ->where('status', 'Livrée')
                ->sum('total');

            $totalDepenses = DB::table('depenses')
                ->where('date', $date)
                ->sum('montant');

            // On insère seulement si des données existent
            if ($totalVentes > 0 || $totalDepenses > 0) {
                DB::table('rapport_journaliers')->insertOrIgnore([
                    'date'            => $date,
                    'total_ventes'    => $totalVentes,
                    'total_depenses'  => $totalDepenses,
                    'benefice'        => $totalVentes - $totalDepenses,
                    'created_at'      => now()->subDays($d - 1), // Rapport créé le lendemain
                    'updated_at'      => now()->subDays($d - 1),
                ]);
            }
        }

        $this->command->info('  Dépenses créées : ' . count($depenses));
        $this->command->info('  Rapports journaliers générés pour les 30 derniers jours');
    }

    private function getDescription(string $categorie): string
    {
        $descriptions = [
            'Ingrédients & Épicerie' => ['Achat de riz local', 'Huile de palme', 'Tomates et oignons', 'Sel, épices et condiments', 'Farine et sucre'],
            'Viandes & Poissons'     => ['Poulets fermiers (10 kg)', 'Bœuf local (5 kg)', 'Poissons frais du marché', 'Agneau (3 kg)', 'Poisson fumé'],
            'Légumes & Fruits'       => ['Légumes du marché central', 'Feuilles de manioc (sac)', 'Gombo frais', 'Fruits tropicaux', 'Aubergines et carottes'],
            'Boissons & Jus'         => ['Gingembre et bissap', 'Eau minérale (caisse)', 'Boissons gazeuses', 'Fruits pour jus', 'Tamarin et ditakh'],
            'Gaz & Charbon'          => ['Bouteille de gaz butane', 'Sac de charbon de bois', '2 bouteilles de gaz', 'Charbon pour grillades'],
            'Nettoyage & Entretien'  => ['Produits de nettoyage', 'Lingettes et éponges', 'Détergent cuisine', 'Désinfectant'],
            'Salaires'               => ['Avance sur salaire cuisinier', 'Salaire livreur semaine', 'Avance serveuse', 'Paiement plongeur'],
            'Électricité'            => ['Facture EDG (électricité)', 'Recharge électricité', 'Achat groupe électrogène (carburant)'],
            'Eau'                    => ['Facture SEG (eau)', 'Bidons d\'eau potable', 'Recharge eau'],
            'Divers'                 => ['Réparation matériel cuisine', 'Achat ustensiles', 'Papier d\'emballage', 'Sacs de livraison', 'Recharge téléphone'],
        ];

        $options = $descriptions[$categorie] ?? ['Dépense diverse'];
        return $options[array_rand($options)];
    }

    private function getMontant(string $categorie): int
    {
        $fourchettes = [
            'Ingrédients & Épicerie' => [30000, 150000],
            'Viandes & Poissons'     => [80000, 300000],
            'Légumes & Fruits'       => [20000, 80000],
            'Boissons & Jus'         => [30000, 100000],
            'Gaz & Charbon'          => [50000, 200000],
            'Nettoyage & Entretien'  => [15000, 60000],
            'Salaires'               => [100000, 500000],
            'Électricité'            => [80000, 400000],
            'Eau'                    => [30000, 100000],
            'Divers'                 => [10000, 100000],
        ];

        $range = $fourchettes[$categorie] ?? [10000, 100000];
        // Arrondi à 5000 GNF
        return (int)(round(rand($range[0], $range[1]) / 5000) * 5000);
    }
}
