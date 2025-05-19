<div class="">


<link rel="stylesheet" href="{{ asset('css/filament/pages/client/userProfile.css') }}">
<link rel="stylesheet" href="{{ asset('css/filament/pages/profile.css') }}">
<script defer src="{{ asset('js/filament/filament/uploadFile.js') }}"></script>    

<main class="monCompte">

        <div class="section-img-infos">
            <section class="section1">
                <div class="">
                    <div class="sectionTitre">
                        @if($isEmployee)
                            <h2>{{$employee->name}}</h2>
                            <p class="fonctionUser">{{$employee->fonction}} • {{ $heureService == "Matinée" ? "Service du matin" : "Service du soir" }}</p>
                        @else
                            <h2>{{$user->name}}</h2>
                            <p class="fonctionUser">{{ $user->getRoleNames()->first() }}</p>
                        @endif
                    </div>
                    <div class="img-btn-content">
                        <div class="flexImgContent">
                            @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager']))
                            <button wire:click="previousEmployee" class="nav-arrow left-arrow text-3xl">
                                <x-icon name="angle-left" fill="#ce9c2d" size="25" />
                            </button>
                            @endif
                            @if(is_null($user->image))
                            <div class="userImgContent" id="userImgContent">
                                <x-icon name="user-plein" fill="#1A1F2C" size="90" class="border-2 border-[#1A1F2C] p-3 rounded-full" />
                            </div>
                            @else
                                <div class="userImgContent" id="userImgContent">
                                    @if($isEmployee)
                                    <img src="{{asset('storage/'.$employee->image)}}" alt="image utilisateur {{auth()->user()->name}}" class="w-[150px] h-[150px] border-2 border-[#1A1F2C] p-3 rounded-full object-top">
                                    @else
                                    <img src="{{asset('storage/'.$user->image)}}" alt="image utilisateur {{auth()->user()->name}}" class="w-[150px] h-[150px] border-2 border-[#1A1F2C] p-3 rounded-full object-top">
                                    @endif
                                </div>
                            @endif
                            @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager']))
                            <button wire:click="nextEmployee" class="nav-arrow right-arrow text-3xl">
                                <x-icon name="angle-right" fill="#ce9c2d" size="25" />
                            </button>
                            @endif

                        </div>
                        
                        @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager']) && $isEmployee)
                            <div class="en-service">
                                @if($shiftStarted)
                                    <h2>Aujourd'hui en Service</h2>
                                @elseif(!$shiftStarted)
                                    <p class="text-red-500 font-bold">Pas en service Aujourd'hui</p>
                                @endif
                            </div>
                        @endif

                        <div class="">
                            <!-- Le component pour modifier la photo -->
                            <livewire:client.update-profile-image :user="$user" />
                        </div>

                    </div>
                </div>
            </section>
    
            <section class="section2 mt-10 bg-white">
                <header>
                    @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager']))
                    <h2 class="sectionTitre">
                        {{ __('Informations') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Informations personnelles") }}
                    </p>
                    @else

                    <h2 class="sectionTitre">
                        {{ __('Mes Informations') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Modifier mes informations personnelles") }}
                    </p>
                    @endif
                </header>
            
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
            
                <form method="post" class="mt-6 space-y-6" wire:submit="updateInformations">
                    @csrf
                    @method('patch')
            
                    @if(auth()->user()->id === $user->id)
                    <div>
                        <x-input-label for="name" :value="__('Nom')" class="formLabel" />
                        <x-text-input id="name" name="name" type="text" class="profilInput" :value="old('name', $isEmployee ? $employee->name : $user->name)" required autofocus autocomplete="name" wire:model.live="name" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="formLabel" />
                        <x-text-input id="email" name="email" type="email" wire:model.live="email" class="profilInput" :value="old('email', $isEmployee ? $employee->email : $user->email)" required autocomplete="email" wire:model.live="email" />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}
            
                                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
            
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
    
                    <div>
                        <x-input-label for="phone" :value="__('Phone')" class="formLabel" />
                        <x-text-input id="phone" name="phone" type="text" class="profilInput" :value="old('phone', $isEmployee ? $employee->phone : $user->phone)" required autofocus autocomplete="phone" wire:model.live="phone" />
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="flex items-center gap-4">
                        <x-primary-button class="btnCommander">{{ __('Modifier') }}</x-primary-button>
            
                        @if (session('status') === 'Profil modifié')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Modifié !') }}</p>
                        @endif
                    </div>
                    @else
                        <div>
                            <x-input-label for="name" :value="__('Nom')" class="formLabel" />
                            <x-text-input id="name" name="name" type="text" class="profilInput" :value="old('name', $isEmployee ? $employee->name : $user->name)" readonly />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" class="formLabel" />
                            <x-text-input id="email" name="email" type="email" wire:model.live="email" class="profilInput" :value="old('email', $isEmployee ? $employee->email : $user->email)" readonly />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone')" class="formLabel" />
                            <x-text-input id="phone" name="phone" type="text" class="profilInput" :value="old('phone', $isEmployee ? $employee->phone : $user->phone)" readonly />
                        </div>
                    @endif
                </form>
            </section>
            
        </div>

        <!-- Modifier le mot de passe -->
       
        @if($isEmployee)
            @if(auth()->user()->id === $employee->user->id)
                <section class="" x-data = "{ passwordEdit : false}" x-cloak>
                    <header @click = "passwordEdit = !passwordEdit" class="flex justify-between">
                        <div class="">
                            <h2 class="sectionTitre">
                                {{ __('Modifier mon mot de passe') }}
                            </h2>
            
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </div>
                        <div class="icon-light">
                            <x-icon name="angle-up" fill="#000" />
                        </div>
                        <div class="icon-dark">
                            <x-icon name="angle-up" fill="#fff" />
                        </div>
                    </header>

                    <form method="post" wire:submit.prevent="updatePassword"  class="mt-6 space-y-6" x-show="passwordEdit" @click.outside="passwordEdit = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                        @csrf
                        <!-- @method('put') -->

                        <div>
                            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="formLabel" />
                            <x-text-input wire:model.live="current_password" id="update_password_current_password" name="current_password" type="password" class="profilInput" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe ')" class="formLabel" />
                            <x-text-input wire:model.live="password" id="update_password_password" name="password" type="password" class="profilInput" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" class="formLabel" />
                            <x-text-input wire:model.live="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="profilInput" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="btnCommander">{{ __('Valider') }}</x-primary-button>

                            @if (session('status') === 'password-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class=""
                                >{{ __('Modifié.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
                
            @endif
            
        @endif




    <div class="" style="width: 100%">

        @if($isEmployee)
        <div class="">
            <section>
                <h2 class="sectionTitre">
                    @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Manager']))
                    {{ __('Activités') }}
                    @else
                    {{ __('Mes activités') }}
                    @endif
                </h2>
                <!-- Stats Cards Section -->
                <div class="stats-grid">
                    <!-- Shifts Card -->
                    <div class="stat-card">
                        <div class="stat-content">
                        <div class="stat-value">{{$attendanceStats['services']}}</div>
                        <div class="stat-label">Service{{$attendanceStats['services'] > 1 ? 's' : ''}} du mois</div>
                        <div class="stat-sublabel">Mois dernier: {{$attendanceStats['servicesLastMonth']}} service{{$attendanceStats['servicesLastMonth'] > 1 ? 's' : ''}}</div>
                        </div>
                        <div class="stat-icon shift-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        </div>
                    </div>
                    
                    <!-- Absences Card -->
                    <div class="stat-card">
                        <div class="stat-content">
                        <div class="stat-value">{{$attendanceStats['absences']}}</div>
                        <div class="stat-label">Absence{{$attendanceStats['absences'] > 1 ? 's' : ''}}</div>
                        <div class="stat-sublabel">Ce mois-ci</div>
                        </div>
                        <div class="stat-icon absences-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        </div>
                    </div>
                    
                    <!-- Tables Served Card -->
                    <div class="stat-card">
                        <div class="stat-content">
                        <div class="stat-value">{{$nbreCmdPassed}}</div>
                        <div class="stat-label">Commande{{$nbreReservationPassed > 1 ? 's' :  ''}} passée{{$nbreReservationPassed > 1 ? 's' :  ''}}</div>
                        <div class="stat-sublabel">Ce mois-ci</div>
                        </div>
                        <div class="stat-icon tables-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        </div>
                    </div>
                    
                    <!-- Hours Card -->
                    <div class="stat-card">
                        <div class="stat-content">
                        <div class="stat-value">{{$attendanceStats['hoursWorked']}}</div>
                        <div class="stat-label">Heure{{$attendanceStats['hoursWorked'] > 1 ? 's' : ''}} travaillée{{$attendanceStats['hoursWorked'] > 1 ? 's' : ''}}</div>
                        <div class="stat-sublabel">Ce mois-ci</div>
                        </div>
                        <div class="stat-icon hours-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        </div>
                    </div>
                    
                    <!-- Tips Card -->
                    <div class="stat-card">
                        <div class="stat-content">
                        <div class="stat-value">{{$nbreReservationPassed}}</div>
                        <div class="stat-label">Réservation{{$nbreReservationPassed > 1 ? 's' :  ''}} passée{{$nbreReservationPassed > 1 ? 's' :  ''}}</div>
                        <div class="stat-sublabel">Ce mois-ci</div>
                        </div>
                        <div class="stat-icon tips-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- GRAPHIQUE DES PRESENCES -->
        <div class="attendance-section mt-10">
            <div class="section-header">
                <h2>Historique de Présence</h2>
                <div class="section-controls">
                    <button class="control-btn active">Mois</button>
                    <!-- <button class="control-btn">Semaine</button> -->
                </div>
                </div>
                
                <div class="chart-container">
                <!-- Chart placeholder - in real application, you would use a chart library -->
                <div class="bar-chart">
                    @foreach($chartData as $data)
                    <div class="chart-bar" style="height: {{$data['percentage']}}%;"></div>
                    @endforeach
                    <!-- <div class="chart-bar" style="height: 85%;"></div>
                    <div class="chart-bar" style="height: 60%;"></div>
                    <div class="chart-bar" style="height: 90%;"></div>
                    <div class="chart-bar" style="height: 75%;"></div>
                    <div class="chart-bar" style="height: 80%;"></div>
                    <div class="chart-bar" style="height: 65%;"></div>
                    <div class="chart-bar" style="height: 72%;"></div>
                    <div class="chart-bar" style="height: 78%;"></div>
                    <div class="chart-bar" style="height: 92%;"></div>
                    <div class="chart-bar" style="height: 68%;"></div>
                    <div class="chart-bar" style="height: 55%;"></div> -->
                </div>
                <div class="chart-labels">
                    <span>Jan</span>
                    <span>Fév</span>
                    <span>Mar</span>
                    <span>Avr</span>
                    <span>Mai</span>
                    <span>Jun</span>
                    <span>Jul</span>
                    <span>Aoû</span>
                    <span>Sep</span>
                    <span>Oct</span>
                    <span>Nov</span>
                    <span>Déc</span>
                </div>
            </div>
        </div>

        <!-- SECTION POINTAGE -->
        
        @if($isEmployee && auth()->user()->id === $user->id)

            <div class="shift-action-section">
                <h2>Pointage</h2>
                <div class="time-display">{{$displayTime}}</div>
                <div class="action-buttons">
                @if(!$shiftStarted)
                <button wire:click="clockIn" class="action-btn clock-in">Pointer l'entrée</button>
                @endif
                <button wire:click="clockOut" class="action-btn clock-out cursor-pointer">Pointer la sortie</button>
                </div>
                <div class="last-action">
                <p>Dernière action: <span>{{$lastAction}}</span></p>
                </div>
            </div>
        @endif

              

        @else 
            <div class="" style="width: 100%">
                <section>
                    <h2 class="sectionTitre">
                        {{ __('Mes activités') }}
                    </h2>
                    <!-- Stats Cards Section -->
                    <div class="stats-grid flex">
                        <!-- Shifts Card -->
                        
                        <!-- Tables Served Card -->
                        <div class="stat-card">
                            <div class="stat-content">
                            <div class="stat-value">{{$nbreCmdPassed}}</div>
                            <div class="stat-label">Commande{{$nbreReservationPassed > 1 ? 's' :  ''}} passée{{$nbreReservationPassed > 1 ? 's' :  ''}}</div>
                            <div class="stat-sublabel">Ce mois-ci</div>
                            </div>
                            <div class="stat-icon tables-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            </div>
                        </div>

                        <!-- Tips Card -->
                        <div class="stat-card">
                            <div class="stat-content">
                            <div class="stat-value">{{$nbreReservationPassed}}</div>
                            <div class="stat-label">Réservation{{$nbreReservationPassed > 1 ? 's' :  ''}} passée{{$nbreReservationPassed > 1 ? 's' :  ''}}</div>
                            <div class="stat-sublabel">Ce mois-ci</div>
                            </div>
                            <div class="stat-icon tips-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endif

    </div>

    
</main> 

</div>

