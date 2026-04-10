<?php

use App\Http\Controllers\Admin\AdminAdvertisementController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\Admin\AdminFooterController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\FooterController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/home', [HomeController::class, 'index']);

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// Articles
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/search', [ArticleController::class, 'search']);
    Route::get('/by-tag/{tag}', [ArticleController::class, 'byTag']);
    Route::get('/latest', [ArticleController::class, 'latest']);
    Route::get('/popular', [ArticleController::class, 'popular']);
    Route::get('/{article}', [ArticleController::class, 'show']);
    
    // Admin routes (protected in production)
    Route::post('/', [ArticleController::class, 'store']);
    Route::put('/{article}', [ArticleController::class, 'update']);
    Route::delete('/{article}', [ArticleController::class, 'destroy']);
});

// Tags
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);

// Authors
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);
Route::get('/authors/{author}/articles', [AuthorController::class, 'articles']);

// Settings
Route::get('/settings', [SettingController::class, 'index']);

// Advertisements
Route::get('/advertisements', [AdvertisementController::class, 'index']);

// Footer
Route::get('/footer', [FooterController::class, 'index']);

// SEO
Route::get('/seo/article/{id}', [SeoController::class, 'article']);
Route::get('/seo/website', [SeoController::class, 'website']);

// Upload (públicas para desarrollo, proteger en producción)
Route::post('/upload/image', [UploadController::class, 'image']);
Route::delete('/upload/image', [UploadController::class, 'delete']);

// Admin Routes (protegidas con autenticación)
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('articles', AdminArticleController::class);
    Route::post('articles/{article}/publish', [AdminArticleController::class, 'publish']);
    Route::post('articles/{article}/unpublish', [AdminArticleController::class, 'unpublish']);
    
    Route::apiResource('tags', AdminTagController::class);
    Route::apiResource('authors', AdminAuthorController::class);
    Route::apiResource('advertisements', AdminAdvertisementController::class);
    Route::apiResource('footer', AdminFooterController::class)->parameters(['footer' => 'footerItem']);
    
    Route::get('settings', [AdminSettingController::class, 'index']);
    Route::get('settings/{setting}', [AdminSettingController::class, 'show']);
    Route::put('settings', [AdminSettingController::class, 'update']);
    Route::put('settings/batch', [AdminSettingController::class, 'updateMultiple']);
});
