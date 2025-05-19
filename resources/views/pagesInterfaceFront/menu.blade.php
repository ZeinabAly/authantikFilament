@extends('layouts.app')
@section('content')

<div class="">

    <div class="flex justify-end">
      @if(Session::has('cartVide'))
      <p class="absolute z-[1000] top-[40px] min-w-[300px] px-3 py-5 text-red-500 bg-white font-bold rounded-md">
        {{Session::get('cartVide')}}
      </p>
      @endif
    </div>

    <!-- Banniere -->
    <div class="bgMenuBanner relative w-[100%] h-[250px] md:h-[330px]">
      <div class="w-[100%] h-[100%] relative">
          <img src="{{asset('assets/images/pageIndex/tori.jpg')}}" alt="image banniere menu" class="h-full w-full object-cover">
      </div>
      
      <div class="w-[100%] h-[100%] pt-5 absolute top-0 bg-black/80 flex items-center justify-center text-center">
          <p class="text-center text-white text-4xl md:text-4xl lg:text-5xl font-bold">NOS <span class="text-yellow1">PRODUITS</span></p>
      </div>
    </div>  
  
    <!-- Fin banniere -->

    <section class="productsPageMenu">

      <!-- SIDEBAR: LES FILTRES -->
       <livewire:interface-user.product.product-filters  />

    </section>


  


</div>



@endsection


