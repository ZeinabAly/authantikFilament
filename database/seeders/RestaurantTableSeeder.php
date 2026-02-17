<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['name' => 'Table 1',    'position' => 'Salle principale', 'seats' => 4,  'status' => 'free'],
            ['name' => 'Table 2',    'position' => 'Salle principale', 'seats' => 4,  'status' => 'free'],
            ['name' => 'Table 3',    'position' => 'Salle principale', 'seats' => 6,  'status' => 'free'],
            ['name' => 'Table 4',    'position' => 'Salle principale', 'seats' => 6,  'status' => 'free'],
            ['name' => 'Table 5',    'position' => 'Salle principale', 'seats' => 2,  'status' => 'free'],
            ['name' => 'Table 6',    'position' => 'Salle principale', 'seats' => 2,  'status' => 'free'],
            ['name' => 'Terrasse 1', 'position' => 'Terrasse',         'seats' => 4,  'status' => 'free'],
            ['name' => 'Terrasse 2', 'position' => 'Terrasse',         'seats' => 4,  'status' => 'free'],
            ['name' => 'Terrasse 3', 'position' => 'Terrasse',         'seats' => 6,  'status' => 'free'],
            ['name' => 'VIP A',      'position' => 'Salle VIP',        'seats' => 8,  'status' => 'free'],
            ['name' => 'VIP B',      'position' => 'Salle VIP',        'seats' => 10, 'status' => 'free'],
            ['name' => 'VIP C',      'position' => 'Salle VIP',        'seats' => 12, 'status' => 'free'],
        ];

        foreach ($tables as $table) {
            DB::table('restaurant_tables')->insertOrIgnore([
                ...$table,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('  Tables restaurant créées : ' . count($tables));
    }
}
