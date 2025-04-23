<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderStatusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderStatusUpdated  $event
     * @return void
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $user = $event->order->user;
        $user->notify(new OrderStatusChangedNotification($event->order, $event->oldStatus));
    }
}