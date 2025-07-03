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
        if ($this->user && $this->user->hasAnyRole(['User'])) {
            return ['database', 'mail']; 
        }
    
        return ['database']; 
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
                ->subject('Confirmation de votre commande')
                ->greeting('Bonjour ' . $notifiable->name . '!')
                ->line("Votre commande a été passée avec succès !")
                ->line("Nbre de produits : ". $this->order->orderItems->count() )
                ->action('Voir ma commande', url("/client/client/orders/{$this->order->id}"))
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
            'nocmd' => $this->order->nocmd, 
            'name' => $this->order->name,
            'serveur' => $this->order->employee->name ?? '',
            'nbrPrdt' => $this->order->orderItems->count(),
            'title' => "Nouvelle commande",
            'total' => $this->order->total,
            'produits' => $this->order->orderItems ?? [],
        ];
    }
}
