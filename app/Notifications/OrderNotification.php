<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\{User, Order};

class OrderNotification extends Notification
{
    use Queueable;
    protected $order;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, User $user = null)
    {
        $this->order = $order;
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
        if($notifiable->hasAnyRole(['superAdmin', 'admin', 'manager'])){
            return (new MailMessage)
                ->subject('Nouvelle commande ! ')
                ->greeting("Bonjour {$notifiable->name} !")
                ->line('Une nouvelle commande a été passé par '. $this->order->name )
                ->line(' Nbre de produits : '. $this->order->orderItems->count() )
                ->line('Montant : '. $this->order->total . ' GNF' )
                ->line('Lieu : '. $this->order->lieu )
                ->action('Voir la commande', url("admin.order.show/{$this->order->id}"))
                ->line('Merci de gérer cette commande rapidement.');
        }
        return (new MailMessage)
            ->subject('Confirmation de votre commande')
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line("Votre commande a été passée avec succès !")
            ->line("Nbre de produits : ". $this->order->orderItems->count() )
            ->action('Voir ma commande', url("/myprofile.commande.details/{$this->order->id}"))
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
            'id' => $this->order->id, 
            'name' => $this->order->name,
            'date' => $this->order->created_at,
            'nbrPrdt' => $this->order->orderItems->count(),
            'message' => ($notifiable->hasAnyRole(['superAdmin', 'admin', 'manager'])) ?
                "Nouvelle commande de {$this->order->name}." :
                "Votre commande a été enregistrée avec succès."
        ];
    }
}
