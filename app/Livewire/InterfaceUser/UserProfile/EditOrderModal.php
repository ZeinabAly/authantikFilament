<?php

namespace App\Livewire\InterfaceUser\UserProfile;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CartService;
use App\Models\{Product, Order, OrderItem, Address};

class EditOrderModal extends Component
{
    public $editing = true;
    public $order;
    public $search = '';
    // public $orderId;

    public $name;
    public $phone;
    public $email;
    public $note;

    public $modePayement = "";
    public $lieu = "";
    public $orderTotal = "";
    
    // Les variables du form d'adresse
    public $ville = "";
    public $commune = "";
    public $adresse = "";
    public $quartier = "";
    public $point_de_reference = "";
    public $userHasAdresse = false;
    public $userAdresse = "";
    public $autreAdresse; //Livrer a une autre adresse
    public $NewAdresse = ""; //Nouvelle adresse créée

    
    public $isDefaultAdresse = 0;

    #[On('commandeModifiée')]
    public function mount(Order $order){
        $this->order = $order;
        $this->name = $order->name;
        $this->phone = $order->phone;
        $this->email = $order->email;
        $this->lieu = $order->lieu;
        $this->modePayement = $order->transaction->modePayement;
        $this->calculTotal();
        $this->choisirLieu($this->lieu);

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

    public function editOrder($orderId)
    {
        $this->editing = true;
        $this->order = Order::findOrFail($orderId);
        // dd($this->order->transaction->mode_payement);
        $this->name = $this->order->name;
        $this->phone = $this->order->phone;
        $this->email = $this->order->email;
        $this->lieu = $this->order->lieu;
        $this->note = $this->order->note;
        $this->modePayement = $this->order->transaction->mode_payement;
        $this->calculTotal();
        return $this->order;
        
    }

    // Calculer le total de la commande
    
    #[On('commandeModifiée')]
    public function calculTotal(){
        $total = 0;
        foreach($this->order->orderItems as $orderItem){
            $total +=  $orderItem->quantity * $orderItem->price;
        }

        $this->order->total = $total;
        $this->order->subtotal = $total;
        $this->order->save();
        $this->orderTotal = $this->order->total;
    }
        
    public function closeEditBtn(){
        $this->validate();
        $this->editing = false;
    }

    public function defaultAdresse($value){
        $this->isDefaultAdresse = $value;
    }

    public function confirmAutreAdresse($boolean){
        return $this->autreAdresse = $boolean;
    }

    public function choisirLieu($lieu){
        $this->lieu = $lieu;

        
        if($this->lieu == "Sur place" || $this->lieu == "surPlace" || $this->lieu == "A emporter" || $this->lieu == "aEmporter"){
            // Récupérer l'adresse Authentik
            $addressAuthentik = Address::where('name', 'Authantik')->first();
            
            if(!$addressAuthentik) {
                // Si l'adresse Authentik n'existe pas, créer un message d'erreur
                return session()->flash('error', 'Adresse Authentik non trouvée!');
            }
            return $addressAuthentik->id;
            
        } else if($this->lieu == "aLivrer" || $this->lieu == "A livrer") {

            $this->userAdresse = Address::where('user_id', auth()->user()->id)
                                        ->where('isDefault', 1)->first();

            if($this->userAdresse){
                $this->userHasAdresse = true;

                // Si l'user a une adresse mais veut etre livré ailleurs
                $confirmAutreAdresse = $this->confirmAutreAdresse($this->autreAdresse);
                if($confirmAutreAdresse){
                    // Si l'utilisateur veut changer d'adresse par défaut
                    return $this->creerAdresse()->id;
                }else{
                    return $this->userAdresse->id;
                }

            } else{
                    // Créer ou utiliser une adresse de livraison
                    $newAddress = $this->creerAdresse();
                    // Vérifier si l'adresse a été créée correctement
                    if($newAddress) {
                        return $newAddress->id;
                    } 

                }
            }
            
            
        }
    

    
    public function creerAdresse(){
        $data = [];
        
        // Tout cela n'est valable que pour une commande à livrer
        if($this->lieu === "aLivrer"){
                                  
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

            if($this->isDefaultAdresse === 1){
                $this->userAdresse->isDefault = 0;
                $this->userAdresse->save();
                $data['isDefault'] = 1; 
            }
            return Address::create($data);
        }  
        
        return null; 
    }

    public function modePayement($modePayement){
        $this->modePayement = $modePayement;
    }

    public function increaseQuantity($itemId){
        $item = OrderItem::find($itemId);

        if ($item) {
            $item->quantity += 1;
            $item->save(); 
        }

        $this->calculTotal();

    }

    public function decreaseQuantity($itemId){
        $item = OrderItem::find($itemId);
    
        $total = 0;
        foreach($this->order->orderItems as $orderItem){
            $total +=  $orderItem->quantity * $orderItem->price;
        }
    
        $this->order->total = $total;
        $this->order->save(); // Correction: Ajout des parenthèses
        
        // DECREMENTER
        if ($item && $item->quantity > 1) {
            $item->quantity -= 1;
            $item->save(); 
        }
        
        $totalDecre = $item->price;
        $this->order->total -= $totalDecre;
        $this->orderTotal = $this->order->total;
    }

    public function addOtherItemsToOrder($productId){
        $product = Product::findOrFail($productId);
        $this->order->orderItems()->create([
            'product_id' => $product->id,
            'price' => $product->sale_price ?? $product->regular_price,
            'quantity' => 1,
        ]);

        $this->calculTotal();

        return session()->flash('success', 'Produit ajouté avec succcès !');

    }

    public function removeProductToOrder($productId){

        if($this->order->orderItems->count() > 1){
            $item = OrderItem::where('product_id', $productId)
                ->where('order_id', $this->order->id)->first();
   
                if ($item) {
                    $item->delete(); 
                    $this->order->refresh();

                    $this->calculTotal();
                    return session()->flash('success', 'Produit supprimé de la commande !');
                } 

        }else{
            return session()->flash('error', 'La commande doit contenir au moins un produit !');
        }  

    }

    public function updateOrder(){
        $this->validate();
        
        // GESTION DE L'ADRESSE SELON LE LIEU DE LIVRAISON
        $adresse_id = $this->choisirLieu($this->lieu); 
        
        // Vérifier que l'adresse_id est défini
        if(!$adresse_id) {
            return session()->flash('error', 'Veuillez spécifier une adresse de livraison valide!');
        }
    
        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?? "",
            'address_id' => $adresse_id, // Maintenant on a une valeur d'ID valide
            'subtotal' => $this->orderTotal,
            'total' => $this->orderTotal,
            'note' => $this->note,
        ];
       
        // Définir le lieu selon l'option choisie
        if($this->lieu == 'aLivrer'){
            $data['lieu'] = "A livrer";
        }
        elseif($this->lieu == 'aEmporter'){
            $data['lieu'] = "A emporter";
        }else{
            $data['lieu'] = "Sur place";
        }
    
        // Mettre à jour la commande
        $this->order->update($data);
        $this->calculTotal();
        $this->order->refresh();
        $this->dispatch('commandeModifiée');
        
        $this->editing = false;

        return session()->flash('success', 'Votre commande a été modifiée !');
    }

    public function annulerCmd(){
        if($this->order->status == 'En cours'){ // Correction: == au lieu de =
            $this->order->status = 'Annulée';
            $this->order->cancelled_date = now();
            $this->order->save();
            $this->annulerTransaction();
            $this->order->refresh();
            $this->editing = false;
            return session()->flash('success', 'La commande a été annulée !');
        }
        else if($this->order->status == 'Livrée' || $this->order->status == 'Annulée'){ // Correction: == au lieu de =
            return session()->flash('error', 'Vous ne pouvez plus modifier le status !');
        }
    }

    public function validerCmd(){
        if($this->order->status == 'En cours'){ // Correction: == au lieu de =
            $this->order->status = 'Livrée';
            $this->order->delivred_date = now();
            $this->order->save();
            $this->confirmerTransaction();
            $this->order->refresh();
            $this->editing = false;
            return session()->flash('success', 'Confirmation validée !');
        }
        else if($this->order->status == 'Livrée' || $this->order->status == 'Annulée'){ // Correction: == au lieu de =
            return session()->flash('error', 'Vous ne pouvez plus modifier le status !');
        }
    }

    public function confirmerTransaction(){
        if($this->order->status == 'Livrée' || $this->order->status == 'En cours'){ // Correction: == au lieu de =
            $this->order->transaction->status = "Approuvée"; // Correction: = au lieu de ==
            $this->order->transaction->save(); // Ajout de save()
            return session()->flash('success', 'La transaction a été approuvée !');
        }
        else if($this->order->status == 'Annulée'){ // Correction: == au lieu de =
            return session()->flash('error', 'Vous ne pouvez annuler une transaction déjà approuvée !');
        }
    }

    public function annulerTransaction(){
        if($this->order->status == 'Annulée' || $this->order->status == 'En cours'){ // Correction: == au lieu de =
            $this->order->transaction->status = "Annulée"; // Correction: = au lieu de ==
            $this->order->transaction->save(); // Ajout de save()
            return session()->flash('success', 'La transaction a été annulée !');
        }
        else if($this->order->status == 'Annulée' || $this->order->status == 'Livrée'){ // Correction: == au lieu de =
            return session()->flash('error', 'Vous ne pouvez annuler une transaction déjà approuvée !');
        }
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
                            ->paginate(5);

        return view('livewire.interface-user.user-profile.edit-order-modal', [
            'products' => $products
        ]);
    }
}
