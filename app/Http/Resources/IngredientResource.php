<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->whenPivotLoaded('recipe_ingredients', fn () => $this->pivot->amount),
            'unit' => $this->whenPivotLoaded('recipe_ingredients', fn () => $this->pivot->unit),
        ];
    }
}
