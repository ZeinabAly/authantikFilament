<?php

namespace App\Livewire\InterfaceUser\UserProfile;

use Livewire\Component;
use App\Models\Reservation;
use App\Traits\WithSortingAndPagination;
use Carbon\Carbon;

class UserWeekReservations extends Component
{
    use WithSortingAndPagination;

    public $createRoute = 'admin.reservation.create';
    
    // POUR LE FILTRE DE COLONNES
    public $columns = ['id', 'name', 'email', 'phone', 'nbrPers', 'created_at', 'date', 'heure', 'details', 'action']; 
    

    // LES NOMS A AFFICHER DANS LE FILTRE DES COLONNES
    public $columnSlugs = [
                            'id' => 'Id', 'name' => 'Nom', 'email' => 'Email', 'phone' => 'Téléphone', 'nbrPers' => 'Nombre de personnes', 'created_at' => 'Réserver le', 'date' => 'Pour le',   
                            'heure' => 'Heure',
                            'details' => 'Details',
                        ]; 

    
    public function delete($reservationId){
        $reservation = Reservation::findOrFail($reservationId);
        if($reservation){
            if($reservation->deleted_by_user == 0){
                $reservation->deleted_by_user = 1;
                $reservation->save();
                return session()->flash('status', 'Reservation supprimée avec succès');
            }else{
                return session()->flash('error', 'Cette reservation ne peut être supprimée');
            }
        }
    }

    public function cancel($reservationId){
        $reservation = Reservation::findOrFail($reservationId);
        $reservation_time = Carbon::parse($reservation->date . '' .$reservation->heure);
        $current_time = Carbon::now();
        // Verifier si l'heure de reservation est dans moins de 2heures

        if($reservation){
            if($reservation->cancelled_date == null && $reservation_time->diffInHours($current_time) < 2){
                return session()->flash('error', 'Cette réservation ne peut être supprimée');
            }else{
                $reservation->cancelled_date = now();
                $reservation->save();
                return session()->flash('status', 'Réservation supprimée avec succès');
            }
        }

    }

    public function render()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $reservations = $this->applyFilters(Reservation::where('user_id', auth()->user()->id)
        ->where('deleted_by_user', 0)
        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        );

        return view('livewire.interface-user.user-profile.user-week-reservations', [
            'reservations' => $reservations
        ]);
    }
}
