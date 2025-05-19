<?php

namespace App\Filament\Resources\Admin\DepenseResource\Pages;

use App\Filament\Resources\Admin\DepenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepense extends EditRecord
{
    protected static string $resource = DepenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
