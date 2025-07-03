
<div class="flex gap-4">
    @if(request()->routeIs(['cart.index','buy.now', 'cart.checkout', 'cart.wishlist', 'cart.order.confirmation', 'product.view', 'login', 'register', 'password.request', 'password.reset']))
    <!-- Icone user -->
    <div class="">
        @guest()
        <div class="header-tools__item hover-container">
            <a href="{{ route('login') }}">
                <x-icon name="user-vide" fill="#000" size="20" class="userLogin headerIcon" />
            </a>
        </div>
        @endguest
        @auth()
        <div class="header-tools__item hover-container">
            <a href="{{ Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Manager', 'Caissier', 'Serveur']) ? route('filament.admin.pages.dashboard'):route('filament.client.pages.dashboard') }}" class="header-tools__item header-tools__cart relative">
                <!-- <span class="pr-6px">{{Auth::user()->name}}</span>   -->
                <x-icon name="user-plein" fill="#000" size="20" class="userLogin headerIcon relative" />
                <span class="cart-amount">
                    {{ $userNotifs }}
                </span>
            </a>
        </div>
        @endauth
    </div>
    <div class="">
        <a href="{{ route('cart.index') }}" class="header-tools__item header-tools__cart relative" data-aside="cartDrawer">

            <x-icon name="cart" size="22" fill="#000" wire:ignore class="headerIcon panier relative"/>
            <span class="cart-amount">
                {{ $cartCount }}
            </span>
        </a>
    </div>

    <div class="">
        <a href="{{ route('cart.wishlist') }}" class="header-tools__item header-tools__cart relative" data-aside="cartDrawer">

            <x-icon name="heart-plein" size="22" fill="#000" wire:ignore class="headerIcon panier wishlist relative"/>
            <span class="cart-amount">
                {{ Cart::instance('wishlist')->content()->count() }}
            </span>
            
        </a>
    </div>
    @else
    <!-- Icone user -->
    <div class="">
        @guest()
        <div class="header-tools__item hover-container">
            <a href="{{ route('login') }}">
                <x-icon name="user-vide" fill="#fff" size="20" class="userLogin headerIcon" />
            </a>
        </div>
        @endguest
        @auth()
        <div class="header-tools__item hover-container">
            <a href="{{ Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Manager', 'Caissier', 'Serveur']) ? route('filament.admin.pages.dashboard'):route('filament.client.pages.dashboard') }}" class="header-tools__item header-tools__cart relative">
                <!-- <span class="pr-6px">{{Auth::user()->name}}</span>   -->
                <x-icon name="user-plein" fill="#fff" size="20" class="userLogin headerIcon relative" />
                <span class="cart-amount">
                    {{ $userNotifs }}
                </span>
            </a>
        </div>
        @endauth
    </div>
    <div class="">
        <a href="{{ route('cart.index') }}" class="header-tools__item header-tools__cart relative" data-aside="cartDrawer">

            <x-icon name="cart" size="22" fill="#fff" wire:ignore class="headerIcon panier relative"/>
            <span class="cart-amount">
                {{ $cartCount }}
            </span>
        </a>
    </div>

    <div class="">
        <a href="{{ route('cart.wishlist') }}" class="header-tools__item header-tools__cart relative" data-aside="cartDrawer">

            <x-icon name="heart-plein" size="22" fill="#fff" wire:ignore class="headerIcon panier wishlist relative"/>
            <span class="cart-amount">
                {{ Cart::instance('wishlist')->content()->count() }}
            </span>
            
        </a>
    </div>
    @endif
</div>
