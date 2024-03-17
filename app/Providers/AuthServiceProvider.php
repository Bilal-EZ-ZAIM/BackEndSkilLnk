<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Profile;
use App\Models\User;
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

        Gate::define('update-profile', function (User $user, Profile $profile) {

            return $user->id === $profile->user_id;

        });

        Gate::define('cree-profile', function (User $user) {

            return $user ;
            
        });
    }
}
