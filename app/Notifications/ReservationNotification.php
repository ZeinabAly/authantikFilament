<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\{Reservation, User};

class ReservationNotification extends Notification 
{
    use Queueable;

    private $reservation;
    private $user;
    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation, User $user = null)
    {
        $this->reservation = $reservation;
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
        if($notifiable->hasRole('superAdmin') || $notifiable->hasRole('admin') || $notifiable->hasRole('manager')){
            return (new MailMessage)
                ->subject('Nouvelle réservation ! ')
                ->greeting("Bonjour {$notifiable->name} !")
                ->line('Une nouvelle réservation a été faite par '. $this->reservation->name )
                ->line('📅 Pour le '. $this->reservation->date )
                ->line('⏰ A '. $this->reservation->heure )
                ->line('👥  Nombre de personnes : '. $this->reservation->nbrPers )
                // ->action('Voir la réservation', url("admin/reservations/{$this->reservation['id']}"))
                ->action('Voir la réservation', url("/"))
                ->line('Merci de gérer cette réservation rapidement.');
        }
        return (new MailMessage)
            ->subject('Confirmation de votre réservation')
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line("Votre réservation pour le {$this->reservation->date} à {$this->reservation->heure} au nom de {$this->reservation->name} a été reçue avec succès !")
            ->line("Nombre de personnes : {$this->reservation->nbrPers}")
            ->action('Voir ma réservation', url("/reservation/{$this->reservation->id}"))
            ->line('Merci de nous faire confiance ! ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->reservation->id, 
            'name' => $this->reservation->name,
            'date' => $this->reservation->date,
            'heure' => $this->reservation->heure,
            'nbrPers' => $this->reservation->nbrPers,
            'message' => ($notifiable->hasRole('superAdmin') || $notifiable->hasRole('admin')) ?
                "Nouvelle réservation de {$this->reservation->name}." :
                "Votre réservation a été enregistrée avec succès."
        ];
    }

}
