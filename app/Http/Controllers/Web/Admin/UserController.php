<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->withCount(['recipes', 'reviews'])
            ->when($request->get('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function toggleBan(User $user)
    {
        if ($user->hasRole('superadmin')) {
            return back()->with('error', __('ui.tidak_bisa_ban_superadmin'));
        }

        $user->update([
            'banned_at' => $user->banned_at ? null : now(),
        ]);

        return back()->with('success', $user->banned_at
            ? __('ui.user_dibanned', ['name' => $user->name])
            : __('ui.user_diunbanned', ['name' => $user->name]));
    }

    public function recipes(User $user)
    {
        $recipes = $user->recipes()
            ->with(['recipeable', 'categories'])
            ->withCount('reviews')
            ->latest()
            ->paginate(12);

        return view('admin.users.recipes', compact('user', 'recipes'));
    }
}
