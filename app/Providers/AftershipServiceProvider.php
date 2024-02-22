<?php

namespace App\Providers;

use Aftership;
use Illuminate\Support\ServiceProvider;

class AftershipServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Aftership::class, function ($app) {
            $apiKey = config('app.AFTERSHIP_API_KEY');
            return new Aftership($apiKey);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}