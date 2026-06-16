<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_en', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

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
        return $this->belongsToMany(Recipe::class, 'category_recipe');
    }
}
