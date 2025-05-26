<div class="w-[100%] overflow-hidden relative">
    <!-- PRODUCT SLIDER PAGE INDEX -->
    <section  class="sectionProducts">
        <div class="swiper products-slide ">
            <div class="swiper-wrapper ">
                @foreach($slideProducts as $slideProduct)
                <livewire:interface-user.product.product-card :product=$slideProduct />
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


