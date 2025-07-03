<div>

<footer class="bg-gray-100 dark:bg-gray-900 border border-block">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:grid md:grid-cols-[1fr_2fr]">
          <div class="mb-6 md:mb-0 ">
              <a href="{{route('home.index')}}" class="flex items-center">
                @if (!empty($settings->logo_path) && Storage::disk('public')->exists($settings->logo_path))
                    <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo du site" class="h-20">
                @else
                    <img src="{{ asset('logoAuth.png') }}" alt="logo par défaut" class="h-20">
                @endif

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
                          <a href="{{route('home.reservation')}}" class="hover:underline">Réservation</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{route('home.reservation')}}" class="hover:underline">Contact</a>
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
                          <a href="{{$settings->facebook_url}}" class="hover:underline">Facebook</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{$settings->instagram_url}}" class="hover:underline">Instagram</a>
                      </li>
                      <li class="mb-4">
                          <a href="{{$settings->snapchat_url}}" class="hover:underline">Snapchat</a>
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
              <a href="{{$settings->facebook_url}}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                  <x-icon name="facebook" fill="#1877F2"/>
                  <span class="sr-only">Facebook page</span>
              </a>
              <a href="{{$settings->twitter_url}}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                <x-icon name="x-twitter" fill="#000000"/>
                  <span class="sr-only">Twitter</span>
              </a>
              <a href=""{{$settings->instagram_url}} class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                <x-icon name="instagram" fill="#E1306C"/>
                  <span class="sr-only">Instagram page</span>
              </a>
                <a href="{{$settings->snapchat_url}}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    <x-icon name="snapchat" fill="#ce9c2d"/>
                    <span class="sr-only">Snapchat compte</span>
                </a>
   
          </div>
      </div>
    </div>
</footer>

</div>
