<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Notifications\ContactUsNotification;
use App\Models\{User, Contact};

class ContactNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $contactInfos;

    public function __construct(Contact $contactInfos, User $user = null)
    {
        $this->user = $user;
        $this->contactInfos = $contactInfos;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Notifier le client
        if (!$this->user) {
            $this->user->notify(new ContactUsNotification($this->contactInfos));
        }else if(auth()->check()){
            auth()->user()->notify(new ContactUsNotification($this->contactInfos));
        }

        // Notifier les admins
        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['superAdmin', 'admin', 'manager']);
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new ContactUsNotification($this->contactInfos));
        }
    }
}
