<?php

namespace App\Filament\Resources\Admin\EmployeeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Admin\EmployeeResource;
use App\Filament\Resources\Admin\EmployeeResource\RelationManagers\{CalendrierEmployeesRelationManager, AbsencesRelationManager};

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    public static function getRelations(): array
    {
        return [
            CalendrierEmployeesRelationManager::class,
            AbsencesRelationManager::class,
        ];
    }
}
