<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// 📦 ROUTES API - Catégories
Route::get('/categories', [CategoryController::class, 'getCategories']); // Renvoie les catégories avec leurs contenus

// 📦 ROUTES API - Contenus
Route::get('/podcasts', [ContentController::class, 'getPodcasts']); // Renvoie uniquement les contenus audio
Route::get('/contents', [ContentController::class, 'getAllContents']); // Renvoie tous les contenus avec URL complètes

// 📦 ROUTE API - Podcasts par catégorie
Route::get('/contents/category/{categoryName}', [ContentController::class, 'getPodcastsByCategory']);