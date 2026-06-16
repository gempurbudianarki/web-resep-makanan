<?php

namespace Tests\Feature;

use App\Models\FoodRecipe;
use App\Models\Recipe;
use App\Models\User;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    protected User $user;
    protected Recipe $recipe;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->assignRole('user');

        $owner = User::factory()->create();
        $food = FoodRecipe::factory()->create();
        $this->recipe = Recipe::factory()
            ->for($owner)
            ->published()
            ->create();
        $this->recipe->recipeable()->associate($food)->save();
    }

    public function test_guest_can_view_reviews(): void
    {
        $response = $this->getJson("/api/recipes/{$this->recipe->id}/reviews");

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function test_user_can_submit_review(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/reviews", [
            'rating' => 5,
            'comment' => 'Enak banget!',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.rating', 5);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'recipe_id' => $this->recipe->id,
            'rating' => 5,
        ]);
    }

    public function test_review_updates_recipe_avg_rating(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $this->recipe->update(['avg_rating' => 0]);
        $this->assertDatabaseHas('recipes', ['id' => $this->recipe->id, 'avg_rating' => 0]);

        $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/reviews", [
            'rating' => 5,
        ]);

        $this->assertDatabaseHas('reviews', [
            'recipe_id' => $this->recipe->id,
            'user_id' => $this->user->id,
            'rating' => 5,
        ]);

        $updated = \App\Models\Recipe::find($this->recipe->id);
        $this->assertEquals(5.0, (float) $updated->avg_rating);
    }

    public function test_guest_cannot_submit_review(): void
    {
        $response = $this->postJson("/api/recipes/{$this->recipe->id}/reviews", [
            'rating' => 5,
        ]);

        $response->assertStatus(401);
    }

    public function test_rating_must_be_between_1_and_5(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/reviews", [
            'rating' => 6,
        ]);

        $response->assertStatus(422);
    }
}
