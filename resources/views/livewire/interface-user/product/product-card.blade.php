
<div class="bg-[#fff] product-slide relative w-[220px] rounded-md shadow-md shadow-black/10">
    <div class="wishlist absolute top-2 left-2 z-10 ">
        <button wire:click="addToWishlist({{$product->id}})" class="coeur-vide">
            @if(Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                <x-icon name="heart-plein" fill="#ce9c2d"/>
            @else
                <x-icon name="heart-vide" fill="#585858" />
            @endif
        </button>

    </div>
    <div class="">
        <a href="{{route('product.view', ['product' => $product])}}" class="oeil bg-[#F0F0F0] md:py-2 md:px-2 px-1 py-1 rounded-full absolute top-2 right-2">
            <x-icon name="eye-vide" size="16" fill="#585858" />
        </a>
    </div>

    <div class="productImgContent">
        <img src="{{asset('storage/'. $product->image)}}" alt="{{$product->name}}">
    </div>
    
    <div class="content relative mt-[10px]">
        <div class="">
            <p class="text-center font-semibold md:text-lg ">{{$product->name}}</p>
            <p class="hidden md:block text-center font-medium text-sm text-gray-400">{{$product->sousCategory->name}}</p>
        </div>
        <div class="flex gap-2 justify-center font-semibold text-[13px]">
            <span class="money price">
            @if($product->sale_price)
                <s class="text-gray-400">{{str_replace(',','.',number_format($product->regular_price, 0))}}</s> <span class="text-[--color2-yellow]">{{str_replace(',','.',number_format($product->sale_price, 0))}} GNF</span>
            @else
                <p class="text-[--color2-yellow]">
                {{str_replace(',','.',number_format($product->regular_price, 0))}} GNF
                </p>
            @endif
            </span>
        </div>
        <div class="flex justify-center mt-2 gap-[6px]">
            @if(Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
            <button class="btnPanier text-center border-[1px] border-[--color2-yellow] hover:border-green-800 hover:bg-green-800 text-[--color2-yellow] px-2 rounded-full group text-xs block md:hidden"><a href="{{ route('cart.index') }}" class="group-hover:text-white">Voir</a></button>
            <button class="btnPanier text-center border-[1px] border-[--color2-yellow] hover:border-green-800 hover:bg-green-800 text-[--color2-yellow] px-2 rounded-full group text-xs hidden md:block"><a href="{{ route('cart.index') }}" class="group-hover:text-white">Voir le panier</a></button>
            @else
            <button wire:click="addToCart({{$product->id}})" class="btnPanier text-center border-[1px] border-[--color2-yellow] text-green-800 px-2 py-[2px] rounded-full group text-xs hover:text-white">
                <x-icon name="cart" fill="#ce9c2d" size="18" />
            </button>
            <!-- <button wire:click="addToCart({{$product->id}})" class="btnPanier text-center border-[1px] border-green-800 hover:bg-green-800 text-green-800 px-2 rounded-full group text-xs hover:text-white block md:hidden">Panier</button> -->
            @endif
            <a href="{{route('buy.now', ['product'=>$product])}}" class="group-hover:text-green-800 btnPanier text-center border-[1px] border-green-800 bg-green-800 py-[2px] md:py-1 px-2 text-white hover:text-green-800 rounded-full group hover:bg-white text-xs">Commander</a>
        </div>
        <!-- icones -->
        <div class="">
            <!-- <div class="icones-products flex justify-between  items-center  py-1 px-4">
                
                <a href="{{route('product.view', ['product' => $product])}}" class="oeil bg-[#F0F0F0] md:py-2 md:px-2 px-1 py-1 rounded-full absolute md:top-[-25px] md:right-2 top-[-20px] -right-1">
                    <x-icon name="eye-vide" size="16" fill="#585858" />
                </a>
                
            </div> -->
        </div>
    </div>
</div>
