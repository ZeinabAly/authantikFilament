<section class="block">
  <!-- Container -->
  <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
    <!-- Heading -->
     <p class="section-subtitle text-center">Appréciations</p>
    <h2 class="section-title text-center"> Avis de nos clients </h2>
    <!-- Contents -->
    <div class="mb-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 lg:mb-8">
      <!-- Content 1 -->
      <div class="grid grid-cols-1 gap-6 rounded-md border border-solid border-gray-300 bg-white p-8 md:p-10">
        <div class="flex gap-1">
          @for($i=0; $i<5; $i++)
          <x-icon name="etoile-pleine" size="14" fill="#f5bb0d"/>
          @endfor
        </div>

        <div class="text-gray-500"> <pre>“</pre> Une expérience culinaire inoubliable ! Les plats étaient savoureux, bien présentés, et le service impeccable. Je recommande vivement ce restaurant à tous les amateurs de bonne cuisine." </div>
        <div class="flex flex-row items-start">
          <img src="{{asset('assets/images/pageIndex/homme.jpg')}}" alt="photo homme qui temoigne" class="mr-4 inline-block h-16 w-16 object-cover rounded-full" loading="lazy" />
          <div class="flex flex-col items-start">
            <h6 class="text-base font-bold">Thierno Ila</h6>
            <p class="text-sm text-gray-500">Communiquant</p>
          </div>
        </div>
      </div>
      <!-- Content 2 -->
      <div class="grid grid-cols-1 gap-6 rounded-md border border-solid border-gray-300 bg-white p-8 md:p-10">
        <div class="flex gap-1">
          @for($i=0; $i<4; $i++)
          <x-icon name="etoile-pleine" size="14" fill="#f5bb0d"/>
          @endfor
          <x-icon name="etoile-vide" size="14" fill="#f5bb0d"/>
        </div>
        <div class="text-gray-500"> <pre>“</pre> Le cadre est chaleureux et propre, le personnel accueillant. Un petit bémol : le temps d’attente était un peu long, mais ça valait largement le coup. </div>
        <div class="flex flex-row items-start">
          <img src="{{asset('assets/images/pageIndex/femme.jpg')}}" alt="photo femme qui temoigne" class="mr-4 inline-block h-16 w-16 object-cover rounded-full" loading="lazy" />
          <div class="flex flex-col items-start">
            <h6 class="text-base font-bold">Fatoumata Sylla</h6>
            <p class="text-sm text-gray-500">Mannequin</p>
          </div>
        </div>
      </div>
      <!-- Content 3 -->
      <div class="grid grid-cols-1 gap-6 rounded-md border border-solid border-gray-300 bg-white p-8 md:p-10">
        <div class="flex gap-1">
          @for($i=0; $i<5; $i++)
          <x-icon name="etoile-pleine" size="14" fill="#f5bb0d"/>
          @endfor
        </div>

        <div class="text-gray-500"> <pre>“</pre> Tout était parfait du début à la fin ! Le personnel est souriant et attentionné, le service rapide, et les plats… un vrai délice !  </div>
        <div class="flex flex-row items-start">
          <img src="{{asset('assets/images/pageIndex/homme2.jpg')}}" alt="photo femme qui temoigne" class="mr-4 inline-block h-16 w-16 object-cover rounded-full" loading="lazy" />
          <div class="flex flex-col items-start">
            <h6 class="text-base font-bold">Mohamed Bah</h6>
            <p class="text-sm text-gray-500">Designer</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Text Button -->
    <!-- <div class="flex flex-col">
      <a href="#" class="mx-auto font-bold text-black"> Check all reviews </a>
    </div> -->
  </div>
</section>

