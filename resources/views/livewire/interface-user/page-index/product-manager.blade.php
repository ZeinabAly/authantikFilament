<div class="w-[100%] overflow-hidden relative">
    <!-- PRODUCT SLIDER PAGE INDEX -->
    <section  class="sectionProducts">
        <div class="swiper products-slide">
            <div class="swiper-wrapper flex">
                @foreach($slideProducts as $product)
                <div class="swiper-slide bg-[#fff] product-slide relative w-[220px] rounded-md shadow-md shadow-black/10 py-5">

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

            <div class="mt-10">
                <div class="swiper-pagination"></div>
                <div class="swiper-nav swiper-button-next"></div>
                <div class="swiper-nav swiper-button-prev"></div>
            </div>
    
            <div class="">
                <a href="{{route('home.menu')}}" class="py-3 underline text-green-900 flex gap-2 items-center justify-center">
                    <span>Voir tous les produits</span>
                    <x-icon name="fleche-right" fill="#000" class="underline"/>
                </a>
            </div>

        </div>  
    </section> 

</div>



