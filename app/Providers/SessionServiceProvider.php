<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\SessionControl;
use App\Services\UserSession;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(SessionControl::class, function ($app) {
            return $app->make(UserSession::class);
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
