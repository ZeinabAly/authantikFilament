<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Notifications\ReservationNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\{User, Reservation};

class SendReservationNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $reservation; 

    public function __construct(Reservation $reservation, User $user = null)
    {
        $this->user = $user;
        $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
    
            // Notifier le client
            if ($this->user) {
                $this->user->notify(new ReservationNotification($this->reservation));
            } 
            
            // auth()->user()->notify(new ReservationNotification($this->reservation));
 

            $admins = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Admin', 'Manager']);
            })->get();

            foreach ($admins as $admin) {
                $admin->notify(new ReservationNotification($this->reservation));
            }
    

            // Notification::send($admins, new ReservationNotification($reservationDetails));

        } catch (\Exception $e) {
            \Log::error('Erreur dans SendReservationNotification: ' . $e->getMessage());
            throw $e;
        }
        
    }
}
