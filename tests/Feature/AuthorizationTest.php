<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    public function test_normal_user_cannot_access_admin_endpoints(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->postJson('/api/categories', [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(403);
    }

    public function test_superadmin_can_manage_categories(): void
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');
        $token = $superadmin->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->postJson('/api/categories', [
            'name' => 'New Category',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'New Category');

        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    public function test_superadmin_gate_bypass_all_works(): void
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');

        $this->assertTrue($superadmin->can('bypass-all'));
        $this->assertTrue($superadmin->hasPermissionTo('bypass-all'));
    }
}
