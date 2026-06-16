<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct(
        protected BookmarkService $bookmarkService,
    ) {}

    public function toggle(Recipe $recipe, Request $request): JsonResponse
    {
        $result = $this->bookmarkService->toggle($recipe, $request->user()->id);

        return response()->json($result);
    }

    public function index(Request $request): JsonResponse
    {
        $bookmarks = $this->bookmarkService->getUserBookmarks(
            userId: $request->user()->id,
            perPage: $request->get('per_page', 15),
        );

        return response()->json([
            'data' => RecipeResource::collection($bookmarks->items()),
            'meta' => [
                'current_page' => $bookmarks->currentPage(),
                'last_page' => $bookmarks->lastPage(),
                'per_page' => $bookmarks->perPage(),
                'total' => $bookmarks->total(),
            ],
        ]);
    }
}
