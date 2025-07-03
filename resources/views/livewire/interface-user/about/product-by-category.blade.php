<div class="productByCategory">
    <div class="productByCategoryContent">
        <div class="titres">
            <p class="section-subtitle">Découvrez nos plats</p>
            <h2 class="section-title text-[2.5rem]">Notre menu</h2>
        </div>
        <!-- CATEGORIES -->
        <div class="listeCategories">
            <button class="list-item {{$selectedCategory === '' ? 'chk-cat' : ''}}"  wire:click="selectCategory('')">
                <span>Tout</span>
            </button>
            @foreach($sousCategories as $sousCategory)
            <button wire:click="selectCategory({{$sousCategory->id}})" class="list-item  {{$selectedCategory === $sousCategory->id ? 'chk-cat' : ''}}">
                <span>{{$sousCategory->name}}</span>
            </button>
            @endforeach
        </div>
    
        <!-- PRODUCTS -->
        <div class="aboutProducts products-slide">
            @foreach($products as $product)
                {{-- <livewire:interface-user.product.product-card :product=$product /> --}}
                 
                <div class="bg-[#fff] swiper-slide product-slide relative w-[220px] rounded-md shadow-md shadow-black/10">
                    <div class="wishlist absolute top-2 left-2 z-10 ">
                        @auth()
                        <button wire:click="addToWishlist({{$product ->id}})" class="coeur-vide">
                            @if(Cart::instance('wishlist')->content()->where('id', $product ->id)->count() > 0)
                                <x-icon name="heart-plein" fill="#ce9c2d"/>
                            @else
                                <x-icon name="heart-vide" fill="#585858" />
                            @endif
                        </button>
                        @endauth

                        @guest()
                        
                            <div class="" x-data="{loginModal: false}" x-cloak>
                                <button @click="$dispatch('open-login-modal')">
                                    <x-icon name="heart-vide" fill="#585858" />
                                </button>
                            </div>
                        @endguest

                    </div>
                    <div class="">
                        <a href="{{route('product.view', ['product' => $product ])}}" class="oeil bg-[#F0F0F0] md:py-2 md:px-2 px-1 py-1 rounded-full absolute top-2 right-2">
                            <x-icon name="eye-vide" size="16" fill="#706c6c" />
                        </a>
                    </div>

                    <div class="productImgContent">
                        <img src="{{asset('storage/'. $product ->image)}}" alt="{{$product ->name}}">
                    </div>

                    <div class="content relative mt-[10px]">
                        <div class="">
                            <p class="text-center font-semibold md:text-lg ">{{$product ->name}}</p>
                            <p class="hidden md:block text-center font-medium text-sm text-gray-400">{{$product ->sousCategory->name}}</p>
                        </div>
                        <div class="flex gap-2 justify-center font-semibold text-[13px]">
                            <span class="money price">
                            @if($product ->sale_price)
                                <s class="text-gray-400">{{str_replace(',','.',number_format($product ->regular_price, 0))}}</s> <span class="text-[--color2-yellow]">{{str_replace(',','.',number_format($product ->sale_price, 0))}} GNF</span>
                            @else
                                <p class="text-[--color2-yellow]">
                                {{str_replace(',','.',number_format($product ->regular_price, 0))}} GNF
                                </p>
                            @endif
                            </span>
                        </div>
                        <div class="flex justify-center mt-2 gap-[6px]">
                            
                            <!-- BOUTON AJOUTER AU PANIER -->
                            @auth()
                                @if(Cart::instance('cart')->content()->where('id', $product ->id)->count() > 0)
                                <button class="btnPanier text-center border-[1px] border-[--color2-yellow] hover:border-green-800 hover:bg-green-800 text-[--color2-yellow] px-2 rounded-full group text-xs block md:hidden"><a href="{{ route('cart.index') }}" class="group-hover:text-white">Voir</a></button>
                                <button class="btnPanier text-center border-[1px] border-[--color2-yellow] hover:border-green-800 hover:bg-green-800 text-[--color2-yellow] px-2 rounded-full group text-xs hidden md:block"><a href="{{ route('cart.index') }}" class="group-hover:text-white">Voir le panier</a></button>
                                @else
                                <button wire:click="addToCart({{$product ->id}})" class="btnPanier text-center border-[1px] border-[--color2-yellow] text-green-800 px-2 py-[2px] rounded-full group text-xs hover:text-white">
                                    <x-icon name="cart" fill="#ce9c2d" size="18" />
                                </button>
                                @endif
                            @endauth

                            @guest()
                            <div class="" x-data="{loginModal: false}" x-cloak>
                                <button @click="$dispatch('open-login-modal')" class="btnPanier text-center border-[1px] border-[--color2-yellow] text-green-800 px-2 py-[2px] rounded-full group text-xs hover:text-white">
                                    <x-icon name="cart" fill="#ce9c2d" size="18" />
                                </button>
                            </div>
                            @endguest
                            <!-- FIN AJOUTER AU PANIER -->

                            <!-- BOUTON COMMANDER -->
                            <div class="">
                                @auth()
                                <a href="{{route('buy.now', ['product'=>$product ])}}" class="group-hover:text-green-800 btnPanier text-center border-[1px] border-green-800 bg-green-800 py-[2px] md:py-1 px-2 text-white hover:text-green-800 rounded-full group hover:bg-white text-xs">Commander</a>
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
                </div>

            @endforeach
        </div>
        <a href="{{route('home.menu')}}" class="py-3 underline text-green-900 flex gap-2 items-center justify-center">
            <span>Voir tout</span>
            <x-icon name="fleche-right" fill="#000" class="underline"/>
        </a>

    </div>

    

  <!-- MODAL DE CONNEXTION ET INSCRIPTION -->
  <livewire:interface-user.auth.login-modal />
  <livewire:interface-user.auth.register-modal />

</div>
