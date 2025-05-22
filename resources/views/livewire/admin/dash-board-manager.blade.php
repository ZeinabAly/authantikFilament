
<div class="dashAccueil" x-data="{ search: '', products: @entangle('products') }">
    
    <div class="orderModalContent">
        <div class="">
            <div class="">
                <!-- <h3 class="titre">Tableau de bord</h3> -->
            </div>
            <div class="orderMainContent">
    
                @if (session()->has('success'))
                    <div class="py-3 px-3 min-w-[300px] bg-white text-green-600 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
                        <x-icon name="success" fill="#05821c"/>
                        {{ session('success') }}
                    </div>
                @endif
    
                <!-- PLATS DU JOUR -->
                <div class="platsDuJour">
                    <h3 class="platJourTitre">Plats du jour</h3>

                    @if($platsDuJour->isEmpty())
                        <p class="aucunPlat">Aucun plat pour l'instant, veuillez en selectionner</p>
                    @endif
                    <div class="platsContent">
                        @foreach($platsDuJour as $platDuJour)
                            <div class="productDiv">
                                <div class="">
                                    <img class="productDivImg" src="{{asset('storage/'.$platDuJour->image)}}" alt="{{$platDuJour->name}}">
                                </div>
                                <div class="">
                                    <h5 class="name">{{ $platDuJour->name }}</h5>
                                    <div class="productTextContent">
                                        <p class="prix">{{ number_format($platDuJour->sale_price ?? $platDuJour->regular_price, 0, '.', '')  }} GNF</p>
                                        <p class="category">{{ Str::limit($platDuJour->sousCategory->name, 10) }}</p>
                                        
                                    </div>
                                </div>

                                <button class="btnRetirerPlats" wire:click="retirerDesPlats({{$platDuJour->id}})">
                                    <x-icon name="btn-fermer" fill="#741704" size="14" class="cursor-pointer"/>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- FIN PLATS DU JOUR -->
    
                <!-- TOUS LES PLATS -->
                <div class="px-3">
                    <h3 class="platJourTitre">Tous les plats</h3>
                    
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
                    <div class="">
                        <div class="titre2Content">
                            <h2 class="titre2">Les categories</h2>
                        </div>
                        <!-- Zone categorie -->
                        <div class="adminCategoriesContent">
                            
                            @foreach($sousCategories as $sCategory)
                                <button type="button" @click="$wire.setSelectedCategory({{$sCategory->id}})" class="btnModalCategory">
                                    <div class="adminCatImageContent">
                                        <img class="adminCatImage" src="{{asset('storage/'.$sCategory->image)}}" alt="{{$sCategory->name}}">
                                    </div>
                                    <div class="adminCatTexteContent x-bind:ring-2 ring-[--color2-yellow]">
                                        <h5 class="adminCatName">{{ $sCategory->name }}</h5>
                                        <p class="adminCatProductCount"><span>Produits : </span> <span class="text-gray-500"> {{ $sCategory->products->count() }}</span></p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    
                        <!-- AFFICHAGE DES PRODUITS -->
                        <div class="titre2Content">
                            <h2 class="titre2">Les plats</h2>
                            <span>Cliquer sur ajouter pour l'ajouter un plat aux plats du jour</span>
                        </div>
                        <div class="platsContent">
                            @foreach($products as $product)
                                <div class="productDiv {{$platsDuJour->contains('id', $product->id) ? 'hidden' : ''}}">
                                    <div class="">
                                        <img class="productDivImg" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                                    </div>
                                    <div class="">
                                        <h5 class="name">{{ Str::limit($product->name, 15) }}</h5>
                                        <div class="productTextContent">
                                            <p class="prix">{{ number_format($product->sale_price ?? $product->regular_price, 0, '.', '')  }} GNF</p>
                                            <p class="category">{{ Str::limit($product->sousCategory->name, 10) }}</p>
                                            <button class="btnAjouterPlats" wire:click="ajouterAuxPlats({{$product->id}})">
                                                <x-icon name="plus" size="12" fill="#fff" />
                                                <span>Ajouter</span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes du jour -->
        <div class="invoiceContent px-4">
            <h2 class="platJourTitre">Commandes du jour</h2>
            <div class="products">
                
                <div class="cmdStatusContent">
                    <input type="radio" id="enCours" name="cmdJourStatus" checked />
                    <label for="enCours" wire:click="getOrdersByStatus('En cours')">En cours</label>
                    <input type="radio" id="livre" name="cmdJourStatus" />
                    <label for="livre" wire:click="getOrdersByStatus('Livrée')">Livré</label>
                    <input type="radio" id="annule" name="cmdJourStatus" />
                    <label for="annule" wire:click="getOrdersByStatus('Annulée')">Annulé</label>
                </div>
                
                @if(!$dayOrders == [])
                    <div class="dayOrders">
                        @foreach($dayOrders as $dayOrder)
                            <div class="dayOrder relative">
                                <div class="w-full">
                                    <div class="">
                                        @foreach ($dayOrder->orderItems as $item)
                                            <span class="font-semibold">{{$item->product->name}}</span>,
                                        @endforeach
                                    </div>

                                    <p class="">
                                        <span>{{$dayOrder->note == "" ? 'Aucune note' : $dayOrder->note}}</span>
                                    </p>
                                    
                                    
                                    <div class="flex items-center gap-4">
                                        <p class="">
                                            <span class="font-bold">Lieu : </span>
                                            <span>{{$dayOrder->lieu}}</span>
                                        </p>
                                        
                                        <p class="">
                                            <span class="font-bold">{{$dayOrder->table}}</span>
                                        </p>
                                    </div>

                                    <!-- STATUS -->
                                    <div class="">
                                        <p class="">
                                            <span class="font-bold">Status : </span>
                                            @if($dayOrder->status == "En cours")
                                            <span class="badge badge-warning">{{$dayOrder->status}}</span>
                                            @elseif($dayOrder->status == "Livrée")
                                            <span class="badge badge-success">{{$dayOrder->status}}</span>
                                            @elseif($dayOrder->status == "Annulée")
                                            <span class="badge badge-danger">{{$dayOrder->status}}</span>
                                            @endif
                                        </p>
                                    </div>
    

                                    <!-- Total -->
                                    <div class="">
                                        <p class="">
                                            <span class="text-[--color1-green]"><span class="font-bold mr-2">Total : </span>{{number_format($dayOrder->total, 0, ',', '.')}} GNF</span>
                                        </p>
                                    </div>
                                    
                                    
                                </div>
                                
                            </div>
                        @endforeach

                        <div class="zoneTotal">
                            
                            <div class="text-lg flexBetween p-3">
                                @if($statusSelected == "En cours")
                                <p class="text-[14px] md:text-sm font-bold roboto">Total En cours</p>
                                <p class="text-[14px] md:text-sm font-bold roboto text-[--color1-green]">{{number_format($totalsData['totalEncours'], 0, ',', '.')}} GNF</p>
                                @elseif($statusSelected == "Livrée")
                                <p class="text-[14px] md:text-sm font-bold roboto">Total Livré</p>
                                <p class="text-[14px] md:text-sm font-bold roboto text-[--color1-green]">{{number_format($totalsData['totalDeLivre'], 0, ',', '.')}} GNF</p>
                                @elseif($statusSelected == "Annulée")
                                <p>Total Annulé</p>
                                <p class="text-[14px] md:text-sm font-bold roboto text-[--color1-green]">{{number_format($totalsData['totalAnnule'], 0, ',', '.')}} GNF</p>
                                @endif
                            </div>
                            
                            <div class="text-lg flexBetween py-5 px-3 border-t-2 border-dotted">
                                <p>Total</p>
                                <p class="font-bold text-[--color2-yellow]">{{number_format($totalsData['dayOrderTotal'], 0, ',', '.')}} GNF</p>
                            </div>
                        </div>
                    </div>
                @else 
                    <p>Aucune commande pour aujourd'hui</p>   
                @endif
            </div>

            <!-- <button class="px-3 py-2 bg-[--color1-green] text-white rounded-sm w-full font-semibold" wire:click="createOrder">Commander</button> -->
            
        </div>
    </div>
    <!-- FIN TOUS LES PLATS -->


    <!-- LES COMMANDES RECENTES -->
    <div class="">
        <livewire:admin.order.recent-orders />
    </div>


</div>


