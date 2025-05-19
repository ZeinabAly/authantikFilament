<?php

namespace App\Filament\Pages\Client;

use Filament\Pages\Page;
use App\Filament\Widgets\{StatsClient, RecentOrders, ReservationsChart, OrdersChart, MostOrderedDishes};

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.client.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            StatsClient::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrdersChart::class,
            ReservationsChart::class,
            MostOrderedDishes::class,
            RecentOrders::class,
        ];
    }

}
