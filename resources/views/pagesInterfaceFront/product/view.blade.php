@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles

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