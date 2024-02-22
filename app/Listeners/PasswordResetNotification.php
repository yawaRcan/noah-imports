<?php

namespace App\Listeners;

use App\Notifications\ChangePasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PasswordReset;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordResetLinkNotification;


class PasswordResetNotification
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
    public function handle(PasswordReset $event): void
    {
        if ($event->eventName == "PasswordReset") {
            Notification::send($event->notifiable, new ChangePasswordNotification($event->template, $event->shortCodes, $event->notifiable));
        }


    }
}
