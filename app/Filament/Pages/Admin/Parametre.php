<?php

namespace App\Filament\Pages\Admin;

use Filament\Pages\Page;

class Parametre extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static string $view = 'filament.pages.admin.parametre';

    protected static ?string $navigationLabel = "Réglages";

    protected static ?string $title = '';

    protected static ?int $navigationSort = 18;
}
