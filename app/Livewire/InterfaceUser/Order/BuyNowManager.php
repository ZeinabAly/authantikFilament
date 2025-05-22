<?php

namespace App\Livewire\InterfaceUser\Order;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Jobs\OrderNotificationJob;
use App\Models\{Product, Address, User, Order, OrderItem, Transaction, RestaurantTable};

class BuyNowManager extends Component
{

    public $productId;
    public $product;
    public $name;
    public $phone;
    public $email;
    public $note;
    public $quantity = 1;
    public $prixTotal;
    public $order;

    public $modePayement = "liquide";
    public $lieu = "surPlace";

    // Les variables du form d'adresse
    public $ville;
    public $commune;
    public $adresse;
    public $quartier;
    public $point_de_reference = "";
    public $userHasAdresse = false;
    public $userAdresse;
    public $autreAdresse = false; //Livrer a une autre adresse
    public $newAdresse = ""; //Nouvelle adresse créée

    
    public $isDefaultAdresse = 0;
    public $commandeCreee = false;

    public $restaurantTables;
    public $tableSelected;


    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->prixTotal = ($this->product->sale_price ?? $this->product->regular_price) * $this->quantity;
        
        if(auth()->user()){
            $this->userAdresse = Address::where('user_id', auth()->user()->id)
                                        ->where('isdefault', 1)->first() ;
        }

        if($this->userAdresse){
            $this->userHasAdresse = true;
        }
    
        $this->restaurantTables = RestaurantTable::get();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'phone' => 'required|digits:9',
            'ville' => ($this->lieu == 'aLivrer' && !$this->userHasAdresse) || ($this->lieu == 'aLivrer' && $this->userHasAdresse && $this->autreAdresse) ? 'required|string|min:3' : 'nullable',
            'commune' => ($this->lieu == 'aLivrer' && !$this->userHasAdresse) || ($this->lieu == 'aLivrer' && $this->userHasAdresse && $this->autreAdresse) ? 'required|string|min:3' : 'nullable',
            'adresse' => ($this->lieu == 'aLivrer' && !$this->userHasAdresse) || ($this->lieu == 'aLivrer' && $this->userHasAdresse && $this->autreAdresse) ? 'required|string|min:3' : 'nullable',
            'quartier' => ($this->lieu == 'aLivrer' && !$this->userHasAdresse) || ($this->lieu == 'aLivrer' && $this->userHasAdresse && $this->autreAdresse) ? 'required|string|min:3' : 'nullable',
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

    public function creerAdresse(){
        $data = [];

        // Tout cela n'est valable que pour une commande à livrer
        if($this->lieu === "aLivrer"){
            
            $this->userAdresse = Address::where('user_id', auth()->user()->id)
                                            ->where('isdefault', 1)->first();

            if($this->userAdresse){
                $this->userHasAdresse = true;
            }
    
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
    
            // CAS 1 : Si l'user a une adresse mais veut etre livré ailleurs
            if($this->userAdresse && $this->autreAdresse ){
                // Si l'utilisateur veut changer d'adresse par défaut
                if($this->isDefaultAdresse === 1){
                    $this->userAdresse->isDefault = 0;
                    $this->userAdresse->save();
                    $data[] = [
                        'isdefault' => 1
                    ];
                    $this->newAdresse = Address::create($data);
                }
                $this->newAdresse = Address::create($data);
            }
            else if(!$this->userAdresse){ //CAS 2: Si pas d'adresse
                $data[] = [
                    'isdefault' => $this->isDefaultAdresse
                ];
                $this->newAdresse = Address::create($data);
            }
        }
        if($this->newAdresse){
            return $this->newAdresse;  
        }else{
            return $this->userAdresse;  
        }
    }

    public function defaultAdresse($value){
        $this->isDefaultAdresse = $value;

    }

    public function confirmAutreAdresse($boolean){
        $this->autreAdresse = $boolean;
    }

    public function getModePayement($modePayement){
        $this->modePayement = $modePayement;
    }

    public function increaseQty(){
        $this->quantity += 1;
        $this->prixTotal = ($this->product->sale_price ?? $this->product->regular_price) * $this->quantity;
    }

    public function decreaseQty(){
        if($this->quantity > 1){
            $this->quantity -= 1;
            $this->prixTotal = ($this->product->sale_price ?? $this->product->regular_price) * $this->quantity;
        }
    }

    
    public function selectTable($table){
        $this->tableSelected = $table;
    }

    public function createNowOrder(){
        $adresse_id = "";
        $user_id = "";

        $this->validate();
        

        if(auth()->check()){
            $user = auth()->user();
            $user_id = $user->id;
        }else{
            $user = User::where('name', 'Guest')->first();
            if($user){
                $user_id = $user->id;
            }else{
                $user = User::create([
                    'name' => 'Guest',
                    'email' => 'guest@gmail.com',
                    'phone' => '628976865',
                    'password' => Hash::make('guest'),
                ]);
                $user_id = $user->id;
            }
        }

        $addressAuthentik = Address::where('name', 'Authantik')->firstorFail();
        
        if($this->lieu == "surPlace" || $this->lieu == "aEmporter"){
            $adresse_id = null;
        }else if($this->lieu == "aLivrer"){
            $this->creerAdresse();
            if($this->userHasAdresse && !$this->autreAdresse){
                $adresse_id = $this->userAdresse->id;
            }
            else if($this->userHasAdresse && $this->autreAdresse){
                $adresse_id = $this->newAdresse->id;
            }
            else if(!$this->userHasAdresse){
                $adresse_id = $this->newAdresse->id;
            }

        }

        // Créer la commande
        $data = [
            'user_id' => $user_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address_id' => $adresse_id,
            'subtotal' => $this->prixTotal,
            'discount' => 0,
            'tax' => 0,
            'total' => $this->prixTotal,
            'status' => "En cours",
            'note' => $note ?? "",
            'table' => $this->tableSelected,
        ];

        if($this->lieu == 'aLivrer'){
            $data[] = 
                $data['lieu ']= "A livrer";
        }
        elseif($this->lieu == 'aEmporter'){
            $data['lieu'] = "A emporter";
        }else{
            $data['lieu'] = "Sur place";
        }

        $this->order = Order::create($data);

        // Ajouter les items de la commande       
        OrderItem::create([
            'product_id' => $this->product->id,
            'order_id' => $this->order->id,
            'quantity' => $this->quantity,
            'price' => $this->prixTotal,
        ]);

        if($this->modePayement == "liquide"){
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $this->order->id,
                'mode_payment' => "Liquide",
                'status' => "En attente",
            ]);
        }elseif($this->modePayement == "OM"){
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $this->order->id,
                'mode_payment' => "Orange Money",
                'status' => "En attente",
            ]); 
        }elseif($this->modePayement == "MM"){
            
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $this->order->id,
                'mode_payment' => "Mobile Money",
                'status' => "En attente",
            ]);

            
        }
        elseif($this->modePayement == "livraison"){
            
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $this->order->id,
                'mode_payment' => "A la livraison",
                'status' => "En attente",
            ]);

        }

        $this->commandeCreee = true;
        OrderNotificationJob::dispatch($this->order, auth()->user())->delay(now()->addSeconds(1));

    }

    public function render()
    {
        return view('livewire.interface-user.order.buy-now-manager');
    }
}
