<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogLastLogin',
        ],
        'App\Events\ParcelEvent' => [
            'App\Listeners\ParcelListener',
        ],
        'App\Events\OrderEvent' => [
            'App\Listeners\OrderListener',
        ],
        'App\Events\ConsolidateEvent' => [
            'App\Listeners\ConsolidateListener',
        ],
        'App\Events\UserEvent' => [
            'App\Listeners\UserListener',
        ],
        'App\Events\WalletEvent' => [
            'App\Listeners\WalletListener',
        ],
        'App\Events\UserCreated' => [
            'App\Listeners\NotifyAdminOnUserCreation',
        ],
        'App\Events\PasswordReset' => [
            'App\Listeners\PasswordResetNotification',
        ],
        'App\Events\Scrapping' => [
            'App\Listeners\ProcessScrapping',
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
