
<div>
    <div class="main">

        @if (session()->has('error'))
            <!-- Messages d'erreur -->
            <div class="py-3 px-3 min-w-[300px] bg-white text-red-500 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
                <x-icon name="warning" fill="#f20"/>
                {{ session('error') }}
            </div>
            @endif
            
            <!-- Messages de succès -->
            @if (session()->has('success'))
            <div class="py-3 px-3 min-w-[300px] bg-white text-green-600 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
                <x-icon name="success" fill="#05821c"/>
                {{ session('success') }}
            </div>
            @endif
        @if(Cart::instance('wishlist')->content()->count() > 0)
        
        <!-- SECTION2: LES ELEMENTS DE LA CARTE -->
        <section class="wishSectionProducts w-full">
            <!-- ITEMS -->
                <div class="items">
                    <table class="table-cart-items">
                        <thead class="">
                            <th class="">Produit</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </thead>
                        
                        <tbody class="tbody">
                            @foreach(Cart::instance('wishlist')->content() as $item)
                                <tr>
                                    <td class="name_image">
                                        <img src="{{asset('storage/'. $item->model->image)}}" alt="">
                                        <div class="flex flex-col gap-2">
                                            <span>{{$item->name}}</span>
                                            <span class="money price">
                                                <p class="">
                                                    {{Str::limit($item->model->short_description, 30)}}
                                                </p>
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="table_col">{{str_replace(',','.',number_format($item->price, 0))}} GNF</td>
                                    <td class="table_col col_action">
                                        <div class="">
                                            <button class="btnDeplacer" wire:click="moveWishListToProduct('{{$item->rowId}}')">Deplacer vers le panier</button>
                                            <button wire:click="removeProductToWishList('{{$item->rowId}}')" class="delete text-[#b10303]">
                                                <x-icon name="delete"/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btnViderPanier" wire:click="resetWishList">Vider la liste</button>
                </div>
            <!-- FIN ITEMS -->

        </section>
        @else 
            <div class="flexColumn gap-3">
                <p>Panier vide</p>
                <a href="{{route('home.menu')}}" class="btnViderPanier">Retour au menu</a>
            </div>
        @endif
    </div>
</div>
