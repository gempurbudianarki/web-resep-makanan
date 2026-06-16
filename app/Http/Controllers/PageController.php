<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function privacy(): View
    {
        $view = app()->getLocale() === 'en' ? 'pages.privacy-en' : 'pages.privacy';
        return view($view);
    }

    public function terms(): View
    {
        $view = app()->getLocale() === 'en' ? 'pages.terms-en' : 'pages.terms';
        return view($view);
    }
}
