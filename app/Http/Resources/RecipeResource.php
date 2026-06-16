<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'steps' => $this->when($request->routeIs('recipes.show'), $this->steps),
            'avg_rating' => $this->avg_rating,
            'status' => $this->status,
            'details' => $this->when(
                $this->relationLoaded('recipeable') && $this->recipeable,
                fn () => $this->recipeable->getRecipeDetails()
            ),
            'recipeable' => $this->whenLoaded('recipeable'),
            'user' => new UserResource($this->whenLoaded('user')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
            'reviews_count' => $this->whenCounted('reviews'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
