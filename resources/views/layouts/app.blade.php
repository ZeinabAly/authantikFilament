<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('assets/images/faviconAuth.ico')}}" type="image/x-icon">
    <title>AUTHANTIK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>
<body>

    <div class="">
        <livewire:interface-user.partials.top-header />
    </div>
    
    <!-- NAVIGATION -->
    @include('layouts.navigation')
    <!-- FIN NAVIGATION -->

    <main class=" h-full bg-[#e8e8e8]">
        @yield('content')
    </main>

    <livewire:interface-user.partials.footer />

    <script src="https://unpkg.com/scrollreveal"></script>

    <script>

        // SCROLL REVEAL
        // Initialisation de ScrollReveal
        document.addEventListener('DOMContentLoaded', () => {
           

            const sr = ScrollReveal({
                origin: 'bottom', // Point d'origine de l'animation ('top', 'right', 'bottom', 'left')
                distance: '50px', // Distance parcourue par l'élément
                duration: 1000,   // Durée de l'animation (en ms)
                delay: 200,       // Délai avant de commencer l'animation (en ms)
                reset: true,      // Si 'true', l'animation se rejoue au scroll
            
            // Application de l'animation sur différents éléments
            sr.reveal('.revealTop', { origin: 'top', delay: 300 });
            sr.reveal('.revealLeft', { origin: 'left', distance: '100px', delay: 500 });
            sr.reveal('.revealBottom', { origin: 'bottom', delay: 400, duration: 1200 });
            sr.reveal('.revealRight', { origin: 'right', distance: '70px', delay: 600 });
    
    
            // topBottom
            const topBottom = ScrollReveal({
            distance: '50px',   // Distance de l'animation
            duration: 800,      // Durée de l'animation (en ms)
            easing: 'ease-out', // Effet de l'animation
            reset: true,        // Rejoue l'animation à chaque scroll
            });
    
            // Animation des éléments venant du haut
            topBottom.reveal('.from-top', {
            origin: 'top',     // Vient du haut
            interval: 200,     // Délai entre chaque élément
            });
    
            // Animation des éléments venant du bas
            topBottom.reveal('.from-bottom', {
            origin: 'bottom',  // Vient du bas
            interval: 200,     // Délai entre chaque élément
            });
            });
        })
    </script>


    @livewireScripts

</body>
</html>