<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\{Order, Depense, RapportJournalier};
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Cache;

class StatsCaisse extends BaseWidget
{
    // Rafraîchir toutes les 5 minutes
    protected static ?string $pollingInterval = '300s';

    protected function getStats(): array
    {
        // OPTIMISATION: Cache de 5 minutes pour éviter de recalculer constamment
        return Cache::remember('stats_caisse', now()->addMinutes(5), function () {
            $today = Carbon::today()->toDateString();
            $hier = Carbon::yesterday()->toDateString();

            
            $rapport = RapportJournalier::whereDate('created_at', $hier)->first() 
                ?? RapportJournalier::latest()->first();

            // Hier - Requêtes optimisées
            $statsHier = Order::whereDate('created_at', $hier)
                ->where('status', 'Livrée')
                ->selectRaw('SUM(total) as total_ventes, COUNT(*) as nb_orders')
                ->first();
            
            $totalVentesHier = $statsHier->total_ventes ?? 0;
            $totalDepensesHier = Depense::whereDate('date', $hier)->sum('montant');
            $beneficeHier = $totalVentesHier - $totalDepensesHier;

            // Aujourd'hui - Requêtes optimisées
            $statsToday = Order::whereDate('created_at', $today)
                ->where('status', 'Livrée')
                ->selectRaw('SUM(total) as total_ventes, COUNT(*) as nb_orders')
                ->first();
            
            $totalVentes = $statsToday->total_ventes ?? 0;
            $totalDepenses = Depense::whereDate('date', $today)->sum('montant');
            $benefice = $totalVentes - $totalDepenses;
            
            return [
                Stat::make('Depenses', number_format($totalDepenses, 0, ',', '.') . ' GNF')
                    ->description('Aujourd\'hui')
                    ->descriptionIcon('heroicon-m-arrow-trending-down')
                    ->color('danger')
                    ->icon('heroicon-o-banknotes'),
                
                Stat::make('Ventes', number_format($totalVentes, 0, ',', '.') . ' GNF')
                    ->description('Aujourd\'hui')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('success')
                    ->icon('heroicon-o-shopping-cart'),
                
                Stat::make('Bénéfice du jour', number_format($benefice, 0, ',', '.') . ' GNF')
                    ->description('Hier : ' . number_format($beneficeHier, 0, ',', '.') . ' GNF')
                    ->descriptionIcon('heroicon-m-document-arrow-down')
                    ->color($benefice >= 0 ? 'success' : 'danger')
                    ->icon('heroicon-o-chart-bar')
                    ->url($rapport ? route('rapport.telecharger', ['rapport' => $rapport]) : null)
                    ->extraAttributes(['title' => 'Cliquer pour télécharger le rapport d\'hier']),
            ];
        });
    }
}
