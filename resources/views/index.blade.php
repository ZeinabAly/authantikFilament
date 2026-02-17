@extends('layouts.app')
@section('content')


    <!-- MESSAGES D'ERREUR -->
    @if (session()->has('error'))
        <!-- Messages d'erreur -->
        <div class="relative" x-data="{showError: {{ session()->has('error') ? 'true' : 'false' }}}" x-cloak>
            <div x-show="showError" class="py-5 px-3 min-w-[300px] bg-white text-red-500 shadow-md font-semibold text-sm fixed z-[10000] top-3 right-3 flex items-center gap-2 rounded-md border-2 border-red-600">
                <x-icon name="warning" fill="#f20"/>
                {{ session('error') }}
                <button @click="showError = false" class="absolute top-2 right-2">
                    <x-icon name="btn-fermer" fill="#0d0d0d"/>
                </button>
            </div>
        </div>
    @endif

    <!-- Messages de succès -->

    @if (session()->has('success'))
    <div class="relative" x-data="{showSuccess: true}" x-cloak>
        <div x-show="showSuccess" class="py-5 px-3 min-w-[300px] bg-white text-green-700 shadow-md font-semibold text-sm fixed z-[10000] top-3 right-3 flex items-center gap-2 rounded-md border-2 border-green-600">
            <x-icon name="success" fill="#05821c"/>
            {{ session('success') }}
            <button @click="showSuccess = false" class="absolute top-2 right-2">
                <x-icon name="btn-fermer" fill="#0d0d0d"/>
            </button>
        </div>
    </div>
    @endif

<!-- BANNIERE PAGE ACCUEIL -->

<!-- HEADER-SLIDER -->
<section class="hero text-center" aria-label="home" id="home">

    <!-- LE NOMBRE DE SLIDER DANS LA BASE DE DONNEES DOIT ETRE SUPERIEUR A 2 SINON LE SYSTEME 
    LES IGNORE ET PREND LES SLIDERS PAR DEFAUT -->
    
    <ul class="hero-slider" data-hero-slider>
        
        @if($sliders->count() >= 2 )
            @foreach($sliders as $key => $slider)
            <li class="slider-item active" data-hero-slider-item>

                <div class="slider-bg">
                    <img src="{{asset('storage/'.$slider->image)}}" alt="image banniere {{$key}}" class="img-cover" loading="lazy">
                </div>

                <div class="cover">
                    <p class="label-2 section-subtitle slider-reveal">{{$slider->sous_titre}}</p>
            
                    <h1 class="display-1 hero-title slider-reveal">
                        {{$slider->titre}}
                    </h1>
            
                    <p class="body-2 hero-text slider-reveal">
                        {{$slider->texte}}
                    </p>
            
                    @if($slider->linkButton == "home.reservation")
                        <div class="" x-data="{openReservation: false}" x-cloak>
                            <button type="button" @click="$dispatch('open-reservation')" class="btn btn-primary slider-reveal">
                                <span class="text text-1">Réserver une table</span>
                            </button>
                        </div>
                    @else
                        <a href="{{ route($slider->linkButton) }}" class="btn btn-primary slider-reveal">
                        <span class="text text-1">{{$slider->textButton}}</span>
                    @endif
            
                    </a>

                </div>

            </li>
            @endforeach
        @else
            <li class="slider-item active" data-hero-slider-item>

                <div class="slider-bg">
                    <img src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="image foutou banane" class="img-cover" loading="lazy">
                </div>

                <div class="cover">
                    <p class="label-2 section-subtitle slider-reveal">Saveurs authentitiques</p>
            
                    <h1 class="display-1 hero-title slider-reveal">
                    Bienvenue chez <br>
                    Authantik
                    </h1>
            
                    <p class="body-2 hero-text slider-reveal">
                    Un voyage culinaire exceptionnel vous attend
                    </p>
            
                    <a href="{{ route('home.menu') }}" class="btn btn-primary slider-reveal">
                    <span class="text text-1">Voir Notre Menu</span>
            
                    </a>

                </div>

            </li>

            <li class="slider-item" data-hero-slider-item>

                <div class="slider-bg">
                    <img src="{{asset('assets/images/pageIndex/tori.jpg')}}" width="1880" height="950" alt="" class="img-cover" loading="lazy">
                </div>

                <div class="cover">
                    <p class="label-2 section-subtitle slider-reveal">Experience délicieuse</p>
            
                    <h1 class="display-1 hero-title slider-reveal">
                    Découvrez nos plats <br>
                    savoureux
                    </h1>
            
                    <p class="body-2 hero-text slider-reveal">
                    Des recettes parfaites pour eveiller vos pupilles
                    </p>
            
                    <a href="{{route('home.menu')}}" class="btn btn-primary slider-reveal">
                    <span class="text text-1">Découvrez nos plats</span>
            
                    <!-- <span class="text text-2" aria-hidden="true">View Our Menu</span> -->
                    </a>
                </div>

            </li>

            <li class="slider-item" data-hero-slider-item>

                <div class="slider-bg">
                    <img src="{{asset('assets/images/pageIndex/cotelettes.jpg')}}" width="1880" height="950" alt="" class="img-cover" loading="lazy">
                </div>

                <div class="cover">
                    <p class="label-2 section-subtitle slider-reveal">Un cadre chaleureux et acceuillant</p>
            
                    <h1 class="display-1 hero-title slider-reveal">
                    Vivez une expérience <br>
                    Mémorable
                    </h1>
            
                    <p class="body-2 hero-text slider-reveal">
                    Venez en famille et savourez la joie d'une cuisine délicieuse
                    </p>
            
                    <div class="" x-data="{openReservation: false}" x-cloak>
                        <button type="button" @click="$dispatch('open-reservation')" class="btn btn-primary slider-reveal">
                            <span class="text text-1">Réserver une table</span>
                        </button>
                    </div>
                </div>

            </li>
        @endif


    </ul>

    <button class="slider-btn prev" aria-label="slide to previous" data-prev-btn>
        <x-icon name="angle-left" color="#ccc" fill="#ccc" size="20" class="angles" />
    </button>

    <button class="slider-btn next" aria-label="slide to next" data-next-btn>
        <x-icon name="angle-right" color="#ccc" fill="#ccc" size="20" class="angles" />
    </button>

</section>
<!-- FIN BANNIERE PAGE ACCUEIL -->


<!-- PRODUCTS SLIDE: SECTION1 ET LES MODALES DE CONNEXIONS POUR LES NON CONNECTES -->

<livewire:interface-user.page-index.product-manager />
<livewire:interface-user.auth.login-modal />
<livewire:interface-user.auth.register-modal />

<!-- FIN SECTION 1 -->



<!-- SECTION2: QUI SOMMES-NOUS -->
<section class="w-[95%] md:w-[90%] lg:w-[80%] mx-auto md:pt-5">
    <div class="w-[100%] grid grid-cols-1 md:grid-cols-2 gap-[20px] justify-center">
        <div class="w-[100%] md:py-5 py-3 border-[4px] border-[var(--color2-yellow)] bg-white text-center shadow-lg rounded-sm flex flex-col items-center justify-center revealLeft">
            <h2 class="text-yellow1"><span class="text-yellow1 font-semibold text-4xl allura">Qui sommes</span> <br /><span class="text-black text-[20px] font-bold">NOUS ?</span></h2>
            <p class="text-gray-800 my-3 px-3 text-[16px] heading-[30px]"> Fondé avec passion et un profond respect pour la tradition gastronomique, Authentik est bien plus qu’un restaurant. C’est un lieu de rencontre où l’on célèbre l’amour de la bonne cuisine, la convivialité et l’art de vivre.</p>
            <button class="py-2 px-4 border-2 border-gray-600 rounded-sm">
                <a href="{{ route('home.about') }}" class="font-bold ">Découvrez notre histoire</a>
            </button>
        </div>
        <div class="w-[100%] shadow-lg revealRight hidden md:block">
            <img src="{{asset('assets/images/pageIndex/cuisine.jpg')}}" alt="cuisine" class="w-[100%] h-[100%] object-cover rounded-sm" loading="lazy">
        </div>
    </div>
</section>
<!-- FIN SECTION 2 -->



<!-- SECTION3: GALLERY -->
<section class="section3Accueil">
    <div class="h-[350px] pt-7 leading-[30px]">
        <h3 class="font-medium text-center text-3xl px-3 revealTop">Un aperçu de nos créations culinaires</h3>
        <p class="w-[80%] lg:w-[60%] mx-auto text-center revealLeft text-[15px] md:text-sm md:text-[16px] md:mt-5 leading-[30px] md:leading-[30px]">Chaque assiette est une oeuvre d'art, autant pour les yeux que pour les papilles. Une image vaut mille mots et nos plats valent mille saveurs. Laissez vous séduire par un aperçu de ce que vous attendez chez <span class="font-bold text-yellow1">AUTHANTIK</span></p>
    </div>
    <div class="galleryAccueil">
        <div class="boxes">
            <div class="boxImage box from-top">
                <img class="w-full h-full object-cover rounded-sm" src="{{asset('assets/images/pageIndex/tori.jpg')}}" alt="">
            </div>
            <div class="boxImage from-bottom">
                <img class="w-full h-full object-cover rounded-sm" src="{{asset('assets/images/pageIndex/cotelettes.jpg')}}" alt="">
            </div>
            <div class="boxImage box from-top">
                <img class="w-full h-full object-cover rounded-sm" src="{{asset('assets/images/pageIndex/jus-bissap.webp')}}" alt="">
            </div>
            <div class="boxImage from-bottom">
                <img class="w-full h-full object-cover rounded-sm" src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="">
            </div>
        </div>

        <h1 class="font-medium text-center text-3xl text-white">bon Appétit ! </h1>
    </div>
</section>
<!-- FIN SECTION3 -->


<!-- SECTION6: EXPERIENCE CULINAIRE -->
<section class="w-[95%] md:w-[90%] lg:w-[80%] mx-auto my-7">
    <div class="w-[100%] grid grid-cols-1 md:grid-cols-2 gap-[20px] justify-center">
        <div class="w-[100%] flex gap-[7px]">
            <img src="{{asset('assets/images/pageIndex/tori.jpg')}}" alt="cuisine" class="w-[49%] h-[100%] shadow-lg object-cover rounded-sm from-top " loading="lazy">
            <img src="{{asset('assets/images/pageIndex/cotelettes.jpg')}}" alt="cuisine" class="w-[49%] h-[100%] shadow-lg object-cover rounded-sm from-bottom" loading="lazy">
        </div>
        <div class="w-[100%] py-5 border-[4px] border-[var(--color2-yellow)] text-center shadow-lg rounded-sm revealRight bg-white">
            <h2 class="text-yellow1 "><span class="allura text-4xl font-semibold">Expérience</span> <br /><span class="text-black font-bold text-[20px]">CULINAIRE</span></h2>
            <p class="text-gray-800 my-3 px-3 text-[16px] heading-[30px]"> Fondé avec passion et un profond respect pour la tradition gastronomique, Authentik est bien plus qu’un restaurant. C’est un lieu de rencontre où l’on célèbre l’amour de la bonne cuisine, la convivialité et l’art de vivre.</p>
            <button class="py-2 px-4 border-2 border-black rounded-sm">
                <a href="{{ route('home.about') }}" class="font-bold ">Découvrez notre histoire</a>
            </button>
        </div>
        
    </div>
</section>
<!-- FIN SECTION 6 -->

<!-- CATEGORIES POPULAIRE -->
<section class="sectionProducts bg-[#f1f1f1]">
    <h2 class="text-yellow1 text-center mb-3"><span class="allura text-4xl font-semibold">Top</span> <span class="text-gray-800 font-bold text-[20px]">CATEGORIES</span></h2>
    <div class="products-slide flexCenter gap-4 flex-wrap">

    @foreach($categories as $category)
    <a href="{{route('home.menu', ['categories' => $category->name ])}}" class="bg-[#fff] product-slide relative rounded-md shadow-md shadow-black/10 revealTop">
        <div class="productImgContent">
            <img src="{{asset('storage/'.$category->image)}}" alt="{{$category->name}}" loading="lazy">
        </div>
        
        <div class="content relative mt-[10px] md:mt-[20px]">
            <div class="">
                <p class="text-center font-semibold md:text-lg ">{{$category->name}}</p>
                <p class="text-center font-medium text-sm text-gray-400">{{$category->name}}</p>
            </div>
            
        </div>
    </a>
    @endforeach
    </div>
</section>
<!-- FIN CATEGORIES POPULAIRE -->

<!-- SECTION: POURQUOI NOUS -->
<section class="section features text-center bg-[#e1e1e1] py-3" aria-label="features">
    <div class="mx-[10%] md:mx-3 p5-10 mb-5">

        <p class="section-subtitle">Pourquoi Nous Choisir ? </p>

        <h2 class="headline-1 text-gray-800 font-bold text-3xl md:text-4xl mb-10">Notre Force</h2>

        <ul class="grid-list">

            <li class="feature-item revealLeft">
                <div class="feature-card">

                <div class="card-icon">
                    <img src="{{ asset('assets/images/icones/icons8-fruits.png') }}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Alimentation saine</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy <br /> printing and typesetting.</p>

                </div>
            </li>

            <li class="feature-item from-top">
                <div class="feature-card">

                <div class="card-icon">
                    <img src="{{ asset('assets/images/icones/icons8-table-de-restaurant.png') }}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Environnement frais</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy <br /> printing and typesetting.</p>

                </div>
            </li>

            <li class="feature-item from-bottom">
                <div class="feature-card">

                <div class="card-icon">
                    <img src="{{ asset('assets/images/icones/icons8-cuisinier-homme.png') }}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Des chefs qualifiés</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy <br /> printing and typesetting.</p>

                </div>
            </li>

            <li class="feature-item revealRight">
                <div class="feature-card">

                <div class="card-icon">
                    <img src="{{ asset('assets/images/icones/icons8-serveur.png') }}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Un service rapide</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy <br /> printing and typesetting.</p>

                </div>
            </li>

        </ul>


    </div>
</section>

<!-- FIN POURQUOI NOUS -->


<!-- CAROUSEL DES MEMBRES DE L'EQUIPE -->
@include('layouts.carouselEquipe')



<!-- INTEGRER LES VIDEOS FACOBOOK  -->
<section class="sectionVideosFacebook">
    <h3 class="text-center text-4xl"><span class="text-black font-bold">Découvrez nos vidéos</span> <br /> <span class="allura font-semibold text-[--color2-yellow]">Facebook</span></h3>
    <p class="mb-10 text-center md:max-w-[70%] max-w-[90%] mx-auto text-semibold">Plongez dans notre univers à travers une sélection de vidéos exclusives directement issues de notre page Facebook. Pour ne rien manquer de nos actualités, événements et coulisses, n’hésitez pas à visiter notre page Facebook et à nous suivre !</p>
    
    <div class="videosGrid">
        @if($settings?->facebookVideos)
            @foreach($settings->facebookVideos as $video)
                <div class="video-wrapper">{!! $video !!}</div>
            @endforeach
        @endif   
    </div>

</section>

<!-- TESTIMONIAL -->
@include('layouts.testimonial')

@endsection