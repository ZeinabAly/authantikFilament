<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Réinitialisation du cache des permissions Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ---- Création des rôles ----
        $admin    = Role::firstOrCreate(['name' => 'Admin',      'guard_name' => 'web']);
        $manager  = Role::firstOrCreate(['name' => 'Manager',    'guard_name' => 'web']);
        $caissier = Role::firstOrCreate(['name' => 'Caissier',   'guard_name' => 'web']);
        $client   = Role::firstOrCreate(['name' => 'Client',     'guard_name' => 'web']);

        // ---- Administrateur ----
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@restaurant.com'],
            [
                'name'              => 'Administrateur',
                'phone'             => '620000001',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $userAdmin->assignRole($admin);

        // ---- Manager ----
        $userManager = User::firstOrCreate(
            ['email' => 'manager@restaurant.com'],
            [
                'name'              => 'Mamadou Diallo',
                'phone'             => '620000002',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $userManager->assignRole($manager);

        // ---- Caissier ----
        $userCaissier = User::firstOrCreate(
            ['email' => 'caissier@restaurant.com'],
            [
                'name'              => 'Fatoumata Camara',
                'phone'             => '620000003',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $userCaissier->assignRole($caissier);

        // ---- Clients de test ----
        $clients = [
            ['name' => 'Ibrahima Bah',     'email' => 'ibrahima@test.com',  'phone' => '621000001'],
            ['name' => 'Aissatou Sow',     'email' => 'aissatou@test.com',  'phone' => '621000002'],
            ['name' => 'Oumar Kouyaté',    'email' => 'oumar@test.com',     'phone' => '621000003'],
            ['name' => 'Mariama Barry',    'email' => 'mariama@test.com',   'phone' => '621000004'],
            ['name' => 'Thierno Baldé',    'email' => 'thierno@test.com',   'phone' => '621000005'],
        ];

        foreach ($clients as $clientData) {
            $user = User::firstOrCreate(
                ['email' => $clientData['email']],
                [
                    'name'              => $clientData['name'],
                    'phone'             => $clientData['phone'],
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active'         => true,
                ]
            );
            $user->assignRole($client);
        }

        $this->command->info('  Rôles et utilisateurs créés');
        $this->command->info('   admin@restaurant.com    → Admin    (password)');
        $this->command->info('   manager@restaurant.com  → Manager  (password)');
        $this->command->info('   caissier@restaurant.com → Caissier (password)');
        $this->command->info('   ibrahima@test.com, aissatou@test.com... → Clients (password)');
    }
}
