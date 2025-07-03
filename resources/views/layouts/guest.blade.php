<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('assets/images/faviconAuth.ico')}}" type="image/x-icon">

        <title>AUTHANTIK</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="pageCartProducts">
            <!-- NAVIGATION -->
            @include('layouts.navigation')

            <div class="min-h-screen py-20 flexCenter bg-[#e8e8e8] dark:bg-gray-900 mt-[100px]">
                <div class="sm:min-w-[450px] min-w-[90%] rounded-xl shadow-md bg-white rounded-xl flexCenter">
                    <div class="w-full p-8 flexColumn gap-7" >
                        <!-- <div class="">
                            <a href="/">
                                <img src="{{asset('logoAuth.png')}}" alt="logo du site" class="w-[130px] object-cover">
                            </a>
                        </div> -->
                        
                        <div class="w-full md:w-[90%] mx-auto pt-7">
                            {{ $slot }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>
