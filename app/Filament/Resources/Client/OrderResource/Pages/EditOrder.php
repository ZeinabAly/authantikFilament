<?php

namespace App\Filament\Resources\Client\OrderResource\Pages;

use App\Filament\Resources\Client\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use App\Models\Order;

class EditOrder extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.client.order-resource.pages.edit-order';

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    public $order;

    public function mount(Order $record)
    {
        $this->order = $record;

    }
}
