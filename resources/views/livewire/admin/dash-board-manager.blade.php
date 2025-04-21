
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
                            <button class="productDiv">
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
                            </button>
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
                            <div class="relative">
                                <div class="divIconSearch absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                    <x-icon name="btn-search2"/>
                                </div>
                                <input type="text" wire:model.live.debounce.100ms="search" id="table-search" class="inputSearch" placeholder="Rechercher ...">
                            </div>
    
                        </div>
                    </div>
    
                    <!-- Fin zone recheche -->
                    <div class="">
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
                        <div class="platsContent">
                            @foreach($products as $product)
                                <button class="productDiv">
                                    <div class="">
                                        <img class="productDivImg" src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}">
                                    </div>
                                    <div class="">
                                        <h5 class="name">{{ $product->name }}</h5>
                                        <div class="productTextContent">
                                            <p class="prix">{{ number_format($product->sale_price ?? $product->regular_price, 0, '.', '')  }} GNF</p>
                                            <p class="category">{{ Str::limit($product->sousCategory->name, 10) }}</p>
                                            
                                        </div>
                                    </div>
    
                                </button>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Commandes du jour -->
        <div class="invoiceContent px-4">
            <h2 class="md:text-[24px] text-[18px]  font-bold py-3">Commandes du jour</h2>
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
                               
                                @if( $dayOrder->status == "En cours" && auth()->user()->hasAnyRole(['superAdmin', 'manager']))
                                <button wire:click="editDayOrder({{ $dayOrder->id }})">
                                    <x-icon name="edit" fill="#025239" size="15" class="absolute top-3 right-3" />
                                </button>
                                @endif
                                <div class="">
                                    {{--<img class="w-[80px] h-full shadow-sm rounded-sm object-cover" src="{{asset('storage/'. optional($dayOrder->orderItems->random())->product->image ?? '1736471588.webp' )}}" alt="{{$dayOrder->name}}">--}}
                                </div>
                                
                                <div class="w-full">
                                    <div class="">
                                        @foreach ($dayOrder->orderItems as $item)
                                            <span class="font-semibold">{{$item->product->name}}</span>,
                                        @endforeach
                                    </div>
                                    <p class="">
                                        <span>{{$dayOrder->note ?? 'Aucune note'}}</span>
                                    </p>
                                    <div class="flexBetween">
                                        <p class="">
                                            <span class="font-bold">Lieu : </span>
                                            <span>{{$dayOrder->lieu}}</span>
                                        </p>
                                        <p class="">
                                            @if($dayOrder->status == "En cours")
                                            <span class="bg-[--color2-yellow] py-[1px] px-2 rounded-sm text-white font-semibold">{{$dayOrder->status}}</span>
                                            @elseif($dayOrder->status == "Livrée")
                                            <span class="bg-[--color1-green] py-[1px] px-2 rounded-sm text-white font-semibold">{{$dayOrder->status}}</span>
                                            @elseif($dayOrder->status == "Annulée")
                                            <span class="bg-red-600 py-[1px] px-2 rounded-sm text-white font-semibold">{{$dayOrder->status}}</span>
                                            @endif
                                        </p>
                                    </div>
    
                                    <div class="flexBetween gap-5">
                                        @if($dayOrder->lieu == "Sur place") 
                                        <p class="">
                                            <span class="font-bold">Table : </span>
                                            <span>1</span>
                                        </p>
                                        @endif
                                        <p class="">
                                            <span class="font-bold text-[--color1-green]">{{number_format($dayOrder->total, 0, ',', '.')}} GNF</span>
                                        </p>
                                    </div>
                                    
                                    
                                </div>
                                
                            </div>
                        @endforeach

                        <div class="border-2 border-dotted rounded-md mt-5">
                            
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
    <div class="main-content-inner bg-[--white] py-5 relative">
        <div class="main-content-wrap">
            <h3 class="md:text-[24px] text-[18px]  font-bold text-center roboto">Commandes recentes</h3>
            <div class="table-wrapper">
                <table class="table border">
                    <div class="sessionMessage">
                        @if(Session::has('status'))
                            <p class="alert alert-success">{{Session::get('status')}}</p>
                        @endif
                    </div>
                    <thead class="thead">
                        <tr>
                            
                            <th class="w-[150px] text-center">NoCmd</th>
                            <th class="text-center min-w-[150px]">Commandé par </th>
                            <th class="text-center">Phone</th>
                            <th class="text-center min-w-[130px]">Nbre Produits</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Lieu</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Date de livraison</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        {{-- Indicateur de chargement --}}
                            <div wire:loading class="flex items-center justify-center p-4">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                                <span class="ml-2">Chargement...</span>
                            </div>
                        @if($search && $orders[0] == null)
                            <tr class="colsTbody">
                                <td colspan="9" class="colsTbody">
                                    Aucune commande trouvée pour "{{ $search }}"
                                </td>
                            </tr>
                        @endif
                        @foreach($orders as $order)
                        <tr class="">
                            <td scope="row" class="colsTbody">
                                {{ $order->NoCMDParJour }}
                            </td>
                            <td scope="row" class="colsTbody text-center font-bold">
                                {{ $order->name }}
                            </td>
                            <td scope="row" class="colsTbody">
                                {{ $order->phone }}
                            </td>
                            <td scope="row" class="colsTbody">
                                {{ $order->orderItems->count() }}
                            </td>
                            <td scope="row" class="colsTbody font-bold">
                                {{ str_replace(',','.',number_format($order->total, 0)) }} GNF
                            </td>
                            <td class="colsTbody">
                                @if($order->lieu == 'Sur place')
                                    Reçue
                                @else
                                    @if($order->status == 'delivred')
                                    <span class="badge bg-success">Livré</span>
                                    @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Annulé</span>
                                    @else 
                                    <span class="badge bg-warning">En attente</span>
                                    @endif
        
                                @endif
                            </td>
                            
                            <td scope="row" class="colsTbody">
                                {{ $order->lieu }}
                            </td>
        
                            <td scope="row" class="colsTbody">
                                {{ $order->created_at }}
                            </td>
                            
                            <td scope="row" class="colsTbody">
                                @if($order->lieu == 'Sur place')
                                {{ $order->created_at }}
                                @else
                                {{ $order->delivred_date }}
                                @endif
                            </td>
                            
                            
        
                            <td class="colsTbody">
                                <div class="divIconsActions">
                                <a href="route('admin.order.show', ['order' => $order] ) }}">
                                    <div class="item edit">
                                        <x-icon name="eye-vide" fill="#1A1F2C"/>
                                    </div>
                                </a>
                                    <!-- <form action="" id="formDelete" method="POST" class="flex items-center">
                                        @method('DELETE')
                                        @csrf
                                        <div class="item text-danger delete">
                                            <x-icon name="delete" fill="#a30505"/>
                                        </div>
                                    </form> -->
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- POUR POUVOIR FAIRE APPEL A EDIT IL FAUT INSERER SON COMPOSANT -->

        {{--<livewire:admin.order.edit-order-modal />--}}
    </div>


     

</div>


