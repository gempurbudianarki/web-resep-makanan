<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->banned_at) {
            auth()->logout();

            return redirect()->route('login')->with('error', __('ui.akun_dibanned'));
        }

        return $next($request);
    }
}
