<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_en'];

    public function getLocalizedName(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->name_en) {
            return $this->name_en;
        }
        return $this->name;
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients')
            ->withPivot(['amount', 'unit'])
            ->withTimestamps();
    }
}
