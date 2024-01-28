<?php

namespace App\Providers;

// use Illuminate\Auth\Notifications\ResetPassword; BLOG
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            Gate::before(function () {
                // Permitir acceso en todas las pruebas
                return true;
            });
        }

        /*
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        }); BLOG
        */
    }
}
