<?php

namespace App\Livewire\Client\Order;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CartService;
use Filament\Notifications\Notification;
use App\Models\{Product, Order, OrderItem, Address};

class EditOrder extends Component
{
    public $openEditModal = false;
    public $confirmingLivraison = false;
    public $confirmingAnnulation = false;

    public $order;
    public $search = '';

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
    public $autreAdresse = false; //Livrer a une autre adresse
    public $NewAdresse = ""; //Nouvelle adresse créée

    public $isDefaultAdresse = 0;

    #[On('openEditModal')]
    #[On('orderUpdated')]
    public function getOrder($orderId){
        $this->order = Order::findOrFail($orderId);
        $this->openEditModal = true;
        $this->name = $this->order->name ?? "";
        $this->phone = $this->order->phone ?? "";
        $this->email = $this->order->email ?? "";
        $this->lieu = $this->order->lieu;
        // $this->lieu = $this->getLieuValue($this->order->lieu);
        $this->modePayement = $this->order->transaction->mode_payement ?? "";
        $this->calculTotal();
    }


    public function closeModal()
    {
        $this->openEditModal = false;
        $this->reset(['order', 'name', 'phone', 'email', 'modePayement', 'lieu', 'orderTotal', 
                     'ville', 'commune', 'adresse', 'quartier', 'userHasAdresse', 'autreAdresse']);
        $this->confirmingLivraison = false;
        $this->confirmingAnnulation = false;
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

    protected function messages() 
    {
        return [
            'name.required' => 'Ce champ est obligatoire',
            'name.min' => 'Le nom doit contenir au moins 3 caractères',
            'phone.required' => 'Ce champ est obligatoire',
            'phone.digits' => 'Le numéro de téléphone doit contenir 9 chiffres',
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
    
    // Calculer le total de la commande
    public function calculTotal(){
        $total = 0;
        foreach($this->order->orderItems as $orderItem){
            $total += $orderItem->quantity * $orderItem->price;
        }

        $this->order->total = $total;
        $this->order->subtotal = $total;
        $this->order->save();
        $this->orderTotal = $this->order->total;
    }

    public function addOtherItemsToOrder($productId){
        if($this->order->orderItems->contains('product_id', $productId)){
            $item = $this->order->orderItems()->where('product_id', $productId)->first();
            $item->update([
                'quantity' => $item->quantity + 1
            ]);
            $this->dispatch('orderUpdated', $this->order->id);
        }
        else{
            $product = Product::findOrFail($productId);
            $this->order->orderItems()->create([
                'product_id' => $product->id,
                'price' => $product->sale_price ?? $product->regular_price,
                'quantity' => 1,
            ]);
    
            $this->calculTotal();

            $this->dispatch('orderUpdated', $this->order->id);

            Notification::make()
                ->title('Produit ajouté !')
                ->success()
                ->send();
        }

        return session()->flash('success', 'Produit ajouté avec succès !');
    }

    public function removeProductToOrder($productId){
        if($this->order->orderItems->count() > 1){
            $item = OrderItem::where('product_id', $productId)
                ->where('order_id', $this->order->id)->first();
   
            if ($item) {
                $item->delete(); 
                $this->order->refresh();

                $this->calculTotal();
                $this->dispatch('orderUpdated', $this->order->id);
                return Notification::make()
                    ->title('Produit supprimé de la commande !')
                    ->success()
                    ->send();

            } 
        } else {
            $this->dispatch('orderUpdated', $this->order->id);
            return Notification::make()
                ->title('La commande doit contenir au moins un produit !')
                ->danger()
                ->send();
        }  
    }

    public function defaultAdresse($value){
        $this->isDefaultAdresse = $value;
    }

    public function confirmAutreAdresse($boolean){
        $this->autreAdresse = $boolean;
    }

    public function choisirLieu($lieu){

        $this->lieu = $lieu;
        
        // Si lieu est "aLivrer", vérifier si l'utilisateur a déjà une adresse par défaut
        if($lieu === "aLivrer") {
            $this->userAdresse = Address::where('user_id', auth()->user()->id)
                ->where('isDefault', 1)->first();
            
            if($this->userAdresse) {
                $this->userHasAdresse = true;
            }
        }
    }

    public function creerAdresse(){
        $data = [];
        
        // Tout cela n'est valable que pour une commande à livrer
        if($this->lieu === "aLivrer"){
            if(!$this->userAdresse) {
                $this->userAdresse = Address::where('user_id', auth()->user()->id)
                                            ->where('isDefault', 1)->first();
                
                if($this->userAdresse){
                    $this->userHasAdresse = true;
                }
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
    
            // CAS 1 : Si l'user a une adresse mais veut être livré ailleurs
            if($this->userHasAdresse && $this->autreAdresse) {
                // Si l'utilisateur veut changer d'adresse par défaut
                if($this->isDefaultAdresse === 1){
                    $this->userAdresse->isDefault = 0;
                    $this->userAdresse->save();
                    $data['isDefault'] = 1;
                }
                $this->NewAdresse = Address::create($data);
                return $this->NewAdresse->id;
            }
            else if(!$this->userHasAdresse){ //CAS 2: Si pas d'adresse
                $data['isDefault'] = $this->isDefaultAdresse;
                $this->NewAdresse = Address::create($data);
                return $this->NewAdresse->id;
            }
            else if($this->userHasAdresse && !$this->autreAdresse) {
                return $this->userAdresse->id;
            }
        }
        return null;
    }

    public function mode_payement($modePayement){
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
        
        if ($item && $item->quantity > 1) {
            $item->quantity -= 1;
            $item->save(); 
            $this->calculTotal();
        }
    }

    // Modale de confirmation pour annuler la commande
    public function confirmerAnnulation() {
        $this->confirmingAnnulation = true;
    }

    // Annuler la commande
    public function annulerCmd() {
        if($this->order->status === 'En cours') {
            $this->order->status = 'Annulée';
            $this->order->cancelled_date = now();
            $this->order->save();
            
            // Annuler la transaction associée
            $this->order->transaction->status = "Annulée";
            $this->order->transaction->save();
            
            $this->order->refresh();
            $this->closeModal();
            
            Notification::make()
                ->title('Commande annulée avec succès')
                ->success()
                ->send();
                
            $this->dispatch('commandeAnnulée');
        } else {
            Notification::make()
                ->title('Impossible d\'annuler cette commande')
                ->body('Seules les commandes en cours peuvent être annulées.')
                ->danger()
                ->send();
        }
        
        $this->confirmingAnnulation = false;
    }

    // Modale de confirmation pour valider la livraison
    public function confirmerLivraison() {
        $this->confirmingLivraison = true;
    }

    // Valider la livraison
    public function validerCmd() {
        if($this->order->status === 'En cours') {
            $this->order->status = 'Livrée';
            $this->order->delivred_date = now();
            $this->order->save();
            
            // Confirmer la transaction associée
            $this->order->transaction->status = "Approuvée";
            $this->order->transaction->save();
            
            $this->order->refresh();
            $this->closeModal();
            
            Notification::make()
                ->title('Livraison confirmée avec succès')
                ->success()
                ->send();
                
            $this->dispatch('commandeLivrée');
        } else {
            Notification::make()
                ->title('Impossible de confirmer la livraison')
                ->body('Seules les commandes en cours peuvent être confirmées comme livrées.')
                ->danger()
                ->send();
        }
        
        $this->confirmingLivraison = false;
    }

    public function updateOrder() {
        $this->validate();

        // GESTION DE L'ADRESSE SELON LE LIEU DE LIVRAISON
        $adresse_id = null;
        
        if($this->lieu == "surPlace" || $this->lieu == "aEmporter") {
            $addressAuthentik = Address::where('name', 'Authantik')->first();
            if ($addressAuthentik) {
                $adresse_id = $addressAuthentik->id;
            }
        } else if($this->lieu == "aLivrer") {
            $adresse_id = $this->creerAdresse();
        }

        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?? "",
            'subtotal' => $this->orderTotal,
            'total' => $this->orderTotal,
            'note' => $this->note,
        ];
       
        if ($adresse_id) {
            $data['address_id'] = $adresse_id;
        }
        
        if($this->lieu == 'aLivrer') {
            $data['lieu'] = "A livrer";
        } elseif($this->lieu == 'aEmporter') {
            $data['lieu'] = "A emporter";
        } else {
            $data['lieu'] = "Sur place";
        }

        // Mettre à jour le mode de paiement si nécessaire
        if ($this->modePayement && $this->order->transaction) {
            $this->order->transaction->mode_payement = $this->modePayement;
            $this->order->transaction->save();
        }

        $this->order->update($data);
        $this->calculTotal();
        $this->order->refresh();
        
        $this->dispatch('commandeModifiée');
        
        Notification::make()
            ->title('Commande modifiée avec succès')
            ->success()
            ->send();
            
        $this->closeModal();
    }

    public function render() {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
                           ->paginate(5);
                           
        return view('livewire.client.order.edit-order', [
            'products' => $products
        ]);
    }
}