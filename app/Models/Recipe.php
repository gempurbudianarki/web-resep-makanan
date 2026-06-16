<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'title_en',
        'slug',
        'description',
        'description_en',
        'image',
        'steps',
        'steps_en',
        'status',
        'avg_rating',
    ];

    protected $casts = [
        'steps' => 'array',
        'steps_en' => 'array',
        'avg_rating' => 'decimal:2',
    ];

    protected $appends = ['image_url'];

    protected static function booted(): void
    {
        static::creating(function (Recipe $recipe) {
            $recipe->slug = static::generateUniqueSlug($recipe->title);
        });

        static::updating(function (Recipe $recipe) {
            if ($recipe->isDirty('title')) {
                $recipe->slug = static::generateUniqueSlug($recipe->title, $recipe->id);
            }
        });

        static::deleting(function (Recipe $recipe) {
            if ($recipe->isForceDeleting() && $recipe->image) {
                Storage::disk('public')->delete($recipe->getRawOriginal('image'));
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getImageUrlAttribute(): ?string
    {
        $image = $this->getRawOriginal('image');

        if (!$image) {
            return null;
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return asset('storage/' . $image);
    }

    public function getLocalizedTitle(): string
    {
        if (app()->getLocale() === 'en' && $this->title_en) {
            return $this->title_en;
        }
        return $this->title;
    }

    public function getLocalizedDescription(): string
    {
        if (app()->getLocale() === 'en' && $this->description_en) {
            return $this->description_en;
        }
        return $this->description;
    }

    public function getLocalizedSteps(): array
    {
        if (app()->getLocale() === 'en' && $this->steps_en) {
            return $this->steps_en;
        }
        return $this->steps ?? [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipeable()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_recipe');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
            ->withPivot(['amount', 'unit'])
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }
}
