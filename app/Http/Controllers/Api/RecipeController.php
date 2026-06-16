<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct(
        protected RecipeService $recipeService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $recipes = $this->recipeService->search(
            query: $request->get('search'),
            categoryId: $request->get('category_id'),
            perPage: $request->get('per_page', 15),
        );

        return response()->json([
            'data' => RecipeResource::collection($recipes->items()),
            'meta' => [
                'current_page' => $recipes->currentPage(),
                'last_page' => $recipes->lastPage(),
                'per_page' => $recipes->perPage(),
                'total' => $recipes->total(),
            ],
        ]);
    }

    public function show(Recipe $recipe): JsonResponse
    {
        $recipe->load(['recipeable', 'categories', 'ingredients', 'user', 'reviews' => fn ($q) => $q->with('user')->latest()->limit(5)]);

        return response()->json([
            'data' => new RecipeResource($recipe),
        ]);
    }

    public function store(StoreRecipeRequest $request): JsonResponse
    {
        $recipe = $this->recipeService->create(
            $request->validated(),
            $request->user()->id,
        );

        return response()->json([
            'data' => new RecipeResource($recipe),
        ], 201);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe): JsonResponse
    {
        $this->authorize('update', $recipe);

        $recipe = $this->recipeService->update($recipe, $request->validated());

        return response()->json([
            'data' => new RecipeResource($recipe),
        ]);
    }

    public function destroy(Recipe $recipe): JsonResponse
    {
        $this->authorize('delete', $recipe);

        $this->recipeService->delete($recipe);

        return response()->json(['message' => 'Resep berhasil dihapus']);
    }
}
