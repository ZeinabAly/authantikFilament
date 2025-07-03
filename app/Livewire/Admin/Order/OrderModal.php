<?php

namespace App\Livewire\Admin\Order;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\CheckoutService;
use App\Jobs\OrderNotificationJob;
use Illuminate\Support\Facades\Session;
use App\Models\{Product, SousCategory, Address, User, Order, Employee, RestaurantTable};

class OrderModal extends Component
{
    public $products = [];
    public $nbreTotalPrdts;
    public $sousCategories = [];
    public $selectedCategory = '';
    public $allCategories = '';
    public $search = '';
    public $isOpen = true;
    public $cartContent = [];
    public $total = 0;

    // Les wire model doivent eviter = ""
    public $name;
    public $phone;
    public $email;
    public $note = "";

    public $modePayement = "liquide";
    public $lieu = "surPlace";
    public $isDefaultAdresse = 0;

    public $couponCode = '';

    public $newAdresse = "";
    // Les variables du form d'adresse
    public $ville;
    public $commune;
    public $adresse;
    public $quartier;
    public $point_de_reference = "";

    public $order;
    public $commandeCreee = false;
    public $serveurs;
    public $serveur;
    public $selectedServeur = null;
    public $isManager = false;
    
    public $restaurantTables;
    public $tableSelected;
    


    public function mount(CartService $cartService){

        if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager'])){
            $this->isManager = true;
            $this->serveur = auth()->user();
        }

        $this->total =  $cartService->getCartTotal();

        $this->products = Product::all();
        $this->sousCategories = SousCategory::all();

        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);

        // Je change de logique, il n'y a pas que les serveurs, tous les employés peuvent passer une cmd
 
        $this->serveurs = Employee::where('fonction', 'serveur')->get();

        $this->restaurantTables = RestaurantTable::get();

        $this->allCategories = SousCategory::inRandomOrder()->take(1)->first();

        $this->nbreTotalPrdts = Product::count();

    }

    protected function rules()
    {
        return [
            'serveur' => 'required',
            'name' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : '',
            'phone' => $this->lieu == 'aLivrer' ? 'required|digits:9' : '',
            'email' => $this->lieu == 'aLivrer' ? 'email|nullable' : '',
            'ville' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
            'commune' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
            'adresse' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
            'quartier' => $this->lieu == 'aLivrer' ? 'required|string|min:3' : 'nullable',
        ];
    }

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
            'serveur.required' => 'Veuillez selectionner un serveur',
        ];
    }

    public function choice(int $serveurId){
        $this->serveur = Employee::findOrFail($serveurId);
    }


    #[On('openModal')]
    public function openModal(){
        $this->isOpen = true;
    }
    public function closeModal(){
        $this->isOpen = false;
    }

    public function selectTable($table){
        $this->tableSelected = $table;
    }
    
    public function setSelectedCategory($id){
        $this->selectedCategory = $id;
    }

    public function addToCart(CartService $cartService, $product, CheckoutService $checkoutService){
        $this->commandeCreee = false;
        $cart = $cartService->addProduct($product);
        $this->dispatch('cartUpdated');
        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }

        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);
    }
    
    public function getCartContent(){
        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }

        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);
        $this->dispatch('cartUpdated');
    }

    public function clearCart(CartService $cartService, CheckoutService $checkoutService){
        $cartService->resetCart();
        $this->total = $cartService->getCartTotal();
        
        $checkoutService->remove_coupon_code();
        
        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);
        $this->dispatch('cartUpdated');
    }

    public function increaseQuantity(CartService $cartService, $rowId, CheckoutService $checkoutService){
        $cartService->increaseQuantity($rowId);
        $this->dispatch('cartUpdated');

        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }

        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);
    }

    public function decreaseQuantity(CartService $cartService, $rowId, CheckoutService $checkoutService){
        $cartService->decreaseQuantity($rowId);
        $this->dispatch('cartUpdated');

        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }

        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);

    }

    public function removeProduct(CartService $cartService, $productId, CheckoutService $checkoutService){
        
        $cartService->removeProduct($productId);
        $this->dispatch('cartUpdated');

        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }

        // Récuperer tous les éléments de l'item
        $this->getCartItemElements($cartService);

    }

    public function getCartTotal(CartService $cartService){
        $this->total = $cartService->getCartTotal();
        $this->dispatch('cartUpdated');

    }

    public function applyCoupon(CheckoutService $checkoutService){
        $checkoutService->apply_coupon_code($this->couponCode);
        $checkoutService->calculateCheckout();
    }
    
    public function choisirLieu($lieu){
        $this->lieu = $lieu;
    }

    public function getModePayemeent($mode){
        $this->modePayement = $mode;
    }

    public function createOrder(OrderService $orderService, CartService $cartService, CheckoutService $checkoutService){
        
        $this->validate();

        if($this->lieu == "aLivrer"){

            $data = [
                'user_id' => auth()->user()->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'commune' => $this->commune,
                'address' => $this->adresse,
                'ville' => $this->ville,
                'quartier' => $this->quartier,
                'point_de_reference' => $this->point_de_reference,
            ];

            $this->newAdresse = Address::create($data);

            $serveur_id = null;
            if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager'])){
                $this->order = $orderService->createOrder($print = false, $mode_payment = $this->modePayement,$note = $this->note, $adresse_id = $this->newAdresse->id, $lieu = $this->lieu, $name = $this->serveur->name, $phone = $this->serveur->phone, $email = $this->serveur->email, $serveur_id = null, $table = $this->tableSelected);
            }else{
                $serveur_id = $this->serveur->id;
                $this->order = $orderService->createOrder($print = false, $mode_payment = $this->modePayement,$note = $this->note, $adresse_id = $this->newAdresse->id, $lieu = $this->lieu, $name = $this->serveur->name, $phone = $this->serveur->phone, $email = $this->serveur->email, $serveur_id = $serveur_id, $table = $this->tableSelected);
            }

        
            $this->commandeCreee = true;
            OrderNotificationJob::dispatch($this->order)->delay(now()->addSeconds(1));
            $this->dispatch('notifUpdated');
            
            $this->clearCart($cartService, $checkoutService);
    
            
        }else if($this->lieu == "aEmporter" || $this->lieu == "surPlace"){
            
            $serveur_id = null;
            if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager'])){
                $this->order = $orderService->createOrder($print = false, $mode_payment = $this->modePayement, $note = $this->note, $adresse_id = null, $lieu = $this->lieu, $name = $this->serveur->name, $phone = $this->serveur->phone, $email = $this->serveur->email, $serveur_id = null, $table = $this->tableSelected);
            }else{
                $serveur_id = $this->serveur->id;
                $this->order = $orderService->createOrder($print = false, $mode_payment = $this->modePayement, $note = $this->note, $adresse_id = null, $lieu = $this->lieu, $name = $this->serveur->name, $phone = $this->serveur->phone, $email = $this->serveur->email, $serveur_id = $serveur_id, $table = $this->tableSelected);
            }

            $this->commandeCreee = true;
            $this->clearCart($cartService, $checkoutService);
    
            $this->dispatch('notifUpdated');
            OrderNotificationJob::dispatch($this->order)->delay(now()->addSeconds(1));
        
        }

    }

    public function telechargerFacture(OrderService $orderService){
        $orderService->generateInvoicePDF($this->order);
    }

    // La fonction pour recuperer tous les éléments de la collection cartItem et les transformer en tableau
    public function getCartItemElements(CartService $cartService){
        $cartItems = $cartService->getCartContent();
        $this->cartContent = $cartItems->map(function($item) {
            return [
                'rowId' => $item->rowId,
                'id' => $item->id,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'options' => $item->options,
                'subtotal' => $item->subtotal,
                'tax' => $item->tax,
                'image' => $item->model->image ?? null,
                'description' => $item->model->description,
                'short_description' => $item->model->short_description,

            ];
        })->toArray();

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

        return view('livewire.admin.order.order-modal', [
            "products" => $this->products,
            "cartContent" => $this->cartContent,
        ]);
    }
}
