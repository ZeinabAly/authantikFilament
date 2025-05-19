<?php

namespace App\Filament\Resources\Admin\EmployeeResource\Pages;

use Carbon\Carbon;
use Livewire\Attributes\On;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\Admin\EmployeeResource;
use App\Models\{Employee, Pointage, Absence, Horaire, Reservation, Order, User};

class EmployeeProfile extends Page
{
    protected static string $resource = EmployeeResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Mon profil';
    protected static ?string $slug = 'employee-profile';
    protected static string $view = 'filament.resources.admin.employee-resource.pages.employee-profile';

    public $record;
}
