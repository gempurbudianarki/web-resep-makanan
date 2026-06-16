<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Services\BookmarkService;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct(
        protected BookmarkService $bookmarkService,
    ) {}

    public function index(Request $request)
    {
        $bookmarks = $this->bookmarkService->getUserBookmarks(
            userId: auth()->id(),
            perPage: 12,
        );

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Recipe $recipe)
    {
        $result = $this->bookmarkService->toggle($recipe, auth()->id());

        return back()->with('success', $result['message']);
    }
}
