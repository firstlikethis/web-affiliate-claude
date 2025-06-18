<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    Route::get('/products/search', [AdminProductController::class, 'search']);
    
    // Articles
    Route::resource('articles', AdminArticleController::class);
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Tags
    Route::resource('tags', AdminTagController::class);
    
    // Users (admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', AdminUserController::class);
    });
});

// Frontend routes for products and articles
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

// Affiliate link redirect
Route::get('/go/{product:slug}', [RedirectController::class, 'redirectToAffiliate'])->name('redirect.affiliate');

// Category pages
Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('category.show');

// Tag pages
Route::get('/tag/{tag:slug}', [HomeController::class, 'tag'])->name('tag.show');

// Search
Route::get('/search', [HomeController::class, 'search'])->name('search');