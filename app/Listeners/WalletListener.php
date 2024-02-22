<?php

namespace App\Listeners;

use App\Events\WalletEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DepositRequestNotification;
use App\Notifications\WithDrawlRequestNotification;
use App\Notifications\ApproveTransactionNotification;
use App\Notifications\RejectTransactionNotification;

class WalletListener
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
    public function handle(WalletEvent $event): void
    {
        if($event->eventName == 'Deposit')
        {
            Notification::send($event->notifiable, new DepositRequestNotification($event->template,$event->shortCodes,$event->wallet));
        }
        if($event->eventName == 'Withdraw')
        {
            Notification::send($event->notifiable, new WithDrawlRequestNotification($event->template,$event->shortCodes,$event->wallet));
        }
        if($event->eventName == 'ApproveTransaction')
        {
            Notification::send($event->notifiable, new ApproveTransactionNotification($event->template,$event->shortCodes, $event->wallet));
        }
        if($event->eventName == 'RejectTransaction')
        {
            Notification::send($event->notifiable, new RejectTransactionNotification($event->template,$event->shortCodes, $event->wallet));
        }
    }
}
