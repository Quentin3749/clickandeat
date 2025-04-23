<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $oldStatus;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Order  $order
     * @param  string  $oldStatus
     * @return void
     */
    public function __construct(Order $order, string $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Nous allons envoyer un email et enregistrer la notification en base de données
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $newStatus = $this->order->status;
        $restaurantName = $this->order->restaurant->name;

        return (new MailMessage)
                    ->subject("Mise à jour du statut de votre commande #{$this->order->id} chez {$restaurantName}")
                    ->line("Bonjour {$notifiable->name},")
                    ->line("Le statut de votre commande #{$this->order->id} chez {$restaurantName} a été mis à jour.")
                    ->line("L'ancien statut était: {$this->oldStatus}")
                    ->line("Le nouveau statut est: {$newStatus}")
                    ->action('Voir votre commande', route('orders.show', $this->order->id))
                    ->line('Merci de votre commande !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'restaurant_name' => $this->order->restaurant->name,
            'old_status' => $this->oldStatus,
            'new_status' => $this->order->status,
        ];
    }
}