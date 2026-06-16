<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $xml .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>' . "\n";
        $xml .= '<url><loc>' . route('recipes.index') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>' . "\n";
        $xml .= '<url><loc>' . route('privacy') . '</loc><changefreq>monthly</changefreq><priority>0.3</priority></url>' . "\n";
        $xml .= '<url><loc>' . route('terms') . '</loc><changefreq>monthly</changefreq><priority>0.3</priority></url>' . "\n";

        $recipes = Recipe::where('status', 'published')->latest()->get();
        foreach ($recipes as $recipe) {
            $xml .= '<url><loc>' . route('recipes.show', $recipe) . '</loc><lastmod>' . $recipe->updated_at->toDateString() . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>' . "\n";
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            $xml .= '<url><loc>' . route('recipes.index', ['category_id' => $category->id]) . '</loc><changefreq>weekly</changefreq><priority>0.5</priority></url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
