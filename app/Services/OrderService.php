<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use PDF; //Du package barryvdh/laravel-dompdf
use App\Services\{CartService, CheckoutService};
use App\Models\{Order, OrderItem, Transaction, Address};

class OrderService
{
    protected $cartService;
    protected $checkoutService;
    protected $facturePDFService;

    public function __construct(CartService $cartService, CheckoutService $checkoutService, FacturePDFService $facturePDFService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
        $this->facturePDFService = $facturePDFService;
    }

    /**
     * Créer une commande à partir des produits du panier.
     */
    public function createOrder(bool $print = false, string $mode_payment = "liquide", $note = '', $adresse_id = null, $lieu = "surPlace", $name = "", $phone = "", $email = "", $serveur_id = null)
    {

        // Vérifier si le panier contient des produits
        $cartContent = $this->cartService->getCartContent();
        if ($cartContent->isEmpty()) {
            Notification::make()
                ->title('Erreur de commande')
                ->danger()
                ->body('Une erreur est survenue. Veuillez réessayer ! ')
                ->send();
            // session()->flash('error', 'Le panier est vide ! ');
            return null; 
        }

        $user = Auth::user();
        $user_id = $user->id;
        $name = $name ?? $user->name;
        $phone = $phone ?? $user->phone;

        // $addressAuthentik = Address::where('name', 'Authantik')->firstorFail();


        // if($adresse == ""){
        //     $adresse_id = $addressAuthentik->id;
        // }else{
            // }
         
        // $adresse_id = $adresse->id;

        // Calculer les totaux et informations de checkout
        $this->checkoutService->calculateCheckout();
        $checkoutData = $this->checkoutService->getCheckoutData();

        // Créer la commande
        $order = Order::create([
            'user_id' => $user_id,
            'name' => $name,
            'phone' => $phone,
            'address_id' => $adresse_id,
            'subtotal' => (float)str_replace(',', '', $checkoutData['subtotal']),
            'discount' => (float)str_replace(',', '', $checkoutData['discount']),
            'tax' => $checkoutData['tax'],
            'total' => (float)str_replace(',', '', $checkoutData['total']),
            'status' => "En cours",
            'note' => $note,
            'employee_id' => $serveur_id,
        ]);

        // Ajouter les items de la commande       
        foreach ($cartContent as $item) {
            OrderItem::create([
                'product_id' => $item->id,
                'order_id' => $order->id,
                'quantity' => $item->qty,
                'price' => $item->price,
            ]);
        }

        if($mode_payment == "liquide"){
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $order->id,
                'mode_payment' => $mode_payment,
                'status' => "En attente",
            ]);
        }elseif($mode_payment == "OM"){
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $order->id,
                'mode_payment' => $mode_payment,
                'status' => "En attente",
            ]); 
        }elseif($mode_payment == "MM"){
            
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $order->id,
                'mode_payment' => $mode_payment,
                'status' => "En attente",
            ]);

            
        }

        // Gérer l'impression de la facture
        // if ($print) {
        //     return $this->generateInvoicePDF($order);
        // }
            
        // Réinitialiser le panier
        $this->cartService->resetCart();

        // session()->flash('success', 'Commande passée avec succès ! ');
        Notification::make()
            ->title('Commande réussie !')
            ->success()
            ->body('Votre commande a bien été enregistrée')
            ->send();
        return $order;
    }

    /**
     * Générer le PDF de la facture.
     */
    public function generateInvoicePDF(Order $order)
    {
        return $this->facturePDFService->saveInvoiceFile($order);
    }
}
