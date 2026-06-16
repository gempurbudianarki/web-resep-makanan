<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function __construct(
        protected RecipeService $recipeService,
    ) {}

    public function index(Request $request)
    {
        $recipes = Recipe::with(['user', 'recipeable', 'categories'])
            ->withCount('reviews')
            ->when($request->get('search'), function ($q, $search) {
                $sanitized = str_replace(['%', '_'], ['\%', '\_'], trim($search));
                $q->where('title', 'like', "%{$sanitized}%");
            })
            ->when($request->get('status'), function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.recipes.index', compact('recipes'));
    }

    public function destroy(Recipe $recipe)
    {
        $this->recipeService->delete($recipe);
        return back()->with('success', __('ui.resep_berhasil_dihapus'));
    }

    public function toggleStatus(Recipe $recipe)
    {
        $recipe->update([
            'status' => $recipe->status === 'published' ? 'draft' : 'published',
        ]);
        return back()->with('success', __('ui.status_diperbarui'));
    }

    public function categories()
    {
        $categories = Category::withCount('recipes')->orderBy('name')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:255', 'unique:categories']]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', __('ui.kategori_ditambah'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', __('ui.kategori_diperbarui'));
    }

    public function destroyCategory(Category $category)
    {
        $recipeCount = $category->recipes()->count();

        if ($recipeCount > 0) {
            return back()->with(
                'error',
                __('ui.kategori_punya_resep', ['name' => $category->name, 'count' => $recipeCount])
            );
        }

        $category->delete();
        return back()->with('success', __('ui.kategori_dihapus'));
    }
}
