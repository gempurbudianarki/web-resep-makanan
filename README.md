<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Playfair+Display&weight=700&size=36&duration=3000&pause=1000&color=D9A441&center=true&vCenter=true&width=600&lines=BagiResep;Platform+Berbagi+Resep" alt="BagiResep" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?logo=alpine.js&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/i18n-ID_|_EN-22C55E?logo=googletranslate&logoColor=white" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Domain-bagiresep.fun-7A5A3A" />
  <img src="https://img.shields.io/badge/Migrations-24-22C55E" />
  <img src="https://img.shields.io/badge/Routes-48-3B82F6" />
  <img src="https://img.shields.io/badge/Security-16_Layers-EF4444" />
  <img src="https://img.shields.io/badge/License-MIT-blue" />
</p>

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [Technology Stack](#technology-stack)
3. [Features](#features)
4. [Object-Oriented Architecture](#object-oriented-architecture)
   - [Encapsulation: Service Layer](#41-encapsulation--service-layer)
   - [Inheritance: Base Controller & Polymorphic Relations](#42-inheritance--polymorphic-relations)
   - [Polymorphism: Recipeable Interface](#43-polymorphism--the-recipeable-interface)
   - [Observer Pattern: Event-Driven Rating](#44-observer-pattern--event-driven-rating)
   - [Policy-Based Authorization](#45-policy-based-authorization)
5. [Database Design](#database-design)
6. [Security Implementation](#security-implementation)
7. [SEO & Performance Optimization](#seo--performance-optimization)
8. [Installation](#installation)
9. [API Reference](#api-reference)
10. [Artisan Commands](#artisan-commands)
11. [Testing](#testing)
12. [Deployment](#deployment)
13. [Directory Structure](#directory-structure)

---

## Project Overview

**BagiResep** is a full-stack Indonesian recipe sharing platform built on Laravel 10. The application demonstrates enterprise-grade software architecture through rigorous application of object-oriented programming principles — encapsulation, inheritance, and polymorphism — integrated within the Model-View-Controller pattern.

Every component in this codebase is designed with a single responsibility. Controllers delegate business logic to dedicated service classes. Models enforce data integrity through type casting, accessor methods, and relationship definitions. Authorization logic is centralized in policy classes rather than scattered across controllers. This separation of concerns ensures the codebase remains maintainable, testable, and extensible as the application grows.

The platform is fully bilingual (Indonesian and English), with automatic translation powered by Google Translate's engine. Content is indexed for search engines through structured JSON-LD data, XML sitemaps, and Open Graph meta tags. Images are automatically optimized to WebP format, reducing storage requirements by over 90% without visible quality loss.

Production deployment is live at **[bagiresep.fun](https://bagiresep.fun)**, served behind Cloudflare's CDN and WAF with full HTTPS enforcement.

---

## Technology Stack

### Backend Infrastructure

| Component | Technology | Purpose |
|---|---|---|
| Runtime | PHP 8.1 | Application execution |
| Framework | Laravel 10.x | MVC architecture, routing, ORM, queue, caching |
| Database | MySQL 8.0 | Persistent storage with FULLTEXT search indexes |
| Authentication | Laravel Sanctum 3.x | Token-based API authentication |
| Authorization | Spatie Permission 6.x | Role-based access control with permission inheritance |
| Translation | stichoza/google-translate-php 5.x | Google Translate integration (primary engine) |
| Translation Fallback | MyMemory API | Secondary translation service when Google is unavailable |
| HTTP Client | Guzzle 7.x | External API communication |

### Frontend Layer

| Component | Technology | Purpose |
|---|---|---|
| CSS Framework | Tailwind CSS 3.x | Utility-first styling with custom design tokens |
| JavaScript | Alpine.js 3.x | Lightweight reactive components for UI interactivity |
| Image Cropping | Cropper.js 1.6 | Client-side image manipulation with configurable aspect ratios |
| Asset Bundling | Vite 5.x | Module bundling with hot module replacement |
| HTTP Client | Axios 1.x | Promise-based HTTP requests |
| Display Typeface | Playfair Display | Editorial-grade serif for headings and branding |
| Body Typeface | DM Sans | Geometric sans-serif optimized for screen readability |

---

## Features

### Unauthenticated Users

- Full-screen hero landing page with glass-morphism mobile navigation
- Recipe browsing with MySQL FULLTEXT search, 24-category filtering, and dual sort modes (rating and recency)
- Infinite-scroll carousel for highest-rated recipes using CSS transform animation
- Complete recipe detail view: photograph, ingredients with quantities, numbered steps, community reviews, and nutritional information
- User registration with server-side password complexity enforcement (uppercase, lowercase, numeric)
- Authentication with rate limiting (6 attempts per minute)
- Password recovery via Gmail SMTP with signed URL tokens
- Language switching between Indonesian and English — all content, including recipe titles, descriptions, and preparation steps, is translated
- Cookie consent notification with localStorage persistence

### Authenticated Users

- Personal dashboard showing recipe statistics: total created, published count, draft count, and average rating
- Recipe creation workflow:
  - Food/Drink type selection with conditional form fields
  - Image upload with Cropper.js integration (4:3 viewfinder, rotate, flip, zoom, reset)
  - Server-side image processing: resize to 1920px maximum dimension, convert to WebP at 80% quality
  - Category selection from 24 bilingual options
  - Dynamic ingredient management with autocomplete from 98-item database and 53 unit options
  - Dynamic step management with numbered entries
- Recipe editing with pre-populated forms and status toggle (Published/Draft)
- Soft-delete for recipes with database-level recovery capability
- Bookmark management with toggle and dedicated collection view
- Star rating system (1-5) with comment support
- Review deletion with authorization check (owner or superadmin)
- Profile management: name update, email update, password change with current-password verification
- A4-optimized print layout with specialized print CSS media queries
- Automatic bilingual translation of recipe title, description, and preparation steps via Google Translate API with MyMemory fallback

### Superadmin

- Overview dashboard with real-time statistics: total users, total recipes, published/draft breakdown, review count, average platform rating, and weekly user growth
- Recipe management: global listing, publish/draft toggle, permanent deletion
- User management: global listing, ban/unban toggle (with superadmin protection), per-user recipe listing
- Category management: full CRUD with bilingual name support, deletion protection when recipes are associated
- RBAC implementation: single `superadmin` role with `bypass-all` permission evaluated through Laravel's `Gate::before` hook

---

## Object-Oriented Architecture

This project applies three fundamental OOP principles throughout its architecture. The following sections explain each principle with concrete code examples drawn directly from the codebase.

### 4.1 Encapsulation — Service Layer

**Principle**: Encapsulation hides internal implementation details behind a public interface. Consumers of a class interact only with its public methods; internal logic, data structures, and dependencies remain private.

**Implementation**: The application separates HTTP request handling (controllers) from business logic (services). Controllers validate input and delegate to services. Services encapsulate complex operations — database transactions, image processing, translation, and relationship synchronization — behind clean method signatures.

```
HTTP Request
     |
     v
Controller (thin)
  - Validates input via FormRequest
  - Calls service method
  - Returns view or redirect
     |
     v
Service Layer (encapsulated logic)
  - Database transactions
  - Image optimization
  - Auto-translation
  - Relationship synchronization
     |
     v
Eloquent Models (data layer)
```

**Code Example** — The controller is a thin orchestrator. All business logic resides in the service:

```php
// App\Http\Controllers\Web\RecipeController.php
class RecipeController extends Controller
{
    public function __construct(
        protected RecipeService $recipeService,
        protected RatingService $ratingService,
    ) {}

    public function store(StoreRecipeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->resolveImage($request);

        $recipe = $this->recipeService->create($data, auth()->id());

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', __('ui.resep_berhasil_dibuat'));
    }
}
```

```php
// App\Services\RecipeService.php
class RecipeService
{
    public function create(array $data, int $userId): Recipe
    {
        return DB::transaction(function () use ($data, $userId) {
            $recipeable = $this->createRecipeable($data);          // Polymorphic child
            $translated = $this->translationService->translateRecipe($data); // Auto-translate

            $recipe = Recipe::create([
                'user_id'        => $userId,
                'title'          => $data['title'],
                'title_en'       => $translated['title_en'] ?? null,
                'description'    => $data['description'],
                'description_en' => $translated['description_en'] ?? null,
                'image'          => $this->handleImageUpload($data['image'] ?? null),
                'steps'          => $data['steps'] ?? [],
                'steps_en'       => $translated['steps_en'] ?? null,
                'status'         => $data['status'] ?? 'published',
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

    private function handleImageUpload($image, ?string $oldImage = null): ?string
    {
        // Image validation, filename sanitization, GD-based resize, WebP conversion
        // All encapsulated — controller never touches image processing
    }
}
```

The `RecipeService::create()` method encapsulates seven distinct operations within a single database transaction: polymorphic child creation, translation, image processing, recipe insertion, morph association, category synchronization, and ingredient synchronization. The controller is unaware of any of these implementation details.

### 4.2 Inheritance — Polymorphic Relations

**Principle**: Inheritance allows a class to derive properties and behavior from a parent class. In Laravel's Eloquent ORM, all models inherit from `Illuminate\Database\Eloquent\Model`, gaining database interaction capabilities without explicit implementation.

**Implementation — Base Controller**:

All application controllers extend `App\Http\Controllers\Controller`, which itself extends Laravel's base controller and imports two traits:

```php
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
```

- `AuthorizesRequests` — provides the `$this->authorize()` method used throughout resource controllers
- `ValidatesRequests` — provides the `$this->validate()` method for inline validation

This inheritance chain means every controller in the application automatically inherits authorization and validation capabilities without duplicating code.

**Implementation — Eloquent Model Inheritance**:

The `User` model demonstrates multiple inheritance through trait composition:

```php
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    // ...
}
```

Each trait contributes a specific capability:
- `HasApiTokens` — Sanctum token management for API authentication
- `HasFactory` — model factory support for testing and seeding
- `Notifiable` — email notification dispatch (verification, password reset)
- `HasRoles` — Spatie RBAC integration (role and permission checks)
- `SoftDeletes` — non-destructive deletion with `deleted_at` timestamp

The `Recipe` model similarly inherits from `Model` and composes `HasFactory` and `SoftDeletes` traits. Its `booted()` method overrides the parent's lifecycle hooks:

```php
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
```

This demonstrates method overriding in the inheritance chain: `booted()` extends the parent's boot process by adding slug auto-generation on create/update and storage cleanup on force-delete.

### 4.3 Polymorphism — The Recipeable Interface

**Principle**: Polymorphism allows objects of different types to be treated through a common interface. A single `Recipe` model can reference either a `FoodRecipe` or a `DrinkRecipe` without knowing which concrete type it holds.

**The Interface Contract**:

```php
// App\Interfaces\Recipeable.php
interface Recipeable
{
    public function getRecipeDetails(): string;
}
```

This interface establishes a contract: any class implementing `Recipeable` must provide a `getRecipeDetails()` method that returns a formatted string of type-specific attributes.

**Concrete Implementations**:

```php
// App\Models\FoodRecipe.php
class FoodRecipe extends Model implements Recipeable
{
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
```

```php
// App\Models\DrinkRecipe.php
class DrinkRecipe extends Model implements Recipeable
{
    protected $fillable = ['is_cold', 'glass_type'];

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
```

**The Polymorphic Relationship**:

The `Recipe` model uses Laravel's polymorphic `morphTo` relationship:

```php
// App\Models\Recipe.php
public function recipeable()
{
    return $this->morphTo();
}
```

The `recipes` table stores two columns that enable this relationship:

| Column | Example Value | Purpose |
|---|---|---|
| `recipeable_type` | `'food'` or `'drink'` | Identifies which model to load |
| `recipeable_id` | `7` | References the primary key of the target model |

**Morph Map for Security**:

Laravel's `morphMap` prevents arbitrary class injection by whitelisting allowed polymorphic types:

```php
// App\Providers\AppServiceProvider.php
Relation::morphMap([
    'food'  => FoodRecipe::class,
    'drink' => DrinkRecipe::class,
]);
```

**Usage in Service Layer**:

The `RecipeService` creates the appropriate child type based on user input:

```php
private function createRecipeable(array $data)
{
    $type = $data['recipeable_type'] ?? 'food';

    if ($type === 'drink') {
        return DrinkRecipe::create($data['recipeable'] ?? []);
    }

    return FoodRecipe::create($data['recipeable'] ?? []);
}
```

**Extensibility**: To add a new recipe type (for example, `BakeryRecipe`), a developer needs only to:
1. Create a new model implementing `Recipeable`
2. Add the new class to `Relation::morphMap()`
3. Extend `createRecipeable()` to handle the new type

No changes to the `Recipe` model, existing services, or views are required. This is the core benefit of polymorphism in software design.

### 4.4 Observer Pattern — Event-Driven Rating

**Principle**: The Observer pattern defines a one-to-many dependency between objects. When one object changes state, all its dependents are notified and updated automatically.

**Implementation**: When a review is created, updated, or deleted, the system automatically recalculates the associated recipe's average rating. This is achieved through Laravel's model observer system.

```
User Submits Review
       |
       v
RatingService::createOrUpdate()
  - Handles soft-deleted review restoration
  - Creates or updates the review record
       |
       | Eloquent fires model event (created / updated / deleted)
       v
ReviewObserver
       |
       ├── created(Review $review)
       ├── updated(Review $review)
       └── deleted(Review $review)
              |
              v
       RatingService::recalculateAvgRating(Recipe $recipe)
              |
              v
       UPDATE recipes SET avg_rating = (
           SELECT AVG(rating) FROM reviews
           WHERE recipe_id = ? AND deleted_at IS NULL
       )
```

**Observer Registration**:

```php
// App\Providers\AppServiceProvider.php
public function boot(): void
{
    Relation::morphMap([
        'food'  => FoodRecipe::class,
        'drink' => DrinkRecipe::class,
    ]);

    Review::observe(app(ReviewObserver::class));
}
```

**Observer Implementation**:

```php
// App\Observers\ReviewObserver.php
class ReviewObserver
{
    public function __construct(
        protected RatingService $ratingService,
    ) {}

    public function created(Review $review): void
    {
        $this->ratingService->recalculateAvgRating($review->recipe);
    }

    public function updated(Review $review): void
    {
        $this->ratingService->recalculateAvgRating($review->recipe);
    }

    public function deleted(Review $review): void
    {
        $this->ratingService->recalculateAvgRating($review->recipe);
    }
}
```

**Soft-Delete Handling in Rating Service**:

The `RatingService` must handle the case where a user has previously reviewed a recipe, deleted that review (soft delete), and wants to review again. The `createOrUpdate` method checks for soft-deleted records before creating new ones:

```php
public function createOrUpdate(Recipe $recipe, int $userId, int $rating, ?string $comment = null): Review
{
    $review = Review::withTrashed()
        ->where('user_id', $userId)
        ->where('recipe_id', $recipe->id)
        ->first();

    if ($review) {
        if ($review->trashed()) {
            $review->restore();
        }
        $review->update(['rating' => $rating, 'comment' => $comment]);
        return $review;
    }

    return Review::create([
        'user_id'  => $userId,
        'recipe_id' => $recipe->id,
        'rating'    => $rating,
        'comment'   => $comment,
    ]);
}
```

This observer-driven architecture means that no controller, view, or API endpoint needs to manually recalculate ratings. The system guarantees data consistency automatically.

### 4.5 Policy-Based Authorization

**Principle**: Authorization logic should be centralized and declarative, not scattered across controllers as inline conditionals.

**Recipe Policy**:

```php
// App\Policies\RecipePolicy.php
class RecipePolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // Recipe listing is public
    }

    public function view(?User $user, Recipe $recipe): bool
    {
        if ($recipe->status === 'published') {
            return true; // Anyone can view published recipes
        }
        if (!$user) {
            return false; // Unauthenticated users cannot view drafts
        }
        return $user->id === $recipe->user_id
            || $user->hasPermissionTo('bypass-all');
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create recipes
    }

    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id
            || $user->hasPermissionTo('bypass-all');
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id
            || $user->hasPermissionTo('bypass-all');
    }
}
```

**Global Bypass for Superadmin**:

The `Gate::before` hook evaluates before any policy check. If the user has the `bypass-all` permission, all authorization checks are skipped:

```php
// App\Providers\AuthServiceProvider.php
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Recipe::class => RecipePolicy::class,
    ];

    public function boot(): void
    {
        Gate::before(function ($user) {
            if ($user->hasPermissionTo('bypass-all')) {
                return true;
            }
        });
    }
}
```

**Usage in Controllers**:

```php
public function edit(Recipe $recipe)
{
    $this->authorize('update', $recipe); // Single-line authorization check
    // ...
}
```

---

## Database Design

### Entity Relationship Diagram

```
 users
  1|
   |hasMany
   |
   |          morphTo            implements
   +------ recipes ────────── recipeable ─────── Recipeable
   |         |                                       |
   |         |                    ┌──────────────────┤
   |         |                    |                  |
   |    belongsToMany     FoodRecipe          DrinkRecipe
   |    (category_recipe) (cooking_time,       (is_cold,
   |         |             serving_size,        glass_type)
   |         |             calories)
   |    categories
   |
   |    belongsToMany
   |    (recipe_ingredients)
   |         |
   |    ingredients
   |    (name, name_en, amount, unit)
   |
   +───< reviews
   |      (rating, comment, soft delete)
   |
   +───< bookmarks
          (user_id + recipe_id composite key)

 Spatie RBAC:
   roles ─── role_has_permissions ─── permissions
     |                                     |
   model_has_roles                   model_has_permissions
     |                                     |
   users (morph)                      users (morph)
```

### Table Schema Summary

| Table | Primary Key | Key Columns | Notes |
|---|---|---|---|
| `users` | id | name, email, password, banned_at, deleted_at | Soft deletes, MustVerifyEmail |
| `recipes` | id | user_id (FK), title, title_en, description, description_en, image, steps (JSON), steps_en (JSON), recipeable_type, recipeable_id, avg_rating, status | Polymorphic morph, FULLTEXT index |
| `categories` | id | name, name_en, slug | Bilingual via `getLocalizedName()` |
| `ingredients` | id | name, name_en | Bilingual via `getLocalizedName()` |
| `food_recipes` | id | cooking_time, serving_size, calories | Implements Recipeable |
| `drink_recipes` | id | is_cold, glass_type | Implements Recipeable |
| `reviews` | id | user_id, recipe_id, rating, comment, deleted_at | UNIQUE(user_id, recipe_id), soft deletes |
| `bookmarks` | id | user_id, recipe_id, created_at, updated_at | Composite FK |
| `category_recipe` | id | category_id (FK), recipe_id (FK) | Pivot: UNIQUE(category_id, recipe_id) |
| `recipe_ingredients` | id | recipe_id (FK), ingredient_id (FK), amount, unit | Pivot: UNIQUE(recipe_id, ingredient_id) |

### Index Strategy

| Table | Index Type | Columns |
|---|---|---|
| `recipes` | FULLTEXT | title, description |
| `recipes` | INDEX | status |
| `reviews` | UNIQUE | user_id, recipe_id |
| `bookmarks` | UNIQUE | user_id, recipe_id |
| All FKs | FOREIGN KEY | CASCADE ON DELETE |

---

## Security Implementation

| Layer | Mechanism | Detail |
|---|---|---|
| 1 | Web Authentication | Laravel Session Guard with secure cookies (`httpOnly`, `sameSite=lax`) |
| 2 | API Authentication | Laravel Sanctum personal access tokens |
| 3 | Authorization | Spatie RBAC (`superadmin` role + `bypass-all` permission) + Model Policies |
| 4 | Gate Bypass | `Gate::before` grants superadmin unrestricted access |
| 5 | Rate Limiting | 6 req/min (auth endpoints), 10 req/min (API write), 30 req/min (API read) |
| 6 | CSRF Protection | `VerifyCsrfToken` middleware on all state-changing web routes |
| 7 | XSS Prevention | Blade `{{ }}` auto-escapes output; `{!! !!}` is never used for user content |
| 8 | SQL Injection | All queries use Eloquent parameter binding; LIKE wildcards are escaped via `preg_replace('/[%_]/', '\\\\$0', $query)` |
| 9 | Mass Assignment | `$fillable` whitelist on all 7 models; no `$guarded` usage |
| 10 | Morph Injection | `Relation::morphMap(['food', 'drink'])` prevents arbitrary class instantiation |
| 11 | File Upload Validation | MIME type whitelist (JPEG, PNG, WebP), 20MB limit, `basename()` path traversal prevention |
| 12 | Session Security | 5-minute idle timeout, `secure: true`, `httpOnly: true`, `sameSite: lax` |
| 13 | Ban Enforcement | `CheckBanned` middleware reads `users.banned_at`, logs out and redirects banned users |
| 14 | Content Security Policy | `default-src 'self'` with granular script/style/font/img/frame directives |
| 15 | Cross-Origin Headers | `Cross-Origin-Opener-Policy`, `Cross-Origin-Resource-Policy`, `Cross-Origin-Embedder-Policy` |
| 16 | HSTS & HTTPS | `Strict-Transport-Security: max-age=31536000; includeSubDomains; preload` (production only) |
| 17 | Security Disclosure | `/.well-known/security.txt` with contact information and policy links |

---

## SEO & Performance Optimization

### Search Engine Optimization

| Mechanism | Implementation |
|---|---|
| XML Sitemap | `/sitemap.xml` — dynamically generated; includes all published recipes, categories, and static pages |
| Robots Exclusion | `/robots.txt` — allows public content indexing, blocks auth and admin routes |
| Meta Tags | Unique `title`, `description`, and `keywords` per page via Blade `@yield` directives |
| Open Graph | `og:title`, `og:description`, `og:image`, `og:type`, `og:locale` on every page |
| Twitter Cards | `twitter:card` with `summary_large_image` variant |
| Canonical URLs | `link[rel=canonical]` on every page to prevent duplicate content indexing |
| JSON-LD Structured Data | Recipe schema with `name`, `author`, `description`, `image`, `datePublished`, `cookTime`, `recipeYield`, `nutrition`, `recipeIngredient`, `recipeInstructions`, `aggregateRating` |
| Google Search Console | Verified via HTML file and meta tag |

### Performance Optimization

| Optimization | Method | Result |
|---|---|---|
| Image Format | GD library converts all uploads to WebP (80% quality) | 92-96% file size reduction |
| Image Dimensions | `getimagesize()` + `imagecopyresampled()` limits to 1920px max | Prevents oversized file storage |
| Lazy Loading | `loading="lazy"` attribute on all `<img>` elements | Deferred off-screen image loading |
| Font Delivery | Bunny.net CDN with `preconnect` hint | Reduced font latency |
| Static Asset Caching | `Cache-Control: max-age=31536000, immutable` | One-year browser cache |
| Database Search | MySQL FULLTEXT index on `recipes(title, description)` | Sub-second search across all recipes |
| Storage Footprint | WebP migration of all existing images | 35MB reduced to 3.3MB total |

---

## Installation

### System Requirements

- PHP 8.1 or higher with extensions: `gd` (WebP support required), `mbstring`, `pdo_mysql`, `dom`, `json`
- Composer 2.x
- MySQL 8.0 or higher (FULLTEXT index support required)
- Node.js 18 or higher with npm

### Setup Instructions

```bash
# Clone the repository
git clone https://github.com/gempurbudianarki/web-resep-makanan.git bagiresep
cd bagiresep

# Install PHP dependencies
composer install

# Install and build frontend assets
npm install
npm run build

# Create environment configuration
cp .env.example .env
php artisan key:generate

# Configure database credentials in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=bagiresep
# DB_USERNAME=root
# DB_PASSWORD=

# Run database migrations and seed default data
php artisan migrate --seed

# Create symbolic link for public storage access
php artisan storage:link

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the development server
php artisan serve
```

### Default Accounts

| Role | Email | Password |
|---|---|---|
| SuperAdmin | `admin@resepkita.test` | `password` |
| User | `gempurbudianarki@gmail.com` | `password` |

### Email Configuration (Gmail SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="BagiResep"
```

### Cloudflare Turnstile (Optional)

```env
TURNSTILE_SITE_KEY=your-site-key
TURNSTILE_SECRET_KEY=your-secret-key
```

### Cover Images

Place the following files in `storage/app/public/sampul/`:

- `sampuldepan.webp` — Landing page hero background
- `sampuldalam.webp` — Internal page header background

---

## API Reference

### Authentication Endpoints

```
POST   /api/auth/register     Rate: 6/min     Register new user, returns Sanctum token
POST   /api/auth/login        Rate: 6/min     Authenticate and receive token
POST   /api/auth/logout       Auth: Sanctum   Revoke current access token
GET    /api/auth/me           Auth: Sanctum   Get authenticated user profile with roles
```

### Recipe Endpoints

```
GET    /api/recipes             Public          List recipes (query: ?search=&category_id=&per_page=&sort=)
GET    /api/recipes/{id}        Public          Get recipe with relations and recent reviews
POST   /api/recipes             Auth: Sanctum   Create recipe (rate: 10/min)
PUT    /api/recipes/{id}        Auth: Sanctum   Update recipe (rate: 10/min)
DELETE /api/recipes/{id}        Auth: Sanctum   Delete recipe
```

### Review Endpoints

```
GET    /api/recipes/{id}/reviews           Public          List reviews for a recipe
POST   /api/recipes/{id}/reviews           Auth: Sanctum   Create review
PUT    /api/recipes/{id}/reviews/{id}      Auth: Sanctum   Update own review
DELETE /api/recipes/{id}/reviews/{id}      Auth: Sanctum   Delete own review (or superadmin)
```

### Bookmark Endpoints

```
POST   /api/recipes/{id}/bookmark    Auth: Sanctum   Toggle bookmark status
GET    /api/bookmarks                Auth: Sanctum   List user's bookmarked recipes
```

### Category & Ingredient Endpoints

```
GET    /api/categories          Public          List all categories
GET    /api/categories/{id}     Public          Get single category
POST   /api/categories          Auth: Admin     Create category
PUT    /api/categories/{id}     Auth: Admin     Update category
DELETE /api/categories/{id}     Auth: Admin     Delete category
GET    /api/ingredients         Public          Search ingredients (?search=)
```

---

## Artisan Commands

```bash
# Translate all recipes missing English content
php artisan recipes:translate

# Force re-translate all recipes (overwrites existing translations)
php artisan recipes:translate --force

# Seed specific datasets
php artisan db:seed --class=RealRecipesSeeder --force
php artisan db:seed --class=GempurRecipesSeeder --force
php artisan db:seed --class=DemoDataSeeder --force
```

---

## Testing

```bash
php artisan test

# Test Suite Results
# Tests\Unit\ExampleTest                  PASS
# Tests\Feature\AuthTest                  PASS (5 tests)
# Tests\Feature\AuthorizationTest         PASS (3 tests)
# Tests\Feature\BookmarkTest              PASS (5 tests)
# Tests\Feature\RecipeTest                PASS (10 tests)
# Tests\Feature\ReviewTest                PASS (5 tests)
#
# Total: 30 tests, 68 assertions passed
```

---

## Deployment

This application is deployed on Hostinger shared hosting infrastructure:

| Layer | Configuration |
|---|---|
| Web Server | Nginx |
| PHP | 8.1 FPM |
| Database | MySQL 8.0 (utf8mb4) |
| SSL/TLS | Let's Encrypt via Cloudflare |
| CDN & WAF | Cloudflare (proxy mode, DDoS protection, bot management) |
| Domain | [bagiresep.fun](https://bagiresep.fun) |

---

## Directory Structure

```
app/
├── Console/
│   ├── Commands/TranslateRecipes.php    # Batch translation command
│   └── Kernel.php                       # Console kernel (schedule + commands)
├── Exceptions/Handler.php               # Exception handling configuration
├── Http/
│   ├── Controllers/
│   │   ├── Api/                         # REST API controllers (6 files)
│   │   ├── Web/                         # MVC controllers (10 files)
│   │   │   └── Admin/                   # Admin sub-controllers (3 files)
│   │   └── Controller.php               # Base controller with AuthorizesRequests + ValidatesRequests
│   ├── Kernel.php                       # HTTP kernel (middleware registration)
│   ├── Middleware/                      # Custom middleware (12 files)
│   │   ├── Authenticate.php             # Redirect unauthenticated users
│   │   ├── CheckBanned.php              # Auto-logout banned users
│   │   ├── SecurityHeaders.php          # CSP, HSTS, COOP/CORP/COEP headers
│   │   └── SetLanguage.php              # Locale detection from session
│   ├── Requests/                        # Form request validation (3 files)
│   └── Resources/                       # API resource transformers (5 files)
├── Interfaces/Recipeable.php            # Polymorphism contract
├── Models/                              # Eloquent models (7 files)
├── Observers/ReviewObserver.php         # Rating auto-recalculation
├── Policies/RecipePolicy.php            # Authorization rules
├── Providers/                           # Service providers (5 files)
└── Services/                            # Business logic layer (4 files)
    ├── RecipeService.php                # Recipe CRUD, image processing, translation orchestration
    ├── RatingService.php                # Review management, aggregate rating calculation
    ├── BookmarkService.php              # Bookmark toggle, collection queries
    ├── TranslationService.php           # Google Translate + MyMemory fallback
    └── TurnstileService.php             # Cloudflare Turnstile token verification

config/                                  # Application configuration (16 files)
database/
├── factories/                           # Model factories for testing (7 files)
├── migrations/                          # Database migrations (24 files)
└── seeders/                             # Data seeders (6 files)
lang/
├── en/                                  # English translation files (4 files)
└── id/                                  # Indonesian translation files (4 files)
resources/
├── css/app.css                          # Tailwind directives + custom components
├── js/
│   ├── app.js                           # Alpine.js + Axios bootstrap
│   └── bootstrap.js                     # Laravel bootstrap
└── views/                               # Blade templates (33 files)
    ├── admin/                           # Admin panel views
    ├── auth/                            # Authentication views
    ├── errors/                          # Custom error pages (403, 404, 419, 429, 500, 503)
    ├── layouts/                         # Master layouts (app, guest)
    ├── pages/                           # Static pages (privacy, terms)
    └── recipes/                         # Recipe CRUD views
routes/
├── web.php                              # Web routes with middleware groups
├── api.php                              # API routes with Sanctum authentication
├── channels.php                         # Broadcasting channel definitions
└── console.php                          # Console route definitions
tests/
├── Feature/                             # Feature tests (6 files, 29 tests)
└── Unit/                                # Unit tests (1 file)
```

---

<p align="center">
  <br>
  <sub>Built by</sub>
  <br>
  <strong>Gempur Budi Anarki</strong>
  <br>
  <sub>Senior Software Engineer & Web Developer</sub>
  <br>
  <a href="https://gempurbudianarki.space/">gempurbudianarki.space</a>
  <br>
  <br>
  <sub>Live at <a href="https://bagiresep.fun/">bagiresep.fun</a></sub>
  <br>
  <br>
  <sub>&copy; 2026 BagiResep. All rights reserved.</sub>
</p>
