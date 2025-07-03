<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;
use App\Models\{Product, SousCategory, Order};
use Filament\Tables\Concerns\InteractsWithTable;

#[On('platDuJourAdded')]
class DashBoardManager extends Component
{
    public $products = [];
    public $nbreTotalPrdts;
    public $sousCategories = [];
    public $selectedCategory = '';
    public $allCategories = '';
    public $search = '';
    public $orders = [];
    public $dayOrders = [];
    public $dayOrderTotal = 0;
    public $platsDuJour = [];
    public $statusSelected = "En cours";
    public $totalsData = "";

    public function mount(){

        $this->products = Product::all();
        $this->sousCategories = SousCategory::all();

        $this->orders();
        $this->totalsData = $this->orders();

        $this->allCategories = SousCategory::inRandomOrder()->take(1)->first();

        $this->nbreTotalPrdts = Product::count();
        
    }

    public function setSelectedCategory($id){
        $this->selectedCategory = $id;
    }

    public function orders(){

        $today = Carbon::now()->toDateString(); // Format : YYYY-MM-DD
        $this->dayOrders = Order::whereDate('created_at', $today)
                                ->where('status', $this->statusSelected)
                                ->orderBy('created_at', 'desc')->get();


        $ordersForTotal = Order::whereDate('created_at', $today)
                                ->orderBy('created_at', 'desc')->get();
        $totalEncours = 0;
        foreach ($ordersForTotal as $dayOrder) {
            if($dayOrder->status === "En cours"){
                $totalEncours += $dayOrder->total; 
            }
        }
        $totalDeLivre = 0;
        foreach ($ordersForTotal as $dayOrder) {
            if($dayOrder->status === "Livrée"){
                $totalDeLivre += $dayOrder->total; 
            }
        }
        $totalAnnule = 0;
        foreach ($ordersForTotal as $dayOrder) {
            if($dayOrder->status === "Annulée"){
                $totalAnnule += $dayOrder->total; 
            }
        }  


        $this->dayOrderTotal = $totalEncours + $totalDeLivre + $totalAnnule;

        return [
            'dayOrderTotal' => $this->dayOrderTotal,
            'totalEncours' => $totalEncours,
            'totalDeLivre' => $totalDeLivre,
            'totalAnnule' => $totalAnnule,
        ];
    }

    // AFFICHER LES COMMANES EN FONCTION DU STATUS
    public function getOrdersByStatus($status){
        $this->statusSelected = $status;
        $today = Carbon::now()->toDateString();
        $this->dayOrders = Order::whereDate('created_at', $today)
                ->where('status', $status)
                ->orderBy('created_at', 'desc')->get();
    }

    // EDITER UNE COMMANDE
    public function editDayOrder($dayOrderId){
        $this->dispatch('editDayOrder', dayOrderId: $dayOrderId);
    }

    #[On('commandeModifiée')]
    public function afficherStatus(){
        return session()->flash('success', 'Votre commande a été modifiée !');
    }

    
    public function retirerDesPlats($id){
        
        $product = Product::findOrFail($id);
        $product->platDuJour = 0;
        $product->save();

        $this->dispatch('platDuJourAdded');

        // return Notification::make('plats')
        //                     ->title('Le produit a été retiré des plats du jour !')
        //                     ->body("
        //                         Client : Zeinab \n
        //                         \nTable : 1
        //                         \nProduits : Tiramisu
        //                         \nTotal : 100.000GNF
        //                     ")
        //                     ->icon('heroicon-o-shopping-bag')
        //                     ->success()
        //                     ->sendToDatabase(auth()->user());
       
    }

    public function ajouterAuxPlats($id){
        
        $product = Product::findOrFail($id);
        $product->platDuJour = 1;
        $product->save();

        $this->dispatch('platDuJourAdded');

        return Notification::make('plats')
                            ->title('Le produit a été ajouté aux plats du jour !')
                            ->success()
                            ->send();
       
    }

    public function render()
    {

        $query = Product::query();

        if (!empty($this->selectedCategory)) {
            $query->where('sousCategory_id', $this->selectedCategory);
        }

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->products = $query->get();

        // Toutes les commandes
        $this->orders = Order::where('status', $this->statusSelected)->take(10)->latest()->get();
        
        // Plats du jour
        $this->platsDuJour = Product::where('platDuJour', 1)->get();


        return view('livewire.admin.dash-board-manager', [
            "products" => $this->products,
            "dayOrders" => $this->dayOrders,
            "orders" => $this->orders,
            "platsDuJour" => $this->platsDuJour,
        ]);
    }

}
