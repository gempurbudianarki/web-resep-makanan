<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $ingredients = Ingredient::query()
            ->when($request->get('search'), function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate($request->get('per_page', 50));

        return response()->json([
            'data' => IngredientResource::collection($ingredients->items()),
            'meta' => [
                'current_page' => $ingredients->currentPage(),
                'last_page' => $ingredients->lastPage(),
                'per_page' => $ingredients->perPage(),
                'total' => $ingredients->total(),
            ],
        ]);
    }
}
