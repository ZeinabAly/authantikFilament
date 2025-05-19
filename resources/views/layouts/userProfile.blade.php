<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTHANTIK</title>
    <meta name="description" content="Site de Authantik Restaurant, un restaurant qui transforme chacune de vos bouchées en moment de plaisir ">
    <link rel="shortcut icon" href="{{asset('assets/images/faviconAuth.ico')}}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <main class="flex">
        <!-- SIDEBAR -->
        @include('partials.userSidebar')
        <!-- FIN SIDEBAR -->
        <div class="mainContent"> 
            <div class="">
                @include('partials.userProfileTopBar')
            </div>
            @yield('content')
        </div>
    </main>

    <!-- @livewireScripts -->
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>