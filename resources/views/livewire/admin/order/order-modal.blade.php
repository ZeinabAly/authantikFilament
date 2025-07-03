
<div class="">
    @livewireStyles
    <!-- vue livewire:open-modal -->

    <!-- orderModal: blade -->
    <div class="modalContent" x-data="{ openModalCmd: false }" x-cloak @open-order-modal.window="openModalCmd = true">
  
        <div class="orderModal" x-show="openModalCmd" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
    
            <div class="py-3 flex items-center justify-between">
                <h3 class="text-2xl font-bold">Votre commande</h3>
                <button class="closeModalBtn" @click="openModalCmd = false">
                    <x-icon name="btn-fermer" fill="#fff" size="20" class="cursor-pointer"/>
                </button>
            </div>
    
            <div class="orderModalContent">
                <div class="orderMainContent">
                    <!-- btnRechercher -->
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
            
                    <!-- Fin zone recheche -->
                    <!-- Zone categorie -->
                    <div class="">
                        <div class="titre2Content">
                            <h2 class="titre2">Les categories</h2>
                        </div>
                        <div class="adminCategoriesContent">
                            <button type="button" wire:click="setSelectedCategory('')" class="btnModalCategory md:bg-[--white] {{$selectedCategory === '' ? 'selectedCategory' : ''}}">
                                <div class="adminCatImageContent">
                                    <img class="adminCatImage" src="{{asset('storage/'.$allCategories->image)}}" alt="tout">
                                </div>
                                <div class="adminCatTexteContent x-bind:ring-2 ring-[--color2-yellow]">
                                    <h5 class="adminCatName">Tout</h5>
                                    <p class="adminCatProductCount"><span>Produits:</span> <span class="{{$selectedCategory !== '' ? 'text-gray-500' : ''}}">{{ $nbreTotalPrdts }}</span></p>
                                </div>
                            </button>
                            @foreach($sousCategories as $sCategory)
                                <button type="button" wire:click="setSelectedCategory({{$sCategory->id}})" class="btnModalCategory md:bg-[--white] {{$selectedCategory === $sCategory->id ? 'selectedCategory' : ''}}">
                                    <div class="adminCatImageContent">
                                        <img class="adminCatImage" src="{{asset('storage/'.$sCategory->image)}}" alt="{{$sCategory->name}}">
                                    </div>
                                    <div class="adminCatTexteContent x-bind:ring-2 ring-[--color2-yellow]">
                                        <h5 class="adminCatName">{{ $sCategory->name }}</h5>
                                        <p class="adminCatProductCount"><span>Produits:</span> <span class="{{$sCategory->id !== $selectedCategory ? 'text-gray-500' : ''}}">{{ $sCategory->products->count() }}</span></p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
     
                    
                        <!-- AFFICHAGE DES PRODUITS -->
                        <div class="titre2Content">
                            <h2 class="titre2">Les plats</h2>
                        </div>
                        <div class="displayModalProducts">
                            @foreach($products as $product)
                                <!-- Si le produit est deja dans le panier alors il suffit de cliquer sur plus ou moins -->
                                @if(Cart::instance('cart')->content()->where('id', $product->id)->count() > 0 )
                                <div class="productDiv">
                                    <div class="productContent">
                                        <img class="productImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        <div class="productText">
                                            <h5 class="productName">{{ $product->name }}</h5>
                                            <p class="productDescription desktop">{{ Str::limit($product->description, 40) }}</p>
                                            <p class="productSousCategory mobile">{{ Str::limit($product->sousCategory->name, 20) }}</p>
                                        </div>
                                    </div>
                                    <div class="priceAndActions">
                                        <p class="productPrice">{{ number_format($product->sale_price ?? $product->regular_price, 0, '.', '') }} GNF</p>

                                        @php
                                            $cartItem = Cart::instance('cart')->content()->firstWhere('id', $product->id);
                                            $qty = $cartItem ? $cartItem->qty : 0;
                                            $rowId = $cartItem->rowId;
                                        @endphp

                                        <div class="quantityControl">
                                            <button wire:click="decreaseQuantity('{{ $rowId }}')">
                                                <x-icon name="circle-moins" fill="#fff" color="#fff" size="20" class="icon" />
                                            </button>
                                            <p class="quantity">{{ $qty }}</p>
                                            <button wire:click="increaseQuantity('{{ $rowId }}')">
                                                <x-icon name="circle-plus" fill="{{ $qty > 0 ? '#ce9c2d' : '#fff' }}" size="20" class="icon" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @else 
                                <button wire:click="addToCart({{$product}})" class="productDiv">
                                    <div class="productContent">
                                        <img class="productImage" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                                        <div class="text-left">
                                            <h5 class="productName">{{ $product->name }}</h5>
                                            <p class="productDescription desktop">{{ Str::limit($product->description, 40) }}</p>
                                            <p class="productSousCategory mobile">{{ Str::limit($product->sousCategory->name, 20) }}</p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <!-- <h5 class="mt-2 text-gray-700 font-semibold text-sm">{{ $product->name }}</h5> -->
                                        <div class="priceAndActions">
                                            <p class="productPrice">{{ number_format($product->sale_price ?? $product->regular_price, 0, '.', '')  }} GNF</p>
                                            @php
                                                $cartItem = Cart::instance('cart')->content()->firstWhere('id', $product->id);
                                                $qty = $cartItem ? $cartItem->qty : 0;
                                            @endphp

                                            <div class="quantityControl">
                                                <x-icon name="circle-moins" fill="#fff" color="#fff" size="17" class="icon" />
                                                <p class="text-xs md:text-sm font-semibold">{{ $qty }}</p>
                                                <x-icon name="circle-plus" fill="{{ $qty > 0 ? '#025239' : '#fff' }}" size="17" class="icon" />
                                            </div>
                                        </div>
                                    </div>
            
                                </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
    
    
                <!-- Contenu de la facture -->
                <div class="invoiceContent">
                    <h2 class="text-2xl font-bold py-3">Mon panier</h2>
                    <div class="products">
    
                        @if(!$cartContent == [])
                            <div class="productsContent">
                                @foreach($cartContent as $item)
                                    <div class="invoiceProduct">
                                        <button wire:click="removeProduct('{{$item['rowId']}}')" class="delete">
                                            <x-icon name="delete" size="14"/>
                                        </button>
                                        <div class="invoiceProductHeader">
                                            <div class="">
                                                <img class="" src="{{asset('storage/'.$item['image'])}}" alt="$item['name']">
                                            </div>
                                            <div class="w-full">
                                                <p class="productName">{{$item['name']}}</p>
                                                <p class="productDesc">{{Str::limit($item['description'], 40)}}</p>
                                            </div>
                                        </div>
                                        <div class="productFooter">
        
                                            <div class="quantityControl">
                                                <button wire:click="decreaseQuantity('{{$item['rowId']}}')">
                                                    <x-icon name="circle-moins" fill="#fff" color="#fff" size="20" class="" />
                                                </button>
                                                <p class="font-semibold">{{ $item['qty'] }}</p>
                                                <button wire:click="increaseQuantity('{{$item['rowId']}}')">
                                                    <x-icon name="circle-plus" fill="#fff" size="20" class="" />
                                                </button>
                                            </div>
    
        
                                            <div class="">
                                                <p class="subtotal">{{number_format($item['subtotal'], 0, '.', '')}} GNF</p>
                                            </div>
        
                                        </div>
                                    </div>
                                @endforeach
                                <button wire:click="clearCart" class="btnVider">Vider le panier</button>
                            </div>
                        @endif
                    </div>
    
                    <div class="sectionPayement">
                        <!-- Appliquer un coupon -->
                        @if(!Cart::instance('cart')->content()->isEmpty())
                        <div class="coupon_payement">
                            <form wire:submit="applyCoupon">
                                <div class="couponContent">
                                    <input type="text" name="coupon" class="couponInput" wire:model="couponCode" placeholder="Appliquer un coupon">
                                    @error('coupon')
                                        <p class="alert-danger">{{$message}}</p>
                                    @enderror
                                    <button class="couponApplyBtn">Appliquer</button>
                                </div>
                                @if(Session::has('discounts'))
                                    <div class="flex items-center gap-2">
                                        <p class="text-green-800 font-bold text-sm">Coupon appliqué</p>
                                        <p class="font-bold text-sm">{{Session::get('coupon')['code']}}</p>
                                    </div>
                                @endif
                            </form>


                            <!-- INFORMATIONS DU CLIENT -->
                            
                            @if(!$isManager)
                                <div class="mb-4">
                                    <h2 class="font-bold text-md text-gray-800">. Qui a passé la commande ? </h2>
                                </div>
                                <select wire:change="choice($event.target.value)" class="selectServeur">
                                    <option value="">Sélectionnez un serveur</option>
                                    @foreach($serveurs as $serveur)
                                        <option value="{{$serveur->id}}">{{$serveur->name}}</option>
                                    @endforeach
                                </select>
                                @error('serveur')
                                    <span class="alert alert-danger">{{$message}}</span>
                                @enderror
                            @endif

                            <!-- FIN INFORMATIONS DU CLIENT -->
    
                            <!-- MODE DE PAYEMENT -->
                            <div class="">
                                <h4 class="text-md font-semibold">Mode de payement</h4>

                                <div class="payementModesContent">

                                    <input type="radio" id="liquide" name="payementMode" checked class="hidden" />
                                    <label for="liquide" wire:click="getModePayemeent('liquide')">En espèce</label>
                                    
                                    <input type="radio" id="om" name="payementMode" class="hidden" />
                                    <label for="om" wire:click="getModePayemeent('OM')">O.Money</label>
                                    
                                    <input type="radio" id="mm" name="payementMode" class="hidden" />
                                    <label for="mm" wire:click="getModePayemeent('MM')">M.Money</label>
                                    
                                </div>
                            </div>
                            <!-- FIN MODE PAYEMENT -->

                            <!-- MODE DE LIVRAISON -->
                            <div class=" ">
                        
                                <h2 class="text-md font-semibold">Mode de livraison</h2>
                                <div class="modesDeLivraisonContent ">
                                    <input type="radio" checked name="modeLivraison" id="surPlace" class="hidden">
                                    <label for="surPlace" wire:click="choisirLieu('surPlace')">Sur place</label>

                                    <input type="radio" name="modeLivraison" id="aEmporter" class="hidden">
                                    <label for="aEmporter" wire:click="choisirLieu('aEmporter')">Emporter</label>
                                    
                                    <input type="radio" name="modeLivraison" id="aLivrer" class="hidden">
                                    <label for="aLivrer" wire:click="choisirLieu('aLivrer')">Livrer</label>

                                </div>
                
                                <!-- ADRESSE DE LIVRAISON -->
                                <div class="adresseLivraison">
                                    @if($lieu === "aLivrer")
                                    <h4 class="font-bold text-lg my-5">Veuillez remplir ce formulaire pour la livraison</h4>
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
                                    </div>
                                    @endif
                                </div>
                                <!-- FIN ADRESSE DE LIVRAISON -->
                            </div>
                            <!-- FIN MODE DE LIVRAISON -->

                            <!-- CHOISIR UNE TABLE -->
                            <div class="restaurantTableConten mt-3">
                                <h2 class="text-md font-semibold">Numero de table</h2>
                                <select wire:click="selectTable(event.target.value)">
                                    <option value="">Choisir une table</option>
                                    @foreach($restaurantTables as $table)
                                    <option value="{{$table->name}}">{{$table->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- LAISSER UNE NOTE -->
                            <div class="mt-3">
                                <h4 class="text-md font-semibold">Laisser une note</h4>

                                <div class="">
                                    <textarea wire:model="note" placeholder="Pas de piment" class="payementModesContent border-0"></textarea>
                                </div>
                            </div>
                            <!-- FIN MODE PAYEMENT -->

                        </div>


        
                        <div class="py-5 px-3">
                            <p class="nbreProduits">Nbre Produits : <span class="">{{count($cartContent)}}</span></p>
                            @if(Session::has('discounts'))
                                <p class="rabais">Rabais : <span>{{number_format((float) str_replace(',', '', Session::get('discounts')['discount']), 0, '.', '.')}} GNF</span></p>
                                <h3 class="total">Total : <span>{{number_format((float) str_replace(',', '', Session::get('discounts')['total']), 0, '.', '.')}} GNF</span></h3>
                            @else
                                <h3 class="text-lg text-gray-900 font-bold">Total: <span>{{number_format((float) str_replace(',', '', $total), 0, '.', '.')}} GNF</span></h3>
                            @endif
                        </div>
        
                        
    
                        @else
                        <div class="px-3 py-3">
                            <p class="text-sm py-3">Aucun produit selectionné</p>
                            <h3 class="text-lg text-gray-900 font-bold">Total: <span>{{ number_format($total, 0, '.', '')}}</span></h3>
                        </div>
                        @endif
                        
                    </div>
    
                    @if(!$cartContent == [] && $commandeCreee == false)
                        <button class="btnClickCommande" wire:click="createOrder">Commander</button>
                    @else
                        @if(isset($order))
                        <div class="text-[--color1-green] flex gap-3 items-center">
                            <x-icon name="success" fill="#05821c"/>
                            <span>Commande validée ! </span>
                        </div>
                        <div class="telechargementBtns">
                            <a href="{{route('facture.telecharger', ['order' => $order])}}" class="btnCommander">Imprimer la facture</a> 
                            <a href="{{route('recu.telecharger', ['order' => $order])}}" class="btnCommander">Imprimer le recu de cuisine</a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    @livewireScripts
</div>

