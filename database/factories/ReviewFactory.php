<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional(0.7)->sentence(),
        ];
    }
}
