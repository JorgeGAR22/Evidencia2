<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Notifications\WelcomeEmailNotification;
use App\Notifications\LoginAlertNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log; // Asegúrate de agregar esta línea de 'use'

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        
        User::created(function (User $user) {
            $user->notify(new WelcomeEmailNotification());
        });

        Event::listen(Login::class, function (Login $event) {
            $event->user->notify(new LoginAlertNotification());
        });
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}