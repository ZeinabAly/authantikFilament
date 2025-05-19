@extends('layouts.app')
@section('content')
<div class="pageAbout bg-gray-200">
    <!-- Banniere -->
    <div class="bgMenuBanner relative w-[100%] h-[250px] md:h-[400px]">
      <div class="w-[100%] h-[100%] relative">
          <img src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="image banniere menu" class="h-full w-full object-cover">
      </div>
      
      <div class="w-[100%] h-[100%] pt-5 absolute top-0 bg-black/80 flex items-center justify-center text-center">
          <p class="text-center text-white text-4xl md:text-4xl lg:text-5xl font-bold">A <span class="text-yellow1">PROPOS</span></p>
      </div>
    </div>  

    <!-- FIN BANNIERE -->

    <!-- SECTION1 -->
    <section class="section1Histoire">
        <div class="histoireTexteContent revealLeft">
            <h2 class="text-yellow1"><span class="text-yellow1 font-semibold text-4xl allura">Notre</span> <br /><span class="text-black text-[20px] font-bold uppercase">histoire</span></h2>
            <p class="text-gray-800 my-3 px-3 text-[16px] heading-[30px]"> Fondé avec passion et un profond respect pour la tradition gastronomique, Authentik est bien plus qu’un restaurant. C’est un lieu de rencontre où l’on célèbre l’amour de la bonne cuisine, la convivialité et l’art de vivre.</p>
            <button class="py-2 px-4 border-2 border-gray-600 rounded-sm">
                <a href="{{ route('home.about') }}" class="font-bold ">Découvrez notre histoire</a>
            </button>
        </div>
        <div class="h-full grid grid-cols-2 gap-2 gridImages">
            <img class="h-[180px] w-full object-cover rounded-md shadow-lg shadow-black/10" src="{{asset('assets/images/pageIndex/cotelettes.jpg')}}" alt="image banniere menu" class="h-full w-full object-cover">
            <img class="h-[180px] w-full object-cover rounded-md shadow-lg shadow-black/10" src="{{asset('assets/images/pageIndex/Poulet-Yassa.jpg')}}" alt="image banniere menu" class="h-full w-full object-cover">
            <img class="h-[180px] w-full object-cover rounded-md shadow-lg shadow-black/10" src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="image banniere menu" class="h-full w-full object-cover">
            <img class="h-[180px] w-full object-cover rounded-md shadow-lg shadow-black/10" src="{{asset('assets/images/pageIndex/jus-bissap.webp')}}" alt="image banniere menu" class="h-full w-full object-cover">
        </div>
    </section>
    <!--FIN  SECTION1 -->

    <!-- SECTION2 -->
    <section class="section2About">
        <div class="section2Cover">
            <div class="left">
                <p class="section-subtitle text-white">Des plats qui respirent</p>
                <h2 class="section-title text-[--color2-yellow]">Nos Valeurs</h2>
                <p class="text-gray-300 text-justify">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis, saepe obcaecati? Officia aliquid ea neque. Aspernatur, ratione exercitationem? Soluta laboriosam deleniti dolorem magni quaerat quas, eius asperiores illo non. Quae!</p>
                <div class="buttons">
                    <button class="btnAbout btnAbout1">
                        <a href="{{route('home.menu')}} ">Voir le menu</a>
                    </button>
                    <button class="btnAbout btnAbout2">
                        <a href="{{route('reservation.create')}} ">Réserver une table</a>
                    </button>
                </div>
            </div>
            <div class="right">
                <div class="border">
                    <img class="aboutImageBorder" src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="image banniere menu" class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </section>
    <!--FIN  SECTION2 -->
   
    <!-- SECTION3:PRODUCT PAR CATEGORY -->
        
        <livewire:interface-user.about.product-by-category />
    <!-- FIN SECTION3:PRODUCT PAR CATEGORY -->


    <!-- SECTION4: PARLER DE NOS SERVICES -->
    <section class="section4About">
        <div class="section4Content">
            <div class="zoneTexte">
                <div class="">
                    <p class="section-subtitle">Services</p>
                    <h2 class="section-title">Nous proposons les meilleurs services</h2>
                    <button class="btnAbout btnAbout2">
                        <a href="tel:+224629889895" class="flex items-center gap-2">
                            <x-icon name="phone" fill="#f2f2f2" class="hover:text-[--color2-yellow]"/>
                            <span class="text-[#f2f2f2] hover:text-[--color2-yellow]">Appelez nous</span>
                        </a>
                    </button>
                </div>
                <div class="texte">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus accusantium facere quibusdam aut magnam quod distinctio repellat impedit eveniet aliquid maxime, a quaerat debitis, tenetur enim expedita optio sunt. Nemo.</p>
                </div>
            </div>
            <div class="serviceGrid">
                <div class="service service1">
                    <h3 class="serviceTitre">Restauration</h3>
                    <p class="serviceTexte">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat nostrum voluptatem, laborum in repellendus commodi suscipit error</p>
                    <div class="imgContent"><img src="{{asset('assets/images/about/service1.jpg')}}" alt="service1" class="serviceImage" /></div>
                </div>
                <div class="service service2">
                    <h3 class="serviceTitre">Livraison</h3>
                    <p class="serviceTexte">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat nostrum voluptatem, laborum in repellendus commodi suscipit error</p>
                    <div class="imgContent"><img src="{{asset('assets/images/about/service2.png')}}" alt="service2" class="serviceImage" /></div>
                </div>
                <div class="service service3">
                    <h3 class="serviceTitre">Traiteur</h3>
                    <p class="serviceTexte">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat nostrum voluptatem, laborum in repellendus commodi suscipit error</p>
                    <div class="imgContent"><img src="{{asset('assets/images/about/service3.jpg')}}" alt="service3" class="serviceImage"/> </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FIN SECTION4: PARLER DE NOS SERVICES -->
    
    <!-- SECTION5: RESERVATION ET HORAIRE -->
    <div class="section5About relative">
        <img src="{{asset('assets/images/about/menu-unique-viande.webp')}}" alt="des assiettes de viande grillée" class="imgSection5"/>
        <div class="cover">
            <p class="section-subtitle">Ne vous faites pas attendre</p>
            <p class="section-title text-white">Horaires</p>
            <div class="horaires">
                <div class="horairesContent">
                    <div class="lundi-jeudi">
                        <h4>Lundi - Jeudi</h4>
                        <p>07:00</p>
                        <p>22:00</p>
                    </div>
                    <div class="vendredi-samedi">
                        <h4>Vendredi - Samedi</h4>
                        <p>10:00</p>
                        <p>00:00</p>
                    </div>
                </div>
                <div class="buttons">
                    <a href="{{route('reservation.create')}}"><button class="btnAbout btnAbout1">Réserver en ligne</button></a>
                    <a href="tel:+224629889895"><button class="btnAbout btnAbout2">Nous appeler</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN SECTION5: RESERVATION ET HORAIRE -->
</div>
@endsection