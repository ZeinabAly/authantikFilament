<?php

namespace App\Livewire\InterfaceUser\PanierWishlist;

use Livewire\Component;
use App\Services\OrderService;
use App\Models\Order;
use Livewire\Attributes\On;


class OrderConfirmation extends Component
{

    public $order;
    public $commandeCreee = true;

    #[On('commandeCreee')]
    public function mount($order = null)
    {
        if ($order === null) {
            $order = request()->route('order');
        }
        $this->order = Order::findOrFail($order);
        $this->commandeCreee = true;
    }

    // public function telechargerFacture(OrderService $orderService)
    // {
    //     $facture = $orderService->generateInvoicePDF($this->order);
        
    //     // Retourner le PDF pour téléchargement
    //     return response()->streamDownload(function () use ($facture) {
    //         echo $facture;
    //     }, 'facture-commande-'.$this->order->id.'.pdf');
    // }


    public function render()
    {
        return view('livewire.interface-user.panier-wishlist.order-confirmation', [
            'order' => $this->order
        ]);
    }
}
