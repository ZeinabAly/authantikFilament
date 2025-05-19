<?php

namespace App\Filament\Resources\Admin\CategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Admin\CategoryResource;
use App\Filament\Resources\Admin\CategoryResource\RelationManagers\SousCategoriesRelationManager;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    public static function getRelations(): array
    {
        return [
            SousCategoriesRelationManager::class,
        ];
    }
}
