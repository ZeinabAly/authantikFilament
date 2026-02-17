<div>

    <!-- DEBUT SIDEBAR -->
    <div class="shop-sidebar side-sticky px-10 mt-10" id="shopFilter">
        <div class="aside-header d-flex d-lg-none align-items-center">
            <h3 class="text-uppercase fs-6 mb-0">Filtrer Par</h3>
            <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>

        <div class="pt-4 pt-lg-0"></div>

        <!-- Section des filtres -->
        <div class="accordion" id="categories-list">
            <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-1">
                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                Categories
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                    </g>
                </svg>
                </button>
            </h5>
            <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                <div class="accordion-body px-0 pb-0 pt-3">
                <ul class="list list-inline mb-0">
                @foreach($sousCategories as $sousCategory)
                    <li class="list-item" >
                    <span class="menu-link py-1" >
                        <input type="checkbox" wire:click="add({{$sousCategory->id}})" name="categories" class="chk-cat" value="{{$sousCategory->id}}" @if(in_array($sousCategory->id, explode(',', $sousCategories))) checked @endif>
                        {{$sousCategory->name}}
                    </span>
                    <span class="text-right float-end" >
                        {{$sousCategory->products->count()}}
                    </span>
                    </li>
                @endforeach
                </ul>
                </div>
            </div>
            </div>
        </div>

        <!-- Filtre de prix -->
        <div class="accordion" id="price-filters">
            <div class="accordion-item mb-4">
            <h5 class="accordion-header mb-2" id="accordion-heading-price">

                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                Prix
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                    </g>
                </svg>
                </button>
            </h5>
            
            <!-- Slider de prix avec wire:ignore pour éviter les conflits -->
            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                aria-labelledby="accordion-heading-price" 
                data-bs-parent="#price-filters">
    
                <div class="product-filter">
                    <div class="custom-wrapper">

                        <div class="price-input-container">
                            
                            <div class="slider-container">
                                <div class="price-slider">
                                </div>
                            </div>
                        </div>

                        <!-- Slider -->
                        <div class="range-input">
                            <input type="range" 
                                class="min-range" 
                                min="{{$minPrice}}" 
                                max="{{$maxPriceValue}}" 
                                value="{{$minPrice}}" 
                                step="5000">
                            <input type="range" 
                                class="max-range" 
                                min="{{$minPrice}}" 
                                max="{{$maxPriceValue}}" 
                                value="{{$maxPrice}}" 
                                step="5000">
                        </div>
                        <!-- Afficher les prix -->
                        <div class="price-input">
                            <div class="price-field">
                                <h4>Min</h4>
                                <span class="min-input">{{$minPrice}}</span>
                            </div>
                            <div class="price-field">
                                <h4>Max</h4>
                                <span class="max-input">{{$maxPrice}}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>

        
       <livewire:interface-user.product.price-range-filter  />

        <div class="mt-10 accordion" id="top-products-filters">
            <div class="accordion-item mb-4">
            <h5 class="accordion-header mb-2" id="accordion-heading-price">
                <button class="accordion-button pb-2 p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                Top Produits
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                    </g>
                </svg>
                </button>
            </h5>

            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
            
                <div class="">
                @foreach($featuredProducts as $fproduct)
                <div class="my-2">
                    <a href="route('menu.product.details', ['product_slug' => $fproduct->slug]) }}">
                    <div class="flex gap-2 items-center border-b-2 border-gray-700 pb-2">
                        <div class="">
                        <img src="{{asset('storage/'. $fproduct->image)}}" alt="{{ $fproduct->name }}" class="w-[80px] h-[75px] object-cover rounded-sm shadow-md border-[1px]  border-gray-300" loading="lazy">
                        </div>
                        <div class="leading-[25px]">
                        <p class="font-bold">{{ $fproduct->name }}</p>
                        @if($fproduct->sale_price)
                            <s class="text-gray-400 text-sm font-bold">{{str_replace(',','.',number_format($fproduct->regular_price, 0))}}</s> <span class="text-orange-500">{{str_replace(',','.',number_format($fproduct->sale_price, 0))}} GNF</span>
                            @else
                            <p class="text-orange-500 font-bold">
                            {{str_replace(',','.',number_format($fproduct->regular_price, 0))}} GNF
                            </p>
                            @endif
                        <p class="text-gray-400 text-xs font-bold">{{ $fproduct->sousCategory->name }}</p>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
                </div>
            </div>
            </div>
        </div>
            
    </div>

    <!-- FIN SIDEBAR -->

    <div class="relative max-w-xl w-full">
        <div>
            <input type="range"
                   wire:model.live="minPrice"
                   step="100"
                   min="{{ $min }}"
                   max="{{ $max }}"
                   wire:change="updatedMinPrice"
                   class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

            <input type="range"
                   wire:model.live="maxPrice"
                   step="100"
                   min="{{ $min }}"
                   max="{{ $max }}"
                   wire:change="updatedMaxPrice"
                   class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

            <div class="relative z-10 h-2">
                <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>
                
                <div class="absolute z-20 top-0 bottom-0 rounded-md bg-green-300" 
                     style="right: {{ $maxThumb }}%; left: {{ $minThumb }}%"></div>

                <div class="absolute z-30 w-6 h-6 top-0 left-0 bg-green-300 rounded-full -mt-2 -ml-1" 
                     style="left: {{ $minThumb }}%"></div>

                <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-green-300 rounded-full -mt-2 -mr-3" 
                     style="right: {{ $maxThumb }}%"></div>
            </div>
        </div>

        <div class="flex justify-between items-center py-5">
            <div>
                <input type="text"
                       wire:model.live="minPrice"
                       wire:change="updatedMinPrice"
                       maxlength="5"
                       class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
            </div>
            <div>
                <input type="text"
                       wire:model.live="maxPrice"
                       wire:change="updatedMaxPrice"
                       maxlength="5"
                       class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
            </div>
        </div>
    </div>

    <!-- Affichage des produits filtrés -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        @foreach($products as $product)
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ number_format($product->price, 2) }} €</p>
                <!-- Ajoutez d'autres détails du produit ici -->
            </div>
        @endforeach
    </div>

    <style>
        input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 24px;
            height: 24px;
            -webkit-appearance: none;
        }
    </style>
</div>