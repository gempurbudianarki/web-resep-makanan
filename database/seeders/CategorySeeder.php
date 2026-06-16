<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Masakan Rumahan' => 'Home Cooking',
            'Kue & Roti' => 'Cakes & Breads',
            'Minuman' => 'Beverages',
            'Makanan Cepat Saji' => 'Fast Food',
            'Makanan Tradisional' => 'Traditional Food',
            'Dessert' => 'Desserts',
            'Sarapan' => 'Breakfast',
            'Cemilan' => 'Snacks',
            'Makanan Sehat' => 'Healthy Food',
            'Sup & Soto' => 'Soups & Stews',
            'Sambal & Saos' => 'Sambal & Sauces',
            'Lauk Pauk' => 'Side Dishes',
            'Sayur & Tumis' => 'Vegetables & Stir Fry',
            'Nasi & Mie' => 'Rice & Noodles',
            'Gorengan' => 'Fried Foods',
            'Bakar & Panggang' => 'Grilled & Roasted',
            'Kukus & Rebus' => 'Steamed & Boiled',
            'Jajanan Pasar' => 'Market Snacks',
            'Minuman Segar' => 'Fresh Drinks',
            'Minuman Hangat' => 'Hot Drinks',
            'Diet & Rendah Kalori' => 'Diet & Low Calorie',
            'Vegetarian' => 'Vegetarian',
            'Seafood' => 'Seafood',
            'Daging & Ayam' => 'Meat & Chicken',
        ];

        foreach ($categories as $nameId => $nameEn) {
            Category::updateOrCreate(
                ['name' => $nameId],
                ['name_en' => $nameEn]
            );
        }
    }
}
