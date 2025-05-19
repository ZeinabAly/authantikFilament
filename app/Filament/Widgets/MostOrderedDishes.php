<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MostOrderedDishes extends ChartWidget
{
    protected static ?string $heading = 'Les plats les plus commandés';

    protected function getData(): array
    {
        $panelId = Filament::getCurrentPanel()?->getId();
        if($panelId == "admin"){
            $data = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id') 
                ->select('products.name as product_name', DB::raw('SUM(order_items.quantity) as total'))
                ->join('orders', 'order_items.order_id', '=', 'orders.id') 
                ->groupBy('products.name')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('total', 'product_name');
            }else{
                $data = DB::table('order_items')
                    ->join('products', 'order_items.product_id', '=', 'products.id') 
                    ->select('products.name as product_name', DB::raw('SUM(order_items.quantity) as total'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id') 
                    ->where('orders.user_id', auth()->id())
                    ->groupBy('products.name')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->pluck('total', 'product_name');
            }

        return [
            'datasets' => [
                [
                    'label' => 'Nombre',
                    'data' => $data->values(),
                    'backgroundColor' => ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6'],
                ]
            ],
            'labels' => $data->keys(),
        ];
    }

    public function getColumnSpan(): int | string
    {
        return 'full'; //  Prend toute la largeur
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
