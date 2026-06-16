<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Garam', 'Gula', 'Tepung Terigu', 'Telur', 'Bawang Putih',
                'Bawang Merah', 'Cabai', 'Minyak Goreng', 'Kecap Manis', 'Saus Tiram',
                'Merica', 'Ketumbar', 'Kunyit', 'Jahe', 'Lengkuas',
                'Daun Salam', 'Serai', 'Santan', 'Susu', 'Mentega',
                'Keju', 'Coklat', 'Vanili', 'Baking Powder', 'Ragi',
            ]),
        ];
    }
}
