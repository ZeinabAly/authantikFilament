@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles

<div class="pageCheckout pageOneProduit">
    @include('layouts.navigation')
    <!-- NAVIGATION -->
    <!-- FIN NAVIGATION -->

    <!-- FAIRE PASSER UN PARAMETRE DE L'URL DANS LE COMPOSANT -->
    <livewire:interface-user.order.buy-now-manager productId="{{ $product->id }}" />
</div>

<div class="footer">
    @livewireScripts
    @include('layouts.footer')
</div>



