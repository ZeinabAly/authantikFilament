<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\{Order, Depense, RapportJournalier};
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsCaisse extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today()->toDateString();
        $hier = Carbon::yesterday()->toDateString();
        $rapport;
        if(RapportJournalier::whereDate('created_at', $hier)->first()){
            $rapport = RapportJournalier::whereDate('created_at', $hier)->first();
        }else{
            $rapport = RapportJournalier::latest()->first();
        }

        // Hier
        $totalVentesHier = Order::whereDate('created_at', $hier)->where('status', 'Livrée')->sum('total');
        $totalDepensesHier = Depense::whereDate('date', $hier)->sum('montant');
        $beneficeHier = $totalVentesHier - $totalDepensesHier;


        // Aujourdhui
        $totalVentes = Order::whereDate('created_at', $today)->where('status', 'Livrée')->sum('total');
        $totalDepenses = Depense::whereDate('date', $today)->sum('montant');
        $benefice = $totalVentes - $totalDepenses;
        
        return [
            Stat::make('Depenses', number_format($totalDepenses, 0, ',', '.') . ' GNF')
            ->description('Aujourd\'hui')
            ->color('primary')
            ->icon('heroicon-o-shopping-cart'),
            Stat::make('Ventes', number_format($totalVentes, 0, ',', '.') . ' GNF')
                ->description('Aujourd\'hui')
                ->color('info')
                ->icon('heroicon-o-calendar-days'),
            Stat::make('Bénéfice de la journée', number_format($benefice, 0, ',', '.') . ' GNF')
                ->description("Hier : " . number_format($beneficeHier, 0, ',', '.') . ' GNF')
                ->color('primary')
                ->description("Cliquer pour télecharger le rapport d'hier")
                ->url(route('rapport.telecharger', ['rapport' => $rapport]))
                ->icon('heroicon-o-shopping-cart'),
        ];
    }
}
