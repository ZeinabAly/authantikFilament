<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\{User, Contact};


class ContactUsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $contactInfos;
    protected $user;

    public function __construct(Contact $contactInfos, User $user = null)
    {
        $this->contactInfos = $contactInfos;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
    */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Log::info('Avant notification', ['user' => $no-tifiable->id]);

        if($notifiable->hasRole('superAdmin') || $notifiable->hasRole('admin') || $notifiable->hasRole('manager')){
            return (new MailMessage)
                        ->subject('Notification de contact')
                        ->greeting("Bonjour {$notifiable->name} ! ")
                        ->line("L\'utilisateur {$this->contactInfos->name} à besoin de votre aide")
                        ->line("Pour : {$this->contactInfos->message} ")
                        ->action('Voir le message', url('/'));
        }
        return (new MailMessage)
                    ->subject('Notification de contact')
                    ->greeting("Bonjour {$notifiable->name} ! ")
                    ->line("votre requête a bien été reçu nous vous ferons un retour très bientôt")
                    ->line('Merci d\'utiliser notre application !');
        

        // Log::info('Notification envoyée');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->contactInfos->user_id,
            'name' => $this->contactInfos->name,
            'phone' => $this->contactInfos->phone,
            'message' => $this->contactInfos->message,
        ];
    }
}
