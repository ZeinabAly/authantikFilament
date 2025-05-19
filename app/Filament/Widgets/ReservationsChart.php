<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ReservationsChart extends ChartWidget
{
    protected static ?string $heading = 'Nombre de réservations';

    protected function getData(): array
    {
        if(Filament::getCurrentPanel()?->getId() == "admin"){
            $data = Reservation::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
                    ->where('user_id', auth()->id())
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->orderBy('date', 'asc')
                    ->get();
                    
        }else{
            $data = Reservation::where('user_id', auth()->id())
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
                    ->where('user_id', auth()->id())
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->orderBy('date', 'asc')
                    ->get();

        }

        return [
            'datasets' => [
                [
                    'label' => 'Réservations',
                    'data' => $data->values(),
                    'borderColor' => '#10b981', // teal
                    'backgroundColor' => 'rgba(16,185,129,0.1)',
                ]
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
