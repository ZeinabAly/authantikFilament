<?php

namespace App\Livewire\Admin\Notification;

use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Facades\Filament;

class NotificationIcon extends Component
{
    public $nbreNotifs;
    public $panelId;

    #[On('notifUpdated')]
    public function mount(){
        $this->panelId = Filament::getCurrentPanel()->getId();
        $this->nbreNotifs = auth()->user()->unreadNotifications->count();
    }

    public function render()
    {
        return view('livewire.admin.notification.notification-icon');
    }
}
