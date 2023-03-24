<?php

namespace App\Providers;

use App\Policies\AllowedIpPolicy;
use App\Policies\SquidUserPolicy;
use App\Policies\UserPolicy;
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
    public function boot(): void
    {
        Gate::define('create-user', [UserPolicy::class, 'create']);
        Gate::define('modify-user', [UserPolicy::class, 'modify']);
        Gate::define('destroy-user', [UserPolicy::class, 'destroy']);
        Gate::define('search-user', [UserPolicy::class, 'search']);

        Gate::define('create-squid-user', [SquidUserPolicy::class, 'create']);
        Gate::define('modify-squid-user', [SquidUserPolicy::class, 'modify']);
        Gate::define('destroy-squid-user', [SquidUserPolicy::class, 'destroy']);
        Gate::define('search-squid-user', [SquidUserPolicy::class, 'search']);

        Gate::define('create-squid-allowed-ip', [AllowedIpPolicy::class, 'create']);
        Gate::define('destroy-squid-allowed-ip', [AllowedIpPolicy::class, 'destroy']);
        Gate::define('search-squid-allowed-ip', [AllowedIpPolicy::class, 'search']);
    }
}
