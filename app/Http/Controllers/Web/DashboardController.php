<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $filter = $request->get('filter', 'all');

        $myRecipes = Recipe::with(['recipeable', 'categories'])
            ->withCount('reviews')
            ->where('user_id', $userId)
            ->when($filter === 'published', fn ($q) => $q->where('status', 'published'))
            ->when($filter === 'draft', fn ($q) => $q->where('status', 'draft'))
            ->latest()
            ->paginate(10);

        $totalRecipes = Recipe::where('user_id', $userId)->count();
        $draftCount = Recipe::where('user_id', $userId)->where('status', 'draft')->count();
        $avgRating = Recipe::where('user_id', $userId)->where('status', 'published')->avg('avg_rating');

        return view('dashboard', compact('myRecipes', 'totalRecipes', 'draftCount', 'avgRating'));
    }
}
