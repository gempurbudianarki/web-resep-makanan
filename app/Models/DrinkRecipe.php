<?php

namespace App\Models;

use App\Interfaces\Recipeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkRecipe extends Model implements Recipeable
{
    use HasFactory;

    protected $fillable = ['is_cold', 'glass_type'];

    protected $casts = [
        'is_cold' => 'boolean',
    ];

    public function recipe()
    {
        return $this->morphOne(Recipe::class, 'recipeable');
    }

    public function getRecipeDetails(): string
    {
        $parts = [];
        $parts[] = $this->is_cold ? 'Disajikan: Dingin' : 'Disajikan: Panas';

        if ($this->glass_type) {
            $parts[] = "Gelas: {$this->glass_type}";
        }

        return implode(' | ', $parts);
    }
}
