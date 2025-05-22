<div class="productsPageMenu">
    <!----------- DEBUT SIDEBAR --------->
    <div class="menuSidebar">
        <ul class="categories">
            <h4 class="section-title">Categories</h4>
            <input type="radio" name="categorySidebar" checked id="tout" class="categorySidebar hidden">
            <li class="category-all">
                <label for="tout" type="button" wire:click="selectCategory('')" name="categorySidebar" class="chk-cat">
                    <span>Tout</span>
                    <span>{{$nbreProducts}}</span>
                </label>
            </li>
            @foreach($sousCategories as $sousCategory)
                <input type="radio" name="categorySidebar" id="{{$sousCategory->name}}" class="categorySidebar hidden">
                <li class="category-item">
                    <label for="{{$sousCategory->name}}" wire:click="selectCategory({{$sousCategory->id}})" class="chk-cat" value="{{$sousCategory->id}}">
                        <span>{{$sousCategory->name}}</span>
                        <span>{{$sousCategory->products->count()}}</span>
                    </label>
                </li>
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
                    <select name="order" id="" wire:model.change="order">
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
                        class="searchProduct w-full border p-2 rounded-sm flex bg-[#fff] relative" />

                    <!-- ICONE RECHERCHER -->
                    <div class="iconSearch absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#bcbcbc" height="18"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
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
                    <livewire:interface-user.product.product-card :product=$product />
                @endforeach
            @endif
            </div>

        <div>

        <!-- Pagination -->
        <div class="">
            {{ $products->links() }}
            {{-- $products->links('pagination::maPagination') --}}
        </div>
    </div>

    
</div>
