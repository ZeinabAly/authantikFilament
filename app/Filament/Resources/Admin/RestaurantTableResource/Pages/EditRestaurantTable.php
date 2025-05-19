<?php

namespace App\Filament\Resources\Admin\RestaurantTableResource\Pages;

use App\Filament\Resources\Admin\RestaurantTableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantTable extends EditRecord
{
    protected static string $resource = RestaurantTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
