<?php

namespace App\Livewire\Admin\Employee;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use App\Models\{Employee, Pointage, Absence, Horaire, Reservation, Order, User};

class EmployeeProfile extends Component
{
    
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

    // INFORMATIONS PERSONNELLES
    public $name ;
    public $email ;
    public $phone ;

    
    // Modifier le mot de passe
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public $jourSuppExiste = false;

    #[On('refresh')]
    public function mount($record){

        // Pour traduire le nom du jour en francais (Lundi, ...)
        Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        $this->userId = (int) $record;

        $this->user = User::find($this->userId);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;

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

        // dd($this->shiftStarted);
        
        $this->updateTime();  //Heure actuelle
        $this->activitesUser(); //Les activités de l'utilisateur (réservation, commande, ...)

    }

    public function updateInformations(){
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        $this->user->name = $this->name;
        if ($this->email !== $this->user->email) {
            $this->user->email = $this->email;
            $this->user->email_verified_at = null;
        }
        
        if($this->phone !== ""){
            $this->user->phone = $this->phone;
        }

        $this->user->save();

        Notification::make()
            ->title('Informations modifiées avec succès ! ')
            ->success()
            ->body('Vos informations ont été modifiées')
            ->send();
    }

    public function updatePassword(){
        $this->resetErrorBag();

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'required', 'string', 'min:8'],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($this->password);
        $user->save();

        Notification::make()
            ->title('Mot de passe modifié avec succès ! ')
            ->success()
            ->body('Votre mot de passe a été modifié')
            ->send();

        // Reset the form
        $this->reset(['current_password', 'password', 'password_confirmation']);
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
                                    ->whereDate('created_at', $today)
                                    ->exists();


        if($this->employee->user->id == auth()->user()->id){
            if($existingClockIn){
                return Notification::make()
                        ->title('Vous avez déjà pointé l\'entrée pour aujourdh\'ui !')
                        ->danger()
                        ->send();
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
                
                Notification::make()
                        ->title('Pointage d\'entrée enregistré avec succès !')
                        ->success()
                        ->send();
            }
        }else{
            return Notification::make()
                    ->title('Vous ne pouvez pas pointer à la place d\'un autre ! ')
                    ->danger()
                    ->send();
        }
    }

    public function clockOut()
    {
        $activeShift = Pointage::where('employee_id', $this->employeeId)
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->latest()
            ->first();
            
        if($this->employee->user->id == auth()->user()->id){
            if ($activeShift) {
                $activeShift->update([
                    'clock_out' => Carbon::now()
                ]);
                
                $this->shiftStarted = false;
                $this->lastAction = 'Sortie à ' . Carbon::now()->format('H:i') . ' aujourd\'hui';
                $this->loadAttendanceStats();
                
                session()->flash('message', 'Pointage de sortie enregistré avec succès !');
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
                ->whereMonth('date', $now->month)
                ->whereYear('date', $now->year)
                ->count(),

            'servicesLastMonth' => Pointage::where('employee_id', $this->employeeId)
                ->whereMonth('date', $startOfMonth ->subMonth()->month)
                ->whereYear('date', $startOfMonth ->subMonth()->year)
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

            $jourSupplementaire = 0;
            //Les jours où il est censé travailler
            $workDays = $this->employee->calendrier_employees()
            ->count();

            //Ses presences
            $attendanceDays = Pointage::where('employee_id', $this->employeeId)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->count(); 
              
            // Calculer le pourcentage de présence (si des jours de travail sont prévus) et des heures supplementaires 
            if($workDays > 0 && $workDays >= $attendanceDays){
                $percentage = ($attendanceDays / $workDays) * 100; //Nbre de presence sur le nbre de presence qu'il doit faire 
            }elseif($workDays > 0 && $workDays < $attendanceDays){
                $percentage = 100;
                
                if($attendanceDays > 0) {
                    $jourSupplementaire = $attendanceDays - $workDays;
                }
            }else{
                $percentage = 0;
            }
            
            
            $this->chartData[] = [
                'month' => ucfirst(Carbon::create($year, $month, 1)->translatedFormat('F')),
                'percentage' => round($percentage, 1),
                'jourSupplementaire' => $jourSupplementaire,
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
    public function render()
    {
        return view('livewire.admin.employee.employee-profile');
    }
}
