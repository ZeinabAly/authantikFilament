<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;

use Livewire\Component;
// use Filament\Forms;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Forms\Contracts\HasForms;
// use Filament\Tables\Contracts\HasTable;
// use Filament\Forms\Concerns\InteractsWithForms;
// use Filament\Tables\Concerns\InteractsWithTable;


class ViewOrder extends Component 
{
    //  use InteractsWithTable, InteractsWithForms;

    public $order;
    public $orderItems;
    public $adresse;
    public $transaction;

    public function mount(Order $order)
    {

        $this->order = $order;
        $this->orderItems();
        $this->adresse();
        $this->transaction();

    }


    public function orderItems(){

        $this->orderItems = $this->order->orderItems;

    }

    public function adresse(){

        $this->adresse = $this->order->address;
        
    }
    
    public function transaction(){
        
        $this->transaction = $this->order->transaction;
    }

    public function render()
    {
        return view('livewire.admin.order.view-order');
    }
}
