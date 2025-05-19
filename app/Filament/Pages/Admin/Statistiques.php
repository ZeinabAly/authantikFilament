<?php

namespace App\Filament\Pages\Admin;

use Filament\Pages\Page;
use App\Filament\Widgets\EmployeesStat;
use App\Filament\Widgets\{StatsClient, StatsCaisse, RecentOrders, ReservationsChart, OrdersChart, MostOrderedDishes};


class Statistiques extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.admin.statistiques';

    protected function getHeaderWidgets(): array
    {
        return [
            StatsCaisse::class,
            StatsClient::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrdersChart::class,
            ReservationsChart::class,
            MostOrderedDishes::class,
            EmployeesStat::class,
            RecentOrders::class,
        ];
    }

}
