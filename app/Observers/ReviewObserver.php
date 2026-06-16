<?php

namespace App\Observers;

use App\Models\Review;
use App\Services\RatingService;

class ReviewObserver
{
    public function __construct(
        protected RatingService $ratingService,
    ) {}

    public function created(Review $review): void
    {
        $this->ratingService->recalculateAvgRating($review->recipe);
    }

    public function updated(Review $review): void
    {
        $this->ratingService->recalculateAvgRating($review->recipe);
    }

    public function deleted(Review $review): void
    {
        $this->ratingService->recalculateAvgRating($review->recipe);
    }
}
