<?php

namespace App\Filament\Resources\Admin\EmployeeResource\Pages;

use App\Filament\Resources\Admin\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
