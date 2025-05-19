<?php

namespace App\Filament\Resources\Admin\DepenseResource\Pages;

use App\Filament\Resources\Admin\DepenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepenses extends ListRecords
{
    protected static string $resource = DepenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
