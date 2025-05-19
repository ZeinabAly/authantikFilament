<?php

namespace App\Filament\Resources\Client\OrderResource\Pages;

use App\Filament\Resources\Client\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
