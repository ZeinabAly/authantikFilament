<div>
<link rel="stylesheet" href="{{ asset('css/filament/pages/edit-order.css') }}">

@if($openEditModal) 
    <div class="editOrderModal">

        
    <div x-data="{ showLivraisonModal: false, showAnnulationModal: false }">
        
        <button wire:click="closeModal" class="btnRetour">
            <div class="dark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="12" width="12" fill="#fff" ><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            </div>
            <div class="light">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="12" width="12" fill="#000" ><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            </div>
            <span>Retour</span>
        </button>
        <h1 class="section-title">Modifier la commande</h1>

        <!-- Boutons d'action principaux -->
        <div class="btnsContent">
            <!-- Bouton de confirmation de livraison -->
            <button @click="showLivraisonModal = true" class="btnConfirmer">
                Confirmer livraison
            </button>

            <!-- Bouton d'annulation -->
            <button @click="showAnnulationModal = true" class="btnAnnuler">
                Annuler commande
            </button>
        </div>

        <!-- Modal de confirmation pour la livraison -->
        <div x-show="showLivraisonModal" x-cloak class="confirmationBox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
            <div class="confirmationContent">
                <h3 class="text-lg font-bold mb-4">Confirmer la livraison</h3>
                <p class="mb-4">Êtes-vous sûr de vouloir confirmer la livraison de cette commande ?</p>
                <div class="flex justify-end gap-2">
                    <button @click="showLivraisonModal = false" class="btnAnnulerCmd">
                        Annuler
                    </button>
                    <button wire:click="validerCmd" @click="showLivraisonModal = false" class="btnConfirmerCmd">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal de confirmation pour l'annulation -->
        <div x-show="showAnnulationModal" x-cloak class="confirmationBox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
            <div class="confirmationContent">
                <h3 class="text-lg font-bold mb-4">Annuler la commande</h3>
                <p class="mb-4">Êtes-vous sûr de vouloir annuler cette commande ?</p>
                <div class="flex justify-end gap-2">
                    <button @click="showAnnulationModal = false" class="btnAnnulerCmd">
                        Retour
                    </button>
                    <button wire:click="annulerCmd" @click="showAnnulationModal = false" class="btnConfirmerCmd" style="background: #8b0f0f">
                        Annuler la commande
                    </button>
                </div>
            </div>
        </div>

    </div>


        <form wire:submit="updateOrder" method="POST">
            <div class="contactInfos">
                <h2 class="font-bold text-lg mb-2 mt-5 text-gray-800">1. Les informations du serveur</h2>
                <div class="infosContent">
                    <div class="">
                        <label for="name" class="font-semibold text-xs">Nom du serveur</label>
                        <div class="icon-input">
                            <x-icon name="user-vide" fill="#939393" />
                            <input type="text" id="name" value="{{$order->name}}" wire:model="name" readonly>
                        </div>
                        @error('name')
                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                        @enderror
                    
                    </div>
                    <div class="">
                        <label for="phone" class="font-semibold text-xs">Phone</label>
                        <div class="icon-input">
                            <x-icon name="phone" fill="#939393" />
                            <input type="number" wire:model="phone" id="phone" placeholder="Téléphone" value="{{$order->phone}}" readonly>
                        </div>
                        @error('phone')
                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label for="email" class="font-semibold text-xs">Email</label>
                        <div class="icon-input">
                            <x-icon name="enveloppe" fill="#939393" />
                            <input type="email" wire:model="email" id="email" placeholder="Email" readonly>
                        </div>
                        @error('email')
                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modesPayement">
                <h2 class="font-bold text-lg mb-1 mt-5 text-gray-800">2. Mode de payement</h2>
                <div class="modesPayementContent">
                    <div wire:click="modePayement('Liquide')" class="{{$order->transaction->mode_payement === 'Liquide' ? 'modePayementSelected' : 'payementItem'}}">
                        <label for="cash" class="border-none">En liquide</label>
                    </div>
                    <div wire:click="modePayement('Orange Money')" class="{{$order->transaction->mode_payement === 'Orange Money' ? 'modePayementSelected' : 'payementItem'}}">
                        <label for="OM" class="border-none">Orange Money</label>
                    </div>
                    <div wire:click="modePayement('Mobile Money')" class="{{$order->transaction->mode_payement === 'Mobile Money' ? 'modePayementSelected' : 'payementItem'}}">
                        <label for="MM" class="border-none">Mobile Money</label>
                    </div>
                    <div wire:click="modePayement('A la livraison')" class="{{$order->transaction->mode_payement === 'A la livraison' ? 'modePayementSelected' : 'payementItem'}}">
                        <label for="livraison" class="border-none">A livraison</label>
                    </div>
                </div>
            </div>

            <div class="modesDeLivraison">
                
                <h2 class="font-bold text-lg mb-2 mt-5 text-gray-800">3. Mode de livraison</h2>
                <div class="modesDeLivraisonContent">
                    <button wire:click="choisirLieu('surPlace')" class="{{$order->lieu === 'Sur place' ? 'modeLivraisonSelected' : 'livraisonItem'}}">
                        <label for="surPlace" class="border-none">Sur place</label>
                    </button>
                    <button wire:click="choisirLieu('aEmporter')"  class="{{$order->lieu === 'A Emporter' ? 'modeLivraisonSelected' : 'livraisonItem'}}">
                        <label for="aEmporter" class="border-none" >A emporter</label>
                    </button>
                    <button wire:click="choisirLieu('aLivrer')"  class="{{$order->lieu === 'A livrer' ? 'modeLivraisonSelected' : 'livraisonItem'}}">
                        <label for="aLivrer" class="border-none">A livrer</label>
                    </button>
                </div>

                <!-- ADRESSE DE LIVRAISON -->
                <div class="adresseLivraison">
                    @if($lieu === "aLivrer")
                        @if($userHasAdresse || !$autreAdresse)
                            <h4>Vous avez déjà une adresse</h4>
                            <p>Commune: {{$userAdresse->commune}}</p>
                            <p>Adresse: {{$userAdresse->address}}</p>
                            <p>Ville: {{$userAdresse->ville}}</p>
                            <p>Quartier: {{$userAdresse->quartier}}</p>

                            <div class="defaultAdresse mb-5">

                                <h5 class="font-bold text-lg my-5">Livrer à une autre adresse ? </h5>
                                <div class="flex gap-4">
                                    <div class="oui">
                                        <input type="radio" name="autreAdress" id="autreAdresseOui" value="1">
                                        <label for="autreAdresseOui" class="rounded-full" wire:click="confirmAutreAdresse(true)">Oui</label>
                                    </div>
                                    <div class="non">
                                        <input type="radio" name="autreAdress" checked id="autreAdresseNon" value="0">
                                        <label for="autreAdresseNon" wire:click="confirmAutreAdresse(false)" class="">Non</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!$userHasAdresse || $autreAdresse)
                            <h4 class="font-bold text-lg my-5">Veuillez remplir ce formulaire pour la livraison</h4>
                            <div class="contactInfos">
                                <div class="infosContent">
                                    <div class="">
                                        <div class="icon-input bg-white">
                                            <x-icon name="ville" fill="#939393" />
                                            <input type="text" wire:model="ville" placeholder="Ville">
                                        </div>
                                        @error('ville')
                                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="">
                                        <div class="icon-input bg-white">
                                            <x-icon name="landmark" fill="#939393" />
                                            <input type="text" wire:model="commune" placeholder="Commune">
                                        </div>
                                        @error('commune')
                                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                        @enderror
                                    </div>
        
                                    <div class="">
                                        <div class="icon-input bg-white bg-white">
                                            <x-icon name="adresse" fill="#939393" />
                                            <input type="text" wire:model="quartier" placeholder="Quartier">
                                        </div>
                                        @error('quartier')
                                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="">
                                        <div class="icon-input bg-white">
                                            <x-icon name="home" fill="#939393" />
                                            <input type="text" wire:model="adresse" placeholder="Adresse">
                                        </div>
                                        @error('adresse')
                                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="">
                                        <div class="icon-input">
                                            <x-icon name="etoile" fill="#939393" />
                                            <input type="text" wire:model="reference"  placeholder="Point de reference">
                                        </div>
                                        @error('reference')
                                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="defaultAdresse mb-5">
                                    <h5 class="font-bold text-lg my-5">Définir comme adresse par défaut ? </h5>
                                    <div class="flex gap-4">
                                        <div class="oui">
                                            <input type="radio" name="defaultAdress" checked id="defaultOui" wire:model="isDefaultAdresse" value="1">
                                            <label for="defaultOui" class="rounded-full" wire:click="defaultAdresse(1)">Oui</label>
                                        </div>
                                        <div class="non">
                                            <input type="radio" name="defaultAdress" id="defaultNon" wire:model="isDefaultAdresse" value="0">
                                            <label for="defaultNon" class="">Non</label>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="flex flex-col justify-start">
                                    <label for="">Laissez une note</label>
                                    <textarea wire:model.debounce.300ms="note" placeholder="Laissez une note" class="w-[80%] h-[100px] p-3"></textarea>
                                </div>
                                
                            </div>
                        @endif
                    @endif
                </div>
                <!-- FIN ADRESSE DE LIVRAISON -->

            </div>

            <!-- Les produits choisis -->
            <div class="produitsChoisis">
                <h3 class="font-bold text-lg mb-2 mt-5 text-gray-800">Les produits choisis</h3>
                <div class="pdtsChoisisContent">
                    @foreach($order->orderItems as $item)
                        <div class="productDiv">
                            <div class="relative">
                                <button type="button" wire:click="removeProductToOrder({{ $item->product->id }})" class="btnRetirerProduct">
                                    <x-icon name="btn-fermer" fill="#fff" size="14" class="cursor-pointer"/>
                                </button>
                                <img class="productDivImg" src="{{asset('storage/'.$item->product->image)}}" alt="{{$item->name}}">
                            </div>
                            <div class="">
                                <h5 class="name">{{ $item->product->name }}</h5>
                                <div class="productTextContent">
                                    <p class="prix">{{ number_format($item->price, 0, '.', '')  }} GNF</p>
                                    <div class="qtyControlContent">
                                        <button type="button" wire:click="decreaseQuantity({{ $item->id }})">
                                            <x-icon name="circle-moins" fill="#fff" color="#fff" size="16" class="rounded-full bg-[#ccc]" />
                                        </button>
                                        <p class="text-xs font-semibold">{{ $item->quantity }}</p>
                                        <button type="button" wire:click="increaseQuantity({{ $item->id }})">
                                            <x-icon name="circle-plus" fill="#fff" size="16" class="rounded-full bg-[#ccc]" />
                                        </button>
                                    </div>
                                    <!-- <div class="flexCenter ">
                                        <button type="button" wire:click="addOtherItemsToOrder({{ $item->product->id }})" class="btnRetirer">
                                            Retirer
                                        </button>
                                    </div>                                     -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- AJOUTER D'AUTRES PRODUITS -->
            <div class="autresProduits">
                <h3 class="font-bold text-lg mb-2 mt-5 text-gray-800">Ajouter d'autre produits</h3>
                <!-- Search zone -->
                <div class="zoneSearchContent">
                    <div class="">
                        <div class="searchBox">
                            <div class="divIconSearch">
                                <x-icon name="btn-search2"/>
                            </div>
                            <input type="text" wire:model.live.debounce.100ms="search" id="table-search" class="inputSearch" placeholder="Rechercher ...">
                        </div>

                    </div>
                </div>
                <div class="produitsContent">
                    @if(!$products == [])
                        @foreach($products as $product) 
                        
                        <div class="productDiv {{$order->orderItems->contains('product_id', $product->id) ? 'hidden' : ''}}">
                            <div class="">
                                <img class="productDivImg" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                            </div>
                            <div class="">
                                <h5 class="name">{{ $product->name }}</h5>
                                <div class="productTextContent">
                                    <p class="prix">{{ number_format($product->sale_price ?? $product->regular_price , 0, '.', '')  }} GNF</p>
                                    
                                    <div class="flexCenter ">
                                        <button type="button" wire:click="addOtherItemsToOrder({{ $product->id }})" class="btnAjouter">
                                            Ajouter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    @endforeach 
                    @else 
                        <p>Aucun produit</p>
                    @endif
                </div>
            </div>

            <div class="btnModifierContent">
                <button type="submit" class="btnConfirmer">Modifier</button>
            </div>
            <!-- <button type="submit" class="btnPasserCmd bg-red-700 hover:text-red-700 hover:border-red-700">Annuler</button> -->
        </form>
    </div>
@endif 
</div>

