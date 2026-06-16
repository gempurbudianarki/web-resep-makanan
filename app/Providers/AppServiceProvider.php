<?php

namespace App\Providers;

use App\Models\FoodRecipe;
use App\Models\DrinkRecipe;
use App\Models\Review;
use App\Observers\ReviewObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

    public function boot(): void
    {
        Relation::morphMap([
            'food' => FoodRecipe::class,
            'drink' => DrinkRecipe::class,
        ]);

        Review::observe(app(ReviewObserver::class));
    }
}
