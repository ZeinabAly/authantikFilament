<?php

namespace App\Filament\Widgets;
use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Nombre de commandes passées';

    protected function getData(): array
    {
        $panelId = Filament::getCurrentPanel()?->getId();

        if($panelId == "admin"){
            $orders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');
        }else{
            $orders = Order::where('user_id', auth()->id())
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');
        }


        return [
            'datasets' => [
                [
                    'label' => 'Évolution des commandes',
                    'data' => $orders->values(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59,130,246,0.1)',
                ]
            ],
            'labels' => $orders->keys(),
        ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
