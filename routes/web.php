<?php

use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Web\Admin\RecipeController as AdminRecipeController;
use App\Http\Controllers\Web\Admin\UserController as AdminUserController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BookmarkController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmailVerificationController;
use App\Http\Controllers\Web\ForgotPasswordController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\RecipeController;
use App\Http\Controllers\Web\ResetPasswordController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->middleware('throttle:6,1')
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->middleware('throttle:6,1')
        ->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create')->middleware('auth');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store')->middleware('auth');
Route::get('/recipes/{recipe:slug}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/{recipe:slug}/edit', [RecipeController::class, 'edit'])->name('recipes.edit')->middleware('auth');
Route::put('/recipes/{recipe:slug}', [RecipeController::class, 'update'])->name('recipes.update')->middleware('auth');
Route::delete('/recipes/{recipe:slug}', [RecipeController::class, 'destroy'])->name('recipes.destroy')->middleware('auth');
Route::get('/recipes/{recipe:slug}/print', [RecipeController::class, 'print'])->name('recipes.print');
Route::post('/recipes/{recipe:slug}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle')->middleware('auth');
Route::post('/recipes/{recipe:slug}/reviews', [RecipeController::class, 'storeReview'])->name('reviews.store')->middleware('auth');
Route::delete('/recipes/{recipe:slug}/reviews/{review}', [RecipeController::class, 'destroyReview'])->name('reviews.destroy')->middleware('auth');

Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

Route::middleware(['auth', 'check.banned'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::middleware('permission:bypass-all')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/recipes', [AdminRecipeController::class, 'index'])->name('recipes');
        Route::delete('/recipes/{recipe}', [AdminRecipeController::class, 'destroy'])->name('recipes.destroy');
        Route::post('/recipes/{recipe}/toggle-status', [AdminRecipeController::class, 'toggleStatus'])->name('recipes.toggle-status');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::post('/users/{user}/toggle-ban', [AdminUserController::class, 'toggleBan'])->name('users.toggle-ban');
        Route::get('/users/{user}/recipes', [AdminUserController::class, 'recipes'])->name('users.recipes');

        Route::get('/categories', [AdminRecipeController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminRecipeController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [AdminRecipeController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminRecipeController::class, 'destroyCategory'])->name('categories.destroy');
    });
});

Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);
