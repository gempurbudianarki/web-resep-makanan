<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => CategoryResource::collection(Category::orderBy('name')->get()),
        ]);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'data' => new CategoryResource($category),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'data' => new CategoryResource($category),
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}
