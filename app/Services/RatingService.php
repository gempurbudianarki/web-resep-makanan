<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\Review;

class RatingService
{
    public function createOrUpdate(Recipe $recipe, int $userId, int $rating, ?string $comment = null): Review
    {
        $review = Review::withTrashed()
            ->where('user_id', $userId)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($review) {
            if ($review->trashed()) {
                $review->restore();
            }
            $review->update([
                'rating' => $rating,
                'comment' => $comment,
            ]);
            return $review;
        }

        return Review::create([
            'user_id' => $userId,
            'recipe_id' => $recipe->id,
            'rating' => $rating,
            'comment' => $comment,
        ]);
    }

    public function delete(Review $review): void
    {
        $review->delete();
    }

    public function recalculateAvgRating(Recipe $recipe): void
    {
        $avg = $recipe->reviews()->avg('rating');

        $recipe->update([
            'avg_rating' => round($avg ?? 0, 2),
        ]);
    }
}
