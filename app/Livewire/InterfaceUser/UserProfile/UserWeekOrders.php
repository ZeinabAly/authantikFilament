<?php

namespace App\Livewire\InterfaceUser\UserProfile;

use Livewire\Component;

use App\Traits\WithSortingAndPagination;
// use App\Livewire\InterfaceUser\UserProfile\EditOrderModal;
use Carbon\Carbon;
use App\Models\Order;

class UserWeekOrders extends Component
{
    use WithSortingAndPagination;

    public $editing = true;

    public $createRoute = 'home.index';

    public $columns = ['NoCMDParJour', 'name', 'phone', 'total', 'status','lieu', 'created_at', 'delivred_date', 'action']; 

    public $columnSlugs = [
                            'NoCMDParJour' => 'NoCMD', 'name' => 'Nom', 'phone' => 'Phone',
                            'total' => 'Total', 'status' => 'Status', 'lieu' => 'Lieu', 'created_at' => 'Date', 'delivred_date' => 'Date de livraison', 
    
                        ]; 


    public function delete($orderId){
        $order = Order::findOrFail($orderId);
        if($order){
            if($order->deleted_by_user == 0){
                $order->deleted_by_user = 1;
                $order->save();
                return session()->flash('status', 'Commande supprimée avec succès');
            }else{
                return session()->flash('error', 'Cette commande a déjà été supprimée');
            }
        }

    }

    public function cancel($orderId){
        $order = Order::findOrFail($orderId);
        $deadline = $order->created_at->addHours(2);
        if($order){
            if($order->cancelled_date == null && $order->status !== 'Livrée' && $order->created_at->lessThan($deadline)){

                $reservation->cancelled_date =  now();
                $reservation->save();
                return session()->flash('status', 'Commande annulée avec succès');
            }else{
                return session()->flash('error', 'Cette commande ne peut être supprimée');
            }
        }

    }

    public function render()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $orders = $this->applyFilters(Order::where('user_id', auth()->user()->id)
        ->where('deleted_by_user', 0)
        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        );

        return view('livewire.interface-user.user-profile.user-week-orders', [
            'orders' => $orders
        ]);
    }
}
