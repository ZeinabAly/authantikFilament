<div>
    <h1 class="font-bold text-3xl md:5xl mt-4 mb-3">Tableau de bord</h1>
    
    <div class="md:flex-row flex flex-col gap-4 gap-3">
        <div class="flexLeft items-start flex-wrap gap-3 w-full md:w-[65%]">
            <!-- Shifts Card -->
            <div class="stat-card min-w-[230px]">
              <div class="stat-content">
                <div class="stat-value">{{$nbreReservations}}</div>
                <div class="stat-label">Reservation{{$nbreReservations > 1 ? 's' : ''}} </div>
              </div>
              <div class="stat-icon shift-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <div class="stat-card min-w-[230px]">
              <div class="stat-content">
                <div class="stat-value">{{$nbreOrders}}</div>
                <div class="stat-label">Commande{{$nbreOrders > 1 ? 's' : ''}} </div>
              </div>
              <div class="stat-icon tables-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <div class="stat-card min-w-[230px]">
              <div class="stat-content">
                <div class="stat-value">{{$nbreNotifs}}</div>
                <div class="stat-label">Notification{{$nbreNotifs > 1 ? 's' : ''}} </div>
              </div>
              <div class="stat-icon tips-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
        </div>
        <!-- Photo de profil et informations -->
        <div class="profile-card w-full md:w-[35%] py-10">
            <div class="profile-content">

                <div class="profile-image-content w-[150px] h-[150px]">
                    <img src="{{asset('uploads/usersImages')}}/{{$user->image}}" class="w-[150px] h-[150px]" alt="Photo de profil user" />
                </div>

                <div class="profile-info">
                    <h3>{{$user->name}}</h3>
                </div>
            
            </div>
        </div>
    </div>

    <!-- AFFICHER LES COMMANDES DE LA SEMAINE -->

    <div x-data="{ order: true }" @click.outside="order = false" class="relative text-left bg-white shadow-md p-2 rounded-md mb-5 mt-7">
        <div @click="order = !order" class="mb-5 mt-3 text-[24px] font-bold flexBetween">
            <div>Commandes de la semaine</div> 
            <div class="">
                <x-icon name="angle-up" fill="#000"/></div>
            </div>
    
        <div x-show="order" class="w-full">
            <livewire:interface-user.user-profile.user-week-orders />
        </div>
    </div>
    <!-- AFFICHER LES RESERVATIONS DE LA SEMAINE -->
    <div x-data="{ reservation: true }" @click.outside="reservation = false" class="relative text-left bg-white shadow-md p-2 rounded-md mb-5 mt-7">
        <div @click="reservation = !reservation" class="mb-5 mt-3 text-[24px] font-bold flexBetween">
            <div>Réservations de la semaine</div> 
            <div class="">
                <x-icon name="angle-up" fill="#000"/></div>
            </div>
    
        <div x-show="reservation" class="w-full">
            <livewire:interface-user.user-profile.user-week-reservations />
        </div>
    </div>

    <!-- AFFICHER LES NOTIFICATIONS DE LA SEMAINE -->
</div>
