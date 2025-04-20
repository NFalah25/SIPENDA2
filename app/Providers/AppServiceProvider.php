<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public static $permissions = [
        'arsip' => ['user'],
        'unit' => ['admin'],
        'user' => ['admin'],
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach (self::$permissions as $role => $permissions) {
            Gate::define($role, function ($user) use ($permissions) {
                return in_array($user->role, $permissions);
            });
        }
    }
}
