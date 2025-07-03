<div>
    <div class="">
        <!-- SECTION2: LES ELEMENTS DE LA CARTE -->
        <section class="sectionProducts relative">
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

            <!-- ITEMS -->
                <div class="items">
                    <table class="table-cart-items">
                        <thead class="">
                            <th class="text-left">Produit</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        
                        <tbody class="tbody">
                            @foreach(Cart::instance('cart')->content() as $item)
                                <tr class="">
                                    <td class="name_image">
                                        <img src="{{asset('storage/'. $item->model->image)}}" alt="">
                                        <div class="flex flex-col gap-2">
                                            <span>{{$item->name}}</span>
                                            <span class="money price">
                                                <p class="text-[--color2-yellow]">
                                                    {{str_replace(',','.',number_format($item->price, 0))}} GNF
                                                </p>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="table_col col_qty">
                                        <div class="content">
                                            <button wire:click="increaseQuantity('{{$item->rowId}}')" class="text-lg">+</button>
                                            <p>{{$item->qty}}</p>
                                            <button wire:click="decreaseQuantity('{{$item->rowId}}')" class="text-lg">-</button>
                                        </div>
                                    </td>
                                    <td class="table_col">{{str_replace(',', '.', number_format($item->total, 0))}} GNF</td>
                                    <td class="table_col" x-data = "{confirmDelete: false}">
                                        <button @click="confirmDelete = true" class=""><x-icon name="delete" class="text-[#b10303]" /></button>

                                        <div x-show="confirmDelete" x-cloak class="confirmationBox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                                            <div class="confirmationContent">
                                                <h3 class="text-lg font-bold mb-4">Supprimer le produit</h3>
                                                <p class="mb-4">Êtes-vous sûr de vouloir retirer ce produit de la commande ?</p>
                                                <div class="flex justify-end gap-2">
                                                    <button @click="confirmDelete = false" class="btnAnnulerCmd">
                                                        Annuler
                                                    </button>
                                                    <button wire:click="removeProduct('{{$item->rowId}}')" @click="confirmDelete = false" class="btnConfirmerCmd" style="background: #8b0f0f">
                                                        Supprimer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>  
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- BOUTON VIDER LE PANIER -->
                    <div class="" x-data = "{confirmViderPanier: false}">
                        <button @click="confirmViderPanier = true" class="btnViderPanier">Vider le panier</button>
    
                        <div x-show="confirmViderPanier" x-cloak class="confirmationBox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                            <div class="confirmationContent">
                                <h3 class="text-lg font-bold mb-4">Vider le panier</h3>
                                <p class="mb-4">Êtes-vous sûr de vouloir vider le panier ?</p>
                                <div class="flex justify-end gap-2">
                                    <button @click="confirmViderPanier = false" class="btnAnnulerCmd">
                                        Annuler
                                    </button>
                                    <button wire:click="clearCart" @click="confirmViderPanier = false" class="btnConfirmerCmd" style="background: #8b0f0f">
                                        Vider
                                    </button>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            <!-- FIN ITEMS -->
                
            <!-- DETAILLS PAYEMENT -->
            <div class="payement_details">
                <h3 class="title">Détails</h3>
                <!-- Coupon -->
                <form wire:submit="applyCoupon" class="couponForm">
                    <div class="formContent">
                        <input type="text" wire:model.live="couponCode" placeholder="Appliquer un coupon">
                        <button {{$couponCode == "" ? "disabled" : ''}} >Valider</button>
                    </div>
                    @if(Session::has('discounts') && Session::get('discounts')['discount'] > 0)
                        <div class="text-success ml-6 mt-2">
                            Valeur du Coupon appliqué : {{str_replace(',', '.', Session::get('discounts')['discount'])}} GNF
                        </div>
                    @endif
                </form>

                @if(Session::has('discounts'))
                    <div class="subtotal details">
                        <span class="titre">Sous-Total : </span>
                        <span>{{str_replace(',', '.', Session::get('discounts')['subtotal'])}} GNF</span>
                    </div>
                    <div class="rabais details">
                        <span class="titre">Rabais : </span>
                        <span>{{str_replace(',', '.', Session::get('discounts')['discount'])}}</span>
                    </div> 
                    <div class="total details">
                        <span class="titre">Total : </span>
                        <span>{{str_replace(',', '.', Session::get('discounts')['total'])}} GNF</span>
                    </div>
                    <a href="{{route('cart.checkout')}}" class="btnPasserCaisse">Passer à la caisse</a>
                @else

                    <div class="subtotal details">
                        <span class="titre">Sous-Total : </span>
                        <span>{{number_format((float) str_replace(',', '', Cart::instance('cart')->subtotal()), 0, '.', '.')}} GNF</span>
                    </div>
                    <div class="rabais details">
                        <span class="titre">Rabais : </span>
                        <span>0</span>
                    </div>
                    <div class="total details">
                        <span class="titre">Total : </span>
                        <span>{{number_format((float) str_replace(',', '', Cart::instance('cart')->total()), 0, '.', '.')}} GNF</span>
                    </div>
                    <a href="{{route('cart.checkout')}}" class="btnPasserCaisse">Passer à la caisse</a>
                @endif
            </div>
            <!-- FIN DETAILLS PAYEMENT -->
        </section>
    </div>
</div>
