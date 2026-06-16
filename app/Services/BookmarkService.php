<?php

namespace App\Services;

use App\Models\Recipe;

class BookmarkService
{
    public function toggle(Recipe $recipe, int $userId): array
    {
        $isBookmarked = $recipe->bookmarks()->where('user_id', $userId)->exists();

        if ($isBookmarked) {
            $recipe->bookmarks()->detach($userId);
            return ['bookmarked' => false, 'message' => 'Resep dihapus dari bookmark'];
        }

        $recipe->bookmarks()->attach($userId);
        return ['bookmarked' => true, 'message' => 'Resep disimpan ke bookmark'];
    }

    public function getUserBookmarks(int $userId, int $perPage = 15)
    {
        return Recipe::with(['recipeable', 'categories', 'user'])
            ->published()
            ->whereHas('bookmarks', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->paginate($perPage);
    }
}
