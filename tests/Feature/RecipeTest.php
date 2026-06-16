<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\FoodRecipe;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    public function test_guest_can_browse_recipes(): void
    {
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($this->user)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $response = $this->getJson('/api/recipes');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function test_guest_can_view_single_recipe(): void
    {
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($this->user)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $response = $this->getJson("/api/recipes/{$recipe->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.title', $recipe->title);
    }

    public function test_authenticated_user_can_create_food_recipe(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;
        $category = Category::factory()->create();
        $ingredient = Ingredient::factory()->create();

        $response = $this->withToken($token)->postJson('/api/recipes', [
            'title' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan bumbu rahasia',
            'recipeable_type' => 'food',
            'recipeable' => [
                'cooking_time' => 30,
                'serving_size' => 4,
                'calories' => 250,
            ],
            'categories' => [$category->id],
            'ingredients' => [
                [
                    'ingredient_id' => $ingredient->id,
                    'amount' => 2,
                    'unit' => 'piring',
                ],
            ],
            'steps' => ['Siapkan bahan', 'Masak nasi', 'Sajikan'],
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title', 'slug', 'recipeable']]);

        $this->assertDatabaseHas('recipes', ['title' => 'Nasi Goreng Spesial']);
        $this->assertDatabaseHas('food_recipes', ['cooking_time' => 30]);
    }

    public function test_authenticated_user_can_create_drink_recipe(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->postJson('/api/recipes', [
            'title' => 'Es Teh Manis',
            'description' => 'Teh manis segar',
            'recipeable_type' => 'drink',
            'recipeable' => [
                'is_cold' => true,
                'glass_type' => 'Highball',
            ],
            'steps' => ['Seduh teh', 'Tambahkan gula', 'Beri es batu'],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('drink_recipes', ['is_cold' => true, 'glass_type' => 'Highball']);
    }

    public function test_user_can_update_own_recipe(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($this->user)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $response = $this->withToken($token)->putJson("/api/recipes/{$recipe->id}", [
            'title' => 'Nasi Goreng Update',
            'description' => 'Deskripsi baru',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Nasi Goreng Update');

        $this->assertDatabaseHas('recipes', ['id' => $recipe->id, 'title' => 'Nasi Goreng Update']);
    }

    public function test_user_cannot_update_others_recipe(): void
    {
        $otherUser = User::factory()->create();
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($otherUser)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $token = $this->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->putJson("/api/recipes/{$recipe->id}", [
            'title' => 'Hacked Title',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_recipe(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($this->user)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $response = $this->withToken($token)->deleteJson("/api/recipes/{$recipe->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    public function test_superadmin_can_delete_any_recipe(): void
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');

        $otherUser = User::factory()->create();
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($otherUser)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $token = $superadmin->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->deleteJson("/api/recipes/{$recipe->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    public function test_search_recipes_by_query(): void
    {
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($this->user)
            ->published()
            ->state(['title' => 'Nasi Goreng Istimewa'])
            ->create();
        $recipe->recipeable()->associate($food)->save();

        $response = $this->getJson('/api/recipes?search=goreng');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_recipes_can_be_filtered_by_category(): void
    {
        $category = Category::factory()->create(['name' => 'Masakan']);
        $food = FoodRecipe::factory()->create();
        $recipe = Recipe::factory()
            ->for($this->user)
            ->published()
            ->create();
        $recipe->recipeable()->associate($food)->save();
        $recipe->categories()->attach($category);

        $response = $this->getJson("/api/recipes?category_id={$category->id}");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
