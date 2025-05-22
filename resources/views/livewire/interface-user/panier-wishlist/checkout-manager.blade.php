<div class="modes">
    <div class="infosClient">
        <form wire:submit="createOrder">
            <h2 class="font-bold text-lg mb-2 text-gray-800">1. Informations de contact</h2>
            <p class="text-xs text-gray-500 font-semibold mb-5">Veuillez noter que ces données ne sont utilisées que dans le cadre professionnel</p>
            <div class="contactInfos">
                <div class="infosContent">
                    <div class="">
                        <div class="icon-input">
                            
                            <x-icon name="user-vide" fill="#939393" />
                            <input type="text" wire:model="name" placeholder="Nom complet">
                        </div>
                        @error('name')
                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                        @enderror
                    
                    </div>
                    <div class="">
                        <div class="icon-input">
                            <x-icon name="phone" fill="#939393" />
                            <input type="number" wire:model="phone" placeholder="Téléphone">
                        </div>
                        @error('phone')
                            <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="">
                        <div class="icon-input">
                            <x-icon name="enveloppe" fill="#939393" />
                            <input type="email" wire:model="email" placeholder="Email">
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
                    <div class="" wire:click="getModePayemeent('liquide')">
                        <input type="radio" checked name="modePayement" id="cash">
                        <label for="cash">En espèce</label>
                    </div>
                    <div class="" wire:click="getModePayemeent('OM')">
                        <input type="radio" name="modePayement" id="OM">
                        <label for="OM">Orange Money</label>
                    </div>
                    <div class="" wire:click="getModePayemeent('MM')">
                        <input type="radio" name="modePayement" id="MM">
                        <label for="MM">Mobile Money</label>
                    </div>
                    <div class="" wire:click="getModePayemeent('livraison')">
                        <input type="radio" name="modePayement" id="livraison">
                        <label for="livraison">A livraison</label>
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
                        <label for="aLivrer">Livrer</label>
                    </div>
                </div>

                <!-- ADRESSE DE LIVRAISON -->
                <div class="adresseLivraison">
                    @if($lieu === "aLivrer")
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
                                    <label for="defaultOui" class="rounded-full">Oui</label>
                                </div>
                                <div class="non">
                                    <input type="radio" name="defaultAdress" id="defaultNon" wire:model="isDefaultAdresse" value="0">
                                    <label for="defaultNon" class="">Non</label>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    @endif
                </div>
                <!-- FIN ADRESSE DE LIVRAISON -->

                <!-- CHOISIR UNE TABLE -->
                <div class="restaurantTableContent">
                    <h2 class="font-bold text-lg mb-2 mt-5 text-gray-800">4. Veuillez indiquer votre position </h2>
                    <select wire:click="selectTable(event.target.value)">
                        <option value="">Choisir une table</option>
                        @foreach($restaurantTables as $table)
                        <option value="{{$table->name}}">{{$table->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($commandeCreee == false)
                <button type="submit" class="btnSubmit">Valider</button>
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
            <p>{{$items->count()}}</p>
        </div>
        <div class="payement_details">
        <div class="detail">
            <span>Sous-total</span>
            <span>{{number_format((float) str_replace(',', '', Cart::instance('cart')->subtotal()), 0, '.', '.')}} GNF</span>
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
            <span class="text-[--color2-yellow]">{{number_format((float) str_replace(',', '', Cart::instance('cart')->total()), 0, '.', '.')}} GNF</span>
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
