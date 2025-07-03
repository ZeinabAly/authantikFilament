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

                <!-- LES INFORMATIONS DU FORMULAIRE -->
                @include('partials.checkoutFormContent')
                <!-- FIN LES INFORMATIONS DU FORMULAIRE -->

            </form>
        </div>
    
        <!-- PARTIE DROITE  -->
        <div class="totaux payement_details">
            <h2 class="titre">
                <div class="border-[1px] border-[#114333] w-[30px] h-[30px] flexCenter rounded-full">
                    <x-icon name="cubes" fill="#114333" />
                </div>
                <span>Votre commande</span>
            </h2>

            <!-- AFFICHAGE DU PRODUIT -->

            <div class="name_image">
                <img src="{{asset('storage/'. $product->image)}}" alt="">
                <div class="flex flex-col gap-2">
                    <span>{{$product->name}}</span>
                    <span class="money price font-bold">
                        <p class="text-[--color2-yellow]">
                            {{number_format($product->sale_price ?? $product->regular_price, 0, '.', '.')}} GNF
                        </p>
                    </span>
                </div>
            </div>

            <div class="payement_details">
            <div class="detail">
                <span>Sous-total</span>
                <span>{{number_format($prixTotal, 0, '.', '.')}} GNF</span>
            </div>

            <div class="total detail">
                <span>Total : </span>
                <span class="text-[--color2-yellow]">{{number_format($prixTotal, 0, '.', '.')}} GNF</span>
            </div>
    
            <div class="detail">
                <span>Mode de paiement : </span>
                <span>
                    @if($modePayement === "liquide")
                        En Espèce
                    @elseif($modePayement === "OM")
                        Orange Money
                    @elseif($modePayement === "MM")
                        Mobile Money
                    @else 
                        {{$modePayement}}
                    @endif
                </span>
            </div>

            </div>
        </div>
    </div>

</div>
