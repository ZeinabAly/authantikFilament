<?php

namespace App\Jobs;

use App\Models\{User, Order};
use App\Notifications\OrderNotification;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $order; 

    public function __construct(Order $order, User $user = null)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
    
            // Notifier le client
            if ($this->user) {
                $this->user->notify(new OrderNotification($this->order));
            } else if(auth()->check()){
                auth()->user()->notify(new OrderNotification($this->order));
            }
 

            $admins = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['superAdmin', 'admin', 'manager']);
            })->get();

            foreach ($admins as $admin) {
                $admin->notify(new OrderNotification($this->order));
            }
    
        } catch (\Exception $e) {
            \Log::error('Erreur dans OrderNotification: ' . $e->getMessage());
            throw $e;
        }
    }
}
