@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles

<div class="pt-90">
    <!-- DEBUT ENTETE -->
    <section class="shop-checkout">
      <div class="checkout-steps">
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number number1">01</span>
          <span class="checkout-steps__item-title number-1_title hidden md:flex">
            <span>Liste</span>
            <em>Consultez votre liste d'articles</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number number1">02</span>
          <span class="checkout-steps__item-title number-1_title hidden md:flex">
            <span>Expédition et Paiement</span>
            <em>Indiquez le moyen de paiement et livraison</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item active w-[80%] md:w-full">
          <span class="checkout-steps__item-number number1">03</span>
          <span class="checkout-steps__item-title number-1_title">
            <span>Confirmation</span>
            <em>Votre Commande est passée</em>
          </span>
        </a>
      </div>

    </section>
    <!-- FIN ENTETE -->

    <main class="">
        <livewire:interface-user.panier-wishlist.order-confirmation />
    </main>
  @livewireScripts
</div>