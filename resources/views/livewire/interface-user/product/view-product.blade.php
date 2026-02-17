
@push('meta')
    {{-- Dans le <head> --}}
    <meta property="og:url" content="{{ $shareUrl ?? url()->current() }}" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $product->name ?? 'Produit' }}" />
    <meta property="og:description" content="{{ $product->description ?? 'Découvrez ce produit' }}" />
    @if(isset($product->image))
    <meta property="og:image" content="{{ asset('storage/'.$product->image) }}" />
    @endif

    {{-- Pour Twitter --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $product->name ?? 'Produit' }}" />
    <meta name="twitter:description" content="{{ $product->description ?? 'Découvrez ce produit' }}" />
    @if(isset($product->image))
    <meta name="twitter:image" content="{{ asset('storage/'.$product->image) }}" />
    @endif
@endpush



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
                    <img src="{{asset('storage/'.$product->image)}}" alt="image principale {{$product->name}}" class="petiteImage" loading="lazy">
                </button>
                @if($product->images)
                    @foreach($product->images as $img)
                        <button wire:click="displayImage('{{$img}}')">
                            <img src="{{asset('storage/'.$img)}}" alt="gallery image" class="petiteImage" loading="lazy">
                        </button>
                    @endforeach 
                @endif
            </div>

            <div class="imgPrincipaleContent">
                <img src="{{asset('storage/'. $imageView)}}" alt="image principale {{$product->name}}" class="imgPrincipale" loading="lazy">
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
                        {{ $product->prix_format }}
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
                
                @auth()
                <div class="flexCenter gap-3 border">
                    <button wire:click="decreaseQuantity({{ $product->id }})" class="bg-[#b5b5b5] p-[0.55rem]"><x-icon name="moins" size="14" fill="#fff"/></button>
                    @if(Cart::instance('cart')->content()->firstWhere('id', $this->product->id))
                        <p class="text-sm font-semibold text-gray-500">{{Cart::instance('cart')->content()->firstWhere('id', $this->product->id)->qty}}</p>
                    @else 
                        <p class="text-[16px] font-semibold text-gray-500">0</p>
                    @endif
                    <button wire:click="increaseQuantity({{ $product->id }})" class="bg-[#b5b5b5] p-[0.55rem]"><x-icon name="plus" size="14" fill="#fff"/></button>
                </div>
                @endauth
    
                <div class="flexCenter gap-3">
                    <!-- CART -->
                    @guest()
                        <div class="" x-data="{loginModal: false}" x-cloak>
                            <button type="button" @click="$dispatch('open-login-modal')" class="px-4 py-[6px] bg-[--color2-yellow] border-2 border-[--color2-yellow] font-semibold text-white rounded-[2px]">Ajouter au panier</button>
                        </div>
                    @endguest

                    @auth()
                        @if(Cart::instance('cart')->content()->firstWhere('id', $this->product->id))
                        <button type="button" wire:click="addToCart({{ $product->id }})" class="px-4 py-[6px] text-[--color2-yellow] border-2 border-[--color2-yellow] font-semibold rounded-[2px]">Retirer du panier</button>
                        @else
                        <button type="button" wire:click="addToCart({{ $product->id }})" class="px-4 py-[6px] bg-[--color2-yellow] border-2 border-[--color2-yellow] font-semibold text-white rounded-[2px]">Ajouter au panier</button>
                        @endif
                    @endauth
                    
                    <!-- WISHLIST -->
                    @guest()
                        <div class="" x-data="{loginModal: false}" x-cloak>
                            <button type="button" @click="$dispatch('open-login-modal')" class="px-4 py-[6px] bg-[--color1-green] border-2 border-[--color1-green] font-semibold text-white rounded-[2px]">Ajouter aux Favoris</button>
                        </div>
                    @endguest

                    @auth()
                        @if(Cart::instance('wishlist')->content()->firstWhere('id', $this->product->id))
                        <button wire:click="addToWishlist({{ $product->id }})" class="px-4 py-[6px] text-[--color1-green] border-2 border-[--color1-green] font-semibold rounded-[2px]">Retirer des favoris</button>
                        @else
                        <button wire:click="addToWishlist({{ $product->id }})" class="px-4 py-[6px] bg-[--color1-green] border-2 border-[--color1-green] font-semibold text-white rounded-[2px]">Ajouter aux Favoris</button>
                        @endif
                    @endauth


                </div>
            </div>

            <p class="font-bold">Categorie: <span class="font-medium text-gray-500">{{$product->sousCategory->name}}</span></p>
            
            <livewire:interface-user.product.share-product :product="$product" />
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
    <div class="w-[100%] bg-[#f1f1f1] mb-20 pb-10">
        <div class="swiper products-slide w-[90%]" wire:ignore>
            <h2 class="text-3xl sofia text-center pt-5">Produits <span class="text-[--color2-yellow]">similaires</span></h2>
            <div class="swiper-wrapper flex justify-center pt-7 pb-10 mx-auto !important">
                @foreach($relatedProducts as $product)
                <div class="swiper-slide bg-[#fff] product-slide relative w-[220px] rounded-md shadow-md shadow-black/10 py-5">

                    <div class="productImgContent">
                        <img src="{{asset('storage/'. $product->image)}}" alt="{{$product->name}}" loading="lazy">
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
                                    {{ $product->prix_format }}
                                </p>
                            @endif
                            </span>
                        </div>
                        <div class="flex justify-center mt-2 gap-[6px]">
                            <a href="{{route('product.view', ['product' => $product])}}" class="btnPanier text-center border-[1px] border-[--color2-yellow] bg-[--color2-yellow] text-white px-2 py-[2px] rounded-full text-xs hover:text-[--color2-yellow] hover:bg-white flexCenter">
                                Voir
                            </a>
                            @auth()
                            <a href="{{route('buy.now', ['product'=>$product])}}" class="group-hover:text-green-800 btnPanier text-center border-[1px] border-green-800 bg-green-800 py-[2px] md:py-1 px-2 text-white hover:text-green-800 rounded-full group hover:bg-white text-xs">Commander</a>
                            @endauth

                            @guest 
                            <div class="" x-data="{loginModal: false}" x-cloak>
                                <button type="button" @click="$dispatch('open-login-modal')" class="btnPanier text-center border-[1px] border-green-800 bg-green-800 py-[2px] md:py-1 px-2 text-white hover:text-green-800 rounded-full group hover:bg-white text-xs">
                                    Commander
                                </button>
                            </div>
                            @endguest
                        </div>
                        
                    </div>
                </div>
                @endforeach
            </div>
     
            <div class="mt-5">
                <div class="swiper-pagination"></div>
                <div class="swiper-nav swiper-button-next"></div>
                <div class="swiper-nav swiper-button-prev"></div>
            </div>
        </div>
    </div>

    

  <!-- MODAL DE CONNEXTION ET INSCRIPTION -->
  <livewire:interface-user.auth.login-modal />
  <livewire:interface-user.auth.register-modal />

</div>

