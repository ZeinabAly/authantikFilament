<div>
    <!-- FIN NAVIGATION -->
    <section class="banniere mt-[90px]">
        <div class="cover">
            <h2 class="page-title">Produit Détails</h2>
            <p class="pageFilAriane">Accueil / Produits / Détails</p>
        </div>
    </section>

    <section class="section section2 detailsProducts">
        <div class="images flex gap-3">
            <!-- Les petites images -->
            <div class="petitesImagesContent">
                <img src="{{asset('storage/'.$product->image)}}" alt="image principale {{$product->name}}" class="petiteImage">
                {{--@if($product->images)
                    @foreach(explode(',',$product->images) as $img)
                        <img src="{{asset('storage/'.$img)}}" alt="gallery image" class="petiteImage">
                    @endforeach 
                @endif--}}
            </div>

            <div class="imgPrincipaleContent">
                <img src="{{asset('storage/'. $product->image)}}" alt="image principale {{$product->name}}" class="imgPrincipale">
            </div>
        </div>
        <div class="details">
            <h2 class="section-title text-[2.4rem] mb-1">{{$product->name}}</h2>
            <div class="price">
            <div class="prices font-bold">
                @if($product->sale_price)
                    <s class="text-gray-400">{{str_replace(',','.',number_format($product->regular_price, 0))}}</s> <span class="text-[--color2-yellow]">{{str_replace(',','.',number_format($product->sale_price, 0))}} GNF</span>
                @else
                    <p class="text-[--color2-yellow]">
                    {{str_replace(',','.',number_format($product->regular_price, 0))}} GNF
                    </p>
                @endif
                </div>
            </div>
            <div class="leading-[30px] mt-4 text-justify">

                @if(Str::length($product->short_description) > 50)
                    <p>{{$product->short_description}}</p>
                @else 
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, velit! Culpa architecto quasi quae consequatur necessitatibus excepturi quia est!</p> 
                @endif
            </div>

            <div class="my-3 flex items-center gap-3">
                <div class="flex gap-1 items-center">
                    <button wire:click="decreaseQuantity({{ $product->id }})"><x-icon name="square-minus" size="24" fill="#ccc"/></button>
                    @if(Cart::instance('cart')->content()->firstWhere('id', $this->product->id))
                        <p class="text-sm font-semibold text-gray-500">{{Cart::instance('cart')->content()->firstWhere('id', $this->product->id)->qty}}</p>
                    @else 
                        <p class="text-sm font-semibold text-gray-500">0</p>
                    @endif
                    <button wire:click="increaseQuantity({{ $product->id }})"><x-icon name="square-plus" size="24" fill="#ccc"/></button>
                </div>
    
                <!-- CART -->
                @if(Cart::instance('cart')->content()->firstWhere('id', $this->product->id))
                <button type="button" wire:click="addToCart({{ $product->id }})" class="px-2 py-[4px] bg-[--color1-green] font-semibold text-white rounded-md">Retirer du panier</button>
                @else
                <button type="button" wire:click="addToCart({{ $product->id }})" class="px-2 py-[4px] bg-[--color2-yellow] font-semibold text-white rounded-md">Ajouter au panier</button>
                @endif
                
                <!-- WISHLIST -->
                @if(Cart::instance('wishlist')->content()->firstWhere('id', $this->product->id))
                <button wire:click="addToWishlist({{ $product->id }})" class="px-2 py-[4px] bg-[--color2-yellow] font-semibold text-white rounded-md">Retirer des favoris</button>
                @else
                <button wire:click="addToWishlist({{ $product->id }})" class="px-2 py-[4px] bg-[--color1-green] font-semibold text-white rounded-md">Ajouter aux Favoris</button>
                @endif
            </div>

            <p class="font-bold">Categorie: <span class="font-medium text-gray-500">{{$product->sousCategory->name}}</span></p>
        </div>
    </section>

    <!-- SECTION3: DESCRIPTION -->
    <section class="section section3">
        <h2 class="section-title">Description</h2>
        <div class="description">
            @if(Str::length($product->description) > 50)
                <p>{{$product->description}}</p>
            @else 
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, velit! Culpa architecto quasi quae consequatur necessitatibus excepturi quia est! Ratione dolore rerum, aliquid repellendus est quibusdam facilis provident fugiat quisquam?</p> 
            @endif
        </div>
    </section>

    <!-- RELATED PRODUCTS -->
    <div class="section section4 w-[100%] bg-[#f1f1f1]">
        <div class="swiper products-slide w-[90%]">
            <h2 class="text-3xl sofia text-center pt-5">Produits <span class="text-[--color2-yellow]">similaires</span></h2>
            <div class="swiper-wrapper flex justify-center pt-7 pb-10 mx-auto !important">
                @foreach($relatedProducts as $product)
                    <livewire:interface-user.product.product-card :product=$product />
                @endforeach
            </div>
     
            <div class="mt-5">
                <div class="swiper-pagination"></div>
                <div class="swiper-nav swiper-button-next"></div>
                <div class="swiper-nav swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

