
@php
    $exceptRoutes = ['cart.index', 'cart.checkout', 'cart.order.confirmation', 'cart.wishlist', 'product.view', 'login', 'register', 'buy.now']; // toutes les routes où l'icône doit être noire
    $fillColor = request()->routeIs(...$exceptRoutes) ? '#000' : '#fff';
@endphp

<div class="flex gap-4">
    <div class="">
        <a href="{{ route('cart.index') }}" class="header-tools__item header-tools__cart relative" data-aside="cartDrawer">

            <x-icon name="cart" size="22" :fill="$fillColor" class="headerIcon panier relative"/>
            <span class="cart-amount">
                {{ $cartCount }}
            </span>
        </a>
    </div>

    <div class="">
        <a href="{{ route('cart.wishlist') }}" class="header-tools__item header-tools__cart relative" data-aside="cartDrawer">

            <x-icon name="heart-plein" size="22" :fill="$fillColor" class="headerIcon panier wishlist relative"/>
            <span class="cart-amount">
                {{ Cart::instance('wishlist')->content()->count() }}
            </span>
            
        </a>
    </div>
</div>
