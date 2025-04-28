<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Notification envoyée lorsqu'un statut de commande change (ex : en préparation, livré, etc.)
class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * La commande concernée par la notification.
     * @var Order
     */
    public $order;

    /**
     * L'ancien statut de la commande avant le changement.
     * @var string
     */
    public $oldStatus;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param  Order   $order      La commande concernée
     * @param  string  $oldStatus  L'ancien statut
     */
    public function __construct(Order $order, string $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Détermine les canaux de diffusion de la notification.
     * Ici : email et base de données.
     *
     * @param  mixed $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // On envoie la notification par email et on l'enregistre en base de données
        return ['mail', 'database']; // Nous allons envoyer un email et enregistrer la notification en base de données
    }

    /**
     * Génère le contenu de l'email envoyé lors du changement de statut.
     *
     * @param  mixed $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $newStatus = $this->order->status;
        $restaurantName = $this->order->restaurant->name;

        // Ici tu peux personnaliser le contenu de l'email envoyé à l'utilisateur
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
     * Représentation de la notification en base de données.
     *
     * @param  mixed $notifiable
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