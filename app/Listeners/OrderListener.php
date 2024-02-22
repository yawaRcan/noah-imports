<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreateOrderNotification;
use App\Notifications\OrderStatusNotification;
use App\Notifications\UpdateOrderNotification;
use App\Notifications\OrderPaymentStatusNotification;

class OrderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderEvent $event): void
    {
        if($event->eventName == 'CreateOrder')
        {
            Notification::send($event->notifiable, new CreateOrderNotification($event->template,$event->shortCodes,$event->order));
        }
        if($event->eventName == 'UpdateOrder')
        {
            Notification::send($event->notifiable, new UpdateOrderNotification($event->template,$event->shortCodes,$event->order));
        }
        if($event->eventName == 'OrderStatus')
        {
            Notification::send($event->notifiable, new OrderStatusNotification($event->template,$event->shortCodes,$event->order));
        }
        if($event->eventName == 'OrderPaymentStatus')
        {
            Notification::send($event->notifiable, new OrderPaymentStatusNotification($event->template,$event->shortCodes,$event->order));
        }
    }
}
