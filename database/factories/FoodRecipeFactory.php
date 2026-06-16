<?php

namespace Database\Factories;

use App\Models\FoodRecipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodRecipeFactory extends Factory
{
    protected $model = FoodRecipe::class;

    public function definition(): array
    {
        return [
            'cooking_time' => fake()->numberBetween(5, 180),
            'serving_size' => fake()->numberBetween(1, 8),
            'calories' => fake()->numberBetween(50, 800),
        ];
    }
}
