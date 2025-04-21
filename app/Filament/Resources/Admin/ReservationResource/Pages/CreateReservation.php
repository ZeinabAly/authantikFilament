<?php

namespace App\Filament\Resources\Admin\ReservationResource\Pages;

use App\Filament\Resources\Admin\ReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;
}
