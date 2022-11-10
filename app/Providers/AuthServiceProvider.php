<?php

namespace App\Providers;

use App\Models\Propose;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('npo', function (User $user) {
            return isset($user->npo);
        });

        Gate::define('volunteer', function (User $user) {
            return !(isset($user->npo));
        });

        // message
        Gate::define('message', function (User $user, Propose $propose) {
            return $user->id === $propose->user_id
                || $user->id === $propose->application->volunteer->user_id;
        });
    }
}
