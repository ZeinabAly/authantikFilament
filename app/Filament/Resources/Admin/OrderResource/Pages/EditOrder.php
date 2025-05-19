<?php

namespace App\Filament\Resources\Admin\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Admin\OrderResource;
use Filament\Resources\Pages\Page;

class EditOrder extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.admin.order-resource.pages.edit-order';

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
