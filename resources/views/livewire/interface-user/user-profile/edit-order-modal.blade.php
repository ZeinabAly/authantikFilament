<div class="userDash">
    
    <div x-data="{ open: false }" x-cloak class="text-left">
        <button @click="open = !open" class="" >Modifier</button>
    
        @if($editing)
        <div x-show="open" class="">
            <div class="editOrderModal top-[--topBarHeight] md:top-[--topBarHeight-md] left-0">
                @if (session()->has('success'))
                    <div class="py-3 px-3 min-w-[300px] bg-white text-green-600 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
                        <x-icon name="success" fill="#05821c"/>
                        {{ session('success') }}
                    </div>
                @endif
                <div class="titre-btnFermer w-[80%]">
                    <h2 class="font-bold text-[2rem] py-5">Modifier la commande</h2>
                    <button class="closeEditBtn" @click="open = false">
                        <x-icon name="croix-fermer" fill="#fff" size="20" class="cursor-pointer"/>
                    </button>
                </div>

                <div class="mb-5">
                    <button wire:click="validerCmd" class="py-2 px-4 rounded-md bg-[--color1-green] font-bold text-white text-[15px]">Confirmer livraison</button>
                    <x-annulerCmd class="py-2 px-4 rounded-md bg-red-700 font-bold text-white text-[15px]"/>
                </div>

                <form wire:submit="updateOrder" method="POST">
                    <h2 class="text-2xl font-bold my-3">Modifier les informations</h2>
                    <div class="contactInfos">
                        <div class="infosContent">
                            <div class="">
                                <label for="name" class="font-semibold text-xs">Nom</label>
                                <div class="icon-input bg-white">
                                    <x-icon name="user-vide" fill="#939393" />
                                    <input type="text" wire:model="name" id="name" value="{{old('name'), $order->name}}" placeholder="Mohamed">
                                </div>
                                @error('name')
                                    <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                @enderror
                            
                            </div>
                            <div class="">
                                <label for="phone" class="font-semibold text-xs">Téléphone</label>
                                <div class="icon-input bg-white">
                                    <x-icon name="phone" fill="#939393" />
                                    <input type="number" wire:model="phone" id="phone" placeholder="623879876" value="{{old('phone'), $order->phone}}">
                                </div>
                                @error('phone')
                                    <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="">
                                <label for="email" class="font-semibold text-xs">Email</label>
                                <div class="icon-input bg-white">
                                    <x-icon name="enveloppe" fill="#939393" />
                                    <input type="email" wire:model="email" id="email" value="{{old('email'), $order->email}}" placeholder="mohamed@gmail.com">
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
                            <div class="" wire:click="modePayement('Liquide')">
                                <input type="radio" name="modePayement" id="cash" {{$order->transaction->mode_payement === "Liquide" ? 'checked' : ''}}>
                                <label for="cash" class="border-none">En liquide</label>
                            </div>
                            <div class="" wire:click="modePayement('Orange Money')">
                                <input type="radio" name="modePayement" id="OM" {{$order->transaction->mode_payement === "Orange Money" ? 'checked' : ''}}>
                                <label for="OM" class="border-none">Orange Money</label>
                            </div>
                            <div class="" wire:click="modePayement('Mobile Money')">
                                <input type="radio" name="modePayement" id="MM" {{$order->transaction->mode_payement === "Mobile Money" ? 'checked' : ''}}>
                                <label for="MM" class="border-none">Mobile Money</label>
                            </div>
                            <div class=""  wire:click="modePayement('A la livraison')">
                                <input type="radio" name="modePayement" id="livraison" {{$order->transaction->mode_payement === "A la livraison" ? 'checked' : ''}}>
                                <label for="livraison" class="border-none">A livraison</label>
                            </div>
                        </div>
                    </div>

                    <div class="modeDeLivraison">
                        
                        <h2 class="font-bold text-lg mb-2 mt-5 text-gray-800">3. Mode de livraison</h2>
                        <div class="modesDeLivraisonContent">
                            <div class="input-label" wire:click="choisirLieu('surPlace')">
                                <input type="radio" name="modeLivraison" id="surPlace" class="hidden" {{$order->lieu === "Sur place" || $lieu === "surPlace" ? 'checked' : ''}}>
                                <label for="surPlace" class="border-none">Sur place</label>
                            </div>
                            <div class="input-label" wire:click="choisirLieu('aEmporter')">
                                <input type="radio" name="modeLivraison" id="aEmporter" class="hidden" {{$order->lieu === "A emporter" || $lieu === "aEmporter" ? 'checked' : ''}}>
                                <label for="aEmporter" class="border-none" >A emporter</label>
                            </div>
                            <div class="input-label" wire:click="choisirLieu('aLivrer')">
                                <input type="radio" name="modeLivraison" id="aLivrer" class="hidden" {{$order->lieu === "A livrer" || $lieu === "aLivrer" ? 'checked' : ''}}>
                                <label for="aLivrer" class="border-none">A livrer</label>
                            </div>
                        </div>

                        <!-- ADRESSE DE LIVRAISON -->
                        <div class="adresseLivraison">
                            @if($lieu === "aLivrer" || $lieu === "A livrer")
                                @if($userHasAdresse && !$autreAdresse)
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
                                @if(!$userHasAdresse || ($userHasAdresse && $autreAdresse))
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
                                                    <input type="text" wire:model="point_de_reference"  placeholder="Point de reference">
                                                </div>
                                                @error('point_de_reference')
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

                        <div class="flex flex-col justify-start">
                            <label for="">Laissez une note</label>
                            <textarea wire:model.debounce.300ms="note" placeholder="Laissez une note" class="w-[80%] h-[100px] p-3"></textarea>
                        </div>
                    </div>

                    <!-- Les produits choisis -->
                    <div class="">
                        <h3 class="font-bold text-[1.7rem] py-5">Les produits choisis</h3>
                        <div class="flexLeft gap-4">
                            @foreach($order->orderItems as $item)
                                <div class="productDiv relative w-[140px] bg-[--white] overflow-x-hidden text-center rounded-md shadow-md pb-2">
                                    <div class="">
                                        
                                        <button type="button" wire:click="removeProductToOrder({{ $item->product->id }})" class="absolute top-2 right-2 bg-[#8a0707] p-[2px] rounded-full">
                                            <x-icon name="croix-fermer" fill="#fff" size="14" class="cursor-pointer"/>
                                        </button>
                                        <img class="w-full h-[70px] object-cover" src="{{asset('storage/'.$item->product->image)}}" alt="{{$item->product->name}}">
                                    </div>
                                    <div class="flexColumn">
                                        <h5 class="mt-2 text-gray-700 font-semibold text-sm">{{ $item->product->name }}</h5>
                                        <div class=" mb-2 px-3">
                                            <p class="text-[--color2-yellow] font-bold text-xs mt-1">{{ $item->product->sale_price ?? $item->product->regular_price  }} GNF</p>
                                            <p class="text-gray-800 font-bold text-xs mt-1">Total {{ $item->quantity * $item->product->sale_price ?? $item->product->regular_price  }} GNF</p>
                                        </div>
                                        
            
                                        <div class="flexCenter mx-auto gap-2 rounded-full bg-[#e9e9e9] p-1 shadow-sm">
                                            <button type="button" wire:click="decreaseQuantity({{ $item->id }})">
                                                <x-icon name="circle-plus" fill="#fff" color="#fff" size="16" class="rounded-full bg-[#ccc]" />
                                            </button>
                                            <p class="text-xs font-semibold">{{ $item->quantity }}</p>
                                            <button type="button" wire:click="increaseQuantity({{ $item->id }})">
                                                <x-icon name="circle-plus" fill="#fff" size="16" class="rounded-full bg-[#ccc]" />
                                            </button>
                                        </div>
            
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Messages de succès -->
                    @if (session()->has('success'))
                    <div class="py-3 px-3 min-w-[300px] bg-white text-green-600 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
                        <x-icon name="success" fill="#05821c"/>
                        {{ session('success') }}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="py-3 px-3 min-w-[300px] bg-white text-red-600 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
                        <x-icon name="warning" fill="#f20"/>
                        {{ session('error') }}
                    </div>
                    @endif
                    <!-- AJOUTER D'AUTRES PRODUITS -->
                    <div class="">
                        <h3 class="font-bold text-[2rem] py-5">Ajouter d'autre produits</h3>
                        <!-- Search zone -->
                        <div class="zoneSearchContent">
                            <div class="">
                                <div class="relative">
                                    <div class="divIconSearch absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                        <x-icon name="search2"/>
                                    </div>
                                    <input type="text" wire:model.live.debounce.300ms="search" id="table-search" class="inputSearch" placeholder="Rechercher ...">
                                </div>
                            </div>
                        </div>
                        <div class="flexLeft gap-4 my-5">
                            @if(!$products == [])
                            @foreach($products as $product) 
                            
                            <div class="productDiv w-[120px] bg-[--white] overflow-x-hidden text-center rounded-md shadow-md pb-2 {{ $order->orderItems->contains('product_id', $product->id) ? 'hidden' : 'block'}}">
                                <div class="">
                                    <img class="w-full h-[70px] object-cover" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                                </div>
                                <div class="flexColumn">
                                    <h5 class="mt-2 text-gray-700 font-semibold text-sm">{{ $product->name }}</h5>
                                    <div class=" mb-2 px-3">
                                        <p class="text-[--color2-yellow] font-bold text-xs mt-1">{{ $product->sale_price ?? $product->regular_price  }} GNF</p>
                                    </div>
                                    

                                    <div class="flexCenter ">
                                        <button type="button" wire:click="addOtherItemsToOrder({{ $product->id }})" class="text-center px-2 py-[2px] rounded-sm text-white bg-[--color1-green] text-xs">
                                            Ajouter
                                        </button>
                                        
                                    </div>
        
                                </div>
                            </div>
                            @endforeach 
                            @else 
                                <p>Aucun produit</p>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btnPasserCmd">Modifier</button>
                    <!-- <button type="submit" class="btnPasserCmd bg-red-700 hover:text-red-700 hover:border-red-700">Annuler</button> -->
                </form>
            </div>
        </div> 
        @endif
    </div>
    
</div>

