<?php

namespace Database\Factories;

use App\Models\DrinkRecipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrinkRecipeFactory extends Factory
{
    protected $model = DrinkRecipe::class;

    public function definition(): array
    {
        return [
            'is_cold' => fake()->boolean(),
            'glass_type' => fake()->randomElement(['Highball', 'Martini', 'Collins', 'Wine', 'Mug', null]),
        ];
    }
}
