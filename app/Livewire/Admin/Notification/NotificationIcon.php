<?php

namespace App\Livewire\Admin\Notification;

use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;

class NotificationIcon extends Component
{
    public $nbreNotifs;
    public $panelId;

    #[On('notifUpdated')]
    public function mount(){
        $this->panelId = Filament::getCurrentPanel()->getId();
        $this->nbreNotifs = auth()->user()->unreadNotifications->count();
    }

    public function markAsRead($notifId){
        $notification = auth()->user()->notifications()->findOrFail($notifId);
        $notification->markAsRead();
        $this->dispatch('notifUpdated');
        Notification::make('markARead')
                    ->title('Notification marquée comme lu')
                    ->success()
                    ->send();
    }

    public function delete($notifId){
        $notification = auth()->user()->notifications()->findOrFail($notifId);
        $notification->delete();

        $this->dispatch('notifUpdated');

        Notification::make('delete')
                    ->title('Notification supprimée')
                    ->success()
                    ->send();
    }

    public function toutMarquer(){
        foreach(auth()->user()->unreadNotifications as $notif){
            $notif->markAsRead();
            $this->dispatch('notifUpdated');
            Notification::make('markARead')
                        ->title('Notifications marquées comme lu')
                        ->success()
                        ->send();
        }
    }

    public function toutEffacer(){
        foreach(auth()->user()->unreadNotifications as $notif){
            $notif->delete();
            $this->dispatch('notifUpdated');
            Notification::make('delete')
                        ->title('Notifications supprimées')
                        ->success()
                        ->send();
        }
    }

    public function render()
    {
        return view('livewire.admin.notification.notification-icon');
    }
}
