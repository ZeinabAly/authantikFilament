

<footer class="bg-gray-100 dark:bg-gray-900 border border-block">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:grid md:grid-cols-[1fr_2fr]">
          <div class="mb-6 md:mb-0 ">
              <a href="" class="flex items-center">
                  <img src="{{asset('logoAuth.png')}}" class="h-16 me-3" alt="FlowBite Logo" />
              </a>
          </div>
          <div class="flex justify-end gap-10 lg:gap-20">
              <div class="">
                  <h2 class="mb-6 text-sm font-bold text-gray-900 uppercase dark:text-white">Pages</h2>
                  <ul class="text-gray-600 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="{{route('home.index')}}" class="hover:underline">Accueil</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{route('home.menu')}}" class="hover:underline">Menu</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{route('home.about')}}" class="hover:underline">A propos</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{route('reservation.create')}}" class="hover:underline">Réservation</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{route('reservation.create')}}" class="hover:underline">Contact</a>
                      </li>
                  </ul>
              </div>
              <div class="">
                  <h2 class="mb-6 text-sm font-bold text-gray-900 uppercase dark:text-white">Services</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <p class="hover:underline ">Restauration</p>
                      </li>
                      <li class="mb-4">
                          <p class="hover:underline ">Traiteur</p>
                      </li>
                      <li class="mb-4">
                          <p class="hover:underline ">Livraison</p>
                      </li>
                      
                  </ul>
              </div>
              <div class="">
                  <h2 class="mb-6 text-sm text-gray-900 uppercase dark:text-white font-bold">Suivez-nous</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="#" class="hover:underline">Facebook</a>
                      </li>
                      <li class="mb-4">
                          <a href="#" class="hover:underline">Instagram</a>
                      </li>
                      <li class="mb-4">
                          <a href="#" class="hover:underline">Snapchat</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="{{route('home.index')}}" class="hover:underline">Authantik</a>. Tous Droits Reservés.
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0">
              <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                  <x-icon name="facebook" fill="#1877F2"/>
                  <span class="sr-only">Facebook page</span>
              </a>
              <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                <x-icon name="x-twitter" fill="#000000"/>
                  <span class="sr-only">Twitter</span>
              </a>
              <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                <x-icon name="instagram" fill="#E1306C"/>
                  <span class="sr-only">Instagram page</span>
              </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    <x-icon name="linkedin" fill="#0A66C2"/>
                    <span class="sr-only">Linkedin compte</span>
                </a>
   
          </div>
      </div>
    </div>
</footer>
