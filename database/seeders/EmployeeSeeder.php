<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $managerUser  = User::where('email', 'manager@restaurant.com')->first();
        $caissierUser = User::where('email', 'caissier@restaurant.com')->first();

        $employees = [
            ['user_id' => $managerUser?->id,  'name' => 'Mamadou Diallo',   'phone' => '620000002', 'email' => 'manager@restaurant.com',  'fonction' => 'Manager',         'salaire' => '5000000', 'embauche_at' => '2024-01-15', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Gestion d\'équipe, stocks, relation client',        'description' => 'Manager expérimenté avec 8 ans dans la restauration.'],
            ['user_id' => null,               'name' => 'Kadiatou Touré',   'phone' => '622000001', 'email' => 'kadiatou@restaurant.com', 'fonction' => 'Chef Cuisinier',  'salaire' => '4500000', 'embauche_at' => '2024-02-01', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Cuisine guinéenne, africaine, pâtisserie',          'description' => 'Chef spécialisée dans les recettes traditionnelles.'],
            ['user_id' => null,               'name' => 'Sékou Condé',      'phone' => '622000002', 'email' => 'sekou@restaurant.com',    'fonction' => 'Cuisinier',       'salaire' => '3000000', 'embauche_at' => '2024-03-10', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Grillades, cuisson charbon, marinades',             'description' => 'Spécialiste des grillades et brochettes.'],
            ['user_id' => $caissierUser?->id, 'name' => 'Fatoumata Camara', 'phone' => '620000003', 'email' => 'caissier@restaurant.com', 'fonction' => 'Caissière',       'salaire' => '2500000', 'embauche_at' => '2024-01-20', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Gestion caisse, facturation, service client',       'description' => 'Caissière rigoureuse et accueillante.'],
            ['user_id' => null,               'name' => 'Alpha Barry',      'phone' => '622000003', 'email' => 'alpha@restaurant.com',    'fonction' => 'Serveur',         'salaire' => '2000000', 'embauche_at' => '2024-04-01', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Service en salle, prise de commandes, accueil',    'description' => 'Serveur dynamique et souriant.'],
            ['user_id' => null,               'name' => 'Aminata Konaté',   'phone' => '622000004', 'email' => 'aminata@restaurant.com',  'fonction' => 'Serveuse',        'salaire' => '2000000', 'embauche_at' => '2024-04-15', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Service en salle, accueil client',                 'description' => 'Serveuse professionnelle et attentive.'],
            ['user_id' => null,               'name' => 'Ibrahima Sylla',   'phone' => '622000005', 'email' => null,                     'fonction' => 'Livreur',         'salaire' => '1800000', 'embauche_at' => '2024-05-01', 'finContrat_at' => null,         'is_active' => true,  'competences' => 'Livraison rapide, connaissance de Conakry',        'description' => 'Livreur fiable connaissant parfaitement la ville.'],
            ['user_id' => null,               'name' => 'Mariama Baldé',    'phone' => '622000006', 'email' => null,                     'fonction' => 'Plongeur',        'salaire' => '1500000', 'embauche_at' => '2024-06-01', 'finContrat_at' => '2025-01-31', 'is_active' => false, 'competences' => 'Nettoyage cuisine, gestion vaisselle',             'description' => 'Responsable de la propreté de la cuisine.'],
        ];

        foreach ($employees as $e) {
            DB::table('employees')->insertOrIgnore([
                'user_id'       => $e['user_id'],
                'name'          => $e['name'],
                'phone'         => $e['phone'],
                'password'      => Hash::make('password'),
                'email'         => $e['email'],
                'fonction'      => $e['fonction'],
                'image'         => 'uploads/employees/default.jpg',
                'salaire'       => $e['salaire'],
                'embauche_at'   => $e['embauche_at'],
                'finContrat_at' => $e['finContrat_at'],
                'competences'   => $e['competences'],
                'description'   => $e['description'],
                'is_active'     => $e['is_active'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        $this->command->info('  Employés créés : ' . count($employees));
    }
}
