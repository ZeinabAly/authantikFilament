<?php

namespace App\Livewire\InterfaceUser\UserProfile;

use Livewire\Component;
use App\Models\Order;
use App\Traits\WithSortingAndPagination;

class OrderList extends Component
{

    use WithSortingAndPagination;

    public $createRoute = 'home.menu';

    // ICI JE DOIS RAJOUTER LA COLONNE NOMBRE DE PRODUITS , 'nbrePrdts'
    
    // POUR LE FILTRE DE COLONNES
    public $columns = ['NoCMDParJour', 'name', 'phone', 'total', 'status','lieu', 'created_at', 'delivred_date', 'action']; 
    

    // LES NOMS A AFFICHER DANS LE FILTRE DES COLONNES
    public $columnSlugs = [
                            'NoCMDParJour' => 'NoCMD', 'name' => 'Nom', 'phone' => 'Phone',
                            'total' => 'Total', 'status' => 'Status', 'lieu' => 'Lieu', 'created_at' => 'Date', 'delivred_date' => 'Date de livraison', 
    
                        ]; 


    public function delete($id)
    {
        $order = Order::find($id);
        
        if($order) {
            $order->delete();
        }
        
        return session()->flash('status', 'Sous categorie supprimé avec succès !');
    }

    // Implémentation des méthodes abstraites du trait
    protected function getData()
    {
        return $this->applyFilters(Order::query());
    }

    protected function getModelClass()
    {
        return Order::class;
    }

    public function render()
    {
        $orders = $this->applyFilters(Order::query());

        return view('livewire.interface-user.user-profile.order-list', [
            'orders' => $orders
        ]);
    }
}
