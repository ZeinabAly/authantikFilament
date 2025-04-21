
<div class="">
    @livewireStyles
    <!-- vue livewire:open-modal -->

    <!-- orderModal: blade -->
    <div class="modalContent" x-data="{ openModalCmd: false }" x-cloak @open-modal.window="openModalCmd = true">
  
        <div class="orderModal" x-show="openModalCmd" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
            <!-- Les messages d'erreur  -->
            <div>
                <!-- Messages d'erreur -->
                    @if (session()->has('error'))
                    <div class="filament-notification">
                        <x-icon name="warning" fill="#f20"/>
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    <!-- Messages de succès -->
                    @if (session()->has('success'))
                    <div class="py-3 px-3 min-w-[300px] bg-white text-green-600 shadow-md font-semibold text-sm fixed z-[200] top-0 right-0 flex items-center gap-2">
                        <x-icon name="success" fill="#05821c"/>
                        {{ session('success') }}
                    </div>
                @endif
            </div>
    
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
                            <div class="divIconSearchContent">
                                <div class="divIconSearch">
                                    <x-icon name="btn-search2"/>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="search" id="table-search" class="inputSearch" placeholder="Rechercher ...">
                            </div>
                        </div>
                    </div>
            
                    <!-- Fin zone recheche -->
                     <!-- Zone categorie -->
                    <div class="">
                        <div class="adminCategoriesContent">
                            
                        @foreach($sousCategories as $sCategory)
                            <button type="button" wire:click="setSelectedCategory({{$sCategory->id}})" class="btnModalCategory md:bg-[--white]">
                                <div class="adminCatImageContent">
                                    <img class="adminCatImage" src="{{asset('storage/'.$sCategory->image)}}" alt="{{$sCategory->name}}">
                                </div>
                                <div class="adminCatTexteContent x-bind:ring-2 ring-[--color2-yellow]">
                                    <h5 class="adminCatName">{{ $sCategory->name }}</h5>
                                    <p class="adminCatProductCount"><span>Produits:</span> <span class="text-gray-500">{{ $sCategory->products->count() }}</span></p>
                                </div>
                            </button>
                        @endforeach
                        </div>
     
                    
                        <!-- AFFICHAGE DES PRODUITS -->
                        <div class="flex items-center gap-2 flex-wrap mt-5">
                            @foreach($products as $product)
                                <!-- Si le produit est deja dans le panier alors il suffit de cliquer sur plus ou moins -->
                                @if(Cart::instance('cart')->content()->where('id', $product->id)->count() > 0 )
                                <div class="productDiv min-w-[145px] md:min-w-[200px] max-w-[220px] pt-2 px-2 overflow-x-hidden text-center rounded-md shadow-md bg-[--white]">
                                    <div class="flexLeft gap-2 pt-2">
                                        <img class="w-[40px] h-[40px] md:w-[50px] md:h-[50px] rounded-md object-cover" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                                        <div class="text-left">
                                            <h5 class="text-gray-800 font-semibold text-[13px] md:text-sm">{{ $product->name }}</h5>
                                            <p class="font-semibold text-[11px] text-gray-500 hidden md:block">{{ Str::limit($product->description, 40) }}</p>
                                            <p class="font-semibold text-[11px] text-gray-500 md:hidden block">{{ Str::limit($product->sousCategory->name, 20) }}</p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <!-- <h5 class="mt-2 text-gray-700 font-semibold text-sm">{{ $product->name }}</h5> -->
                                        <div class="my-2 flex justify-between gap-1">
                                            <p class="text-[--color1-green] font-bold md:text-sm text-[12px] mt-1">{{ number_format($product->sale_price ?? $product->regular_price, 0, '.', '')  }} GNF</p>
                                            @php
                                                $cartItem = Cart::instance('cart')->content()->firstWhere('id', $product->id);
                                                $qty = $cartItem ? $cartItem->qty : 0;
                                                $rowId = $cartItem->rowId;
                                            @endphp

                                            <div class="flexCenter gap-1 md:gap-2 rounded-full bg-[#e5e7eb] p-1">
                                                <button wire:click="decreaseQuantity('{{$rowId}}')">
                                                    <x-icon name="circle-moins" fill="#fff" color="#fff" size="20" class="shadow-md rounded-full" />
                                                </button>
                                                <p class="text-xs md:text-sm font-semibold">{{ $qty }}</p>
                                                <button wire:click="increaseQuantity('{{$rowId}}')">
                                                    <x-icon name="circle-plus" fill="{{ $qty > 0 ? '#ce9c2d' : '#fff' }}" size="20" class="shadow-md rounded-full" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
            
                                </div>
                                @else 
                                <button wire:click="addToCart({{$product}})" class="productDiv min-w-[145px] md:min-w-[200px] max-w-[220px] pt-2 px-2 overflow-x-hidden text-center rounded-md shadow-md bg-[--white]">
                                    <div class="flexLeft gap-2 pt-2">
                                        <img class="w-[40px] h-[40px] md:w-[50px] md:h-[50px] rounded-md object-cover" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                                        <div class="text-left">
                                            <h5 class="text-gray-800 font-semibold text-[13px] md:text-sm">{{ $product->name }}</h5>
                                            <p class="font-semibold text-[11px] text-gray-500 hidden md:block">{{ Str::limit($product->description, 40) }}</p>
                                            <p class="font-semibold text-[11px] text-gray-500 md:hidden block">{{ Str::limit($product->sousCategory->name, 20) }}</p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <!-- <h5 class="mt-2 text-gray-700 font-semibold text-sm">{{ $product->name }}</h5> -->
                                        <div class="my-2 flex justify-between">
                                            <p class="text-[--color2-yellow] font-bold md:text-sm text-[12px] mt-1">{{ number_format($product->sale_price ?? $product->regular_price, 0, '.', '')  }} GNF</p>
                                            @php
                                                $cartItem = Cart::instance('cart')->content()->firstWhere('id', $product->id);
                                                $qty = $cartItem ? $cartItem->qty : 0;
                                            @endphp

                                            <div class="flexCenter gap-1 md:gap-2 rounded-full bg-[#e5e7eb] p-1">
                                                <x-icon name="circle-moins" fill="#fff" color="#fff" size="17" class="shadow-md rounded-full" />
                                                <p class="text-xs md:text-sm font-semibold">{{ $qty }}</p>
                                                <x-icon name="circle-plus" fill="{{ $qty > 0 ? '#025239' : '#fff' }}" size="17" class="shadow-md rounded-full" />
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
                                        <button wire:click="removeProduct('{{$item['rowId']}}')" class="absolute right-3 top-2">
                                            <x-icon name="delete" fill="#b91c13" size="14" class="cursor-pointer"/>
                                        </button>
                                        <div class="">
                                            <img class="w-16 h-full object-cover shadow-xs rounded-sm" src="{{asset('storage/'.$item['image'])}}" alt="$item['name']">
                                        </div>
                                        <div class="w-full">
                                            <p class="text-[12px] md:text-sm font-bold roboto">{{$item['name']}}</p>
                                            <p class="text-xs font-medium text-gray-500">{{Str::limit($item['description'], 30)}}</p>
                                            <div class="w-full pt-2 flex justify-between">
            
                                            <div class="flexCenter gap-2 rounded-full bg-[#e9e9e9] p-1 shadow-sm">
                                                <button wire:click="decreaseQuantity('{{$item['rowId']}}')">
                                                    <x-icon name="circle-moins" fill="#fff" color="#fff" size="17" class="rounded-full bg-[#ccc]" />
                                                </button>
                                                <p class="text-xs font-semibold">{{ $item['qty'] }}</p>
                                                <button wire:click="increaseQuantity('{{$item['rowId']}}')">
                                                    <x-icon name="circle-plus" fill="#fff" size="17" class="rounded-full bg-[#ccc]" />
                                                </button>
                                            </div>
        
            
                                                <div class="">
                                                    <p class="text-xs font-semibold text-gray-500">{{number_format($item['subtotal'], 0, '.', '')}} GNF</p>
                                                </div>
            
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <button wire:click="clearCart" class="px-2 py-2 text-[12px] md:text-sm bg-[--color2-yellow] text-white rounded-sm shadow-md font-bold">Vider le panier</button>
                            </div>
                        @endif
                    </div>
    
                    <div class="sectionPayement">
                        <!-- Appliquer un coupon -->
                        @if(!Cart::instance('cart')->content()->isEmpty())
                        <div class="coupon_payement">
                            <form wire:submit="applyCoupon">
                                <div class="w-3/3 flex gap-2 py-3">
                                    <input type="text" name="coupon" class="w-2/3 text-xs outline-none border border-gray-200 py-2 md:py-3 px-2 rounded-sm" wire:model="couponCode" placeholder="Appliquer un coupon">
                                    @error('coupon')
                                        <p class="alert-danger">{{$message}}</p>
                                    @enderror
                                    <button class="w-1/3 text-xs bg-green-900 text-white px-2 py-1 rounded-sm font-semibold">Appliquer</button>
                                </div>
                                @if(Session::has('discounts'))
                                    <div class="flex items-center gap-2">
                                        <p class="text-green-800 font-bold text-xs">Coupon appliqué</p>
                                        <p class="font-bold text-xs">{{Session::get('coupon')['code']}}</p>
                                    </div>
                                @endif
                            </form>


                            <!-- INFORMATIONS DU CLIENT -->
                             
                            <div class="mb-4">
                                @if($lieu == "aLivrer")
                                <h2 class="font-bold text-md text-gray-800">1. Veuillez remplir les Informations du client</h2>
                                @else
                                <h2 class="font-bold text-md text-gray-800">1. Le serveur</h2>
                                @endif
                            </div>
                            @if($lieu == "aLivrer")
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
                            @else 
                            <select wire:change="choice($event.target.value)" class="py-2 px-3 bg-[#ececec] my-3 rounded-md shadow-md min-w-[150px]">
                                <option value="">Sélectionnez un serveur</option>
                                @foreach($serveurs as $serveur)
                                    <option value="{{$serveur->id}}">{{$serveur->name}}</option>
                                @endforeach
                            </select>
                            @error('serveur')
                                <span class="alert alert-danger text-center text-[--color2-yellow]">{{$message}}</span>
                            @enderror
                            @endif

                            <!-- FIN INFORMATIONS DU CLIENT -->
    
                            <!-- MODE DE PAYEMENT -->
                            <div class="">
                                <h4 class="text-md font-semibold">2. Mode de payement</h4>

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
                        
                                <h2 class="text-md font-semibold">3. Mode de livraison</h2>
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
                        </div>

        
                        <div class="py-5 px-3">
                            <p class="text-lg font-bold text-gray-700">Nbre Produits : <span class="">{{count($cartContent)}}</span></p>
                            @if(Session::has('discounts'))
                                <p class="text-sm text-gray-800">Rabais : <span>{{ number_format(Session::get('discounts')['discount'], 0, '.', '')}}</span></p>
                                <h3 class="text-sm text-gray-600">Total : <span>{{ number_format(Session::get('discounts')['total'], 0, '.', '')}}</span></h3>
                            @else
                                
                                <h3 class="text-lg text-gray-900 font-bold">Total: <span>{{$total}} GNF</span></h3>
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
                        <button class="px-3 py-2 bg-[--color1-green] text-white rounded-sm w-full font-semibold" wire:click="createOrder">Commander</button>
                    @else
                        @if(isset($order))
                        <div class="text-[--color1-green] flexLeft gap-3">
                            <x-icon name="success" fill="#05821c"/>
                            <span>Commande validée ! </span>
                        </div>
                        <div class="telechargementBtns flex gap-4 mt-7">
                            <a href="{{route('facture.telecharger', ['order' => $order])}}" class="btnCommander">Télecharger la facture</a> 
                            <a href="{{route('recu.telecharger', ['order' => $order])}}" class="btnCommander">Télecharger le recu de cuisine</a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    @livewireScripts
</div>

