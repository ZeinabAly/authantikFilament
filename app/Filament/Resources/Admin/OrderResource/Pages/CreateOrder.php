<?php

namespace App\Filament\Resources\Admin\OrderResource\Pages;

use App\Filament\Resources\Admin\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
