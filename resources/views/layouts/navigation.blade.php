
@php
    $exceptRoutes = ['cart.index', 'cart.checkout', 'cart.order.confirmation', 'cart.wishlist', 'product.view', 'login', 'register', 'buy.now']; // toutes les routes où l'icône doit être noire
    $fillColor = request()->routeIs(...$exceptRoutes) ? '#000' : '#fff';
@endphp

<!-- NAVIGATION PETITS ECRAN -->
<div class="header-mobile" id="header-mobile">
    <div class="header-mobile-container">
        <div class="logo">
            
            <a href="{{route('home.index')}}">
                @if (!empty($settings->logo_path) && Storage::disk('public')->exists($settings->logo_path))
                    <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="logo" class="w-[150px]">
                @else
                    <img src="{{ asset('logoAuth.png') }}" alt="logo par défaut" class="w-[10px]">
                @endif
            </a>
        </div>

        <div class="">

        </div>
        <div class="open">
    

            <div class="icones">
                
                <livewire:interface-user.page-index.cart-counter />

            </div>

            <button class="nav-open-btn" id="openBtn">
                <span class="line line-1"></span>
                <span class="line line-2"></span>
                <span class="line line-3"></span>
            </button>
    
            <div class="overlay" data-nav-toggler data-overlay></div>
        </div>


        <!-- SIDEBAR -->
        <div class="header-sidebar">
            <div class="closeBtn">
                <span class="text-4xl">&times;</span>
            </div>
            <div class="navbar-logo mt-[30px] mb-[20px]">
                <a href="route('home.index')">
                    @if (!empty($settings->logo_path) && Storage::disk('public')->exists($settings->logo_path))
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="logo" class="w-[120px]">
                    @else
                        <img src="{{ asset('logoAuth.png') }}" alt="logo par défaut" class="w-[120px]">
                    @endif
                </a>
            </div>
            <nav class="navigation">
                <ul class="navbar-list">
                    <li class="navbar-item">
                        <a href="route('home.index')" class="Route::is('home.index') || Route::is('dashboard') ? 'navbar-active' : 'navbarlink'">
                            <span>Accueil</span>
                        </a>
                    </li>
                    <li class="navbar-item">
                    <a href="{{route('home.menu')}}" class="{{Route::is('home.menu') ? 'navbar-active' : 'navbarlink'}}">Menu</a>
                    </li>
                    <li class="navbar-item">
                    <a href="{{route('home.reservation')}}" class="{{Route::is('reservation.index') ? 'navbar-active' : 'navbarlink'}}">Reservation</a>
                    </li>
                    <li class="navbar-item">
                    <a href="{{route('home.about')}}" class="{{Route::is('home.about') ? 'navbar-active' : 'navbarlink'}}">A propos</a>
                    </li>
                    <li class="navbar-item">
                    <a href="{{route('home.contact')}}" class="{{Route::is('home.contact') ? 'navbar-active' : 'navbarlink'}}">Contact</a>
                    </li>
                </ul>
            </nav>

            <div class="mt-5 flexCenter">
                <livewire:interface-user.reservation.reservation-modal />
            </div>

            <div class="sidebar-infos">
                <p class="adresse">Dixinn Terasse</p>
                <p class="contact"><a href="#tel=629836668">629-83-66-67</a></p>
                <p class="email">authantik@gmail.com</p>
            </div>

        </div>
        <!-- FIN SIDEBAR -->
    </div>
</div>
<!-- FIN NAVIGATION PETITS ECRAN -->

<!-- HEADER GRANDS ECRANS -->

<header id="header" class="header">
    <div class="header-flex">

        
        <div class="header-right">
            <nav class="navigation">
                <ul class="navigation-list">
                    <li class="navigation-item">
                        <a href="{{route('home.index')}}" class="{{Route::is('home.index') ? 'navigation-active' : 'navlink' }} navlink">
                            <span>Accueil</span>
                        </a>
                    </li>
                    <li class="navigation-item">
                        <a href="{{route('home.menu')}}" class="{{ Route::is('home.menu') ? 'navigation-active' : 'navlink' }} navlink">Menu</a>
                    </li>
                    
                    <li class="navigation-item">
                        <a href="{{route('home.reservation')}}" class="{{ Route::is('home.reservation') ? 'navigation-active' : 'navlink' }} navlink">Reservation</a>
                    </li>
                    
                    <li class="navigation-item">
                        <a href="{{route('home.about')}}" class="{{ Route::is('home.about') ? 'navigation-active' : 'navlink' }} navlink">A propos</a>
                    </li>
                    <!-- logo -->
                    <div class="logo">
                        <a href="{{route('home.index')}}">
                        @if (!empty($settings->logo_path) && Storage::disk('public')->exists($settings->logo_path))
                            <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="logo" class="w-[150px]">
                        @else
                            <img src="{{ asset('logoAuth.png') }}" alt="logo par défaut" class="w-[150px]">
                        @endif
                        </a>
                    </div>
                    <!-- logo -->
                    <li class="navigation-item">
                        <a href="{{route('home.contact')}}" class="{{ Route::is('home.contact') ? 'navigation-active' : 'navlink' }} navlink">Contact</a>
                    </li>
                </ul>
            </nav>

            <!-- Button reserver -->
            
            <div class="">
                <livewire:interface-user.reservation.reservation-modal />
            </div>

            <div class="header-tools">
                <!-- ICONES USER, CART ET WISHLIST -->
                <livewire:interface-user.page-index.cart-counter />
                

                
            </div>
        </div>
        
    </div>
</header>