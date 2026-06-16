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
  <img src="https://img.shields.io/badge/Migrations-24_Ran-22C55E" />
  <img src="https://img.shields.io/badge/Routes-48-3B82F6" />
  <img src="https://img.shields.io/badge/Security-15_Layers-EF4444" />
  <img src="https://img.shields.io/badge/Tests-30_Passed-8B5CF6" />
  <img src="https://img.shields.io/badge/License-MIT-blue" />
</p>

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Teknologi](#teknologi)
- [Fitur Lengkap](#fitur-lengkap)
- [Arsitektur](#arsitektur)
- [Struktur Database](#struktur-database)
- [Keamanan](#keamanan)
- [SEO & Performance](#seo--performance)
- [Instalasi](#instalasi)
- [API Endpoint](#api-endpoint)
- [Commands](#commands)
- [Testing](#testing)

---

## Tentang Proyek

**BagiResep** adalah platform berbagi resep masakan Indonesia dengan dukungan bilingual penuh (Indonesia & English). Dibangun dengan **Laravel 10**, menerapkan **Service-Repository Pattern**, **OOP Polymorphism** (FoodRecipe & DrinkRecipe), **RBAC** (Spatie Permission), dan **Google Translate API** untuk auto-translate resep berkualitas tinggi.

> Production-ready di [bagiresep.fun](https://bagiresep.fun) — keamanan 15 lapis, SEO optimized, performa gambar WebP, desain responsif premium dengan font Playfair Display + DM Sans.

---

## Teknologi

### Backend
| Teknologi | Versi | Kegunaan |
|---|---|---|
| PHP | 8.1+ | Runtime |
| Laravel | 10.x | Framework |
| Spatie Permission | 6.x | RBAC |
| Sanctum | 3.x | API Token Auth |
| MySQL | 8.0 | Database + FULLTEXT search |
| stichoza/google-translate-php | 5.x | Google Translate engine (primary) |
| MyMemory API | Free | Fallback translation |
| Guzzle | 7.x | HTTP client |

### Frontend
| Teknologi | Kegunaan |
|---|---|
| Tailwind CSS 3.x | Utility-first styling, custom luxury theme |
| Alpine.js 3.x | Interaktivitas (dropdown, mobile menu, carousel, crop tool) |
| Cropper.js 2.x | Image crop dengan viewfinder 4:3 |
| Vite 5.x | Module bundler |
| Axios 1.x | HTTP client |
| Playfair Display | Display font — luxury steakhouse |
| DM Sans | Body font — clean modern |

---

## Fitur Lengkap

### Guest (Tamu)
- Landing page fullscreen hero image dengan mobile menu glass-morphism
- Jelajahi semua resep dengan search FULLTEXT + filter kategori + sort (rating/terbaru)
- Infinite scroll carousel resep rating tertinggi
- Detail resep lengkap: foto, bahan, langkah, review, info nutrisi
- Register & Login dengan rate limiting + password strength indicator
- Password complexity: uppercase + lowercase + number
- Lupa password & reset password via email (Gmail SMTP)
- Cookie consent banner
- Ganti bahasa: Indonesia / English — seluruh konten diterjemahkan

### Member (User)
- Dashboard personal dengan statistik (total resep, published, draft, avg rating)
- Buat Resep: pilih tipe Makanan/Minuman, upload foto (max 20MB)
- Image cropper dengan viewfinder 4:3 (rotate, flip, zoom)
- Auto-resize gambar >1920px + **output WebP** (80% lebih kecil)
- Pilih kategori (24 kategori bilingual), tambah bahan (70+ satuan + autocomplete)
- Tulis langkah-langkah dinamis
- Form validation error dalam Bahasa Indonesia
- Loading overlay saat submit
- Edit/Hapus resep milik sendiri (soft delete)
- Bookmark toggle + halaman bookmark
- Review & Rating bintang 1-5
- Profil: edit nama, email, ganti password (dengan password complexity)
- Cetak resep layout A4
- **Auto-translate judul, deskripsi & langkah resep ke English** (Google Translate + MyMemory fallback)

### SuperAdmin
- Dashboard statistik: total user, resep, review, rating
- Manajemen Resep: lihat semua, publish/draft toggle, hapus (soft delete)
- Manajemen User: lihat semua, ban/unban, lihat resep per user
- Manajemen Kategori: CRUD bilingual (nama + name_en)
- Sidebar premium dengan gradient dark theme

### Bilingual (Indonesia / English)
- Navbar language switcher (session-based)
- 270+ string UI diterjemahkan
- 24 kategori bilingual
- 98 bahan masakan bilingual
- **Judul, deskripsi & langkah-langkah resep** auto-translate via Google Translate
- Error validasi bilingual
- Email notifikasi bilingual
- Privacy Policy & Terms of Service bilingual (auto-detect locale)

---

## Arsitektur

### Service Layer
| Service | Tanggung Jawab |
|---|---|
| `RecipeService` | CRUD resep + polymorphic child + sync relasi + image optimize (WebP) + auto-translate |
| `RatingService` | Enkapsulasi rating + auto recalculate avg_rating |
| `BookmarkService` | Toggle bookmark (atomic, mencegah duplikasi) |
| `TranslationService` | Google Translate (primary) + MyMemory (fallback) ID→EN |

### OOP Polymorphism
```
Recipe (parent)
  └── recipeable (morphTo)
        ├── FoodRecipe implements Recipeable
        │     └── getRecipeDetails() -> "Waktu Masak: 30 Menit | Porsi: 4 | Kalori: 250 kkal"
        └── DrinkRecipe implements Recipeable
              └── getRecipeDetails() -> "Disajikan: Dingin | Gelas: Highball"
```

### Rating Aggregation (Observer Pattern)
```
User Submit Review -> RatingService::createOrUpdate()
  -> ReviewObserver (created/updated/deleted)
    -> RatingService::recalculateAvgRating()
      -> UPDATE recipes SET avg_rating = AVG(reviews.rating)
```

---

## Struktur Database

### 16 Tabel
| Tabel | Kolom Kunci |
|---|---|
| users | id, name, email, password (hashed), banned_at, deleted_at (soft delete) |
| recipes | id, user_id, title, title_en, description, description_en, image, steps (JSON), steps_en (JSON), recipeable (morph), avg_rating, status, deleted_at |
| categories | id, name, name_en, slug |
| ingredients | id, name, name_en |
| food_recipes | id, cooking_time, serving_size, calories |
| drink_recipes | id, is_cold, glass_type |
| reviews | id, user_id, recipe_id, rating, comment, deleted_at |
| bookmarks | user_id, recipe_id (composite PK), timestamps |

### Pivot Tables
- `category_recipe`: category_id + recipe_id
- `recipe_ingredients`: recipe_id + ingredient_id + amount + unit

### Spatie RBAC
- `roles`, `permissions`, `role_has_permissions`, `model_has_roles`, `model_has_permissions`

### Indexes
- FULLTEXT index on recipes(title, description)
- Unique: reviews(user_id, recipe_id), bookmarks(user_id, recipe_id)
- Foreign keys dengan cascadeOnDelete

---

## Keamanan

| Lapisan | Implementasi |
|---|---|
| Authentication | Session (web) + Sanctum Token (API) |
| Authorization | RBAC Spatie + RecipePolicy + Gate::before bypass-all |
| Rate Limiting | Web: 6/min (auth), API: 10/min (write), 30/min (read) |
| CSRF | Semua form `@csrf`, VerifyCsrfToken |
| XSS | Blade auto-escape `{{ }}`, validasi input ketat |
| SQL Injection | Eloquent binding, tidak ada raw query, LIKE sanitization |
| Mass Assignment | `$fillable` ketat di semua 7 Model |
| Morph Injection | `Relation::morphMap(['food', 'drink'])` |
| File Upload | Validasi JPG/PNG/WebP, max 20MB, sanitasi filename, `basename()` |
| Session | `secure: true`, `httpOnly: true`, `sameSite: lax` |
| Ban System | Middleware `CheckBanned` auto-logout + redirect |
| CSP | Content-Security-Policy header (script-src, style-src, img-src, etc.) |
| COOP/CORP/COEP | Cross-Origin isolation headers |
| HSTS | `max-age=31536000; includeSubDomains; preload` |
| Password | Complexity: uppercase + lowercase + number, min 8 chars |
| security.txt | `/.well-known/security.txt` |

---

## SEO & Performance

### SEO
| Fitur | Status |
|---|---|
| Sitemap XML | `/sitemap.xml` (semua resep + kategori + halaman) |
| Robots.txt | `/robots.txt` (auth/admin di-block, konten di-allow) |
| Meta tags | Title, description, keywords unik per halaman |
| Open Graph | `og:title`, `og:description`, `og:image` semua halaman |
| Twitter Card | `summary_large_image` |
| Canonical URL | Semua halaman |
| JSON-LD Recipe Schema | Structured data di setiap resep (rating, bahan, langkah, nutrisi) |
| Google Verification | File HTML + meta tag |

### Performance
| Optimasi | Detail |
|---|---|
| WebP Conversion | Semua gambar resep PNG→WebP (92-96% lebih kecil) |
| Lazy Loading | `loading="lazy"` di semua `<img>` |
| Image Optimize | Auto-resize >1920px, output WebP quality 80% |
| Auto-upload WebP | Semua upload baru otomatis WebP |
| Total storage | Dari 30MB → 4.3MB (hemat 86%) |
| Font loading | Bunny.net CDN + `preconnect` |
| Cache headers | `max-age=31536000, immutable` |

---

## Instalasi

### Prasyarat
- PHP 8.1+, Composer 2.x
- MySQL 8.0+
- Node.js 18+, npm
- GD Library (dengan WebP support)

```bash
# 1. Clone
git clone <repo-url> bagiresep
cd bagiresep

# 2. Install dependencies
composer install
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=bagiresep
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Migrasi & seeder
php artisan migrate --seed

# 6. Storage symlink
php artisan storage:link

# 7. Build frontend
npm run build

# 8. Cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Jalankan
php artisan serve
```

### Akun Default
| Role | Email | Password |
|---|---|---|
| SuperAdmin | `admin@resepkita.test` | `password` |
| User | `gempurbudianarki@gmail.com` | `password` |

### Konfigurasi Email
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email@gmail.com
MAIL_PASSWORD=app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email@gmail.com
MAIL_FROM_NAME="BagiResep"
```

---

## API Endpoint

### Auth
| Method | Endpoint | Rate Limit |
|---|---|---|
| POST | `/api/auth/register` | 6/min |
| POST | `/api/auth/login` | 6/min |
| POST | `/api/auth/logout` | Sanctum |
| GET | `/api/auth/me` | Sanctum |

### Recipes
| Method | Endpoint | Auth |
|---|---|---|
| GET | `/api/recipes` | Public |
| GET | `/api/recipes/{id}` | Public |
| POST | `/api/recipes` | Sanctum (10/min) |
| PUT | `/api/recipes/{id}` | Sanctum (10/min) |
| DELETE | `/api/recipes/{id}` | Sanctum |

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
| POST/PUT/DELETE | `/api/categories` | Admin |
| GET | `/api/ingredients?search=` | Public |

---

## Commands

```bash
# Translate semua resep ke English (Google Translate)
php artisan recipes:translate

# Force re-translate semua resep
php artisan recipes:translate --force

# Seed resep premium Gempur Budi Anarki
php artisan db:seed --class=GempurRecipesSeeder --force

# Seed resep asli Indonesia
php artisan db:seed --class=RealRecipesSeeder --force

# Seed demo data
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
# Tests: 30 passed (68 assertions)
```

---

## Domain

**[bagiresep.fun](https://bagiresep.fun)** — Hostinger shared hosting, Nginx, PHP 8.1, MySQL 8.0, SSL.

---

<p align="center">
  <br>
  <sub>Dibangun oleh</sub>
  <br>
  <strong>Gempur Budi Anarki</strong>
  <br>
  <sub>Senior Software Engineer & Web Developer</sub>
  <br>
  <br>
  <sub>&copy; 2026 BagiResep. All rights reserved.</sub>
</p>
