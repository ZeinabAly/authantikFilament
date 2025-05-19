<div>

    <div class="modes mt-[90px] md:mt-[95px] px-5 py-10 bg-[#e8e8e8]">
        <div class="infosClient rounded-md">
            <form method="POST" wire:submit="createNowOrder">
                <!-- Image et nom -->
                <div class="mb-4 mb-7 flex gap-3 items-center">
                    <div class="">
                        <img src="{{asset('storage/'. $product->image)}}" alt="image produit" class="w-[150px] h-[150px] object-cover rounded-sm">
                    </div>
                    <div class="">
                        <p class="font-bold text-lg">{{$product->name}}</p>
                        <p class="text-gray-500 text-sm">{{$product->sousCategory->name}}</p>
                        <p class="text-[--color2-yellow] text-[17px] font-bold">{{$product->sale_price ?? $product->regular_price}} GNF</p>
                        
                        <!-- Quantité -->
                        <div class="flexCenter gap-2 rounded-full bg-[#f0f0f0] p-1 w-[150px] max-w-[170px] mb-3 mt-5 shadow-md">
                            <h5>Quantité</h5>
                            <button type="button" wire:click="decreaseQty">
                                <x-icon name="circle-plus" fill="#fff" color="#fff" size="20" class="shadow-md rounded-full" />
                            </button>
                            <p class="text-sm font-semibold">{{ $quantity }}</p>
                            <button type="button" wire:click="increaseQty">
                                <x-icon name="circle-plus" fill="{{ $quantity > 0 ? '#ce9c2d' : '#fff' }}" size="20" class="shadow-md rounded-full" />
                            </button>
                        </div>


                    </div>
                </div>

                <h2 class="font-bold text-lg text-gray-800">1. Veuillez remplir vos Informations de contact</h2>
                <p class="text-xs text-gray-500 font-semibold mb-5">Veuillez noter que ces données ne sont utilisées que dans le cadre professionnel</p>

                <div class="contactInfos">
                    <div class="infosContent">
                        <div class="">
                            <div class="icon-input">
                                
                                <x-icon name="user-vide" fill="#939393" />
                                <input type="text" wire:model="name" value="{{old('name')}}" placeholder="Nom complet">
                            </div>
                            @error('name')
                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                            @enderror
                        
                        </div>
                        <div class="">
                            <div class="icon-input">
                                <x-icon name="phone" fill="#939393" />
                                <input type="number" wire:model="phone" value="{{old('phone')}}" placeholder="Téléphone">
                            </div>
                            @error('phone')
                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="">
                            <div class="icon-input">
                                <x-icon name="enveloppe" fill="#939393" />
                                <input type="email" wire:model="email" value="{{old('email')}}" placeholder="Email">
                            </div>
                            @error('email')
                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>

    
                <div class="modePayement">
                    <h2 class="font-bold text-lg mb-1 mt-5 text-gray-800">2. Mode de payement</h2>
                    <div class="modesPayementContent">
                        <div class="" wire:click="modePayement('liquide')">
                            <input type="radio" checked name="modePayement" id="liquide">
                            <label for="liquide" wire:click="getModePayement('OM')">Espèce</label>
                        </div>
                        <div class="">
                            <input type="radio" name="modePayement" id="OM">
                            <label for="OM" wire:click="getModePayement('OM')">Orange Money</label>
                        </div>
                        <div class="">
                            <input type="radio" name="modePayement" id="MM">
                            <label for="MM" wire:click="getModePayement('MM')">Mobile Money</label>
                        </div>
                        <div class="">
                            <input type="radio" name="modePayement" id="livraison">
                            <label for="livraison" wire:click="getModePayement('livraison')">A la livraison</label>
                        </div>
                    </div>
                </div>
    
                <div class="modeDeLivraison">
                    
                    <h2 class="font-bold text-lg mb-2 mt-5 text-gray-800">3. Mode de livraison</h2>
                    <div class="modesDeLivraisonContent">
                        <div class="input-label" wire:click="choisirLieu('surPlace')">
                            <input type="radio" checked name="modeLivraison" id="surPlace" class="hidden">
                            <label for="surPlace">Sur place</label>
                        </div>
                        <div class="input-label" wire:click="choisirLieu('aEmporter')">
                            <input type="radio" name="modeLivraison" id="aEmporter" class="hidden">
                            <label for="aEmporter">Emporter</label>
                        </div>
                        <div class="input-label" wire:click="choisirLieu('aLivrer')">
                            <input type="radio" name="modeLivraison" id="aLivrer" class="hidden">
                            <label for="aLivrer">A livrer</label>
                        </div>
                    </div>
    
                    <!-- ADRESSE DE LIVRAISON -->
                    <div class="adresseLivraison">
                        @if($lieu === "aLivrer")
                            @if($userHasAdresse || !empty($autreAdresse))
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
                                            <div class="icon-input">
                                                <x-icon name="ville" fill="#939393" />
                                                <input type="text" wire:model="ville" placeholder="Ville">
                                            </div>
                                            @error('ville')
                                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <div class="icon-input">
                                                <x-icon name="landmark" fill="#939393" />
                                                <input type="text" wire:model="commune" placeholder="Commune">
                                            </div>
                                            @error('commune')
                                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                            @enderror
                                        </div>
            
                                        <div class="">
                                            <div class="icon-input">
                                                <x-icon name="adresse" fill="#939393" />
                                                <input type="text" wire:model="quartier" placeholder="Quartier">
                                            </div>
                                            @error('quartier')
                                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <div class="icon-input">
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
            
                                    
                                </div>
                            @endif
                        @endif
                    </div>
                    <!-- FIN ADRESSE DE LIVRAISON -->
                </div>
    
                @if($commandeCreee == false)
                    <button type="submit" class="btnSubmit">Commander</button>
                @else
                    <div class="text-[--color1-green] flexLeft gap-3">
                        <x-icon name="success" fill="#05821c"/>
                        <span>Commande validée ! </span>
                    </div>
    
                    <a href="{{route('cart.order.confirmation', ['order' => $order->id])}}" class="w-[220px] text-center flex items-center btnSubmit bg-[--color1-green] gap-3">
                        <span>Cliquer pour  continuer</span>
                        <x-icon name="fleche-right" fill="#fff"/>
                    </a>
                @endif
            </form>
        </div>
    
        <div class="totaux payement_details">
            <h2 class="titre">
                <div class="border-[1px] border-[#114333] w-[30px] h-[30px] flexCenter rounded-full">
                    <x-icon name="cubes" fill="#114333" />
                </div>
                <span>Inventaire</span>
            </h2>
            <div class="nbreProduits">
                <h5>Nombre de produits</h5>
                <p>{{$quantity}}</p>
            </div>
            <div class="payement_details">
            <div class="detail">
                <span>Sous-total</span>
                <span>{{$prixTotal}} GNF</span>
            </div>
    
            <div class="detail">
                <span>Rabais : </span>
                <span>0</span>
            </div>
    
            <div class="detail">
                <span>Livraison : </span>
                <span>A vos frais</span>
            </div>
    
            <div class="total detail">
                <span>Total : </span>
                <span class="text-[--color2-yellow]">{{$prixTotal}} GNF</span>
            </div>
    
            <div class="detail">
                <span>Mode de paiement : </span>
                <span>Orange Money</span>
            </div>
    
            <!-- <div class="flexCenter">
                <a href="#" class="btnPasserCmd">Confirmer la commande</a>
            </div> -->
            </div>
        </div>
    </div>

</div>
