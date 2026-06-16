<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodRecipe;
use App\Models\DrinkRecipe;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Database\Seeder;

class GempurRecipesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔥 Membuat resep premium Gempur Budi Anarki...');

        $user = User::where('email', 'gempurbudianarki@gmail.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Gempur Budi Anarki',
                'email' => 'gempurbudianarki@gmail.com',
                'password' => 'password',
            ]);
            $user->assignRole('user');
        }

        $translator = app(TranslationService::class);
        $categories = Category::all()->keyBy('name');

        $recipes = $this->premiumRecipes();

        foreach ($recipes as $data) {
            $food = FoodRecipe::create([
                'cooking_time' => $data['cooking_time'],
                'serving_size' => $data['serving_size'],
                'calories' => $data['calories'],
            ]);

            $titleEn = $translator->translateToEnglish($data['title']) ?? $data['title'];
            $descEn = $translator->translateToEnglish($data['description']) ?? $data['description'];

            $recipe = Recipe::create([
                'user_id' => $user->id,
                'title' => $data['title'],
                'title_en' => $titleEn,
                'description' => $data['description'],
                'description_en' => $descEn,
                'steps' => $data['steps'],
                'status' => 'published',
                'avg_rating' => 0,
            ]);
            $recipe->recipeable()->associate($food)->save();

            $catIds = [];
            foreach ($data['categories'] as $catName) {
                if (isset($categories[$catName])) {
                    $catIds[] = $categories[$catName]->id;
                }
            }
            if (!empty($catIds)) {
                $recipe->categories()->sync($catIds);
            }

            $pivotData = [];
            foreach ($data['ingredients'] as $ing) {
                $ingredient = Ingredient::firstOrCreate(
                    ['name' => $ing['name']],
                    ['name_en' => $ing['name_en'] ?? null]
                );
                $pivotData[$ingredient->id] = [
                    'amount' => $ing['amount'],
                    'unit' => $ing['unit'],
                ];
            }
            if (!empty($pivotData)) {
                $recipe->ingredients()->sync($pivotData);
            }

            $this->command->info("  ✅ {$data['title']}");
            usleep(300000);
        }

        $this->command->info('✨ Semua resep premium berhasil dibuat!');
        $this->command->info('👤 Pemilik: Gempur Budi Anarki (gempurbudianarki@gmail.com)');
    }

    private function premiumRecipes(): array
    {
        return [
            [
                'title' => 'Ayam Betutu Khas Gilimanuk',
                'description' => 'Ayam Betutu adalah hidangan ikonik dari Bali yang dimasak dengan bumbu rempah lengkap selama berjam-jam hingga dagingnya empuk dan bumbu meresap sempurna. Disajikan dengan sambal matah, plecing kangkung, dan nasi putih hangat - kombinasi rasa pedas, gurih, dan aromatik yang tak tertandingi.',
                'cooking_time' => 120, 'serving_size' => 5, 'calories' => 420,
                'categories' => ['Makanan Tradisional', 'Daging & Ayam'],
                'ingredients' => [
                    ['name' => 'Ayam Kampung Utuh', 'name_en' => 'Whole Free-Range Chicken', 'amount' => 1, 'unit' => 'ekor'],
                    ['name' => 'Bawang Merah', 'name_en' => 'Shallots', 'amount' => 15, 'unit' => 'butir'],
                    ['name' => 'Bawang Putih', 'name_en' => 'Garlic', 'amount' => 10, 'unit' => 'siung'],
                    ['name' => 'Cabai Merah', 'name_en' => 'Red Chili', 'amount' => 10, 'unit' => 'buah'],
                    ['name' => 'Cabai Rawit', 'name_en' => 'Bird\'s Eye Chili', 'amount' => 8, 'unit' => 'buah'],
                    ['name' => 'Kunyit', 'name_en' => 'Turmeric', 'amount' => 5, 'unit' => 'cm'],
                    ['name' => 'Jahe', 'name_en' => 'Ginger', 'amount' => 4, 'unit' => 'cm'],
                    ['name' => 'Lengkuas', 'name_en' => 'Galangal', 'amount' => 4, 'unit' => 'cm'],
                    ['name' => 'Serai', 'name_en' => 'Lemongrass', 'amount' => 4, 'unit' => 'batang'],
                    ['name' => 'Daun Jeruk', 'name_en' => 'Kaffir Lime Leaves', 'amount' => 5, 'unit' => 'lembar'],
                    ['name' => 'Daun Salam', 'name_en' => 'Bay Leaves', 'amount' => 3, 'unit' => 'lembar'],
                    ['name' => 'Terasi', 'name_en' => 'Shrimp Paste', 'amount' => 1, 'unit' => 'sdt'],
                    ['name' => 'Merica Bubuk', 'name_en' => 'Ground Pepper', 'amount' => 1, 'unit' => 'sdt'],
                    ['name' => 'Garam', 'name_en' => 'Salt', 'amount' => 2, 'unit' => 'sdt'],
                    ['name' => 'Minyak Goreng', 'name_en' => 'Cooking Oil', 'amount' => 3, 'unit' => 'sdm'],
                ],
                'steps' => [
                    'Cuci bersih ayam kampung utuh, buang bagian jeroannya, tiriskan hingga kering.',
                    'Haluskan bawang merah, bawang putih, cabai merah, cabai rawit, kunyit, jahe, lengkuas, dan terasi menjadi pasta bumbu.',
                    'Panaskan minyak, tumis bumbu halus bersama serai geprek, daun salam, dan daun jeruk hingga harum dan matang sempurna (sekitar 10 menit).',
                    'Masukkan ayam utuh ke dalam wajan besar, lumuri seluruh permukaan ayam dengan bumbu tumis, termasuk ke dalam rongga ayam.',
                    'Tambahkan air secukupnya, garam, dan merica. Masak dengan api kecil selama 1.5-2 jam hingga ayam empuk dan bumbu meresap.',
                    'Bolak-balik ayam setiap 30 menit agar bumbu merata. Jika air menyusut, tambahkan sedikit demi sedikit.',
                    'Setelah ayam empuk, angkat dan sajikan utuh di atas piring saji dengan taburan bawang goreng.',
                    'Sajikan bersama sambal matah, plecing kangkung, dan nasi putih hangat untuk pengalaman Bali autentik.',
                ],
            ],
            [
                'title' => 'Pempek Palembang Lenjer & Kapal Selam',
                'description' => 'Pempek asli Palembang dengan tekstur kenyal dan rasa ikan yang dominan. Resep ini mencakup dua varian: Lenjer (silinder panjang) dan Kapal Selam (dengan telur di dalamnya). Disajikan dengan kuah cuko asam pedas manis yang khas - kombinasi gula aren, asam jawa, cabai, dan bawang putih yang direbus sempurna.',
                'cooking_time' => 90, 'serving_size' => 6, 'calories' => 350,
                'categories' => ['Makanan Tradisional', 'Cemilan', 'Seafood'],
                'ingredients' => [
                    ['name' => 'Ikan Tenggiri Giling', 'name_en' => 'Ground Mackerel', 'amount' => 500, 'unit' => 'gram'],
                    ['name' => 'Tepung Terigu', 'name_en' => 'Wheat Flour', 'amount' => 200, 'unit' => 'gram'],
                    ['name' => 'Tepung Tapioka', 'name_en' => 'Tapioca Flour', 'amount' => 400, 'unit' => 'gram'],
                    ['name' => 'Air Es', 'name_en' => 'Ice Water', 'amount' => 250, 'unit' => 'ml'],
                    ['name' => 'Telur Ayam', 'name_en' => 'Chicken Eggs', 'amount' => 5, 'unit' => 'butir'],
                    ['name' => 'Garam', 'name_en' => 'Salt', 'amount' => 2, 'unit' => 'sdt'],
                    ['name' => 'Gula Pasir', 'name_en' => 'Sugar', 'amount' => 1, 'unit' => 'sdt'],
                    ['name' => 'Bawang Putih', 'name_en' => 'Garlic', 'amount' => 5, 'unit' => 'siung'],
                    ['name' => 'Cabai Rawit', 'name_en' => 'Bird\'s Eye Chili', 'amount' => 10, 'unit' => 'buah'],
                    ['name' => 'Gula Aren', 'name_en' => 'Palm Sugar', 'amount' => 200, 'unit' => 'gram'],
                    ['name' => 'Asam Jawa', 'name_en' => 'Tamarind', 'amount' => 50, 'unit' => 'gram'],
                    ['name' => 'Minyak Goreng', 'name_en' => 'Cooking Oil', 'amount' => 500, 'unit' => 'ml'],
                ],
                'steps' => [
                    'Campur ikan giling dengan air es sedikit demi sedikit sambil diaduk hingga tercampur rata dan terasa kenyal.',
                    'Tambahkan garam, gula, dan bawang putih halus. Aduk rata kembali.',
                    'Masukkan tepung terigu sedikit demi sedikit sambil diuleni, kemudian tambahkan tepung tapioka secara bertahap. Uleni hingga adonan kalis dan bisa dibentuk.',
                    'Taburi tangan dengan tepung tapioka agar tidak lengket. Ambil sejumput adonan, bentuk silinder panjang untuk Lenjer.',
                    'Untuk Kapal Selam: pipihkan adonan, letakkan 1 butir telur (atau setengah) di tengahnya, tutup dan bentuk oval hingga telur terbungkus rapat.',
                    'Didihkan air dalam panci besar, tambahkan sedikit minyak agar pempek tidak lengket. Rebus pempek hingga mengapung - tanda sudah matang.',
                    'Angkat pempek, tiriskan. Goreng dalam minyak panas hingga kulitnya berwarna keemasan dan renyah.',
                    'Untuk kuah Cuko: rebus gula aren, asam jawa, bawang putih halus, cabai rawit halus, dan air. Masak hingga mendidih dan sedikit mengental. Saring, dinginkan.',
                    'Sajikan pempek goreng dengan kuah cuko, irisan timun segar, dan mi kuning sebagai pelengkap.',
                ],
            ],
            [
                'title' => 'Es Cendol Dawet Nangka',
                'description' => 'Minuman tradisional Indonesia yang menyegarkan - perpaduan cendol kenyal dari tepung beras, santan gurih, gula merah cair, dan potongan nangka matang. Disajikan dingin dengan es batu, minuman ini adalah pelepas dahaga sempurna di siang hari. Tekstur kenyal cendol berpadu dengan manisnya gula aren dan aroma nangka yang harum.',
                'cooking_time' => 45, 'serving_size' => 4, 'calories' => 280,
                'categories' => ['Minuman', 'Minuman Segar', 'Dessert'],
                'ingredients' => [
                    ['name' => 'Tepung Beras', 'name_en' => 'Rice Flour', 'amount' => 150, 'unit' => 'gram'],
                    ['name' => 'Tepung Tapioka', 'name_en' => 'Tapioca Flour', 'amount' => 30, 'unit' => 'gram'],
                    ['name' => 'Air', 'name_en' => 'Water', 'amount' => 400, 'unit' => 'ml'],
                    ['name' => 'Daun Pandan', 'name_en' => 'Pandan Leaves', 'amount' => 3, 'unit' => 'lembar'],
                    ['name' => 'Garam', 'name_en' => 'Salt', 'amount' => 0.5, 'unit' => 'sdt'],
                    ['name' => 'Santan', 'name_en' => 'Coconut Milk', 'amount' => 500, 'unit' => 'ml'],
                    ['name' => 'Gula Aren', 'name_en' => 'Palm Sugar', 'amount' => 200, 'unit' => 'gram'],
                    ['name' => 'Nangka', 'name_en' => 'Jackfruit', 'amount' => 200, 'unit' => 'gram'],
                    ['name' => 'Es Batu', 'name_en' => 'Ice Cubes', 'amount' => 300, 'unit' => 'gram'],
                ],
                'steps' => [
                    'Blender daun pandan dengan 200ml air, saring untuk mendapatkan air pandan hijau alami.',
                    'Campur tepung beras, tepung tapioka, air pandan, garam, dan sisa air. Aduk rata hingga tidak ada gumpalan.',
                    'Masak adonan di atas api sedang sambil terus diaduk hingga mengental, berwarna transparan, dan meletup-letup. Angkat.',
                    'Siapkan baskom berisi air es. Tuang adonan panas ke dalam cetakan cendol atau saringan berlubang besar. Tekan hingga adonan keluar berbentuk butiran-butiran kecil yang jatuh ke air es.',
                    'Biarkan cendol dalam air es selama 15 menit agar kenyal dan set. Tiriskan.',
                    'Untuk kuah: rebus santan dengan sedikit garam dan 1 lembar daun pandan. Aduk terus agar santan tidak pecah. Setelah mendidih, angkat dan dinginkan.',
                    'Rebus gula aren dengan 100ml air hingga larut dan sedikit mengental. Saring, dinginkan.',
                    'Potong nangka matang menjadi dadu kecil.',
                    'Penyajian: masukkan cendol ke dalam gelas atau mangkuk, tambahkan es batu, siram dengan santan dan gula aren cair. Taburi potongan nangka di atasnya. Sajikan dingin.',
                ],
            ],
            [
                'title' => 'Mie Goreng Tek-Tek Jawa',
                'description' => 'Mie goreng khas pedagang kaki lima Jawa dengan bumbu sederhana namun kaya rasa. Dinamakan tek-tek karena suara khas pedagang yang memukul wajan. Perpaduan mie kuning, sayuran segar, telur, dan bumbu kecap menghasilkan aroma smokey yang menggoda selera. Disajikan dengan taburan bawang goreng, acar, dan kerupuk.',
                'cooking_time' => 25, 'serving_size' => 3, 'calories' => 400,
                'categories' => ['Makanan Cepat Saji', 'Nasi & Mie', 'Masakan Rumahan'],
                'ingredients' => [
                    ['name' => 'Mie Kuning Basah', 'name_en' => 'Fresh Yellow Noodles', 'amount' => 400, 'unit' => 'gram'],
                    ['name' => 'Telur Ayam', 'name_en' => 'Chicken Eggs', 'amount' => 2, 'unit' => 'butir'],
                    ['name' => 'Kol', 'name_en' => 'Cabbage', 'amount' => 150, 'unit' => 'gram'],
                    ['name' => 'Wortel', 'name_en' => 'Carrots', 'amount' => 1, 'unit' => 'buah'],
                    ['name' => 'Daun Bawang', 'name_en' => 'Green Onions', 'amount' => 2, 'unit' => 'batang'],
                    ['name' => 'Bawang Putih', 'name_en' => 'Garlic', 'amount' => 4, 'unit' => 'siung'],
                    ['name' => 'Bawang Merah', 'name_en' => 'Shallots', 'amount' => 4, 'unit' => 'butir'],
                    ['name' => 'Cabai Rawit', 'name_en' => 'Bird\'s Eye Chili', 'amount' => 5, 'unit' => 'buah'],
                    ['name' => 'Kecap Manis', 'name_en' => 'Sweet Soy Sauce', 'amount' => 3, 'unit' => 'sdm'],
                    ['name' => 'Kecap Asin', 'name_en' => 'Soy Sauce', 'amount' => 1, 'unit' => 'sdm'],
                    ['name' => 'Merica Bubuk', 'name_en' => 'Ground Pepper', 'amount' => 0.5, 'unit' => 'sdt'],
                    ['name' => 'Minyak Goreng', 'name_en' => 'Cooking Oil', 'amount' => 3, 'unit' => 'sdm'],
                ],
                'steps' => [
                    'Seduh mie kuning dengan air panas selama 2-3 menit, tiriskan. Aduk dengan sedikit minyak agar tidak lengket.',
                    'Haluskan bawang putih, bawang merah, dan cabai rawit. Iris tipis kol, wortel bentuk korek api, dan daun bawang.',
                    'Panaskan minyak dalam wajan besar dengan api besar - kunci mie goreng enak adalah api besar dan wajan panas.',
                    'Tumis bumbu halus hingga harum dan keemasan. Pinggirkan bumbu, masukkan telur, orak-arik hingga matang.',
                    'Masukkan wortel dan kol, tumis sebentar hingga layu setengah matang.',
                    'Masukkan mie, kecap manis, kecap asin, dan merica. Aduk cepat dengan api besar selama 2-3 menit hingga bumbu merata dan mie berwarna coklat mengkilap.',
                    'Gunakan dua spatula atau garpu untuk mengaduk agar mie tidak menggumpal dan bumbu tersebar sempurna.',
                    'Masukkan daun bawang iris, aduk sebentar. Matikan api.',
                    'Sajikan mie goreng dengan taburan bawang goreng, acar timun, irisan tomat, dan kerupuk. Tambahkan sambal dan kecap sebagai pelengkap.',
                ],
            ],
            [
                'title' => 'Pepes Ikan Mas Bumbu Kuning',
                'description' => 'Pepes ikan mas dengan bumbu kuning rempah yang dibungkus daun pisang dan dikukus hingga matang sempurna. Teknik memasak pepes mengunci semua rasa dan aroma rempah dalam bungkusan daun pisang, menghasilkan ikan yang lembut, harum, dan kaya rasa. Bumbu kuning dari kunyit, kemiri, dan rempah pilihan menciptakan cita rasa khas Sunda yang autentik.',
                'cooking_time' => 60, 'serving_size' => 4, 'calories' => 250,
                'categories' => ['Makanan Tradisional', 'Seafood', 'Kukus & Rebus'],
                'ingredients' => [
                    ['name' => 'Ikan Mas Segar', 'name_en' => 'Fresh Carp', 'amount' => 1, 'unit' => 'ekor'],
                    ['name' => 'Daun Pisang', 'name_en' => 'Banana Leaves', 'amount' => 4, 'unit' => 'lembar'],
                    ['name' => 'Bawang Merah', 'name_en' => 'Shallots', 'amount' => 8, 'unit' => 'butir'],
                    ['name' => 'Bawang Putih', 'name_en' => 'Garlic', 'amount' => 5, 'unit' => 'siung'],
                    ['name' => 'Kuning', 'name_en' => 'Turmeric', 'amount' => 3, 'unit' => 'cm'],
                    ['name' => 'Jahe', 'name_en' => 'Ginger', 'amount' => 2, 'unit' => 'cm'],
                    ['name' => 'Lengkuas', 'name_en' => 'Galangal', 'amount' => 2, 'unit' => 'cm'],
                    ['name' => 'Serai', 'name_en' => 'Lemongrass', 'amount' => 2, 'unit' => 'batang'],
                    ['name' => 'Daun Jeruk', 'name_en' => 'Kaffir Lime Leaves', 'amount' => 3, 'unit' => 'lembar'],
                    ['name' => 'Daun Salam', 'name_en' => 'Bay Leaves', 'amount' => 2, 'unit' => 'lembar'],
                    ['name' => 'Kemangi', 'name_en' => 'Basil', 'amount' => 1, 'unit' => 'ikat'],
                    ['name' => 'Tomat', 'name_en' => 'Tomatoes', 'amount' => 1, 'unit' => 'buah'],
                    ['name' => 'Garam', 'name_en' => 'Salt', 'amount' => 1.5, 'unit' => 'sdt'],
                    ['name' => 'Gula Pasir', 'name_en' => 'Sugar', 'amount' => 0.5, 'unit' => 'sdt'],
                ],
                'steps' => [
                    'Bersihkan ikan mas, buang sisik dan isi perutnya. Cuci bersih, lumuri dengan air jeruk nipis dan garam. Diamkan 15 menit, bilas.',
                    'Haluskan bawang merah, bawang putih, kunyit, jahe, lengkuas, garam, dan gula menjadi pasta bumbu kuning.',
                    'Layukan daun pisang di atas api kompor agar lemas dan mudah dibentuk. Bersihkan dengan lap basah.',
                    'Ambil selembar daun pisang, letakkan sebagian bumbu kuning di tengahnya. Taruh ikan di atas bumbu.',
                    'Lumuri ikan dengan sisa bumbu kuning secara merata, termasuk di dalam perut ikan.',
                    'Tambahkan serai geprek, daun jeruk, daun salam, irisan tomat, dan daun kemangi di atas dan di dalam perut ikan.',
                    'Bungkus ikan dengan daun pisang rapat-rapat seperti amplop. Sematkan lidi di kedua ujungnya agar tidak terbuka.',
                    'Kukus pepes selama 40-45 menit dengan api sedang hingga matang. Daun pisang akan berubah warna menjadi kecoklatan.',
                    'Untuk aroma smokey, panggang pepes di atas bara api atau teflon sebentar sebelum disajikan.',
                    'Buka bungkusan pepes di atas piring saji. Nikmati dengan nasi putih hangat dan sambal terasi.',
                ],
            ],
            [
                'title' => 'Dadar Gulung Pandan Isi Kelapa',
                'description' => 'Dadar gulung klasik Indonesia dengan kulit hijau dari pasta pandan alami dan isian kelapa parut yang dimasak dengan gula merah hingga legit. Tekstur kulit yang tipis dan lembut membungkus isian kelapa manis yang gurih. Disajikan sebagai camilan sore atau hidangan penutup yang selalu dirindukan. Aroma pandan dan gula merah berpadu sempurna.',
                'cooking_time' => 60, 'serving_size' => 8, 'calories' => 180,
                'categories' => ['Kue & Roti', 'Jajanan Pasar', 'Dessert'],
                'ingredients' => [
                    ['name' => 'Tepung Terigu', 'name_en' => 'Wheat Flour', 'amount' => 200, 'unit' => 'gram'],
                    ['name' => 'Telur Ayam', 'name_en' => 'Chicken Eggs', 'amount' => 2, 'unit' => 'butir'],
                    ['name' => 'Santan', 'name_en' => 'Coconut Milk', 'amount' => 350, 'unit' => 'ml'],
                    ['name' => 'Daun Pandan', 'name_en' => 'Pandan Leaves', 'amount' => 5, 'unit' => 'lembar'],
                    ['name' => 'Garam', 'name_en' => 'Salt', 'amount' => 0.25, 'unit' => 'sdt'],
                    ['name' => 'Minyak Goreng', 'name_en' => 'Cooking Oil', 'amount' => 2, 'unit' => 'sdm'],
                    ['name' => 'Kelapa Parut', 'name_en' => 'Grated Coconut', 'amount' => 250, 'unit' => 'gram'],
                    ['name' => 'Gula Merah', 'name_en' => 'Palm Sugar', 'amount' => 150, 'unit' => 'gram'],
                    ['name' => 'Gula Pasir', 'name_en' => 'Sugar', 'amount' => 2, 'unit' => 'sdm'],
                    ['name' => 'Kayu Manis', 'name_en' => 'Cinnamon', 'amount' => 2, 'unit' => 'cm'],
                    ['name' => 'Air', 'name_en' => 'Water', 'amount' => 50, 'unit' => 'ml'],
                ],
                'steps' => [
                    'Blender daun pandan dengan 100ml santan hingga halus. Saring untuk mendapatkan sari pandan kental berwarna hijau alami.',
                    'Campur tepung terigu, telur, garam, sisa santan, dan sari pandan. Aduk dengan whisk hingga halus dan tidak bergumpal. Saring adonan.',
                    'Diamkan adonan kulit 20 menit agar gluten rileks - hasilnya kulit lebih lentur.',
                    'Untuk isian: rebus gula merah dan gula pasir dengan air hingga larut. Saring.',
                    'Masak kelapa parut dengan larutan gula merah, kayu manis, dan sedikit garam. Aduk terus dengan api kecil hingga air menyusut dan kelapa terasa legit (sekitar 15-20 menit). Angkat, buang kayu manis.',
                    'Panaskan wajan datar anti lengket diameter 20cm. Olesi tipis dengan minyak. Tuang satu sendok sayur adonan, ratakan dengan gerakan memutar wajan.',
                    'Masak dengan api kecil hingga permukaan kulit kering dan pinggiran terlepas. Angkat, letakkan di atas piring. Ulangi hingga adonan habis.',
                    'Ambil selembar kulit, letakkan 1-2 sdm isian kelapa di salah satu sisi. Lipat sisi kanan dan kiri, gulung rapi seperti amplop.',
                    'Ulangi untuk semua kulit. Dadar gulung siap disajikan. Simpan di kulkas agar lebih nikmat saat dingin.',
                ],
            ],
        ];
    }
}
