<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\{Product, SousCategory, Order};

class DashBoardManager extends Component
{
    public $products = [];
    public $sousCategories = [];
    public $selectedCategory = '';
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

        // dd($this->dayOrders);
    }

    public function setSelectedCategory($id){
        $this->selectedCategory = $id;
    }


    public function orders(){

        $today = Carbon::now()->toDateString(); // Format : YYYY-MM-DD
        $this->dayOrders = Order::whereDate('created_at', $today)
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
        $this->orders = Order::take(10)->orderBy('created_at', 'desc')->get();
        
        // Plats du jour
        $this->platsDuJour = Product::where('platDuJour', 1)->get();


        return view('livewire.admin.dash-board-manager', [
            "products" => $this->products,
            "dayOrders" => $this->dayOrders,
            "orders" => $this->orders,
            "platsDuJour" => $this->platsDuJour,
        ]);
    }







    protected static ?string $model = Order::class;



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nocmd') 
                    ->label('NoCMD')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderItems_count')
                    ->label('Nbre produits')
                    ->toggleable()
                    ->counts('orderItems'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom client')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address.quartier')
                    ->toggleable()
                    ->counts('orderItems'),
                Tables\Columns\TextColumn::make('lieu')
                    ->label('Lieu')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Lieu')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
