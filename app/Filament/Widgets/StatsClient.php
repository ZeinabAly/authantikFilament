<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\{Order, Reservation, Address, User, Product};

class StatsClient extends BaseWidget
{
    protected function getStats(): array
    {
        // RECUPERER LE NOM DU PANEL ACTUEL
        $panelId = Filament::getCurrentPanel()?->getId();

        // Données pour les utilisateurs simples 
        if($panelId == "admin"){
            $orderCount = Order::count();
            $reservationCount = Reservation::count();
            $livraisons = Order::where('lieu', 'A livrer')->whereNotNull('delivred_date')->count();
            $cmdEncours = Order::where('status', 'En cours')->count();
            $users = User::count();
            $products = Product::count();
        }else{
            $orderCount = Order::where('user_id', auth()->user()->id)->count();
            $reservationCount = Reservation::where('user_id', auth()->user()->id)->count();
            $livraisons = Order::where('user_id', auth()->user()->id)->where('lieu', 'A livrer')->whereNotNull('delivred_date')->count();
        }


        $chart = [
            Stat::make('Commandes', $orderCount)
            ->description('Total commandes')
            ->color('primary')
            ->icon('heroicon-o-shopping-cart'),
            Stat::make('Réservations', $reservationCount)
                ->description('Total réservations')
                ->color('info')
                ->icon('heroicon-o-calendar-days'),
            Stat::make('Livraisons', $livraisons)
                ->description('Nbre de commandes livrées')
                ->color('primary')
                ->icon('heroicon-o-shopping-cart'),
        ];

        
        if($panelId == "admin"){
            $chartAdmin = array_merge($chart, [
                Stat::make('Produits', $products)
                    ->description('Nombre de produits')
                    ->color('info')
                    ->icon('heroicon-o-squares-plus'),
                Stat::make('En cours', $cmdEncours)
                    ->description('Nombre de commandes en cours')
                    ->color('primary')
                    ->icon('heroicon-o-currency-dollar'),
                Stat::make('Utilisateurs', $users)
                    ->description('Nombre d\'utilisateurs')
                    ->color('info')
                    ->icon('heroicon-o-users'),
            ]);
            
            return $chartAdmin;
        }else{
            return $chart;
        }
        
    }
}
