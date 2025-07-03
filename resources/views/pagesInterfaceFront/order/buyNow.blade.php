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

    <div class="pageCheckout pageOneProduit">
        @include('layouts.navigation')
        <!-- NAVIGATION -->
        <!-- FIN NAVIGATION -->

        <!-- FAIRE PASSER UN PARAMETRE DE L'URL DANS LE COMPOSANT -->
        <livewire:interface-user.order.buy-now-manager productId="{{ $product->id }}" />
    </div>

    <div class="footer">
        <livewire:interface-user.partials.footer />
    </div>

    @livewireScripts

</body>
</html>


