<?php

namespace App\Providers;

use App\Models\Recipe;
use App\Policies\RecipePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Recipe::class => RecipePolicy::class,
    ];

    public function boot(): void
    {
        Gate::before(function ($user) {
            if ($user->hasPermissionTo('bypass-all')) {
                return true;
            }
        });
    }
}
