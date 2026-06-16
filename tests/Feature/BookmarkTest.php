<?php

namespace Tests\Feature;

use App\Models\FoodRecipe;
use App\Models\Recipe;
use App\Models\User;
use Tests\TestCase;

class BookmarkTest extends TestCase
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

    public function test_user_can_toggle_bookmark_on(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson("/api/recipes/{$this->recipe->id}/bookmark");

        $response->assertStatus(200)
            ->assertJson(['bookmarked' => true]);

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $this->user->id,
            'recipe_id' => $this->recipe->id,
        ]);
    }

    public function test_user_can_toggle_bookmark_off(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/bookmark");

        $response = $this->withToken($token)
            ->postJson("/api/recipes/{$this->recipe->id}/bookmark");

        $response->assertStatus(200)
            ->assertJson(['bookmarked' => false]);

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $this->user->id,
            'recipe_id' => $this->recipe->id,
        ]);
    }

    public function test_user_can_view_their_bookmarks(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/bookmark");

        $response = $this->withToken($token)->getJson('/api/bookmarks');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_guest_cannot_bookmark(): void
    {
        $response = $this->postJson("/api/recipes/{$this->recipe->id}/bookmark");

        $response->assertStatus(401);
    }

    public function test_duplicate_bookmark_does_not_create_duplicate(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/bookmark");
        $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/bookmark");
        $this->withToken($token)->postJson("/api/recipes/{$this->recipe->id}/bookmark");

        $this->assertDatabaseCount('bookmarks', 1);
    }
}
