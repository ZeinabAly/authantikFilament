<?php

namespace App\Livewire\Admin\Notification;

use Livewire\Component;
use Livewire\WithPagination;
use Filament\Notifications\Notification;

class NotificationManager extends Component
{
    use WithPagination; // Ajoute le trait pour la pagination

    public $typeNotif = 'toutes';

    public function choiceNotifType($type)
    {
        $this->typeNotif = $type;
        $this->resetPage(); // Reset la pagination lorsque le type change
    }

    public function getNotifications()
    {
        if ($this->typeNotif !== 'toutes') {
            $types = [
                // "connexion" => "App\Notifications\ConnexionNotification",
                "reservation" => "App\Notifications\ReservationNotification",
                "commande" => "App\Notifications\OrderNotification",
            ];
        
            if (isset($types[$this->typeNotif])) {
                $query = auth()->user()->notifications()->where('type', $types[$this->typeNotif]);
            } else {
                $query = auth()->user()->notifications();
            }
        } else {
            $query = auth()->user()->notifications();
        }
        
        if ($this->typeNotif == 'nonLu') {
            $query = $query->whereNull('read_at'); 
        }
        
        $notifications = $query->paginate(8);
        
        return $query->paginate(8);
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

    public function render()
    {
        return view('livewire.admin.notification.notification-manager', [
            'notifications' => $this->getNotifications(),
        ]);
    }
}