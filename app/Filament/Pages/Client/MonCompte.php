<?php

namespace App\Filament\Pages\Client;

use Filament\Pages\Page;

class MonCompte extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.client.mon-compte';

    public $user;

    public function mount(){
        $this->user = auth()->user();
    }

}
