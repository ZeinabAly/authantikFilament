<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users    = User::whereHas('roles', fn($q) => $q->where('name', 'Client'))->get();
        $products = DB::table('products')->where('stock_status', 'instock')->get();

        if ($users->isEmpty() || $products->isEmpty()) return;

        $addresses = [];
        foreach ($users as $user) {
            $addressId = DB::table('addresses')->insertGetId([
                'user_id'            => $user->id,
                'name'               => $user->name,
                'phone'              => $user->phone ?? '620000000',
                'commune'            => collect(['Ratoma', 'Matam', 'Kaloum', 'Dixinn', 'Matoto'])->random(),
                'quartier'           => collect(['Coleah', 'Kipé', 'Lambanyi', 'Bambeto', 'Hafia'])->random(),
                'address'            => 'Rue ' . rand(1, 50) . ', Conakry',
                'ville'              => 'Conakry',
                'pays'               => 'Guinée',
                'point_de_reference' => 'En face de ' . collect(['la mosquée', 'l\'école', 'la pharmacie', 'la boutique'])->random(),
                'type'               => 'home',
                'isdefault'          => true,
                'hidden_by_user'     => false,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
            $addresses[$user->id] = $addressId;
        }

        $statuses = ['En cours', 'En cours', 'Livrée', 'Livrée', 'Livrée', 'Annulée'];
        $lieux    = ['Sur place', 'Sur place', 'A emporter', 'A livrer'];
        $modes    = ['Liquide', 'Orange Money', 'Mobile Money', 'A la livraison'];

        for ($i = 1; $i <= 30; $i++) {
            $user    = $users->random();
            $lieu    = $lieux[array_rand($lieux)];
            $status  = $statuses[array_rand($statuses)];
            $daysAgo = rand(0, 45);

            $selectedProducts = $products->random(rand(1, 4));
            $subtotal = 0;
            $items = [];

            foreach ($selectedProducts as $product) {
                $qty   = rand(1, 3);
                $price = $product->sale_price ?? $product->regular_price;
                $items[] = ['product' => $product, 'qty' => $qty, 'price' => $price];
                $subtotal += $price * $qty;
            }

            $discount = ($i % 5 === 0) ? rand(1, 3) * 10000 : 0;
            $total    = $subtotal - $discount;

            $orderId = DB::table('orders')->insertGetId([
                'nocmd'                 => 'CMD-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'user_id'               => $user->id,
                'address_id'            => $addresses[$user->id],
                'subtotal'              => $subtotal,
                'discount'              => $discount,
                'tax'                   => 0,
                'total'                 => $total,
                'name'                  => $user->name,
                'phone'                 => $user->phone ?? '620000000',
                'lieu'                  => $lieu,
                'status'                => $status,
                'note'                  => $i % 4 === 0 ? 'Pas trop épicé SVP' : null,
                'delivred_date'         => $status === 'Livrée'  ? now()->subDays($daysAgo)->toDateString() : null,
                'cancelled_date'        => $status === 'Annulée' ? now()->subDays($daysAgo)->toDateString() : null,
                'hidden_by_user'        => false,
                'is_shipping_different' => false,
                'created_at'            => now()->subDays($daysAgo)->subHours(rand(0, 8)),
                'updated_at'            => now()->subDays($daysAgo),
            ]);

            foreach ($items as $item) {
                DB::table('order_items')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $item['product']->id,
                    'price'      => $item['price'],
                    'quantity'   => $item['qty'],
                    'created_at' => now()->subDays($daysAgo),
                    'updated_at' => now()->subDays($daysAgo),
                ]);
            }

            if ($status !== 'Annulée') {
                DB::table('transactions')->insert([
                    'user_id'       => $user->id,
                    'order_id'      => $orderId,
                    'mode_payement' => $modes[array_rand($modes)],
                    'status'        => $status === 'Livrée' ? 'Approuvée' : 'En attente',
                    'created_at'    => now()->subDays($daysAgo),
                    'updated_at'    => now()->subDays($daysAgo),
                ]);
            }
        }

        $this->command->info('  30 commandes créées avec items, adresses et transactions');
    }
}
