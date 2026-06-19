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

## Daftar Isi

1. [Tentang Proyek](#tentang-proyek)
2. [Teknologi](#teknologi)
3. [Fitur Lengkap](#fitur-lengkap)
4. [Arsitektur Object-Oriented](#arsitektur-object-oriented)
   - [Encapsulation: Service Layer](#encapsulation--service-layer)
   - [Inheritance: Base Controller & Polymorphic Relations](#inheritance--polymorphic-relations)
   - [Polymorphism: Recipeable Interface](#polymorphism--recipeable-interface)
   - [Observer Pattern: Event-Driven Rating](#observer-pattern--event-driven-rating)
   - [Policy-Based Authorization](#policy-based-authorization)
5. [Desain Database](#desain-database)
6. [Keamanan](#keamanan)
7. [SEO & Performa](#seo--performa)
8. [Panduan Instalasi](#panduan-instalasi)
9. [API Reference](#api-reference)
10. [Artisan Commands](#artisan-commands)
11. [Testing](#testing)
12. [Struktur Direktori](#struktur-direktori)

## Tentang Proyek

**BagiResep** adalah platform berbagi resep masakan Indonesia dengan dukungan bilingual penuh (Indonesia dan Inggris). Proyek ini dibangun di atas Laravel 10 dengan penerapan prinsip-prinsip Object-Oriented Programming secara menyeluruh : Encapsulation, Inheritance, dan Polymorphism : yang terintegrasi dalam arsitektur Model-View-Controller.

Setiap komponen dalam proyek ini dirancang dengan Single Responsibility Principle. Controller hanya bertugas menerima request dan mengembalikan response. Business logic dienkapsulasi dalam Service Layer. Authorization logic dipusatkan di Policy class. Database interaction ditangani sepenuhnya oleh Eloquent ORM. Pemisahan concern ini memastikan kode tetap maintainable, testable, dan mudah dikembangkan.

Situs sudah production-ready dan dapat diakses di **[bagiresep.fun](https://bagiresep.fun)**.

Dibangun oleh **[Gempur Budi Anarki](https://gempurbudianarki.space/)** : Senior Software Engineer & Web Developer.

## Teknologi

### Backend

| Teknologi | Versi | Kegunaan |
|---|---|---|
| PHP | 8.1+ | Runtime |
| Laravel | 10.x | MVC Framework |
| Spatie Permission | 6.x | Role-Based Access Control |
| Laravel Sanctum | 3.x | API Token Authentication |
| MySQL | 8.0 | Database + FULLTEXT Search |
| stichoza/google-translate-php | 5.x | Google Translate Engine (gratis, tanpa API key) |
| MyMemory API | Free | Fallback Translation |
| Guzzle | 7.x | HTTP Client |

### Frontend

| Teknologi | Kegunaan |
|---|---|
| Tailwind CSS 3.x | Utility-first CSS dengan custom color palette |
| Alpine.js 3.x | Komponen interaktif (dropdown, carousel, modal) |
| Cropper.js 1.6 | Client-side image cropping 4:3 |
| Vite 5.x | Module bundler |
| Axios 1.x | HTTP client |
| Playfair Display | Display typeface |
| DM Sans | Body typeface |

## Fitur Lengkap

### Tamu (Guest)

- Landing page fullscreen hero image dengan navigasi mobile glass-morphism
- Penjelajahan resep dengan MySQL FULLTEXT search, 24 kategori, dan dual sort (rating dan terbaru)
- Infinite-scroll carousel untuk resep rating tertinggi
- Halaman detail resep lengkap: foto, bahan, langkah, review, dan informasi nutrisi
- Registrasi dengan password complexity (huruf besar, huruf kecil, angka)
- Login dengan rate limiting (6 percobaan per menit)
- Lupa password dan reset password via Gmail SMTP
- Cookie consent notification
- Penggantian bahasa: Indonesia / Inggris : seluruh konten bilingual

### Anggota (User)

**Dashboard Personal**

Statistik lengkap: total resep, published, draft, dan rata-rata rating.

**Pembuatan Resep**

Alur pembuatan resep mencakup:
- Pemilihan tipe Makanan atau Minuman dengan form field yang berubah secara kondisional
- Upload foto dengan Cropper.js (viewfinder 4:3, rotate, flip, zoom, reset)
- Pemrosesan gambar server-side: resize maksimal 1920px, konversi ke WebP kualitas 80%
- Pemilihan dari 24 kategori bilingual
- Manajemen bahan masakan dinamis dengan autocomplete dari 98 item dan 53 satuan
- Manajemen langkah-langkah dinamis
- Validasi form dalam Bahasa Indonesia
- Loading overlay saat submit

**Pengelolaan Resep**

- Edit resep dengan form yang sudah terisi data sebelumnya
- Hapus resep dengan soft delete (data dapat dipulihkan)
- Bookmark toggle dan halaman koleksi bookmark
- Review dan rating bintang 1-5
- Hapus review sendiri (atau oleh superadmin)
- Cetak resep dalam layout A4

**Profil**

- Edit nama dan email
- Ganti password dengan verifikasi password saat ini

**Auto-Translate**

Setiap resep yang dibuat otomatis diterjemahkan ke Bahasa Inggris:
- Judul resep
- Deskripsi resep
- Langkah-langkah pembuatan

Menggunakan Google Translate sebagai engine utama dengan MyMemory sebagai fallback.

### SuperAdmin

- Dashboard statistik: total user, total resep, published/draft, total review, rata-rata rating, dan pertumbuhan user mingguan
- Manajemen Resep: melihat semua resep, toggle publish/draft, hapus permanen
- Manajemen User: melihat semua user, ban/unban (dengan proteksi superadmin), melihat resep per user
- Manajemen Kategori: full CRUD bilingual dengan proteksi penghapusan kategori yang masih memiliki resep
- RBAC: role `superadmin` dengan permission `bypass-all` melalui `Gate::before`

### Bilingual (Indonesia / Inggris)

- Language switcher di navbar (session-based)
- 270+ string UI diterjemahkan di `lang/id/ui.php` dan `lang/en/ui.php`
- 24 kategori bilingual (`name` + `name_en`)
- 98 bahan masakan bilingual (`name` + `name_en`)
- Judul, deskripsi, dan langkah resep auto-translate via Google Translate engine
- Privacy Policy dan Terms of Service bilingual (auto-detect `app()->getLocale()`)
- Email notifikasi bilingual

## Arsitektur Object-Oriented

Proyek ini menerapkan tiga prinsip fundamental OOP di seluruh arsitekturnya. Berikut penjelasan setiap prinsip dengan contoh kode nyata dari proyek ini.

### Encapsulation : Service Layer

**Prinsip**: Encapsulation menyembunyikan detail implementasi internal di balik interface publik. Konsumen sebuah class hanya berinteraksi dengan method public-nya; logika internal, struktur data, dan dependensi tetap private.

**Implementasi**: Aplikasi memisahkan HTTP request handling (Controller) dari business logic (Service). Controller memvalidasi input dan mendelegasikan ke Service. Service mengenkapsulasi operasi kompleks : database transaction, image processing, translation, dan relationship synchronization : di balik method signature yang bersih.

```
HTTP Request
     |
     v
Controller (thin layer)
  - Validasi input via FormRequest
  - Memanggil method service
  - Mengembalikan view atau redirect
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

**Contoh Kode** : Controller hanya sebagai orchestrator. Semua business logic berada di Service:

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
}
```

Method `RecipeService::create()` mengenkapsulasi tujuh operasi berbeda dalam satu database transaction: pembuatan polymorphic child, translation, image processing, recipe insertion, morph association, category synchronization, dan ingredient synchronization. Controller tidak mengetahui detail implementasi apapun dari operasi-operasi tersebut.

### Inheritance : Polymorphic Relations

**Prinsip**: Inheritance memungkinkan sebuah class mewarisi properti dan perilaku dari class induknya. Dalam Eloquent ORM Laravel, semua model mewarisi dari `Illuminate\Database\Eloquent\Model`, sehingga memperoleh kemampuan database interaction tanpa implementasi eksplisit.

**Implementasi : Base Controller**:

Semua controller dalam aplikasi ini mewarisi dari `App\Http\Controllers\Controller`, yang mewarisi dari Laravel base controller dan mengimpor dua trait:

```php
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
```

- `AuthorizesRequests` : menyediakan method `$this->authorize()` yang digunakan di seluruh resource controller
- `ValidatesRequests` : menyediakan method `$this->validate()` untuk inline validation

Rantai inheritance ini berarti setiap controller otomatis mewarisi kemampuan authorization dan validation tanpa duplikasi kode.

**Implementasi : Eloquent Model Inheritance**:

Model `User` mendemonstrasikan multiple inheritance melalui trait composition:

```php
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
}
```

Setiap trait menyumbangkan kapabilitas spesifik:
- `HasApiTokens` : manajemen token Sanctum untuk API authentication
- `HasFactory` : dukungan model factory untuk testing dan seeding
- `Notifiable` : pengiriman notifikasi email (verifikasi, reset password)
- `HasRoles` : integrasi Spatie RBAC (pengecekan role dan permission)
- `SoftDeletes` : penghapusan non-destruktif dengan timestamp `deleted_at`

Model `Recipe` mewarisi dari `Model` dan mengkomposisi trait `HasFactory` dan `SoftDeletes`. Method `booted()` melakukan override terhadap lifecycle hook parent:

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

Ini mendemonstrasikan method overriding dalam rantai inheritance: `booted()` memperluas proses boot parent dengan menambahkan auto-generation slug saat create/update dan pembersihan storage saat force-delete.

### Polymorphism : Recipeable Interface

**Prinsip**: Polymorphism memungkinkan objek dengan tipe berbeda diperlakukan melalui interface yang sama. Satu model `Recipe` dapat mereferensikan `FoodRecipe` atau `DrinkRecipe` tanpa perlu mengetahui tipe konkretnya.

**Interface Contract**:

```php
// App\Interfaces\Recipeable.php
interface Recipeable
{
    public function getRecipeDetails(): string;
}
```

Interface ini menetapkan kontrak: setiap class yang mengimplementasikan `Recipeable` harus menyediakan method `getRecipeDetails()` yang mengembalikan string berisi atribut spesifik tipe resep.

**Implementasi Konkret**:

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
        if ($this->cooking_time > 0) $parts[] = "Waktu Masak: {$this->cooking_time} Menit";
        if ($this->serving_size > 0) $parts[] = "Porsi: {$this->serving_size} Orang";
        if ($this->calories > 0) $parts[] = "Kalori: {$this->calories} kkal";
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
        if ($this->glass_type) $parts[] = "Gelas: {$this->glass_type}";
        return implode(' | ', $parts);
    }
}
```

**Relasi Polymorphic**:

Model `Recipe` menggunakan Eloquent `morphTo`:

```php
// App\Models\Recipe.php
public function recipeable()
{
    return $this->morphTo();
}
```

Tabel `recipes` menyimpan dua kolom untuk relasi ini:

| Kolom | Contoh Nilai | Fungsi |
|---|---|---|
| `recipeable_type` | `'food'` atau `'drink'` | Mengidentifikasi model target |
| `recipeable_id` | `7` | Mereferensikan primary key model target |

**Morph Map untuk Keamanan**:

```php
// App\Providers\AppServiceProvider.php
Relation::morphMap([
    'food'  => FoodRecipe::class,
    'drink' => DrinkRecipe::class,
]);
```

**Penggunaan di Service Layer**:

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

**Ekstensibilitas**: Untuk menambahkan tipe resep baru (misal `BakeryRecipe`), developer hanya perlu:
1. Membuat model baru yang mengimplementasikan `Recipeable`
2. Menambahkan class baru ke `Relation::morphMap()`
3. Memperluas `createRecipeable()` untuk menangani tipe baru

Tidak diperlukan perubahan pada model `Recipe`, service yang sudah ada, atau view manapun.

### Observer Pattern : Event-Driven Rating

**Prinsip**: Observer pattern mendefinisikan dependensi one-to-many antar objek. Ketika satu objek berubah state, semua dependennya diberitahu dan diupdate otomatis.

**Implementasi**: Ketika review dibuat, diupdate, atau dihapus, sistem otomatis menghitung ulang rata-rata rating resep terkait melalui Laravel model observer.

```
User Submit Review
       |
       v
RatingService::createOrUpdate()
  - Menangani soft-deleted review restoration
  - Membuat atau mengupdate record review
       |
       | Eloquent memicu model event (created / updated / deleted)
       v
ReviewObserver
       |
       +-- created(Review $review)
       +-- updated(Review $review)
       +-- deleted(Review $review)
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

**Registrasi Observer**:

```php
// App\Providers\AppServiceProvider.php
Review::observe(app(ReviewObserver::class));
```

**Implementasi Observer**:

```php
// App\Observers\ReviewObserver.php
class ReviewObserver
{
    public function __construct(protected RatingService $ratingService) {}

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

**Soft-Delete Handling**:

`RatingService` menangani kasus user yang sebelumnya sudah mereview, menghapus review tersebut (soft delete), dan ingin mereview lagi:

```php
public function createOrUpdate(Recipe $recipe, int $userId, int $rating, ?string $comment = null): Review
{
    $review = Review::withTrashed()
        ->where('user_id', $userId)
        ->where('recipe_id', $recipe->id)
        ->first();

    if ($review) {
        if ($review->trashed()) $review->restore();
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

### Policy-Based Authorization

**Prinsip**: Authorization logic harus terpusat dan deklaratif, bukan tersebar di controller sebagai inline conditionals.

**Recipe Policy**:

```php
// App\Policies\RecipePolicy.php
class RecipePolicy
{
    public function view(?User $user, Recipe $recipe): bool
    {
        if ($recipe->status === 'published') return true;
        if (!$user) return false;
        return $user->id === $recipe->user_id
            || $user->hasPermissionTo('bypass-all');
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

**Global Bypass Superadmin**:

```php
// App\Providers\AuthServiceProvider.php
Gate::before(function ($user) {
    if ($user->hasPermissionTo('bypass-all')) return true;
});
```

**Penggunaan di Controller**:

```php
public function edit(Recipe $recipe)
{
    $this->authorize('update', $recipe); // Authorization check satu baris
    // ...
}
```

## Desain Database

### Entity Relationship

```
 users
  1|
   |hasMany
   |
   |          morphTo            implements
   +------ recipes ---------- recipeable ------- Recipeable
   |         |                                      |
   |         |                   +------------------+
   |         |                   |                  |
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
   +---< reviews
   |      (rating, comment, soft delete)
   |
   +---< bookmarks
          (user_id + recipe_id composite key)

 Spatie RBAC:
   roles --- role_has_permissions --- permissions
     |                                    |
   model_has_roles                  model_has_permissions
```

### Skema Tabel

| Tabel | Primary Key | Kolom Penting | Catatan |
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

### Index

| Tabel | Tipe Index | Kolom |
|---|---|---|
| `recipes` | FULLTEXT | title, description |
| `recipes` | INDEX | status |
| `reviews` | UNIQUE | user_id, recipe_id |
| `bookmarks` | UNIQUE | user_id, recipe_id |
| Semua FK | FOREIGN KEY | CASCADE ON DELETE |

## Keamanan

| Lapisan | Mekanisme | Detail |
|---|---|---|
| 1 | Web Authentication | Laravel Session Guard dengan secure cookies (`httpOnly`, `sameSite=lax`) |
| 2 | API Authentication | Laravel Sanctum personal access tokens |
| 3 | Authorization | Spatie RBAC (`superadmin` role + `bypass-all` permission) + Model Policies |
| 4 | Gate Bypass | `Gate::before` memberikan akses penuh ke superadmin |
| 5 | Rate Limiting | 6 req/min (auth), 10 req/min (API write), 30 req/min (API read) |
| 6 | CSRF Protection | `VerifyCsrfToken` middleware di semua web route |
| 7 | XSS Prevention | Blade `{{ }}` auto-escape output; `{!! !!}` tidak digunakan |
| 8 | SQL Injection | Semua query Eloquent pakai parameter binding; LIKE wildcard di-escape |
| 9 | Mass Assignment | `$fillable` whitelist di 7 model; tidak ada `$guarded` |
| 10 | Morph Injection | `Relation::morphMap(['food', 'drink'])` |
| 11 | File Upload | Validasi MIME (JPG, PNG, WebP), max 20MB, `basename()` anti traversal |
| 12 | Session | Timeout 5 menit, `secure: true`, `httpOnly: true`, `sameSite: lax` |
| 13 | Ban System | Middleware `CheckBanned` auto-logout user terbanned |
| 14 | Content Security Policy | `default-src 'self'` dengan direktif granular |
| 15 | Cross-Origin Headers | `COOP`, `CORP`, `COEP` |
| 16 | HSTS | `max-age=31536000; includeSubDomains; preload` (production) |

## SEO & Performa

### SEO

| Mekanisme | Implementasi |
|---|---|
| XML Sitemap | `/sitemap.xml` : dinamis: semua resep + kategori + halaman statis |
| Robots.txt | Konten publik di-allow, auth/admin di-block |
| Meta Tags | `title`, `description`, `keywords` unik per halaman via Blade `@yield` |
| Open Graph | `og:title`, `og:description`, `og:image`, `og:type`, `og:locale` |
| Twitter Card | `summary_large_image` |
| Canonical URL | Setiap halaman |
| JSON-LD Recipe Schema | Structured data: rating, bahan, langkah, nutrisi |
| Google Verification | File HTML + meta tag |

### Performa

| Optimasi | Metode | Hasil |
|---|---|---|
| Format Gambar | GD library: semua upload → WebP (80% quality) | 92-96% lebih kecil |
| Dimensi Gambar | `getimagesize()` + `imagecopyresampled()` max 1920px | Mencegah file oversized |
| Lazy Loading | `loading="lazy"` di semua `<img>` | Deferred off-screen loading |
| Font Delivery | Bunny.net CDN + `preconnect` hint | Latensi font minimal |
| Static Cache | `Cache-Control: max-age=31536000, immutable` | 1 tahun browser cache |
| Database Search | MySQL FULLTEXT index `recipes(title, description)` | Search sub-detik |
| Storage | Migrasi WebP semua gambar existing | 35MB → 3.3MB |

## Panduan Instalasi

### Persyaratan Sistem

- PHP 8.1+ dengan ekstensi: `gd` (WebP support), `mbstring`, `pdo_mysql`, `dom`, `json`
- Composer 2.x
- MySQL 8.0+ (FULLTEXT index)
- Node.js 18+ dan npm

### Langkah Instalasi

```bash
# Clone repository
git clone https://github.com/gempurbudianarki/web-resep-makanan.git bagiresep
cd bagiresep

# Install PHP dependencies
composer install

# Install dan build frontend
npm install
npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=bagiresep
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Buat symbolic link storage
php artisan storage:link

# Cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan development server
php artisan serve
```

### Akun Default

| Role | Email | Password |
|---|---|---|
| SuperAdmin | `admin@resepkita.test` | `password` |
| User | `gempurbudianarki@gmail.com` | `password` |

### Konfigurasi Email (Gmail SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-anda@gmail.com
MAIL_PASSWORD=app-password-anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email-anda@gmail.com
MAIL_FROM_NAME="BagiResep"
```

### Gambar Sampul

Letakkan file berikut di `storage/app/public/sampul/`:

- `sampuldepan.webp` : Background hero landing page
- `sampuldalam.webp` : Background header halaman internal

## API Reference

### Authentication

```
POST   /api/auth/register     Rate: 6/min     Registrasi user baru, return Sanctum token
POST   /api/auth/login        Rate: 6/min     Login dan dapatkan token
POST   /api/auth/logout       Auth: Sanctum   Revoke token
GET    /api/auth/me           Auth: Sanctum   Profil user beserta roles
```

### Recipes

```
GET    /api/recipes             Public          List resep (?search=&category_id=&per_page=&sort=)
GET    /api/recipes/{id}        Public          Detail resep dengan relasi dan review terbaru
POST   /api/recipes             Auth: Sanctum   Buat resep (rate: 10/min)
PUT    /api/recipes/{id}        Auth: Sanctum   Update resep (rate: 10/min)
DELETE /api/recipes/{id}        Auth: Sanctum   Hapus resep
```

### Reviews

```
GET    /api/recipes/{id}/reviews           Public          List review suatu resep
POST   /api/recipes/{id}/reviews           Auth: Sanctum   Buat review
PUT    /api/recipes/{id}/reviews/{id}      Auth: Sanctum   Update review sendiri
DELETE /api/recipes/{id}/reviews/{id}      Auth: Sanctum   Hapus review sendiri (atau superadmin)
```

### Bookmarks

```
POST   /api/recipes/{id}/bookmark    Auth: Sanctum   Toggle bookmark
GET    /api/bookmarks                Auth: Sanctum   List resep yang di-bookmark
```

### Categories & Ingredients

```
GET    /api/categories          Public          List semua kategori
GET    /api/categories/{id}     Public          Detail kategori
POST   /api/categories          Auth: Admin     Buat kategori
PUT    /api/categories/{id}     Auth: Admin     Update kategori
DELETE /api/categories/{id}     Auth: Admin     Hapus kategori
GET    /api/ingredients         Public          Cari bahan (?search=)
```

## Artisan Commands

```bash
# Translate resep yang belum ada terjemahan Inggris
php artisan recipes:translate

# Force re-translate semua resep (overwrite)
php artisan recipes:translate --force

# Seed dataset spesifik
php artisan db:seed --class=RealRecipesSeeder --force
php artisan db:seed --class=GempurRecipesSeeder --force
php artisan db:seed --class=DemoDataSeeder --force
```

## Testing

```bash
php artisan test

# Tests\Feature\AuthTest              PASS (5 tests)
# Tests\Feature\AuthorizationTest     PASS (3 tests)
# Tests\Feature\BookmarkTest          PASS (5 tests)
# Tests\Feature\RecipeTest            PASS (10 tests)
# Tests\Feature\ReviewTest            PASS (5 tests)
#
# Total: 30 tests, 68 assertions
```

## Struktur Direktori

```
app/
  Console/Commands/TranslateRecipes.php     Batch translation command
  Http/
    Controllers/
      Api/                                  REST API controllers (6 file)
      Web/                                  MVC controllers (10 file)
        Admin/                              Admin sub-controllers (3 file)
      Controller.php                        Base controller
    Middleware/                             Custom middleware (12 file)
      Authenticate.php                      Redirect unauthenticated
      CheckBanned.php                       Auto-logout banned user
      SecurityHeaders.php                   CSP, HSTS, COOP/CORP/COEP
      SetLanguage.php                       Deteksi locale dari session
    Requests/                               Form request validation (3 file)
    Resources/                              API resource transformers (5 file)
  Interfaces/Recipeable.php                 Polymorphism contract
  Models/                                   Eloquent models (7 file)
  Observers/ReviewObserver.php              Auto-recalculate rating
  Policies/RecipePolicy.php                 Authorization rules
  Providers/                                Service providers (5 file)
  Services/                                 Business logic layer (5 file)
    RecipeService.php                       Recipe CRUD + image + translation
    RatingService.php                       Review + aggregate rating
    BookmarkService.php                     Bookmark toggle + collection
    TranslationService.php                  Google Translate + MyMemory fallback
    TurnstileService.php                    Cloudflare Turnstile verification

config/                                     Konfigurasi aplikasi (16 file)
database/
  factories/                                Model factories (7 file)
  migrations/                               Database migrations (24 file)
  seeders/                                  Data seeders (6 file)
lang/
  en/                                       English translation (4 file)
  id/                                       Indonesian translation (4 file)
resources/
  css/app.css                               Tailwind + custom components
  js/                                       Alpine.js + Axios bootstrap
  views/                                    Blade templates (33 file)
routes/
  web.php                                   Web routes
  api.php                                   API routes
tests/
  Feature/                                  Feature tests (6 file, 29 tests)
  Unit/                                     Unit tests (1 file)
```

<p align="center">
  <br>
  <sub>Dibangun oleh</sub>
  <br>
  <strong>Gempur Budi Anarki</strong>
  <br>
  <sub>Senior Software Engineer & Web Developer</sub>
  <br>
  <a href="https://gempurbudianarki.space/">gempurbudianarki.space</a>
  <br>
  <br>
  <sub>Situs: <a href="https://bagiresep.fun/">bagiresep.fun</a></sub>
  <br>
  <br>
  <sub>&copy; 2026 BagiResep. Seluruh hak cipta dilindungi.</sub>
</p>
