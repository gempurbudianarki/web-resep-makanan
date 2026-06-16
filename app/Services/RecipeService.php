<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\FoodRecipe;
use App\Models\DrinkRecipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    public function __construct(
        protected ?TranslationService $translationService = null,
    ) {
        $this->translationService = $translationService ?? app(TranslationService::class);
    }
    public function create(array $data, int $userId): Recipe
    {
        return DB::transaction(function () use ($data, $userId) {
            $recipeable = $this->createRecipeable($data);

            $translated = $this->translationService->translateRecipe($data);

            $recipe = Recipe::create([
                'user_id' => $userId,
                'title' => $data['title'],
                'title_en' => $translated['title_en'] ?? null,
                'description' => $data['description'],
                'description_en' => $translated['description_en'] ?? null,
                'image' => $this->handleImageUpload($data['image'] ?? null),
                'steps' => $data['steps'] ?? [],
                'steps_en' => $translated['steps_en'] ?? null,
                'status' => $data['status'] ?? 'published',
            ]);

            $recipe->recipeable()->associate($recipeable);
            $recipe->save();

            if (!empty($data['categories'])) {
                $recipe->categories()->sync($data['categories']);
            }

            if (!empty($data['ingredients'])) {
                $this->syncIngredients($recipe, $data['ingredients']);
            }

            return $recipe->load(['recipeable', 'categories', 'ingredients']);
        });
    }

    public function update(Recipe $recipe, array $data): Recipe
    {
        return DB::transaction(function () use ($recipe, $data) {
            $updateData = array_filter([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'steps' => $data['steps'] ?? null,
                'status' => $data['status'] ?? null,
            ], fn ($v) => $v !== null);

            if (isset($data['image'])) {
                $updateData['image'] = $this->handleImageUpload($data['image'], $recipe->getRawOriginal('image'));
            }

            if (!empty($updateData)) {
                $recipe->update($updateData);
            }

            if (isset($data['title']) || isset($data['description']) || isset($data['steps'])) {
                $translated = $this->translationService->translateRecipe([
                    'title' => $data['title'] ?? $recipe->title,
                    'description' => $data['description'] ?? $recipe->description,
                    'steps' => $data['steps'] ?? $recipe->steps,
                ]);

                $translateUpdate = [];
                if (isset($translated['title_en'])) {
                    $translateUpdate['title_en'] = $translated['title_en'];
                }
                if (isset($translated['description_en'])) {
                    $translateUpdate['description_en'] = $translated['description_en'];
                }
                if (isset($translated['steps_en'])) {
                    $translateUpdate['steps_en'] = $translated['steps_en'];
                }

                if (!empty($translateUpdate)) {
                    $recipe->update($translateUpdate);
                }
            }

            if (!empty($data['recipeable'])) {
                $recipeable = $recipe->recipeable;
                if ($recipeable) {
                    $recipeable->update($data['recipeable']);
                }
            }

            if (isset($data['categories'])) {
                $recipe->categories()->sync($data['categories']);
            }

            if (isset($data['ingredients'])) {
                $this->syncIngredients($recipe, $data['ingredients']);
            }

            return $recipe->fresh(['recipeable', 'categories', 'ingredients']);
        });
    }

    public function delete(Recipe $recipe): void
    {
        DB::transaction(function () use ($recipe) {
            if ($recipe->recipeable) {
                $recipe->recipeable->delete();
            }

            $recipe->delete();
        });
    }

    public function search(?string $query = null, ?int $categoryId = null, int $perPage = 15, string $sort = 'rating')
    {
        $sanitizedQuery = $query ? $this->sanitizeSearchQuery($query) : null;

        return Recipe::with(['recipeable', 'categories', 'user'])
            ->published()
            ->when($sanitizedQuery, function ($q) use ($sanitizedQuery) {
                $q->where(function ($sub) use ($sanitizedQuery) {
                    $sub->whereFullText(['title', 'description'], $sanitizedQuery)
                       ->orWhere('title', 'like', "%{$sanitizedQuery}%")
                       ->orWhere('description', 'like', "%{$sanitizedQuery}%");
                });
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->byCategory($categoryId);
            })
            ->when($sort === 'rating', fn ($q) => $q->orderBy('avg_rating', 'desc'))
            ->when($sort === 'latest', fn ($q) => $q->latest())
            ->paginate($perPage);
    }

    private function sanitizeSearchQuery(string $query): string
    {
        $sanitized = preg_replace('/[%_]/', '\\\\$0', $query);

        return trim($sanitized);
    }

    private function handleImageUpload($image, ?string $oldImage = null): ?string
    {
        if (!$image) {
            return null;
        }

        if ($image instanceof \Illuminate\Http\UploadedFile && $image->isValid()) {
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName) . '.webp';
            $path = $this->optimizeAndStore($image, $filename);

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return $path;
        }

        if (is_string($image) && $image === '__REMOVE__' && $oldImage) {
            Storage::disk('public')->delete($oldImage);
            return null;
        }

        return $oldImage;
    }

    private function optimizeAndStore(\Illuminate\Http\UploadedFile $file, string $filename): string
    {
        $mime = $file->getMimeType();
        $sourcePath = $file->getRealPath();

        list($srcWidth, $srcHeight) = getimagesize($sourcePath);

        if (!$srcWidth || !$srcHeight) {
            return $file->storeAs('recipes', $filename, 'public');
        }

        $maxWidth = 1920;
        $maxHeight = 1920;
        $quality = 85;

        $newWidth = $srcWidth;
        $newHeight = $srcHeight;

        if ($srcWidth > $maxWidth || $srcHeight > $maxHeight) {
            $ratio = min($maxWidth / $srcWidth, $maxHeight / $srcHeight);
            $newWidth = (int) round($srcWidth * $ratio);
            $newHeight = (int) round($srcHeight * $ratio);
        }

        $image = imagecreatetruecolor($newWidth, $newHeight);

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($sourcePath);
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $source = imagecreatefromwebp($sourcePath);
                } else {
                    return $file->storeAs('recipes', $filename, 'public');
                }
                break;
            default:
                return $file->storeAs('recipes', $filename, 'public');
        }

        if (!isset($source) || !$source) {
            return $file->storeAs('recipes', $filename, 'public');
        }

        imagecopyresampled($image, $source, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);

        $destinationPath = storage_path('app/public/recipes/' . $filename);

        imagewebp($image, $destinationPath, 80);

        imagedestroy($source);
        imagedestroy($image);

        return 'recipes/' . $filename;
    }

    private function createRecipeable(array $data)
    {
        $type = $data['recipeable_type'] ?? 'food';

        if ($type === 'drink') {
            return DrinkRecipe::create($data['recipeable'] ?? []);
        }

        return FoodRecipe::create($data['recipeable'] ?? []);
    }

    private function syncIngredients(Recipe $recipe, array $ingredients): void
    {
        $syncData = [];

        foreach ($ingredients as $ingredient) {
            $ingredientId = $ingredient['ingredient_id'] ?? null;

            if (!$ingredientId && !empty($ingredient['ingredient_name'])) {
                $ing = Ingredient::firstOrCreate(
                    ['name' => trim($ingredient['ingredient_name'])],
                    ['name' => trim($ingredient['ingredient_name'])]
                );
                $ingredientId = $ing->id;
            }

            if (!$ingredientId) {
                continue;
            }

            $syncData[$ingredientId] = [
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
            ];
        }

        if (!empty($syncData)) {
            $recipe->ingredients()->sync($syncData);
        }
    }
}
