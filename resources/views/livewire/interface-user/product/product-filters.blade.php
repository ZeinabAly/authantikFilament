<div class="productsPageMenu">
    <!----------- DEBUT SIDEBAR --------->
    <div class="menuSidebar">
        <ul class="categories">
            <h4 class="section-title">Categories</h4>
            <button class="category-all category-item {{$selectedCategory === '' ? 'chk-cat' : ''}}"  wire:click="selectCategory('')">
                <span>Tout</span>
                <span>{{$nbreProducts}}</span>
            </button>
            @foreach($sousCategories as $sousCategory)
                <button wire:click="selectCategory({{$sousCategory->id}})" class="category-item  {{$selectedCategory === $sousCategory->id ? 'chk-cat' : ''}}">
                    <span>{{$sousCategory->name}}</span>
                    <span>{{$sousCategory->products->count()}}</span>
                </button>
            @endforeach
        </ul>
        
        <!-- PRODUITS A LA UNE -->
        <div class="fproducts">
            <h4 class="section-title">Top produits</h4>
            @foreach($featuredProducts as $fproduct)
                <div class="my-2">
                    <a href="{{route('product.view', ['product' => $fproduct]) }}">
                    <div class="fproductContent">
                        <div class="">
                        <img src="{{asset('storage/'. $fproduct->image)}}" alt="{{ $fproduct->name }}" class="image" >
                        </div>
                        <div class="leading-[25px]">
                        <p class="title">{{ $fproduct->name }}</p>
                        <div class="priceContent">
                            @if($fproduct->sale_price)
                            <s class="text-gray-400">{{str_replace(',','.',number_format($fproduct->regular_price, 0))}}</s> <span class="text-[--color2-yellow] font-bold">{{str_replace(',','.',number_format($fproduct->sale_price, 0))}} GNF</span>
                            @else
                            <p class="text-[--color2-yellow] font-bold">
                            {{str_replace(',','.',number_format($fproduct->regular_price, 0))}} GNF
                            </p>
                            @endif
                        </div>
                        <p class="sousCategory">{{ $fproduct->sousCategory->name }}</p>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- FIN PRODUITS A LA UNE -->
        
    </div>
    <!------------- FIN SIDEBAR ------------>



    <!-- Les produits -->
        <div class="shop-list">
            
            <!-- BARRE DE RECHERCHE - FIL D'ARIANE FILTRE SELECT -->
            <div class="recherche-filtres-ariane">
                <!-- FIL D'ARIANE -->
                <div class="filAriane">
                    <div class="breadcrumb mb-0 hidden lg:block">
                        <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase font-semibold text-yellow1">Accueil</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium text-gray-500">Menu</a>
                    </div>
                </div>
                
                <!-- FIN FILTRES -->

                <!-- BARRE DE RECHERCHE ET FILTRES -->
                <div class="flexCenter gap-3">

                <!-- FILTRES -->
                <div class="filtres">
                    <select name="order" id="" wire:model.change="order" class="border border-gray-300">
                        <option value="">Filtrer par </option>
                        <option value="name_asc">Ordre croissant</option>
                        <option value="name_desc">Ordre décroissant</option>
                        <option value="price_asc">Prix croissant</option>
                        <option value="price_desc">Prix décroissant</option>
                    </select>
                </div>

                <div class="max-w-[250px] min-w-[170px] relative text-sm">
                    <input type="search" placeholder="Rechercher ..."
                        wire:model.live.debounce.300ms="search"
                        class="searchProduct w-full border border-gray-300 py-2 pr-2 pl-7 rounded-sm flex bg-[#fff] relative" />

                    <!-- ICONE RECHERCHER -->
                    <div class="iconSearch absolute left-3">
                        <x-icon name="search" size="13" fill="#d2d2d2" />
                    </div>
                </div>
                </div>
            </div>
            <!-- FIN -->

            <!-- CATEGORIES -->
            <ul class="listeCategories">
                <input type="radio" name="listCat" checked id="list-item-all" class="listCat hidden">
                <li class="list-item list-item-all">
                    <label for="list-item-all" wire:click="selectCategory('')">Tout</label>
                </li>
                @foreach($sousCategories as $sousCategory)
                    <input type="radio" name="listCat" id="{{$sousCategory->id}}" class="listCat hidden" />
                    <li class="list-item">
                        <label for="{{$sousCategory->id}}" wire:click="selectCategory({{$sousCategory->id}})" class="menu-link py-1">
                            {{$sousCategory->name}}
                        </label>
                    </li>
                @endforeach
            </ul>

            <div class="products-list">
            @if($products->isEmpty())

                <div class="flexColumn gap-5">
                    
                    <p>{{$search ? 'Aucun produit trouvé pour '. $search : 'Aucun produit trouvé' }} </p>
                    <h2 class="section-title mt-4 text-3xl md:text-4xl">Produits suggérés</h2>
                    <div class="flexCenter flex-wrap gap-4">
                        @include('partials.menuProductSuggeres')
                    </div>
                </div>
            @else

                @foreach($products as $product)
                    {{--<livewire:interface-user.product.product-card :product=$product />--}}

                    
                        <div class="bg-[#fff] swiper-slide product-slide relative w-[220px] rounded-md shadow-md shadow-black/10">
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
                                    <x-icon name="eye-vide" size="16" fill="#706c6c" />
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

                @endforeach
            @endif
            </div>

        <div>

        <!-- Pagination -->
        <div class="w-[90%] mx-auto flex justify-end">
            {{ $products->links(data: ['scrollTo' => false]) }}
            {{-- $products->links('pagination::maPagination') --}}
        </div>
    </div>

    
</div>
