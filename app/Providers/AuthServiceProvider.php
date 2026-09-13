<?php

namespace App\Providers;

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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // 🔑 Gate для проверки, может ли пользователь быть автором
        Gate::define('be-author', function (User $user) {
            return in_array($user->role, ['admin', 'author']);
        });

        // 🔑 Gate для доступа к админ-панели
        Gate::define('access-admin-panel', function (User $user) {
            return $user->role === 'admin';
        });

        // 🔑 Gate для проверки, является ли пользователь админом
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // 🔑 Gate для проверки, является ли пользователь автором (строго author, не admin)
        Gate::define('is-author', function (User $user) {
            return $user->role === 'author';
        });

        // 🔑 Gate для проверки, является ли пользователь обычным user
        Gate::define('is-user', function (User $user) {
            return $user->role === 'user';
        });
    }
}
