<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'BIENVENUE10', 'value' => 10,    'cart_value' => 50000,  'type' => 'percent', 'expiry_date' => now()->addMonths(6)->toDateString()],
            ['code' => 'FETE25000',   'value' => 25000,  'cart_value' => 100000, 'type' => 'fixed',   'expiry_date' => now()->addMonths(3)->toDateString()],
            ['code' => 'RAMADAN15',   'value' => 15,    'cart_value' => 80000,  'type' => 'percent', 'expiry_date' => now()->addMonth()->toDateString()],
            ['code' => 'VIP50000',    'value' => 50000,  'cart_value' => 200000, 'type' => 'fixed',   'expiry_date' => now()->addYear()->toDateString()],
        ];

        foreach ($coupons as $coupon) {
            DB::table('coupons')->insertOrIgnore([...$coupon, 'created_at' => now(), 'updated_at' => now()]);
        }

        $this->command->info('  Coupons créés : ' . count($coupons));
    }
}
