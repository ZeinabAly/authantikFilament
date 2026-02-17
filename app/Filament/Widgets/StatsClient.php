<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\{Order, Reservation, Address, User, Product};
use Illuminate\Support\Facades\Cache;

class StatsClient extends BaseWidget
{
     // Rafraîchir toutes les 5 minutes
    protected static ?string $pollingInterval = '300s';

    protected function getStats(): array
    {
        // RECUPERER LE NOM DU PANEL ACTUEL
        $panelId = Filament::getCurrentPanel()?->getId();

        // OPTIMISATION: Cache différent pour admin et client
        $cacheKey = $panelId === 'admin' ? 'stats_client_admin' : 'stats_client_user_' . auth()->id();

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($panelId) {
            
            if($panelId === "admin") {
                // OPTIMISATION: Une seule requête pour plusieurs counts
                $stats = [
                    'orders' => Order::count(),
                    'reservations' => Reservation::count(),
                    'livraisons' => Order::where('lieu', 'A livrer')
                        ->whereNotNull('delivred_date')
                        ->count(),
                    'cmdEncours' => Order::where('status', 'En cours')->count(),
                    'users' => User::count(),
                    'products' => Product::count(),
                ];
            } else {
                $userId = auth()->id();
                // OPTIMISATION: Requêtes groupées pour l'utilisateur
                $stats = [
                    'orders' => Order::where('user_id', $userId)->count(),
                    'reservations' => Reservation::where('user_id', $userId)->count(),
                    'livraisons' => Order::where('user_id', $userId)
                        ->where('lieu', 'A livrer')
                        ->whereNotNull('delivred_date')
                        ->count(),
                ];
            }

            $baseStats = [
                Stat::make('Commandes', $stats['orders'])
                    ->description('Total commandes')
                    ->color('primary')
                    ->icon('heroicon-o-shopping-cart'),
                
                Stat::make('Réservations', $stats['reservations'])
                    ->description('Total réservations')
                    ->color('info')
                    ->icon('heroicon-o-calendar-days'),
                
                Stat::make('Livraisons', $stats['livraisons'])
                    ->description('Commandes livrées')
                    ->color('success')
                    ->icon('heroicon-o-truck'),
            ];

            if($panelId === "admin") {
                return array_merge($baseStats, [
                    Stat::make('Produits', $stats['products'])
                        ->description('Nombre de produits')
                        ->color('info')
                        ->icon('heroicon-o-squares-plus'),
                    
                    Stat::make('En cours', $stats['cmdEncours'])
                        ->description('Commandes en cours')
                        ->color('warning')
                        ->icon('heroicon-o-clock'),
                    
                    Stat::make('Utilisateurs', $stats['users'])
                        ->description('Nombre d\'utilisateurs')
                        ->color('info')
                        ->icon('heroicon-o-users'),
                ]);
            }
            
            return $baseStats;
        });
        
    }
}
