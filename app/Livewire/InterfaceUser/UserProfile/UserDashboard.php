<?php

namespace App\Livewire\InterfaceUser\UserProfile;

use Livewire\Component;
use App\Traits\WithSortingAndPagination;
use Carbon\Carbon;
use App\Models\{Order, Reservation};

class UserDashboard extends Component
{
    public $weekOrders; 
    public $weekReservations; 
    public $commandesEnCours; 
    public $confirmerReceptionCommande; 
    public $nbreReservations; 
    public $nbreOrders; 
    public $nbreNotifs; 
    public $user; 


    public function mount(){
        $this->user = auth()->user();
        $this->weekActivities();
        $this->nbreReservations = Reservation::where('user_id', $this->user->id)->count();
        $this->nbreOrders = Order::where('user_id', $this->user->id)->count();
        $this->nbreNotifs = $this->user->notifications()->count();

    }

    public function weekActivities(){
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $this->weekOrders = Order::where('user_id', $this->user->id)
                            ->where('deleted_by_user', 0)->get();

        $this->weekReservations = Reservation::where('user_id', $this->user->id)
                            ->where('deleted_by_user', 0)->get();

    }
                        


    public function render()
    {
        return view('livewire.interface-user.user-profile.user-dashboard');
    }
}
