<?php

namespace App\Models;

use App\Interfaces\Recipeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecipe extends Model implements Recipeable
{
    use HasFactory;

    protected $fillable = ['cooking_time', 'serving_size', 'calories'];

    public function recipe()
    {
        return $this->morphOne(Recipe::class, 'recipeable');
    }

    public function getRecipeDetails(): string
    {
        $parts = [];

        if ($this->cooking_time > 0) {
            $parts[] = "Waktu Masak: {$this->cooking_time} Menit";
        }

        if ($this->serving_size > 0) {
            $parts[] = "Porsi: {$this->serving_size} Orang";
        }

        if ($this->calories > 0) {
            $parts[] = "Kalori: {$this->calories} kkal";
        }

        return implode(' | ', $parts);
    }
}
