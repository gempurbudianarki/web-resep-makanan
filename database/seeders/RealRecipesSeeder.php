<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodRecipe;
use App\Models\DrinkRecipe;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class RealRecipesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Membuat resep asli Indonesia...');

        $superadmin = User::firstOrCreate(
            ['email' => 'admin@resepkita.test'],
            ['name' => 'Admin Utama', 'password' => 'password']
        );
        if (!$superadmin->hasRole('superadmin')) {
            $superadmin->assignRole('superadmin');
        }

        $chefNames = ['Bunda Ratna', 'Chef Anton', 'Mama Sari', 'Koki Rendra', 'Dapur Maya', 'Bunda Devi'];
        $chefs = [];
        foreach ($chefNames as $i => $name) {
            $chef = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $name)) . '@dapur.test'],
                ['name' => $name, 'password' => 'password']
            );
            if (!$chef->hasRole('user')) $chef->assignRole('user');
            $chefs[] = $chef;
        }

        $categories = Category::all()->keyBy('slug');
        $ingredientNames = $this->ingredients();
        $ingredients = [];
        foreach ($ingredientNames as $nameId => $nameEn) {
            $ingredients[$nameId] = Ingredient::firstOrCreate(
                ['name' => $nameId],
                ['name_en' => $nameEn]
            );
        }

        $recipes = $this->recipeData();

        foreach ($recipes as $data) {
            $chef = $chefs[array_rand($chefs)];
            $food = FoodRecipe::create([
                'cooking_time' => $data['cooking_time'],
                'serving_size' => $data['serving_size'],
                'calories' => $data['calories'],
            ]);

            $recipe = Recipe::create([
                'user_id' => $chef->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'steps' => $data['steps'],
                'status' => 'published',
                'avg_rating' => 0,
            ]);
            $recipe->recipeable()->associate($food)->save();

            $catSlugs = $data['categories'];
            $catIds = [];
            foreach ($catSlugs as $slug) {
                if (isset($categories[$slug])) {
                    $catIds[] = $categories[$slug]->id;
                }
            }
            if (!empty($catIds)) {
                $recipe->categories()->sync($catIds);
            }

            $pivotData = [];
            foreach ($data['ingredients'] as $ing) {
                $ingName = $ing[0];
                $amount = $ing[1];
                $unit = $ing[2];
                if (isset($ingredients[$ingName])) {
                    $pivotData[$ingredients[$ingName]->id] = [
                        'amount' => $amount,
                        'unit' => $unit,
                    ];
                }
            }
            if (!empty($pivotData)) {
                $recipe->ingredients()->sync($pivotData);
            }

            Review::create([
                'user_id' => $chefs[array_rand($chefs)]->id,
                'recipe_id' => $recipe->id,
                'rating' => rand(4, 5),
                'comment' => $data['sample_review'],
            ]);

            app(\App\Services\RatingService::class)->recalculateAvgRating($recipe);

            $this->command->info("  ✓ {$data['title']}");
        }

        $this->command->info('Semua resep berhasil dibuat!');
        $this->command->info('Login: admin@resepkita.test / password');
    }

    private function ingredients(): array
    {
        return [
            'Bawang Putih' => 'Garlic',
            'Bawang Merah' => 'Shallots',
            'Cabai Merah' => 'Red Chili',
            'Cabai Rawit' => 'Bird\'s Eye Chili',
            'Kunyit' => 'Turmeric',
            'Jahe' => 'Ginger',
            'Lengkuas' => 'Galangal',
            'Serai' => 'Lemongrass',
            'Daun Salam' => 'Bay Leaves',
            'Daun Jeruk' => 'Kaffir Lime Leaves',
            'Ketumbar' => 'Coriander',
            'Merica Bubuk' => 'Ground Pepper',
            'Garam' => 'Salt',
            'Gula Pasir' => 'Sugar',
            'Gula Merah' => 'Palm Sugar',
            'Kecap Manis' => 'Sweet Soy Sauce',
            'Kecap Asin' => 'Soy Sauce',
            'Saus Tiram' => 'Oyster Sauce',
            'Terasi' => 'Shrimp Paste',
            'Santan' => 'Coconut Milk',
            'Minyak Goreng' => 'Cooking Oil',
            'Air' => 'Water',
            'Nasi Putih' => 'White Rice',
            'Beras' => 'Rice',
            'Tepung Terigu' => 'Wheat Flour',
            'Tepung Beras' => 'Rice Flour',
            'Telur Ayam' => 'Chicken Eggs',
            'Daging Ayam' => 'Chicken Meat',
            'Daging Sapi' => 'Beef',
            'Ikan' => 'Fish',
            'Udang' => 'Shrimp',
            'Cumi' => 'Squid',
            'Tahu' => 'Tofu',
            'Tempe' => 'Tempeh',
            'Tauge' => 'Bean Sprouts',
            'Kol' => 'Cabbage',
            'Wortel' => 'Carrots',
            'Kentang' => 'Potatoes',
            'Tomat' => 'Tomatoes',
            'Timun' => 'Cucumber',
            'Kemangi' => 'Basil',
            'Daun Bawang' => 'Green Onions',
            'Daun Seledri' => 'Celery Leaves',
            'Jeruk Nipis' => 'Lime',
            'Jeruk Limau' => 'Kaffir Lime',
            'Kacang Tanah' => 'Peanuts',
            'Kelapa Parut' => 'Grated Coconut',
            'Bawang Goreng' => 'Fried Shallots',
            'Cengkeh' => 'Cloves',
            'Kayu Manis' => 'Cinnamon',
            'Pala' => 'Nutmeg',
            'Jinten' => 'Cumin',
            'Asam Jawa' => 'Tamarind',
            'Kluwek' => 'Kluwek Nut',
            'Ebi' => 'Dried Shrimp',
            'Petai' => 'Stink Beans',
            'Jengkol' => 'Jengkol',
            'Nangka Muda' => 'Young Jackfruit',
            'Daun Singkong' => 'Cassava Leaves',
            'Pete Cina' => 'Chinese Petai',
            'Mentega' => 'Butter',
            'Susu' => 'Milk',
            'Keju' => 'Cheese',
            'Coklat Bubuk' => 'Cocoa Powder',
            'Vanili' => 'Vanilla',
            'Es Batu' => 'Ice Cubes',
            'Gula Aren' => 'Palm Sugar',
            'Daun Pandan' => 'Pandan Leaves',
            'Daun Pisang' => 'Banana Leaves',
            'Tusuk Sate' => 'Skewers',
            'Margarin' => 'Margarine',
            'Tepung Maizena' => 'Cornstarch',
            'Baking Powder' => 'Baking Powder',
            'Ragi Instan' => 'Instant Yeast',
            'Madu' => 'Honey',
            'Kacang Merah' => 'Red Beans',
            'Kacang Hijau' => 'Mung Beans',
            'Buncis' => 'Green Beans',
            'Jagung Manis' => 'Sweet Corn',
            'Labu Siam' => 'Chayote',
        ];
    }

    private function recipeData(): array
    {
        return [
            [
                'title' => 'Rendang Daging Sapi Padang',
                'description' => 'Rendang autentik khas Minangkabau dengan bumbu rempah pilihan yang dimasak perlahan hingga kering dan berwarna hitam pekat. Daging sapi yang empuk meresap sempurna dengan santan kental dan aneka rempah, menghasilkan cita rasa gurih, pedas, dan kaya.',
                'cooking_time' => 180, 'serving_size' => 6, 'calories' => 450,
                'categories' => ['makanan-tradisional', 'masakan-rumahan'],
                'ingredients' => [
                    ['Daging Sapi', 1, 'kg'], ['Santan', 1000, 'ml'], ['Bawang Merah', 15, 'butir'],
                    ['Bawang Putih', 10, 'siung'], ['Cabai Merah', 10, 'buah'], ['Cabai Rawit', 5, 'buah'],
                    ['Kunyit', 3, 'cm'], ['Jahe', 3, 'cm'], ['Lengkuas', 4, 'cm'],
                    ['Serai', 3, 'batang'], ['Daun Salam', 4, 'lembar'], ['Daun Jeruk', 3, 'lembar'],
                    ['Ketumbar', 1, 'sdm'], ['Merica Bubuk', 1, 'sdt'], ['Garam', 2, 'sdt'],
                    ['Gula Merah', 50, 'gram'], ['Kelapa Parut', 100, 'gram'], ['Minyak Goreng', 3, 'sdm'],
                ],
                'steps' => [
                    'Haluskan bawang merah, bawang putih, cabai merah, cabai rawit, kunyit, jahe, lengkuas, dan ketumbar menggunakan blender atau ulekan hingga menjadi pasta halus.',
                    'Panaskan minyak goreng dalam wajan besar. Tumis bumbu halus bersama serai yang dimemarkan, daun salam, dan daun jeruk hingga harum dan matang, sekitar 8-10 menit.',
                    'Masukkan daging sapi yang sudah dipotong sesuai selera (ukuran 4x4 cm). Aduk rata hingga daging berubah warna dan tercampur bumbu.',
                    'Tuang santan ke dalam wajan, aduk perlahan. Tambahkan garam, merica bubuk, dan gula merah yang sudah disisir. Masak dengan api sedang.',
                    'Sambil sesekali diaduk, masak rendang hingga santan menyusut dan mengeluarkan minyak. Proses ini memakan waktu sekitar 1.5-2 jam.',
                    'Masukkan kelapa parut yang sudah disangrai (disebut kelapa gongseng atau ambu-ambu). Ini kunci rendang kering yang autentik.',
                    'Kecilkan api dan lanjutkan memasak hingga rendang berubah warna menjadi coklat kehitaman dan bumbu benar-benar kering meresap. Total waktu memasak 2.5-3 jam.',
                    'Angkat dan sajikan rendang dengan nasi putih hangat. Rendang semakin enak jika didiamkan semalaman.',
                ],
                'sample_review' => 'Ini resep rendang terbaik! Dagingnya empuk banget dan bumbunya meresap sempurna. Persis seperti rendang asli Padang. Wajib coba!',
            ],
            [
                'title' => 'Nasi Goreng Kampung Spesial',
                'description' => 'Nasi goreng rumahan khas Indonesia dengan bumbu sederhana namun kaya rasa. Menggunakan nasi putih yang digoreng dengan kecap manis, bawang, dan cabai, menghasilkan perpaduan rasa gurih, manis, dan sedikit pedas. Dilengkapi telur mata sapi dan kerupuk.',
                'cooking_time' => 20, 'serving_size' => 2, 'calories' => 380,
                'categories' => ['masakan-rumahan', 'sarapan'],
                'ingredients' => [
                    ['Nasi Putih', 2, 'piring'], ['Telur Ayam', 2, 'butir'], ['Bawang Merah', 5, 'butir'],
                    ['Bawang Putih', 3, 'siung'], ['Cabai Rawit', 3, 'buah'], ['Kecap Manis', 3, 'sdm'],
                    ['Kecap Asin', 1, 'sdm'], ['Garam', 1, 'sdt'], ['Merica Bubuk', 0.5, 'sdt'],
                    ['Minyak Goreng', 3, 'sdm'], ['Daun Bawang', 2, 'batang'], ['Bawang Goreng', 2, 'sdm'],
                    ['Timun', 1, 'buah'], ['Tomat', 1, 'buah'],
                ],
                'steps' => [
                    'Haluskan bawang merah, bawang putih, dan cabai rawit. Iris tipis daun bawang.',
                    'Panaskan minyak goreng di wajan dengan api besar. Tumis bumbu halus hingga harum dan berwarna keemasan.',
                    'Masukkan telur, orak-arik di sisi wajan hingga matang, lalu campur dengan bumbu tumis.',
                    'Masukkan nasi putih, aduk rata dengan bumbu dan telur. Gunakan api besar agar nasi goreng beraroma smokey.',
                    'Tambahkan kecap manis, kecap asin, garam, dan merica. Aduk terus hingga semua bumbu tercampur merata dan nasi berwarna coklat mengkilap.',
                    'Masukkan daun bawang iris, aduk sebentar hingga layu. Matikan api.',
                    'Sajikan nasi goreng di piring, taburi bawang goreng. Tambahkan telur mata sapi, irisan timun, dan tomat. Lengkapi dengan kerupuk.',
                ],
                'sample_review' => 'Nasi gorengnya simpel tapi enak banget! Wanginya khas nasi goreng kaki lima. Bikin nagih, apalagi pakai kerupuk.',
            ],
            [
                'title' => 'Gado-Gado Betawi Komplit',
                'description' => 'Gado-gado khas Betawi dengan bumbu kacang kental yang gurih dan sedikit pedas. Perpaduan sayuran segar rebus, tahu, tempe, telur, dan lontong disiram saus kacang homemade. Hidangan sehat dan mengenyangkan.',
                'cooking_time' => 45, 'serving_size' => 4, 'calories' => 320,
                'categories' => ['makanan-tradisional', 'masakan-rumahan'],
                'ingredients' => [
                    ['Tahu', 4, 'buah'], ['Tempe', 200, 'gram'], ['Telur Ayam', 3, 'butir'],
                    ['Tauge', 150, 'gram'], ['Kol', 150, 'gram'], ['Wortel', 2, 'buah'],
                    ['Kentang', 2, 'buah'], ['Timun', 2, 'buah'], ['Daun Seledri', 2, 'batang'],
                    ['Kacang Tanah', 250, 'gram'], ['Bawang Putih', 4, 'siung'], ['Cabai Merah', 3, 'buah'],
                    ['Gula Merah', 50, 'gram'], ['Asam Jawa', 1, 'sdt'], ['Garam', 1.5, 'sdt'],
                    ['Air', 300, 'ml'], ['Jeruk Nipis', 1, 'buah'], ['Minyak Goreng', 5, 'sdm'],
                    ['Bawang Goreng', 3, 'sdm'],
                ],
                'steps' => [
                    'Rebus telur hingga matang (10 menit), kupas dan belah dua. Rebus kentang hingga empuk, kupas dan potong-potong.',
                    'Potong tahu dan tempe, goreng dalam minyak panas hingga kecoklatan. Angkat dan tiriskan.',
                    'Rebus tauge sebentar (30 detik), tiriskan. Iris tipis kol, rebus sebentar. Iris wortel dan timun sesuai selera.',
                    'Untuk bumbu kacang: goreng kacang tanah hingga kecoklatan, tiriskan. Goreng bawang putih dan cabai merah sebentar.',
                    'Haluskan kacang tanah goreng, bawang putih, cabai merah, gula merah, garam, dan asam jawa menggunakan blender. Tambahkan air sedikit demi sedikit hingga kekentalan yang diinginkan.',
                    'Masak bumbu kacang dengan api kecil hingga mendidih dan mengental, sekitar 10 menit. Aduk terus agar tidak gosong. Beri perasan jeruk nipis.',
                    'Tata semua sayuran, tahu, tempe, telur, dan kentang di piring. Siram dengan bumbu kacang hangat.',
                    'Taburi bawang goreng dan daun seledri. Sajikan segera dengan lontong atau nasi putih hangat.',
                ],
                'sample_review' => 'Bumbu kacangnya juara! Kental, gurih, dan nagih banget. Porsinya lengkap dengan aneka sayuran. Sehat dan enak!',
            ],
            [
                'title' => 'Sate Ayam Bumbu Kacang',
                'description' => 'Sate ayam empuk dengan bumbu kacang khas Madura yang legit dan gurih. Daging ayam yang dimarinasi dengan kecap dan rempah, dibakar di atas arang hingga harum, disajikan dengan lontong dan sambal kecap.',
                'cooking_time' => 60, 'serving_size' => 4, 'calories' => 350,
                'categories' => ['makanan-tradisional', 'makanan-cepat-saji'],
                'ingredients' => [
                    ['Daging Ayam', 500, 'gram'], ['Kecap Manis', 5, 'sdm'], ['Bawang Putih', 4, 'siung'],
                    ['Bawang Merah', 6, 'butir'], ['Ketumbar', 1, 'sdm'], ['Jeruk Nipis', 1, 'buah'],
                    ['Minyak Goreng', 3, 'sdm'], ['Garam', 1, 'sdt'], ['Kacang Tanah', 200, 'gram'],
                    ['Cabai Rawit', 5, 'buah'], ['Gula Merah', 30, 'gram'], ['Air', 200, 'ml'],
                    ['Tusuk Sate', 20, 'batang'],
                ],
                'steps' => [
                    'Potong daging ayam menjadi dadu kecil sekitar 2x2 cm. Cuci bersih dan tiriskan.',
                    'Haluskan bawang putih, bawang merah, ketumbar, dan garam. Campurkan ke dalam potongan ayam bersama 3 sdm kecap manis dan perasan jeruk nipis. Marinasi minimal 30 menit.',
                    'Rendam tusuk sate dalam air agar tidak mudah terbakar. Tusukkan 4-5 potong ayam ke setiap tusuk sate.',
                    'Untuk bumbu kacang: goreng kacang tanah, haluskan bersama cabai rawit. Masak dengan air, 2 sdm kecap manis, dan gula merah hingga mengental.',
                    'Bakar sate di atas bara api atau grill pan sambil sesekali diolesi campuran kecap dan minyak. Bolak-balik hingga matang merata (sekitar 15 menit).',
                    'Sajikan sate dengan bumbu kacang hangat, lontong, dan sambal kecap. Taburi bawang goreng untuk aroma lebih nikmat.',
                ],
                'sample_review' => 'Satenya empuk dan juicy! Bumbu kacangnya pas banget, nggak terlalu manis. Bikin kangen sate Madura asli.',
            ],
            [
                'title' => 'Sop Buntut Sapi',
                'description' => 'Sop buntut sapi bening dengan kaldu gurih alami yang dimasak perlahan selama berjam-jam. Daging buntut yang empuk lepas dari tulang berpadu dengan wortel, kentang, dan taburan daun bawang seledri. Hangat dan menyegarkan.',
                'cooking_time' => 150, 'serving_size' => 5, 'calories' => 280,
                'categories' => ['masakan-rumahan', 'makanan-tradisional'],
                'ingredients' => [
                    ['Daging Sapi', 1, 'kg'], ['Wortel', 3, 'buah'], ['Kentang', 3, 'buah'],
                    ['Bawang Putih', 5, 'siung'], ['Bawang Merah', 4, 'butir'], ['Merica Bubuk', 1, 'sdt'],
                    ['Pala', 0.5, 'sdt'], ['Cengkeh', 3, 'butir'], ['Kayu Manis', 2, 'cm'],
                    ['Daun Bawang', 3, 'batang'], ['Daun Seledri', 2, 'batang'], ['Garam', 2, 'sdt'],
                    ['Air', 2500, 'ml'], ['Jeruk Nipis', 2, 'buah'], ['Bawang Goreng', 3, 'sdm'],
                    ['Tomat', 2, 'buah'],
                ],
                'steps' => [
                    'Cuci bersih buntut sapi. Rebus dalam air mendidih selama 10 menit untuk menghilangkan kotoran. Buang air rebusan pertama.',
                    'Didihkan 2.5 liter air bersih. Masukkan buntut sapi, cengkeh, dan kayu manis. Masak dengan api kecil selama 1.5-2 jam hingga daging empuk dan kaldu keluar.',
                    'Haluskan bawang putih, bawang merah, merica, dan pala. Tumis dengan sedikit minyak hingga harum.',
                    'Masukkan bumbu tumis ke dalam rebusan buntut. Tambahkan garam. Aduk rata.',
                    'Potong wortel dan kentang ukuran besar. Masukkan ke dalam sop. Masak hingga sayuran empuk (sekitar 20 menit).',
                    'Koreksi rasa. Tambahkan irisan tomat, daun bawang, dan seledri sesaat sebelum mematikan api.',
                    'Sajikan sop buntut hangat dalam mangkuk. Taburi bawang goreng. Beri perasan jeruk nipis. Nikmati dengan nasi putih dan sambal.',
                ],
                'sample_review' => 'Kaldunya bening tapi gurih banget! Daging buntutnya super empuk. Pas banget dimakan pas hujan. Comfort food terbaik!',
            ],
            [
                'title' => 'Sambal Matah Bali',
                'description' => 'Sambal matah autentik khas Bali yang segar dan pedas. Irisan bawang merah, serai, cabai, dan daun jeruk yang disiram minyak kelapa panas, menciptakan aroma yang menggugah selera. Cocok untuk pendamping ayam goreng atau ikan bakar.',
                'cooking_time' => 15, 'serving_size' => 4, 'calories' => 80,
                'categories' => ['masakan-tradisional', 'makanan-cepat-saji'],
                'ingredients' => [
                    ['Bawang Merah', 10, 'butir'], ['Cabai Rawit', 8, 'buah'], ['Serai', 3, 'batang'],
                    ['Daun Jeruk', 5, 'lembar'], ['Jeruk Limau', 2, 'buah'], ['Terasi', 1, 'sdt'],
                    ['Garam', 1, 'sdt'], ['Minyak Goreng', 4, 'sdm'], ['Ebi', 1, 'sdm'],
                ],
                'steps' => [
                    'Iris tipis bawang merah, cabai rawit, dan serai (ambil bagian putihnya saja). Buang tulang daun jeruk, iris setipis mungkin.',
                    'Sangrai terasi sebentar hingga harum, lalu haluskan. Sangrai ebi kering, tumbuk kasar.',
                    'Campurkan semua irisan bawang, cabai, serai, daun jeruk, terasi, ebi, dan garam dalam mangkuk tahan panas.',
                    'Panaskan minyak goreng dalam wajan hingga benar-benar panas (hampir berasap).',
                    'Siram minyak panas ke dalam campuran sambal. Aduk cepat hingga semua bahan layu dan mengeluarkan aroma.',
                    'Beri perasan jeruk limau. Aduk rata. Sambal matah siap disajikan sebagai pendamping.',
                ],
                'sample_review' => 'Sambal matahnya segar banget! Cocok buat ayam goreng. Pedesnya nampol tapi ada seger dari jeruk limau. Wajib ada di meja makan!',
            ],
        ];
    }
}
