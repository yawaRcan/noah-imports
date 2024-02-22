<?php

namespace App\Listeners;

use App\Events\UserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterUserNotification;
use App\Notifications\UpdateUserNotification;
use App\Notifications\ChangePasswordNotification;
use App\Notifications\ActiveUserNotification;
use App\Notifications\ActivatedUserNotification;

class UserListener
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
    public function handle(UserEvent $event): void
    {
        if ($event->eventName == 'RegisterUser') {
            Notification::send($event->notifiable, new RegisterUserNotification($event->template, $event->shortCodes, $event->user));
        }
        if ($event->eventName == 'UpdateUser') {
            Notification::send($event->notifiable, new UpdateUserNotification($event->template, $event->shortCodes, $event->user));
        }
        if ($event->eventName == 'ActiveUserByAdmin') {
            Notification::send($event->notifiable, new ActiveUserNotification($event->template, $event->shortCodes, $event->user));
        }
        if ($event->eventName == 'ActiveUser') {
            Notification::send($event->notifiable, new ActivatedUserNotification($event->template, $event->shortCodes, $event->user));

        }
        if ($event->eventName == 'DeactiveUserByAdmin') {

            Notification::send($event->notifiable, new DeActivatedUserByAdminNotification($event->template, $event->shortCodes, $event->user));
        }
        if ($event->eventName == 'DeactiveUser') {
            Notification::send($event->notifiable, new DeActivatedUserNotification($event->template, $event->shortCodes, $event->user));
        }
        if ($event->eventName == 'ChangePassword') {
            Notification::send($event->notifiable, new ChangePasswordNotification($event->template, $event->shortCodes, $event->user));
        }
    }
}
