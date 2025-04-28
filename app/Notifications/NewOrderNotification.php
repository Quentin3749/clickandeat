<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle commande reçue')
            ->line('Vous avez reçu une nouvelle commande pour votre restaurant !')
            ->action('Voir la commande', url('/restaurateur/commandes/'.$this->order->id))
            ->line('Merci d’utiliser ClickAndEat !');
    }
}
