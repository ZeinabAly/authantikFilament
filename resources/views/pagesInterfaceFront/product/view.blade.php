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


<div class="pageOneProduit">
    <!-- NAVIGATION -->
    @include('layouts.navigation')
    <livewire:interface-user.product.view-product :product="$product">
</div>




<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {

        const swiper = new Swiper('.swiper3', {
        effect: 'slide',
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: 'auto', // Changé pour s'adapter automatiquement
        // spaceBetween: 20,
        pagination: {
        el: '.swiper-pagination3',
        clickable: true,
        },
        
    });
    });
</script>
  
@livewireScripts

</body>
</html>