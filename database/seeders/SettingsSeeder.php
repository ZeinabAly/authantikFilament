<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insertOrIgnore([
            'name'            => 'Authantik Restaurant',
            'slogan'          => 'La vraie cuisine guinéenne, dans toute son authenticité',
            'description'     => 'Restaurant spécialisé dans la cuisine traditionnelle guinéenne et africaine. Nous vous proposons des plats préparés avec des ingrédients frais et locaux.',
            'primary_color'   => '#e63946',
            'secondary_color' => '#2a9d8f',
            'accent_color'    => '#e9c46a',
            'phone'           => '+224 620 00 00 00',
            'email'           => 'contact@authantik.com',
            'address'         => 'Quartier Ratoma, Commune de Ratoma, Conakry, Guinée',
            'facebook_url'    => 'https://facebook.com/authantik',
            'instagram_url'   => 'https://instagram.com/authantik',
            'delivery_zone'   => 'Conakry (Ratoma, Kaloum, Matam, Dixinn, Matoto)',
            'opening_hours'   => json_encode([
                'lundi'    => ['ouvert' => true, 'debut' => '08:00', 'fin' => '22:00'],
                'mardi'    => ['ouvert' => true, 'debut' => '08:00', 'fin' => '22:00'],
                'mercredi' => ['ouvert' => true, 'debut' => '08:00', 'fin' => '22:00'],
                'jeudi'    => ['ouvert' => true, 'debut' => '08:00', 'fin' => '22:00'],
                'vendredi' => ['ouvert' => true, 'debut' => '08:00', 'fin' => '23:00'],
                'samedi'   => ['ouvert' => true, 'debut' => '09:00', 'fin' => '23:00'],
                'dimanche' => ['ouvert' => true, 'debut' => '10:00', 'fin' => '21:00'],
            ]),
            'is_active'       => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $this->command->info('  Paramètres du restaurant créés');
    }
}
