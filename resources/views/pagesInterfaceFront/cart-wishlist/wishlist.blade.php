<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTHANTIK</title>
    <link rel="shortcut icon" href="{{asset('assets/images/faviconAuth.ico')}}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>

    <div class="pageWishlist">
        
        <!-- NAVIGATION -->
        @include('layouts.navigation')
        <!-- FIN NAVIGATION -->

        <!-- BANNIERE -->
        <div class="h-[50vh] md:h-[50vh] relative mt-[90px]">
            <img src="{{asset('assets\images\pageIndex\cotelettes.jpg')}}" alt="image banniere page panier" class="h-full w-full object-cover relative" loading="lazy">
            <div class="absolute bg-black/80 w-full h-full top-0 flex flex-col items-center justify-center">
                <h2 class="text-[3rem] text-white page-title sofia font-bold">Liste des favoris</h2>
                <p class="text-[--color2-yellow] font-bold"><a href="{{route('home.index')}}">Accueil</a> / Favoris</p>
            </div>
        </div>
        <!-- FIN BANNIERE -->
        
        <livewire:interface-user.panier-wishlist.wishlist-manager /> 
    </div>   

    <div class="footer">
        <livewire:interface-user.partials.footer />
    </div>
    
@livewireScripts

</body>
</html>