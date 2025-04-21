<?php

namespace App\Filament\Resources\Admin\EmployeeResource\Pages;

use Carbon\Carbon;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\Admin\EmployeeResource;
use App\Models\{Employee, Pointage, Absence, Horaire, Reservation, Order, User};

class EmployeeProfile extends Page
{
    protected static string $resource = EmployeeResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Mon profil';
    protected static ?string $slug = 'employee-profile';
    protected static string $view = 'filament.resources.admin.employee-resource.pages.employee-profile';

    public $userId;
    public $user;
    public $employeeId;
    public $employee;
    public $isEmployee = false;
    public $lastAction;
    public $shiftStarted = false; //Horaire debut
    public $nbreCmdPassed;
    public $nbreReservationPassed;
    public $nbreNotifications;
    public $attendanceStats;
    public $displayTime; //Heure actuelle
    public $chartData = []; //Afficher le pourcentage de travail pour chaque mois 
    public $heureService;


    public function mount($record){

        Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        $this->userId = (int) $record;

        $this->user = User::find($this->userId);
        if($this->user){
            if($this->user->employee !== null){
                $this->isEmployee = true;
                $this->employeeId = $this->user->employee->id;
                $this->employee = Employee::findOrFail($this->employeeId);
    
                $this->checkActiveShift();
        
                // $this->heureService = $this->isEmployee->calendrier_employees;
                $jour = Carbon::today()->translatedFormat('l');
                $horaire = $this->employee->calendrier_employees->where('jour', $jour)->first();
        
                if($horaire){
                    $this->heureService = $horaire->horaire->name;
                }else{
                    $this->heureService = "Pas de travail aujourd'hui";
                }

                
                $this->loadEmployeeData();
            }
        }
        
        $this->updateTime();  //Heure actuelle
        $this->activitesUser(); //Les activités de l'utilisateur (réservation, commande, ...)
    }

    public function loadEmployeeData()
    {
        $this->employee;
        $this->checkActiveShift();
        $this->loadAttendanceStats();
        $this->generateChartData();
        $this->activitesUser();
    }

    public function checkActiveShift()
    {

        //Verifie si l'employé est en service
        $activeShift = Pointage::where('employee_id', $this->employeeId)
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->latest()
            ->first(); 
            
        if ($activeShift) {
            $this->shiftStarted = true;
            $this->lastAction = 'Entrée à ' . Carbon::parse($activeShift->clock_in)->format('H:i') . ' ' . 
                ($activeShift->clock_in->isToday() ? 'aujourd\'hui' : 'le ' . $activeShift->clock_in->format('d/m/Y'));
        } else {
            $lastShift = Pointage::where('employee_id', $this->employeeId)
                ->latest()
                ->first(); //dernier pointage

                
            if ($lastShift) {
                if($lastShift->clock_out){
                    $this->lastAction = 'Sortie à ' . Carbon::parse($lastShift->clock_out)->format('H:i') . ' ' . 
                        ($lastShift->clock_out->isToday() ? 'aujourd\'hui' : 'le ' . $lastShift->clock_out->format('d/m/Y'));
                }else{
                    $this->lastAction = 'Aucune action enregistrée depuis le '.$lastShift->clock_in->format('d/m/Y');
                }
            } else {
                $this->lastAction = 'Aucune action enregistrée';
            }
        }
    }

    public function activitesUser(){
        $now = Carbon::now();
        $user = auth()->user();
        $this->nbreReservationPassed = Reservation::where('user_id', $user->id)->whereMonth('created_at', $now->month)->count();
        $this->nbreCmdPassed = Order::where('user_id', $user->id)->whereMonth('created_at', $now->month)->count();
        $this->nbreNotifications = $user->notifications()->whereMonth('created_at', $now->month)->count();
    }

    public function updateTime()
    {
        $this->displayTime = Carbon::now()->format('H:i');
    }

    public function clockIn() //Pointage d'entrée
    {
        $today = Carbon::today();
        $existingClockIn = Pointage::where('employee_id', $this->employeeId)
                                    ->whereDate('clock_in', $today)
                                    ->exists();


        if($this->employeeId == auth()->user()->id){
            if($existingClockIn){
                return session()->flash('error', 'Vous avez déjà pointé l\'entrée pour aujourdh\'ui!');
            }else{
                Pointage::create([
                    'employee_id' => $this->employeeId,
                    'date' => Carbon::today(),
                    'clock_in' => Carbon::now(),
                    'horaire_id' => Horaire::getCurrentShiftId() // Méthode hypothétique pour obtenir le shift actuel
                ]);
                
                $this->shiftStarted = true;
                $this->lastAction = 'Entrée à ' . Carbon::now()->format('H:i') . ' aujourd\'hui';
                $this->loadAttendanceStats();
                
                session()->flash('success', 'Pointage d\'entrée enregistré avec succès!');
            }
        }else{
            return session()->flash('error', 'Vous ne pouvez pas pointer à la place d\'un autre ! ');
        }
    }

    public function clockOut()
    {
        $activeShift = Pointage::where('employee_id', $this->employeeId)
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->latest()
            ->first();
            
        if($this->employeeId == auth()->user()->id){
            if ($activeShift) {
                $activeShift->update([
                    'clock_out' => Carbon::now()
                ]);
                
                $this->shiftStarted = false;
                $this->lastAction = 'Sortie à ' . Carbon::now()->format('H:i') . ' aujourd\'hui';
                $this->loadAttendanceStats();
                
                session()->flash('message', 'Pointage de sortie enregistré avec succès!');
            }  
        }else{
            return session()->flash('error', 'Vous ne pouvez pas pointer à la place d\'un autre ! ');
        }
    }

    //Statistiques Presences et Absences
    public function loadAttendanceStats() 
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth(); //Recupérer le premier jour du mois 
        
        $pointages = Pointage::where('employee_id', $this->employeeId)
                ->whereMonth('clock_in', $now->month)
                ->whereYear('clock_in', $now->year)
                ->get();

        $sommeHours = 0;
        foreach($pointages as $pointage){
            if($pointage->clock_out){
                $sommeHours += Carbon::parse($pointage->clock_in)->diffInMinutes(Carbon::parse($pointage->clock_out)) / 60;
            }
        }

        // Calculer les statistiques de présence
        $this->attendanceStats = [
            'services' => Pointage::where('employee_id', $this->employeeId)
                ->whereMonth('clock_in', $now->month)
                ->whereYear('clock_in', $now->year)
                ->count(),

            'servicesLastMonth' => Pointage::where('employee_id', $this->employeeId)
                ->whereMonth('clock_in', $startOfMonth ->subMonth()->month)
                ->whereYear('clock_in', $startOfMonth ->subMonth()->year)
                ->count(),
                
            'absences' => $this->employee->absences()
                ->whereMonth('date', $now->month)
                ->whereYear('date', $now->year)
                ->count(),
                
            'hoursWorked' => round($sommeHours)
        ];

    
    }

    // LE GRAPHIQUE DES PRESENCES
    public function generateChartData()
    {
        $year = Carbon::now()->year;
        $this->chartData = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = Carbon::create($year, $month)->daysInMonth;

            //Les jours où il est censé travailler
            $workDays = $this->employee->calendrier_employees()
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(); 
             
            //Ses presences
            
            $attendanceDays = Pointage::where('employee_id', $this->employeeId)
                ->whereMonth('clock_in', $month)
                ->whereYear('clock_in', $year)
                ->count(); 
              
            // Calculer le pourcentage de présence (si des jours de travail sont prévus) et des heures supplementaires 
            if($workDays > 0 && $workDays >= $attendanceDays){
                $percentage = ($attendanceDays / $workDays) * 100;
            }elseif($workDays > 0 && $workDays <= $attendanceDays){
                $percentage = ($workDays / $attendanceDays) * 100;
            }else{
                $percentage = 0;
            }
            
            
            $this->chartData[] = [
                'month' => Carbon::create($year, $month, 1)->format('M'),
                'percentage' => round($percentage, 1)
            ];

        }


    }
    
    //Afficher l'employé suivant (Visible que par les admins)
    public function nextEmployee()
    {

        $nextEmployee = Employee::where('id', '>', $this->employeeId)
            ->orderBy('id')
            ->first();


        if (!$nextEmployee) {
            $nextEmployee = Employee::orderBy('id')->first();
        }
        
        $this->employeeId = $nextEmployee->id;
        $this->employee = Employee::findOrFail($this->employeeId);
        $this->loadEmployeeData();
        $this->checkActiveShift();
    }

    public function previousEmployee()
    {
        $prevEmployee = Employee::where('id', '<', $this->employeeId)
            ->orderBy('id', 'desc')
            ->first();
            
        if (!$prevEmployee) {
            $prevEmployee = Employee::orderBy('id', 'desc')->first();
        }
        
        $this->employeeId = $prevEmployee->id;
        $this->employee = Employee::findOrFail($this->employeeId);
        $this->loadEmployeeData();
        $this->checkActiveShift();

    }
}
