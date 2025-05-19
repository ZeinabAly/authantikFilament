@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles
<div class="pageCheckout">
    <!-- ENTETE -->
    <section class="shop-checkout">
          <div class="checkout-steps">
            <a href="#" class="checkout-steps__item active md:w-full">
              <span class="checkout-steps__item-number number1">01</span>
              <span class="checkout-steps__item-title number-1_title">
                <span>Liste d'articles</span>
                <em>Consultez votre liste d'articles</em>
              </span>
            </a>
            <a href="#" class="checkout-steps__item active">
              <span class="checkout-steps__item-number number1">02</span>
              <span class="checkout-steps__item-title number-1_title">
                <span>Expédition et Paiement</span>
                <em>Indiquez le moyen de paiement et livraison</em>
              </span>
            </a>
            <a href="#" class="checkout-steps__item">
              <span class="checkout-steps__item-number">03</span>
              <span class="checkout-steps__item-title hidden md:flex">
                <span>Confirmation</span>
                <em>Votre Commande est passée</em>
              </span>
            </a>
          </div>
    
        </section>
    <!-- FIN ENTETE -->

    <!-- MODE DE PAYEMENT - MODE DE LIVRAISON - ADRESSE -->
    <div>
        <livewire:interface-user.panier-wishlist.checkout-manager />
    </div>
</div>

<div class="footer">
    @include('layouts.footer')
</div>

@livewireScripts
