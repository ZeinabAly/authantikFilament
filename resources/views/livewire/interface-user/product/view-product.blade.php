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
                <button wire:click="displayImage('{{$product->image}}')">
                    <img src="{{asset('storage/'.$product->image)}}" alt="image principale {{$product->name}}" class="petiteImage">
                </button>
                @if($product->images)
                    @foreach($product->images as $img)
                        <button wire:click="displayImage('{{$img}}')">
                            <img src="{{asset('storage/'.$img)}}" alt="gallery image" class="petiteImage">
                        </button>
                    @endforeach 
                @endif
            </div>

            <div class="imgPrincipaleContent">
                <img src="{{asset('storage/'. $imageView)}}" alt="image principale {{$product->name}}" class="imgPrincipale">
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
            <div class="leading-[30px] mt-4 md:text-justify text-center">

                @if(Str::length($product->short_description) > 50)
                    <p>{{$product->short_description}}</p>
                @else 
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, velit! Culpa architecto quasi quae consequatur necessitatibus excepturi quia est!</p> 
                @endif
            </div>

            <div class="my-3 flex items-center md:justify-start justify-center flex-wrap gap-3">
                <div class="flexCenter gap-3 border">
                    <button wire:click="decreaseQuantity({{ $product->id }})" class="bg-[#b5b5b5] p-[0.55rem]"><x-icon name="moins" size="14" fill="#fff"/></button>
                    @if(Cart::instance('cart')->content()->firstWhere('id', $this->product->id))
                        <p class="text-sm font-semibold text-gray-500">{{Cart::instance('cart')->content()->firstWhere('id', $this->product->id)->qty}}</p>
                    @else 
                        <p class="text-[16px] font-semibold text-gray-500">0</p>
                    @endif
                    <button wire:click="increaseQuantity({{ $product->id }})" class="bg-[#b5b5b5] p-[0.55rem]"><x-icon name="plus" size="14" fill="#fff"/></button>
                </div>
    
                <div class="flexCenter gap-3">
                    <!-- CART -->
                    @if(Cart::instance('cart')->content()->firstWhere('id', $this->product->id))
                    <button type="button" wire:click="addToCart({{ $product->id }})" class="px-4 py-[6px] text-[--color2-yellow] border-2 border-[--color2-yellow] font-semibold rounded-[2px]">Retirer du panier</button>
                    @else
                    <button type="button" wire:click="addToCart({{ $product->id }})" class="px-4 py-[6px] bg-[--color2-yellow] border-2 border-[--color2-yellow] font-semibold text-white rounded-[2px]">Ajouter au panier</button>
                    @endif
                    
                    <!-- WISHLIST -->
                    @if(Cart::instance('wishlist')->content()->firstWhere('id', $this->product->id))
                    <button wire:click="addToWishlist({{ $product->id }})" class="px-4 py-[6px] text-[--color1-green] border-2 border-[--color1-green] font-semibold rounded-[2px]">Retirer des favoris</button>
                    @else
                    <button wire:click="addToWishlist({{ $product->id }})" class="px-4 py-[6px] bg-[--color1-green] border-2 border-[--color1-green] font-semibold text-white rounded-[2px]">Ajouter aux Favoris</button>
                    @endif
                </div>
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
        <div class=" products-slide w-[90%]">
            <h2 class="text-3xl sofia text-center pt-5">Produits <span class="text-[--color2-yellow]">similaires</span></h2>
            <div class="swiper-wrapper flex justify-center pt-7 pb-10 mx-auto !important">
                @foreach($relatedProducts as $product)
                    <livewire:interface-user.product.product-card :product=$product />
                @endforeach
            </div>
     
            <div class="mt-10">
                <div class="swiper-pagination"></div>
                <div class="swiper-nav swiper-button-next"></div>
                <div class="swiper-nav swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

