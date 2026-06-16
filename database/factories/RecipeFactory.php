<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'steps' => [
                fake()->sentence(),
                fake()->sentence(),
                fake()->sentence(),
            ],
            'status' => fake()->randomElement(['published', 'published', 'published', 'draft']),
        ];
    }

    public function food(): static
    {
        return $this->afterCreating(function (Recipe $recipe) {
            $food = \App\Models\FoodRecipe::factory()->create();
            $recipe->recipeable()->associate($food);
            $recipe->save();
        });
    }

    public function drink(): static
    {
        return $this->afterCreating(function (Recipe $recipe) {
            $drink = \App\Models\DrinkRecipe::factory()->create();
            $recipe->recipeable()->associate($drink);
            $recipe->save();
        });
    }

    public function published(): static
    {
        return $this->state(fn () => ['status' => 'published']);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }
}
