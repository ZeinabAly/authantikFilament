<?php

namespace App\Livewire\Client\Order;

use App\Models\Order;

use Livewire\Component;


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
        return view('livewire.client.order.view-order');
    }
}
