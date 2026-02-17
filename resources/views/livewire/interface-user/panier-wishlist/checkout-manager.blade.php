<div class="modes">
    @if (session()->has('error'))
        <!-- Messages d'erreur -->
        <div x-data="{show: true}" x-show="show" x-cloak class="py-3 px-3 min-w-[300px] bg-white text-red-500 shadow-md font-semibold text-sm fixed z-[10000] top-0 right-0 flex items-center gap-2">
            <button @click="show = false">×</button>
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
    <div class="infosClient">
        @if($commandeCreee == false)
            <p class="btnRevenir my-5" wire:click="retourCart">
                <x-icon name="fleche-left" fill="#727171" />
                <span>Revenir en arrière</span>
            </p>
        @endif
        <form wire:submit="createOrder">
            <!-- LES INFORMATIONS DU FORMULAIRE -->
            @include('partials.checkoutFormContent')
            <!-- FIN LES INFORMATIONS DU FORMULAIRE -->
        </form>
    </div>

    <div class="totaux payement_details">
        <h2 class="titre">
            <div class="border-[1px] border-[#114333] w-[30px] h-[30px] flexCenter rounded-full">
                <x-icon name="cubes" fill="#114333" />
            </div>
            <span>Votre commande</span>
        </h2>

        <div class="">
            
            @foreach(Cart::instance('cart')->content() as $item)
            <div class="name_image">
                <img src="{{asset('storage/'. $item->model->image)}}" alt="{{ $item->name }}" loading="lazy">
                <div class="flex flex-col gap-2">
                    <span>{{$item->name}}</span>
                    <span class="money price font-bold">
                        <p class="text-[--color2-yellow]">
                            {{str_replace(',','.',number_format($item->price, 0))}} GNF
                        </p>
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        @if(Session::has('discounts'))
            <div class="">
                <div class="payement_details">
                <div class="detail">
                    <span>Sous-total</span>
                    <span>{{str_replace(',', '.', Session::get('discounts')['subtotal'])}} GNF</span>
                </div>
    
                <div class="detail">
                    <span>Rabais : </span>
                    <span>{{str_replace(',', '.', Session::get('discounts')['discount'])}} GNF</span>
                </div>
    
                <div class="total detail">
                    <span>Total : </span>
                    <span class="text-[--color2-yellow]">{{str_replace(',', '.', Session::get('discounts')['total'])}} GNF</span>
                </div>
            </div>
        @else
            <div class="">
                <div class="payement_details">
                <div class="detail">
                    <span>Sous-total</span>
                    <span>{{number_format((float) str_replace(',', '', Cart::instance('cart')->subtotal()), 0, '.', '.')}} GNF</span>
                </div>
    
                <div class="detail">
                    <span>Rabais : </span>
                    <span>0</span>
                </div>
    
                <div class="total detail">
                    <span>Total : </span>
                    <span class="text-[--color2-yellow]">{{number_format((float) str_replace(',', '', Cart::instance('cart')->total()), 0, '.', '.')}} GNF</span>
                </div>
    
            </div>
        @endif

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
