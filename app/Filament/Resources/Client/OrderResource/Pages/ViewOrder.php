<?php

namespace App\Filament\Resources\Client\OrderResource\Pages;

use App\Models\Order;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\Client\OrderResource;

class ViewOrder extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.client.order-resource.pages.view-order';

    public $order;

    public function mount(Order $record)
    {
        $this->order = $record;
    }
}
