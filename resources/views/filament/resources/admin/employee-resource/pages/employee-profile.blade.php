<x-filament-panels::page>

    <link rel="stylesheet" href="{{ asset('css/filament/pages/profile.css') }}">
    <div class="dashboard-container">
        @if($isEmployee)
            <!-- Header Section -->
            <div class="dashboard p-5">
                
                <!-- Profile Card -->
                <div class="profile-card">
                
                <div class="profile-content">

                    <div class="profile-info">
                    <h3>{{$employee->name}}</h3>
                    <p>{{$employee->fonction}} • {{ $heureService == "Matinée" ? "Service du matin" : "Service du soir" }}</p>
                    </div>

                    <div class="profile-image-content">
                        <button wire:click="previousEmployee" class="nav-arrow left-arrow text-3xl">
                            <x-icon name="angle-left" fill="#025239" size="25" />
                        </button>
                        
                        <img src="{{asset('storage/'.$employee->image)}}" alt="Photo de profil" />
                        
                        <button wire:click="nextEmployee" class="nav-arrow right-arrow text-3xl">
                            <x-icon name="angle-right" fill="#025239" size="25" />
                        </button>
                    </div>

                    <div class="en-service">
                    @if($shiftStarted)
                        <h2>Aujourd'hui en Service</h2>
                    @elseif(!$shiftStarted)
                        <p class="text-red-500 font-bold">Pas en service Aujourd'hui</p>
                    @endif
                    </div>
                    
                </div>
                
                </div>

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
            </div>
            
            <!-- Attendance Section -->
            <div class="attendance-section">
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

            <!-- Shift Action Section -->
            
                <div class="">
                    @if(Session::has('status'))
                    <p class="alert-success">{{Session::get('status')}}</p>
                    @elseif(Session::has('error'))
                    <p class="alert-error">{{Session::get('error')}}</p>
                    @endif
                </div>

                <div class="shift-action-section">
                    <h2>Pointage</h2>
                    <div class="time-display">{{$displayTime}}</div>
                    <div class="action-buttons">
                    <button wire:click="clockIn" class="action-btn clock-in">Pointer l'entrée</button>
                    <button wire:click="clockOut" class="action-btn clock-out cursor-pointer">Pointer la sortie</button>
                    </div>
                    <div class="last-action">
                    <p>Dernière action: <span>{{$lastAction}}</span></p>
                    </div>
                </div>

        @else

            <!-- POUR LES NON-EMPLOYES -->
            <div class="dashboard items-start p-5">
                
                <!-- Profile Card -->
                <div class="profile-card min-h-[200px]">
                
                
                <div class="profile-content">

                    <div class="profile-info">
                    <h3>{{$user->name}}</h3>
                    <p>{{$user->roles->first()->name ?? 'Admin'}}</p>
                    </div>

                    <div class="profile-image-content">
                        <img src="{{asset('storage/'.$user->image)}}" alt="Photo de profil" />
                        <!-- Le component pour modifier la photo -->
                        {{--<livewire:admin.team-member.update-profile-image :user="$user" />--}}
                        
                    </div>
                    
                </div>
                
                </div>



                        
                <!-- Stats Cards Section -->
                <div class="stats-grid">
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

            </div>

            <!-- AFFICHER LE TABLEAU DES UTILISATEURS -->
            <!-- <div class="main-content-inner bg-white py-5 rounded-md shadow-md">
                <h2 class="section-title text-[2rem] pl-3 pt-5">Liste des employés</h2>
                <div class="main-content-wrap"> -->
                {{--<livewire:admin.team-member.member-list />--}}
                <!-- </div>
            </div> -->
        
        @endif

    </div>

</x-filament-panels::page>
