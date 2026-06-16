<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RatingService;
use App\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct(
        protected RecipeService $recipeService,
        protected RatingService $ratingService,
    ) {}

    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $recipes = $this->recipeService->search(
            query: $request->get('search'),
            categoryId: $request->get('category_id'),
            perPage: 12,
            sort: $request->get('sort', 'rating'),
        );

        $featuredRecipes = Recipe::with(['recipeable', 'categories', 'user'])
            ->published()
            ->orderBy('avg_rating', 'desc')
            ->take(8)
            ->get();

        return view('recipes.index', compact('recipes', 'categories', 'featuredRecipes'));
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['recipeable', 'categories', 'ingredients', 'user']);

        $reviews = $recipe->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        $reviewsCount = $recipe->reviews()->count();

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = $recipe->bookmarks()->where('user_id', auth()->id())->exists();
        }

        return view('recipes.show', compact('recipe', 'isBookmarked', 'reviews', 'reviewsCount'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('recipes.create', compact('categories', 'ingredients'));
    }

    public function store(StoreRecipeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->resolveImage($request);

        $recipe = $this->recipeService->create($data, auth()->id());

        return redirect()->route('recipes.show', $recipe)
            ->with('success', __('ui.resep_berhasil_dibuat'));
    }

    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $recipe->load(['recipeable', 'categories', 'ingredients']);
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $data = $request->validated();
        $data['image'] = $this->resolveImage($request);

        if ($request->has('remove_image') && $request->remove_image) {
            $data['image'] = '__REMOVE__';
        } elseif (!$request->hasFile('image')) {
            unset($data['image']);
        }

        $recipe = $this->recipeService->update($recipe, $data);

        return redirect()->route('recipes.show', $recipe)
            ->with('success', __('ui.resep_berhasil_diperbarui'));
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        $this->recipeService->delete($recipe);

        return redirect()->route('dashboard')->with('success', __('ui.resep_berhasil_dihapus'));
    }

    public function storeReview(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->ratingService->createOrUpdate(
            recipe: $recipe,
            userId: auth()->id(),
            rating: $request->rating,
            comment: $request->comment,
        );

        return back()->with('success', __('ui.review_berhasil_disimpan'));
    }

    public function destroyReview(Recipe $recipe, \App\Models\Review $review)
    {
        $user = auth()->user();

        if ($review->user_id !== $user->id && !$user->hasPermissionTo('bypass-all')) {
            abort(403, 'Tidak diizinkan menghapus review ini');
        }

        $this->ratingService->delete($review);

        return back()->with('success', __('ui.review_berhasil_dihapus'));
    }

    public function print(Recipe $recipe)
    {
        $recipe->load(['recipeable', 'ingredients', 'user']);
        return view('recipes.print', compact('recipe'));
    }

    private function resolveImage($request)
    {
        if ($request->hasFile('image')) {
            return $request->file('image');
        }

        $imageData = $request->input('image_data');
        if ($imageData && str_starts_with($imageData, 'data:image')) {
            return $this->base64ToUploadedFile($imageData);
        }

        return null;
    }

    private function base64ToUploadedFile(string $dataUrl): ?\Illuminate\Http\UploadedFile
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $matches)) {
            return null;
        }

        $extension = strtolower($matches[1]);
        if ($extension === 'jpeg') $extension = 'jpg';

        $data = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1));
        if (!$data) return null;

        $tmpPath = tempnam(sys_get_temp_dir(), 'crop_') . '.' . $extension;
        file_put_contents($tmpPath, $data);

        return new \Illuminate\Http\UploadedFile(
            $tmpPath,
            'cropped.' . $extension,
            'image/' . ($extension === 'jpg' ? 'jpeg' : $extension),
            null,
            true
        );
    }
}
