<?php

namespace App\Livewire\InterfaceUser\Reservation;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use App\Jobs\SendReservationNotificationJob;

class ReservationModal extends Component
{
    public $name, $date, $heure, $nbrPers, $phone, $email, $details;

    public $success = false;

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required',
            'nbrPers' => 'required|integer|min:1',
            'phone' => 'required|digits:9',
            'email' => 'nullable|email',
            'details' => 'nullable|string'
        ];
    }

    public function save()
    {
        if (!Auth::check()) {
            
            // return Notification::make()
            //     ->title('Connexion exigée ! ')
            //     ->danger()
            //     ->body('Vous devez être connecté pour faire une réservation ! ')
            //     ->persistent() //Force manuellement un z-index plus élevé pour les notifications
            //     ->send();
        }

        $this->validate();

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'date' => $this->date,
            'heure' => $this->heure,
            'phone' => $this->phone,
            'nbrPers' => $this->nbrPers,
            'email' => $this->email,
            'details' => $this->details,
        ]);

        SendReservationNotificationJob::dispatch($reservation, Auth::user())->delay(now()->addSeconds(1));

        $this->reset(); // vide les champs
        $this->success = true;
        session()->flash('success', 'Réservation passée avec succès !');

        // $this->dispatch('close-modal'); // événement Alpine
    }

    public function render()
    {
        return view('livewire.interface-user.reservation.reservation-modal');
    }
}
