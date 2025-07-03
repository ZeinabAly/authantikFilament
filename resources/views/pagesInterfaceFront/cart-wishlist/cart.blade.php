
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

  <div class="pageCartProducts">
      <!-- NAVIGATION -->
      @include('layouts.navigation')
      <!-- FIN NAVIGATION -->

      <!-- BANNIERE -->
      <div class="h-[50vh] md:h-[50vh] relative mt-[90px]">
          <img src="{{asset('assets\images\pageIndex\cotelettes.jpg')}}" alt="image banniere page panier" class="h-full w-full object-cover relative">
          <div class="absolute bg-black/80 w-full h-full top-0 flex flex-col items-center justify-center">
              <h2 class="text-[3rem] text-white page-title sofia font-bold">Votre panier</h2>
              <p class="text-[--color2-yellow] font-bold"><a href="{{route('home.index')}}">Accueil</a> / Panier</p>
          </div>
      </div>
      <!-- FIN BANNIERE -->
      <div class="main">
      
      <div class="pt-90">
          @if(Cart::instance('cart')->content()->count() > 0)
          <!-- DEBUT ENTETE -->
          <section class="shop-checkout">
            <div class="checkout-steps">
              <a href="javascript:void(0)" class="checkout-steps__item active w-[80%] md:w-full">
                <span class="checkout-steps__item-number number1">01</span>
                <span class="checkout-steps__item-title number-1_title">
                  <span>Liste</span>
                  <em>Consultez votre liste d'articles</em>
                </span>
              </a>
              <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title hidden md:flex">
                  <span>Expédition et Paiement</span>
                  <em>Indiquez le moyen de paiement et livraison</em>
                </span>
              </a>
              <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title hidden md:flex">
                  <span>Confirmation</span>
                  <em>Votre Commande est passée</em>
                </span>
              </a>
            </div>
      
          </section>
          <!-- FIN ENTETE -->
      
          <livewire:interface-user.panier-wishlist.cart-manager />
          @else 
          <div class="p-10 flexColumn">
            <p class="text-xl font-bold">Panier vide</p>
            <a href="{{route('home.menu')}}" class="btnViderPanier">Retour au menu</a>
          </div>
          @endif
      </div>

  </div>    

  <div class="footer">
    <livewire:interface-user.partials.footer />
  </div>

  @livewireScripts

</body>
</html>

