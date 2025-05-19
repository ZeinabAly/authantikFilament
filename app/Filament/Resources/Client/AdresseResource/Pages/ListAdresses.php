<?php

namespace App\Filament\Resources\Client\AdresseResource\Pages;

use App\Filament\Resources\Client\AdresseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdresses extends ListRecords
{
    protected static string $resource = AdresseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
