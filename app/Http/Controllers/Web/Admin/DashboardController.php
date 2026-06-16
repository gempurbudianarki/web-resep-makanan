<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_recipes' => Recipe::count(),
            'published_recipes' => Recipe::where('status', 'published')->count(),
            'draft_recipes' => Recipe::where('status', 'draft')->count(),
            'total_reviews' => Review::count(),
            'avg_rating' => round(Recipe::where('status', 'published')->avg('avg_rating') ?? 0, 2),
            'recent_recipes' => Recipe::with('user')->latest()->take(8)->get(),
            'recent_users' => User::latest()->take(8)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
