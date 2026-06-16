<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodRecipe;
use App\Models\DrinkRecipe;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding demo data...');

        $superadmin = User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@resepkita.test',
            'password' => 'password',
        ]);
        $superadmin->assignRole('superadmin');

        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()->create(['password' => 'password']);
            $user->assignRole('user');
            $users[] = $user;
        }

        $ingredients = Ingredient::factory()->count(20)->create();
        $categories = Category::all();
        $units = ['sdm', 'sdt', 'buah', 'gram', 'ml', 'gelas', 'piring'];

        $this->command->info('Creating food recipes...');
        for ($i = 0; $i < 12; $i++) {
            $user = $users[array_rand($users)];
            $recipe = Recipe::factory()
                ->for($user)
                ->published()
                ->food()
                ->create();

            $recipe->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            $pivotData = [];
            foreach ($ingredients->random(rand(3, 7)) as $ing) {
                $pivotData[$ing->id] = [
                    'amount' => rand(1, 5),
                    'unit' => $units[array_rand($units)],
                ];
            }
            $recipe->ingredients()->attach($pivotData);

            Review::factory()->count(rand(1, 4))->create([
                'recipe_id' => $recipe->id,
            ]);

            app(\App\Services\RatingService::class)->recalculateAvgRating($recipe);
        }

        $this->command->info('Creating drink recipes...');
        for ($i = 0; $i < 6; $i++) {
            $user = $users[array_rand($users)];
            $recipe = Recipe::factory()
                ->for($user)
                ->published()
                ->drink()
                ->create();

            $recipe->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );

            $pivotData = [];
            foreach ($ingredients->random(rand(2, 5)) as $ing) {
                $pivotData[$ing->id] = [
                    'amount' => rand(1, 3),
                    'unit' => $units[array_rand($units)],
                ];
            }
            $recipe->ingredients()->attach($pivotData);

            Review::factory()->count(rand(0, 3))->create([
                'recipe_id' => $recipe->id,
            ]);

            app(\App\Services\RatingService::class)->recalculateAvgRating($recipe);
        }

        $this->command->info('Demo data seeded!');
        $this->command->info('  Superadmin: admin@resepkita.test / password');
        $this->command->info('  All other users password: password');
    }
}
