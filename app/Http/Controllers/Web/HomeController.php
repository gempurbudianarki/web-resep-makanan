<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Recipe;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $userId = auth()->id();
            $user = auth()->user();

            $myRecipes = Recipe::with(['recipeable'])
                ->where('user_id', $userId)
                ->latest()
                ->take(4)
                ->get();

            $recipeStats = Recipe::where('user_id', $userId)
                ->selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft_count,
                    AVG(CASE WHEN status = 'published' THEN avg_rating ELSE NULL END) as avg_rating
                ")
                ->first();

            $bookmarkCount = $user->bookmarkedRecipes()->count();
            $reviewCount = $user->reviews()->count();

            $recentReviews = $user->reviews()
                ->with('recipe')
                ->latest()
                ->take(5)
                ->get();

            $popularRecipes = Recipe::with(['recipeable', 'user'])
                ->published()
                ->orderBy('avg_rating', 'desc')
                ->take(6)
                ->get();

            return view('home-user', compact(
                'myRecipes',
                'bookmarkCount',
                'reviewCount',
                'recentReviews',
                'popularRecipes',
                'recipeStats',
            ));
        }

        return view('home');
    }
}
