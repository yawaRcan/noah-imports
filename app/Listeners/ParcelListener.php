<?php

namespace App\Listeners;

use Log;
use App\Events\ParcelEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreateParcelNotification;
use App\Notifications\ParcelStatusNotification;
use App\Notifications\UpdateParcelNotification;
use App\Notifications\ConsolidateParcelNotification;
use App\Notifications\ParcelPaymentStatusNotification;

class ParcelListener
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
    public function handle(ParcelEvent $event): void
    {  
       
        if($event->eventName == 'CreateParcel')
        {
            Notification::send($event->notifiable, new CreateParcelNotification($event->template,$event->shortCodes,$event->parcel));
        }
        if($event->eventName == 'UpdateParcel')
        {
            Notification::send($event->notifiable, new UpdateParcelNotification($event->template,$event->shortCodes,$event->parcel));
        }
        if($event->eventName == 'ParcelStatus')
        {
            Notification::send($event->notifiable, new ParcelStatusNotification($event->template,$event->shortCodes,$event->parcel));
        }
        if($event->eventName == 'ParcelPaymentStatus')
        {
            Notification::send($event->notifiable, new ParcelPaymentStatusNotification($event->template,$event->shortCodes,$event->parcel));
        }
        if($event->eventName == 'ConsolidateParcel')
        {
            Notification::send($event->notifiable, new ConsolidateParcelNotification($event->template,$event->shortCodes,$event->parcel));
        }
    }
}
