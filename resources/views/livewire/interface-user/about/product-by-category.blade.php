<div class="productByCategory">
    <div class="productByCategoryContent">
        <div class="titres">
            <p class="section-subtitle">Découvrez nos plats</p>
            <h2 class="section-title text-[2.5rem]">Notre menu</h2>
        </div>
        <!-- CATEGORIES -->
        <ul class="listeCategories">
            <input type="radio" name="categories" id="tout" checked class="hidden categoryAbout">
            <li class="list-item list-item-all cursor-pointer">
                <label for="tout" wire:click="sousCatUpdate('')" class="">Tout</label>
            </li>
            @foreach($sousCategories as $sousCategory)
                <input type="radio" name="categories" id="{{$sousCategory->id}}" class="hidden categoryAbout">
                <li class="list-item">
                    <label for="{{$sousCategory->id}}" class="menu-link py-1" >
                        <p type="button" wire:click="sousCatUpdate({{$sousCategory->id}})" name="categories" class="chk-cat" value="{{$sousCategory->id}}">
                        {{$sousCategory->name}}
                        </p>
                    </label>
                </li>
            @endforeach
        </ul>
    
        <!-- PRODUCTS -->
        <div class="aboutProducts products-slide">
            @foreach($products as $product)
                <livewire:interface-user.product.product-card :product=$product />
            @endforeach
        </div>
        <a href="{{route('home.menu')}}" class="py-3 underline text-green-900 flex gap-2 items-center justify-center">
            <span>Voir tout</span>
            <x-icon name="fleche-right" fill="#000" class="underline"/>
        </a>

    </div>
</div>
