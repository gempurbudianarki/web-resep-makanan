<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('lang')) {
            $lang = in_array($request->get('lang'), ['id', 'en']) ? $request->get('lang') : 'id';
            session(['locale' => $lang]);
            return redirect(url()->previous() ?: route('home'));
        }

        $locale = session('locale', 'id');
        App::setLocale($locale);

        return $next($request);
    }
}
