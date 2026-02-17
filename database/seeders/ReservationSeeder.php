<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', fn($q) => $q->where('name', 'Client'))->get();
        if ($users->isEmpty()) return;

        $reservations = [
            ['user' => 0, 'name' => 'Ibrahima Bah',  'phone' => '621000001', 'email' => 'ibrahima@test.com', 'nbrPers' => 4,  'date' => now()->addDays(2)->toDateString(),  'heure' => '12:30', 'status' => 'confirmee', 'details' => 'Anniversaire, prévoir décoration'],
            ['user' => 1, 'name' => 'Aissatou Sow',  'phone' => '621000002', 'email' => 'aissatou@test.com', 'nbrPers' => 6,  'date' => now()->addDays(3)->toDateString(),  'heure' => '13:00', 'status' => 'encours',   'details' => 'Repas d\'affaires, table tranquille'],
            ['user' => 2, 'name' => 'Oumar Kouyaté', 'phone' => '621000003', 'email' => 'oumar@test.com',    'nbrPers' => 2,  'date' => now()->addDays(5)->toDateString(),  'heure' => '20:00', 'status' => 'confirmee', 'details' => null],
            ['user' => 3, 'name' => 'Mariama Barry', 'phone' => '621000004', 'email' => 'mariama@test.com',  'nbrPers' => 10, 'date' => now()->addDays(7)->toDateString(),  'heure' => '19:00', 'status' => 'encours',   'details' => 'Salle VIP pour baptême'],
            ['user' => 4, 'name' => 'Thierno Baldé', 'phone' => '621000005', 'email' => 'thierno@test.com',  'nbrPers' => 3,  'date' => now()->addDays(10)->toDateString(), 'heure' => '12:00', 'status' => 'confirmee', 'details' => null],
            ['user' => 0, 'name' => 'Ibrahima Bah',  'phone' => '621000001', 'email' => 'ibrahima@test.com', 'nbrPers' => 2,  'date' => now()->subDays(5)->toDateString(),  'heure' => '13:00', 'status' => 'passee',    'details' => null],
            ['user' => 1, 'name' => 'Aissatou Sow',  'phone' => '621000002', 'email' => 'aissatou@test.com', 'nbrPers' => 8,  'date' => now()->subDays(10)->toDateString(), 'heure' => '19:30', 'status' => 'passee',    'details' => 'Table avec vue terrasse'],
            ['user' => 2, 'name' => 'Oumar Kouyaté', 'phone' => '621000003', 'email' => 'oumar@test.com',    'nbrPers' => 4,  'date' => now()->subDays(15)->toDateString(), 'heure' => '20:00', 'status' => 'annulee',   'details' => null],
        ];

        foreach ($reservations as $r) {
            $user = $users[$r['user'] % count($users)];
            DB::table('reservations')->insertOrIgnore([
                'user_id'        => $user->id,
                'name'           => $r['name'],
                'email'          => $r['email'],
                'phone'          => $r['phone'],
                'nbrPers'        => $r['nbrPers'],
                'date'           => $r['date'],
                'heure'          => $r['heure'],
                'status'         => $r['status'],
                'details'        => $r['details'],
                'hidden_by_user' => false,
                'created_at'     => now()->subDays(rand(1, 30)),
                'updated_at'     => now(),
            ]);
        }

        $this->command->info('  Réservations créées : ' . count($reservations));
    }
}
