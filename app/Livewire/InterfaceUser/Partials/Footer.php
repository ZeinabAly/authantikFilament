<?php

namespace App\Livewire\InterfaceUser\Partials;

use Livewire\Component;
use App\Models\Setting;

class Footer extends Component
{
    public $settings;
    public function mount()
    {
        $this->settings = Setting::first(); 
    }

    public function render()
    {
        return view('livewire.interface-user.partials.footer');
    }
}
