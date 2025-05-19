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
                                <tr>
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
                                    <td class="table_col col_action">
                                        <button wire:confirm="Êtes vous sure?" wire:click="removeProduct('{{$item->rowId}}')">
                                            <x-icon name="delete" fill="#b10303" class="delete"/>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btnViderPanier" wire:confirm="Êtes vous sure?" wire:click="clearCart">Vider le panier</button>
                </div>
            <!-- FIN ITEMS -->
                
            <!-- DETAILLS PAYEMENT -->
            <div class="payement_details">
                <h3 class="title">Détails</h3>
                <!-- Coupon -->
                <form wire:submit="applyCoupon" class="couponForm">
                    <div class="formContent">
                        <input type="text" placeholder="Appliquer un coupon">
                        <button >Valider</button>
                    </div>
                </form>

                <p class="tax details">
                    <span class="titre">Taxe : </span>
                    <span>{{Cart::instance('cart')->tax()}}</span>
                </p>
                <div class="subtotal details">
                    <span class="titre">Sous-Total : </span>
                    <span>{{Cart::instance('cart')->subtotal()}} GNF</span>
                </div>
                <div class="rabais details">
                    <span class="titre">Rabais : </span>
                    <span>0</span>
                </div>
                <div class="total details">
                    <span class="titre">Total : </span>
                    <span>{{Cart::instance('cart')->total()}} GNF</span>
                </div>
                <a href="{{route('cart.checkout')}}" class="btnPasserCaisse">Passer à la caisse</a>
            </div>
            <!-- FIN DETAILLS PAYEMENT -->
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmAction() {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Cette action est irréversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, confirmer!',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Appeler la méthode Livewire après confirmation
            $wire.clearCart();
        }
    });
}
</script>