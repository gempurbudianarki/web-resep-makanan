<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Recipe $recipe): bool
    {
        if ($recipe->status === 'published') {
            return true;
        }

        if (!$user) {
            return false;
        }

        return $user->id === $recipe->user_id || $user->hasPermissionTo('bypass-all');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id || $user->hasPermissionTo('bypass-all');
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id || $user->hasPermissionTo('bypass-all');
    }
}
