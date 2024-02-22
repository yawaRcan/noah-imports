<?php

namespace App\Listeners;

use App\Events\ConsolidateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ConsolidateStatusNotification;
use App\Notifications\CreateConsolidateNotification;
use App\Notifications\UpdateConsolidateNotification;
use App\Notifications\ConsolidatePaymentStatusNotification;

class ConsolidateListener
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
    public function handle(ConsolidateEvent $event): void
    {

        if ($event->eventName == 'CreateConsolidate') {
    
            Notification::send($event->notifiable, new CreateConsolidateNotification($event->template, $event->shortCodes, $event->consolidate));
        }
        if ($event->eventName == 'UpdateConsolidate') {
            Notification::send($event->notifiable, new UpdateConsolidateNotification($event->template, $event->shortCodes, $event->consolidate));
        }
        if ($event->eventName == 'OrderStatus') {
            Notification::send($event->notifiable, new ConsolidateStatusNotification($event->template, $event->shortCodes, $event->consolidate));
        }
        if ($event->eventName == 'OrderPaymentStatus') {
            Notification::send($event->notifiable, new ConsolidatePaymentStatusNotification($event->template, $event->shortCodes, $event->consolidate));
        }
    }
}
