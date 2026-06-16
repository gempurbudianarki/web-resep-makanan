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

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Teknologi](#teknologi)
- [Fitur Lengkap](#fitur-lengkap)
- [Arsitektur & Design Patterns](#arsitektur--design-patterns)
  - [Service Layer Pattern](#1-service-layer-pattern)
  - [Polymorphism (Strategy Pattern)](#2-polymorphism-strategy-pattern)
  - [Observer Pattern](#3-observer-pattern)
  - [Repository Pattern](#4-repository-pattern)
  - [Policy-Based Authorization](#5-policy-based-authorization)
- [Struktur Database](#struktur-database)
- [Keamanan](#keamanan)
- [SEO & Performance](#seo--performance)
- [Instalasi](#instalasi)
- [API Endpoint](#api-endpoint)
- [Commands](#commands)
- [Testing](#testing)

---

## Tentang Proyek

**BagiResep** adalah platform berbagi resep masakan Indonesia dengan dukungan bilingual penuh (Indonesia & English). Dibangun dengan **Laravel 10**, proyek ini menerapkan 5 design pattern enterprise-grade: **Service Layer**, **Polymorphism (Strategy)**, **Observer**, **Repository**, dan **Policy-Based Authorization**.

> Production-ready di **[bagiresep.fun](https://bagiresep.fun)** — 16 lapis keamanan, SEO optimized, performa gambar WebP, desain responsif premium Playfair Display + DM Sans.

---

## Teknologi

### Backend
| Teknologi | Versi | Kegunaan |
|---|---|---|
| PHP | 8.1+ | Runtime |
| Laravel | 10.x | Framework MVC |
| Spatie Permission | 6.x | Role-Based Access Control |
| Laravel Sanctum | 3.x | API Token Authentication |
| MySQL | 8.0 | Database + FULLTEXT index |
| stichoza/google-translate-php | 5.x | Google Translate engine (free, no API key) |
| MyMemory API | Free | Fallback translation |
| Guzzle | 7.x | HTTP client |

### Frontend
| Teknologi | Kegunaan |
|---|---|
| Tailwind CSS 3.x | Utility-first CSS, custom luxury color palette |
| Alpine.js 3.x | Interaktivitas ringan (dropdown, carousel, modal) |
| Cropper.js 1.6 | Client-side image cropping 4:3 |
| Vite 5.x | Module bundler |
| Axios 1.x | HTTP client |
| Playfair Display | Display font — luxury editorial |
| DM Sans | Body font — clean modern sans-serif |

---

## Fitur Lengkap

### Guest (Tamu)
- Landing page fullscreen hero image dengan mobile menu glass-morphism
- Jelajahi semua resep dengan **search FULLTEXT** + filter 24 kategori + sort (rating/terbaru)
- Infinite scroll carousel resep rating tertinggi
- Detail resep lengkap: foto, bahan, langkah, review, info nutrisi
- Register & Login dengan **rate limiting** + password complexity (uppercase + lowercase + number)
- Lupa password & reset password via email (Gmail SMTP)
- Cookie consent banner
- Ganti bahasa: Indonesia / English — **seluruh konten bilingual**

### Member (User)
- Dashboard personal dengan statistik (total resep, published, draft, avg rating)
- **Buat Resep**: pilih tipe Makanan/Minuman, upload foto (max 20MB)
- **Image cropper** dengan viewfinder 4:3 (rotate, flip, zoom, reset)
- Auto-resize gambar >1920px + **output WebP** kualitas 80%
- Pilih 24 kategori bilingual, tambah 98 bahan (autocomplete + 53 satuan)
- Tulis langkah-langkah dinamis
- Form validation error dalam Bahasa Indonesia
- Edit/Hapus resep milik sendiri (**soft delete**)
- Bookmark toggle + halaman bookmark
- Review & Rating bintang 1-5
- Profil: edit nama, email, ganti password
- Cetak resep layout A4
- **Auto-translate judul + deskripsi + langkah resep ke English** (Google Translate → MyMemory fallback)

### SuperAdmin
- Dashboard statistik: total user, resep, review, rating + pertumbuhan mingguan
- Manajemen Resep: lihat semua, publish/draft toggle, hapus
- Manajemen User: lihat semua, **ban/unban**, lihat resep per user
- Manajemen Kategori: CRUD bilingual
- RBAC: `superadmin` role dengan `bypass-all` permission via `Gate::before`

### Bilingual (Indonesia / English)
- Navbar language switcher (session-based)
- 270+ string UI diterjemahkan (file `lang/id/ui.php` + `lang/en/ui.php`)
- 24 kategori bilingual (`name` + `name_en`)
- 98 bahan masakan bilingual (`name` + `name_en`)
- **Judul + deskripsi + langkah-langkah resep** auto-translate via Google Translate API
- Privacy Policy & Terms of Service bilingual (auto-detect `app()->getLocale()`)
- Email notifikasi bilingual

---

## Arsitektur & Design Patterns

Proyek ini menerapkan **5 design pattern** yang memisahkan concern, meningkatkan maintainability, dan memungkinkan ekstensi tanpa mengubah kode existing.

### 1. Service Layer Pattern

**Tujuan**: Memisahkan business logic dari controller. Controller hanya bertugas sebagai *traffic cop* — menerima request, memanggil service, mengembalikan response.

```
┌─────────────────────────────────────────────────────────┐
│                     CONTROLLER                          │
│  RecipeController, AuthController, AdminController...   │
│  Tugas: validasi input, panggil service, return view    │
└──────────────────────┬──────────────────────────────────┘
                       │ memanggil
┌──────────────────────▼──────────────────────────────────┐
│                    SERVICE LAYER                        │
│                                                        │
│  RecipeService          TranslationService              │
│  ├─ create()            ├─ translateToEnglish()         │
│  ├─ update()            ├─ translateRecipe()            │
│  ├─ delete()            └─ translateSteps()             │
│  ├─ search()                                            │
│  └─ handleImageUpload() RatingService                   │
│                            ├─ createOrUpdate()           │
│  BookmarkService           ├─ delete()                   │
│  ├─ toggle()               └─ recalculateAvgRating()     │
│  └─ getUserBookmarks()                                  │
│                                                        │
└──────────────────────┬──────────────────────────────────┘
                       │ memanggil
┌──────────────────────▼──────────────────────────────────┐
│                    DATA LAYER                           │
│  Models (Eloquent), Migrations, Database                │
└─────────────────────────────────────────────────────────┘
```

**Contoh kode** — Controller ramping, logic di service:
```php
// ❌ BAD: Logic di controller
public function store(Request $request) {
    $recipe = Recipe::create([...]);
    $recipe->categories()->sync($request->categories);
    // ... banyak logic lain
}

// ✅ GOOD: Controller delegasi ke service
public function store(StoreRecipeRequest $request, RecipeService $service) {
    $recipe = $service->create($request->validated(), auth()->id());
    return redirect()->route('recipes.show', $recipe);
}
```

### 2. Polymorphism (Strategy Pattern)

**Tujuan**: Satu model `Recipe` bisa memiliki dua bentuk berbeda (`FoodRecipe` dan `DrinkRecipe`) tanpa duplikasi kode, menggunakan **Polymorphic Relationship** Laravel (morphTo/morphOne).

```
                    ┌─────────────────┐
                    │     Recipe      │
                    │  (parent model) │
                    │                 │
                    │  recipeable_id  │──┐
                    │  recipeable_type│  │ morphTo()
                    └─────────────────┘  │
                           │             │
              ┌────────────┴─────────────┘
              │
    ┌─────────▼──────────┐    ┌─────────▼──────────┐
    │    FoodRecipe      │    │    DrinkRecipe     │
    │  implements        │    │  implements        │
    │  Recipeable        │    │  Recipeable        │
    │                    │    │                    │
    │  cooking_time      │    │  is_cold           │
    │  serving_size      │    │  glass_type        │
    │  calories          │    │                    │
    │                    │    │                    │
    │  getRecipeDetails()│    │  getRecipeDetails()│
    │  → "30 Menit |     │    │  → "Dingin |       │
    │     4 Orang |      │    │     Highball"      │
    │     250 kkal"      │    │                    │
    └────────────────────┘    └────────────────────┘
```

**Interface `Recipeable`** — kontrak yang harus dipenuhi setiap tipe resep:
```php
interface Recipeable {
    public function getRecipeDetails(): string;
}
```

**Keuntungan design ini**:
- Tambah tipe resep baru (misal `BakeryRecipe`) tanpa ubah kode `Recipe` sama sekali
- Setiap tipe punya kolom sendiri — gak ada kolom nullable yang gak kepakai
- Query tetap efisien karena pakai `morphMap`:
  ```php
  Relation::morphMap([
      'food'  => FoodRecipe::class,
      'drink' => DrinkRecipe::class,
  ]);
  ```

### 3. Observer Pattern

**Tujuan**: Auto-recalculate `avg_rating` setiap kali review dibuat, diupdate, atau dihapus — tanpa controller tahu.

```
User Submit Review
       │
       ▼
RatingService::createOrUpdate()
       │
       │ Eloquent event fired (created/updated/deleted)
       ▼
ReviewObserver
       │
       ├─ created(Review)  ──┐
       ├─ updated(Review)  ──┤
       └─ deleted(Review)  ──┘
                              │
                              ▼
               RatingService::recalculateAvgRating(Recipe)
                              │
                              ▼
               UPDATE recipes SET avg_rating = AVG(reviews.rating)
```

**Registrasi observer** — cukup satu baris di `AppServiceProvider::boot()`:
```php
Review::observe(app(ReviewObserver::class));
```

> **Catatan**: `RatingService::delete()` menggunakan soft delete. Observer menangani event `deleted` (soft delete) untuk recalculate ulang rating tanpa review yang dihapus.

### 4. Repository Pattern

**Tujuan**: Enkapsulasi query database kompleks di dalam Service, bukan di Controller.

**Contoh**: `RecipeService::search()` menangani FULLTEXT + LIKE fallback + sanitasi + filter kategori:
```php
public function search(?string $query, ?int $categoryId, int $perPage, string $sort)
{
    return Recipe::with(['recipeable', 'categories', 'user'])
        ->published()
        ->when($query, fn($q) => $q->whereFullText(['title', 'description'], $query)
            ->orWhere('title', 'like', "%{$query}%"))
        ->when($categoryId, fn($q) => $q->byCategory($categoryId))
        ->when($sort === 'rating', fn($q) => $q->orderBy('avg_rating', 'desc'))
        ->latest()
        ->paginate($perPage);
}
```

### 5. Policy-Based Authorization

**Tujuan**: Authorization logic terpusat di Policy class, bukan di controller. Superadmin bypass via `Gate::before`.

```php
// RecipePolicy.php
class RecipePolicy
{
    public function view(?User $user, Recipe $recipe): bool {
        if ($recipe->status === 'published') return true;  // semua orang bisa lihat published
        if (!$user) return false;                           // guest gak bisa lihat draft
        return $user->id === $recipe->user_id               // owner BISA
            || $user->hasPermissionTo('bypass-all');        // admin BISA
    }

    public function update(User $user, Recipe $recipe): bool {
        return $user->id === $recipe->user_id
            || $user->hasPermissionTo('bypass-all');
    }
}

// AuthServiceProvider.php — SuperAdmin bypass semua Gate check
Gate::before(function ($user) {
    if ($user->hasPermissionTo('bypass-all')) return true;
});
```

---

## Struktur Database

### 16 Tabel — ER Diagram

```
┌──────────┐     ┌──────────────┐     ┌───────────────┐
│   users  │────<│   recipes    │────<│   reviews     │
│          │     │              │     │               │
│ id       │     │ id           │     │ id            │
│ name     │     │ user_id (FK) │     │ user_id (FK)  │
│ email    │     │ title        │     │ recipe_id(FK) │
│ password │     │ title_en     │     │ rating        │
│ banned   │     │ description  │     │ comment       │
│ deleted  │     │ description_en│    │ deleted_at    │
└──────────┘     │ image        │     └───────────────┘
                 │ steps (JSON) │
                 │ steps_en(JSON)│
                 │ recipeable   │──┐ polymorphic
                 │ avg_rating   │  │
                 │ status       │  ├── food_recipes
                 │ deleted_at   │  │   (cooking_time,
                 └──────────────┘  │    serving_size,
                        │          │    calories)
                        │          │
                 ┌──────┴──────┐  └── drink_recipes
                 │   PIVOT     │      (is_cold,
                 │   TABLES    │       glass_type)
                 │             │
                 │ category_   │  recipe_
                 │ recipe      │  ingredients
                 │             │  (amount, unit)
                 └─────────────┘
```

### Spatie RBAC Tables
- `roles` — `superadmin`, `user`
- `permissions` — `bypass-all`
- `role_has_permissions`, `model_has_roles`, `model_has_permissions`

### Indexes
- **FULLTEXT** `recipes_search` on (title, description)
- **UNIQUE** `reviews` (user_id, recipe_id)
- **UNIQUE** `bookmarks` (user_id, recipe_id)
- Foreign keys dengan `cascadeOnDelete`

---

## Keamanan

| # | Lapisan | Implementasi |
|---|---|---|
| 1 | Authentication | Session (web) + Sanctum Token (API) |
| 2 | Authorization | RBAC Spatie + RecipePolicy + `Gate::before` bypass-all |
| 3 | Rate Limiting | Web: 6/min (auth), API: 10/min (write), 30/min (read) |
| 4 | CSRF | Semua form `@csrf`, VerifyCsrfToken middleware |
| 5 | XSS Prevention | Blade auto-escape `{{ }}` + input validation ketat |
| 6 | SQL Injection | Eloquent parameter binding + LIKE wildcard sanitization |
| 7 | Mass Assignment | `$fillable` ketat di semua 7 Model |
| 8 | Morph Injection | `Relation::morphMap(['food', 'drink'])` |
| 9 | File Upload | Validasi mime + size 20MB + sanitasi filename + `basename()` |
| 10 | Session Hardening | `secure: true`, `httpOnly: true`, `sameSite: lax`, 5-min lifetime |
| 11 | Ban System | Middleware `CheckBanned` — auto-logout + redirect banned user |
| 12 | CSP | Content-Security-Policy: script-src, style-src, img-src, frame-src |
| 13 | COOP/CORP/COEP | Cross-Origin isolation headers |
| 14 | HSTS | `max-age=31536000; includeSubDomains; preload` |
| 15 | Password Policy | Complexity: uppercase + lowercase + number, min 8 karakter |
| 16 | Security Disclosure | `/.well-known/security.txt` |

---

## SEO & Performance

### SEO
| Fitur | Detail |
|---|---|
| Sitemap XML | `/sitemap.xml` — 14 resep + 24 kategori + halaman statis |
| Robots.txt | Auth/admin di-block, konten publik di-allow |
| Meta Tags | Title + description + keywords unik per halaman |
| Open Graph | `og:title`, `og:description`, `og:image` di semua halaman |
| Twitter Card | `summary_large_image` |
| Canonical URL | Setiap halaman |
| **JSON-LD Recipe Schema** | Structured data di setiap resep (rating ★, bahan, langkah, nutrisi) |
| Google Verification | File HTML + meta tag |
| Google Translate | Auto-translate ID→EN untuk judul + deskripsi + langkah |

### Performance
| Optimasi | Detail |
|---|---|
| WebP Conversion | Semua PNG → WebP (92-96% lebih kecil) |
| Lazy Loading | `loading="lazy"` di semua `<img>` |
| Image Processing | Auto-resize >1920px, output WebP quality 80% |
| Storage Reduction | 35MB → 3.3MB (hemat 90%) |
| Font CDN | Bunny.net + `preconnect` |
| Cache Headers | `max-age=31536000, immutable` pada aset statis |

---

## Instalasi

### Prasyarat
- PHP 8.1+ dengan ekstensi: `gd` (WebP), `mbstring`, `pdo_mysql`
- Composer 2.x
- MySQL 8.0+
- Node.js 18+, npm

```bash
# 1. Clone repository
git clone https://github.com/gempurbudianarki/web-resep-makanan.git bagiresep
cd bagiresep

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=bagiresep
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi & seeder
php artisan migrate --seed

# 6. Storage symlink
php artisan storage:link

# 7. Build frontend assets
npm run build

# 8. Cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Jalankan development server
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
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME="BagiResep"
```

### Konfigurasi Turnstile (Opsional)
```env
TURNSTILE_SITE_KEY=your-site-key
TURNSTILE_SECRET_KEY=your-secret-key
```

### Gambar Sampul
Letakkan di `storage/app/public/sampul/`:
- `sampuldepan.webp` — Hero image landing page
- `sampuldalam.webp` — Header halaman internal

---

## API Endpoint

### Authentication
| Method | Endpoint | Auth | Rate Limit |
|---|---|---|---|
| POST | `/api/auth/register` | Guest | 6/min |
| POST | `/api/auth/login` | Guest | 6/min |
| POST | `/api/auth/logout` | Sanctum | — |
| GET | `/api/auth/me` | Sanctum | — |

### Recipes
| Method | Endpoint | Auth | Rate Limit |
|---|---|---|---|
| GET | `/api/recipes` | Public | — |
| GET | `/api/recipes/{id}` | Public | — |
| POST | `/api/recipes` | Sanctum | 10/min |
| PUT | `/api/recipes/{id}` | Sanctum | 10/min |
| DELETE | `/api/recipes/{id}` | Sanctum | — |

### Reviews & Bookmarks
| Method | Endpoint | Auth |
|---|---|---|
| GET | `/api/recipes/{id}/reviews` | Public |
| POST | `/api/recipes/{id}/reviews` | Sanctum |
| PUT | `/api/recipes/{id}/reviews/{id}` | Sanctum |
| DELETE | `/api/recipes/{id}/reviews/{id}` | Sanctum |
| POST | `/api/recipes/{id}/bookmark` | Sanctum |
| GET | `/api/bookmarks` | Sanctum |

### Categories & Ingredients
| Method | Endpoint | Auth |
|---|---|---|
| GET | `/api/categories` | Public |
| POST/PUT/DELETE | `/api/categories` | Admin (`bypass-all`) |
| GET | `/api/ingredients?search=` | Public |

---

## Commands

```bash
# Translate semua resep yang belum ada English-nya
php artisan recipes:translate

# Force re-translate semua resep (overwrite terjemahan lama)
php artisan recipes:translate --force

# Seed database dengan data asli
php artisan db:seed --class=RealRecipesSeeder --force

# Seed resep premium
php artisan db:seed --class=GempurRecipesSeeder --force

# Seed data demo
php artisan db:seed --class=DemoDataSeeder --force
```

---

## Testing

```bash
php artisan test

# PASS  Tests\Unit\ExampleTest
# PASS  Tests\Feature\AuthTest
# PASS  Tests\Feature\AuthorizationTest
# PASS  Tests\Feature\BookmarkTest
# PASS  Tests\Feature\RecipeTest
# PASS  Tests\Feature\ReviewTest
#
# Tests:  30 passed
# Assertions:  68
```

---

## Struktur Direktori

```
app/
├── Console/Commands/        # Artisan commands (TranslateRecipes)
├── Http/
│   ├── Controllers/
│   │   ├── Api/             # REST API controllers (6 file)
│   │   └── Web/             # MVC controllers (13 file)
│   │       └── Admin/        # Admin sub-controllers (3 file)
│   ├── Middleware/           # 12 middleware termasuk custom
│   ├── Requests/             # Form request validation
│   └── Resources/            # API resource transformers
├── Interfaces/
│   └── Recipeable.php       # Polymorphism interface
├── Models/                   # 7 Eloquent models
├── Observers/
│   └── ReviewObserver.php   # Auto recalculate avg_rating
├── Policies/
│   └── RecipePolicy.php     # Authorization rules
├── Providers/               # Service providers + morphMap
└── Services/                # Business logic layer (4 service)
    ├── RecipeService.php
    ├── RatingService.php
    ├── BookmarkService.php
    └── TranslationService.php
```

---

## Deployment

Proyek ini di-deploy di **Hostinger shared hosting**:

| Komponen | Konfigurasi |
|---|---|
| Web Server | Nginx |
| PHP | 8.1 FPM |
| Database | MySQL 8.0 |
| SSL | Let's Encrypt via Cloudflare |
| CDN/WAF | Cloudflare (proxy + DDoS protection) |
| Domain | [bagiresep.fun](https://bagiresep.fun) |

---

<p align="center">
  <br>
  <sub>Dibangun dengan ❤️ oleh</sub>
  <br>
  <strong>Gempur Budi Anarki</strong>
  <br>
  <sub>Senior Software Engineer & Web Developer</sub>
  <br>
  <br>
  <sub>&copy; 2026 BagiResep. All rights reserved.</sub>
</p>
