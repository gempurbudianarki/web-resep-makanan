<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Recipe;
use App\Models\Review;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        protected RatingService $ratingService,
    ) {}

    public function index(Recipe $recipe): JsonResponse
    {
        $reviews = $recipe->reviews()
            ->with('user')
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => ReviewResource::collection($reviews->items()),
            'meta' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ],
        ]);
    }

    public function store(StoreReviewRequest $request, Recipe $recipe): JsonResponse
    {
        $review = $this->ratingService->createOrUpdate(
            recipe: $recipe,
            userId: $request->user()->id,
            rating: $request->rating,
            comment: $request->comment,
        );

        return response()->json([
            'data' => new ReviewResource($review->load('user')),
        ], 201);
    }

    public function update(StoreReviewRequest $request, Recipe $recipe, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id) {
            abort(403, 'Tidak diizinkan mengedit review orang lain');
        }

        $updated = $this->ratingService->createOrUpdate(
            recipe: $recipe,
            userId: $request->user()->id,
            rating: $request->rating,
            comment: $request->comment,
        );

        return response()->json([
            'data' => new ReviewResource($updated->load('user')),
        ]);
    }

    public function destroy(Request $request, $recipeId, Review $review): JsonResponse
    {
        $user = $request->user();

        if ($review->user_id !== $user->id && !$user->hasPermissionTo('bypass-all')) {
            abort(403, 'Tidak diizinkan menghapus review ini');
        }

        $this->ratingService->delete($review);

        return response()->json(['message' => 'Review berhasil dihapus']);
    }
}
