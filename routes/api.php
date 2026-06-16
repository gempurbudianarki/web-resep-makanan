<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::get('ingredients', [IngredientController::class, 'index']);
Route::get('recipes', [RecipeController::class, 'index']);
Route::get('recipes/{recipe}', [RecipeController::class, 'show']);
Route::get('recipes/{recipe}/reviews', [ReviewController::class, 'index']);

Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
    Route::post('recipes', [RecipeController::class, 'store'])->middleware('throttle:10,1');
    Route::put('recipes/{recipe}', [RecipeController::class, 'update'])->middleware('throttle:10,1');
    Route::delete('recipes/{recipe}', [RecipeController::class, 'destroy']);

    Route::post('recipes/{recipe}/reviews', [ReviewController::class, 'store']);
    Route::put('recipes/{recipe}/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('recipes/{recipe}/reviews/{review}', [ReviewController::class, 'destroy']);

    Route::post('recipes/{recipe}/bookmark', [BookmarkController::class, 'toggle']);
    Route::get('bookmarks', [BookmarkController::class, 'index']);

    Route::middleware('permission:bypass-all')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });
});
