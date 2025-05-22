<?php

namespace App\Livewire\InterfaceUser\PanierWishlist;

use Livewire\Component;
use App\Services\CartService;
use App\Services\OrderService;
use App\Models\{Address, User, RestaurantTable};
use App\Services\CheckoutService;
use Livewire\Attributes\Validate;

use App\Jobs\OrderNotificationJob;
use Surfsidemedia\Shoppingcart\Facades\Cart;


class CheckoutManager extends Component
{
    #[Validate('required|min:3')] 
    public $name = "";

    #[Validate('required|digits:9')] 
    public $phone = "";
    
    #[Validate('email')] 
    public $email = "";

    public $modePayement = "liquide";
    public $lieu = "surPlace";
    public $note;
    
    // Les variables du form d'adresse
    public $ville = "";
    public $commune = "";
    public $adresse = "";
    public $quartier = "";
    public $reference = "";
    public $isDefaultAdresse = 1;
    // La commande recemment créée
    public $commandeCreee = false;
    public $order;

    
    public $restaurantTables;
    public $tableSelected;


    public function mount(){
        // $this->items = Cart::instance('cart')->content();
        $this->restaurantTables = RestaurantTable::get();
    }

    protected function rules()
    {
        return [
            'ville' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
            'commune' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
            'adresse' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
            'quartier' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
        ];
    }

    // Personnaliser les messages d'erreur
    protected function messages() 
    {
        return [
            'name.required' => 'Ce champ est obligatoire',
            'name.min' => 'Le nom doit contenir au moins 3 caractères',
            'phone.required' => 'Ce champ est obligatoire',
            'phone.digits' => 'Le numéro de téléplone doit contenir 9 chiffres',
            'email.email' => 'L\'email doit être de type mail',
            'ville.required' => 'Ce champ est obligatoire',
            'ville.min' => 'La ville doit contenir au moins 3 caractères',
            'commune.required' => 'Ce champ est obligatoire',
            'commune.min' => 'Ce champ doit contenir au moins 3 caractères',
            'adresse.required' => 'Ce champ est obligatoire',
            'adresse.min' => 'Ce champ doit contenir au moins 3 caractères',
            'quartier.required' => 'Ce champ est obligatoire',
            'quartier.min' => 'Ce champ doit contenir au moins 3 caractères',
        ];
    }

    public function choisirLieu($lieu){
        $this->lieu = $lieu;
    }

    public function getModePayemeent($mode){
        $this->modePayement = $mode;
    }
    
    public function selectTable($table){
        $this->tableSelected = $table;
    }

    // Créer la commande
    public function createOrder(OrderService $orderService, CartService $cartService, CheckoutService $checkoutService){

        $this->validate();

        $user_id = auth()->user()->id ?? User::where('name', 'Guest')->first()->id;

        $adresse = null;
        if($this->lieu == 'aLivrer'){
            $adresse = Address::create([
                'user_id' => $user_id,
                'name' => $this->name,
                'phone' => $this->phone,
                'commune' => $this->commune,
                'address' => $this->adresse,
                'ville' => $this->ville,
                'quartier' => $this->quartier,
                'isDefault' => $this->isDefaultAdresse,
            ]);
            $this->order = $orderService->createOrder($print = false, $mode_payement = $this->modePayement, $note = $this->note ,$adresse_id = $adresse->id,  $lieu = $this->lieu,$name = $this->name, $phone = $this->phone, $email = $this->email, $serveur_id = null,  $table = $this->tableSelected);
        }else{
            $this->order = $orderService->createOrder($print = false, $mode_payement = $this->modePayement, $note = $this->note , $adresse_id = null,  $lieu = $this->lieu,$name = $this->name, $phone = $this->phone, $email = $this->email, $serveur_id = null,  $table = $this->tableSelected);
        }

        $this->commandeCreee = true;


        OrderNotificationJob::dispatch($this->order, auth()->user())->delay(now()->addSeconds(1));

    }

    public function validerCmd(){
        return redirect()->route('cart.order.confirmation', ['order' => $this->order->id]);
        $this->dispatch('commandeCreee');
    }

    public function telechargerFacture(OrderService $orderService){
        $orderService->generateInvoicePDF($this->order);
    }



    public function render()
    {
        return view('livewire.interface-user.panier-wishlist.checkout-manager', [
            'items' => Cart::instance('cart')->content(), 
            'order' => $this->order, 
        ]);
    }
}
