<?php

namespace App\Livewire\InterfaceUser\UserProfile;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use App\Traits\WithSortingAndPagination;

class ReservationList extends Component
{

    public $createRoute = 'home.reservation';

    use WithSortingAndPagination;
        
    // POUR LE FILTRE DE COLONNES
    public $columns = ['id', 'name', 'email', 'phone', 'nbrPers', 'created_at', 'date', 'heure', 'details', 'action']; 
    

    // LES NOMS A AFFICHER DANS LE FILTRE DES COLONNES
    public $columnSlugs = [
                            'id' => 'Id', 'name' => 'Nom', 'email' => 'Email', 'phone' => 'Téléphone', 'nbrPers' => 'Nombre de personnes', 'created_at' => 'Réserver le', 'date' => 'Pour le',   
                            'heure' => 'Heure',
                            'details' => 'Details',
                        ]; 


    public function delete($id)
    {
        $reservation = Reservation::find($id);
        
        if($reservation) {
            $reservation->delete();
        }
        
        return session()->flash('status', 'Réservation supprimée avec succès !');
    }

    // Implémentation des méthodes abstraites du trait
    protected function getData()
    {
        return $this->applyFilters(Reservation::query());
    }

    protected function getModelClass()
    {
        return Reservation::class;
    }



    public function render()
    {
        $reservations = $this->applyFilters(Reservation::query());

        return view('livewire.interface-user.user-profile.reservation-list', [
            'reservations' => $reservations
        ]);
    }
}
