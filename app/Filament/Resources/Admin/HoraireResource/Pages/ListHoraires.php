<?php

namespace App\Filament\Resources\Admin\HoraireResource\Pages;

use App\Filament\Resources\Admin\HoraireResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHoraires extends ListRecords
{
    protected static string $resource = HoraireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
