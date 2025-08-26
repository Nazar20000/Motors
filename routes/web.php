<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BodyTypeController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Public routes
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/inventory', [HomeController::class, 'inventory'])->name('inventory');
Route::get('/detalis/{id?}', [HomeController::class, 'detalis'])->name('detalis');
Route::get('/car/{id}', [HomeController::class, 'detalis'])->name('car.details');
Route::get('/car_finder', [HomeController::class, 'car_finder'])->name('car_finder');
Route::get('/apply_online/{car_id?}', [HomeController::class, 'apply_online'])->name('apply_online');
Route::get('/about_us', [HomeController::class, 'about_us'])->name('about_us');
Route::get('/contact_us', [HomeController::class, 'contact_us'])->name('contact_us');
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy_policy');

// Request routes
Route::post('/contact-request', [ContactRequestController::class, 'store'])->name('contact.request.store');
Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// CSRF token refresh route
Route::get('/csrf-refresh', function () {
    return response()->json([
        'token' => csrf_token(),
        'timestamp' => time()
    ]);
})->middleware('refresh.csrf');

// API routes (temporarily in web.php for testing)
Route::prefix('api')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working!']);
    });
    
    Route::get('/test-models', function () {
        return response()->json([
            'success' => true,
            'data' => [
                ['id' => 1, 'name' => 'Test Model 1', 'brand_id' => 1],
                ['id' => 2, 'name' => 'Test Model 2', 'brand_id' => 1],
            ]
        ]);
    });
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware(['throttle:5,1']); // 5 attempts per minute
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware(['throttle:3,1']); // 3 attempts per minute
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected admin routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    // Car management
    Route::get('/cars', [AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/cars/create', [AdminController::class, 'carCreate'])->name('admin.cars.create');
    Route::post('/cars', [AdminController::class, 'carStore'])->name('admin.cars.store');
    Route::get('/cars/{id}/edit', [AdminController::class, 'carEdit'])->name('admin.cars.edit');
    Route::put('/cars/{id}', [AdminController::class, 'carUpdate'])->name('admin.cars.update');
    Route::delete('/cars/{id}', [AdminController::class, 'carDelete'])->name('admin.cars.delete');
    
    // Image deletion
    Route::delete('/cars/{id}/delete-main-image', [AdminController::class, 'deleteMainImage'])->name('admin.cars.delete-main-image');
    Route::delete('/cars/images/{imageId}', [AdminController::class, 'deleteImage'])->name('admin.cars.delete-image');
    
    // Brand management
    Route::resource('brands', BrandController::class)->names('admin.brands');
    
    // Body type management
    Route::resource('body-types', BodyTypeController::class)->names('admin.body-types');
    
    // Model management
    Route::resource('car-models', CarModelController::class)->names('admin.car-models');
    
    // Other admin routes
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'userDelete'])->name('admin.users.delete');
    
    Route::get('/requests', [AdminController::class, 'requests'])->name('admin.requests');
    Route::get('/requests/{id}', [ContactRequestController::class, 'show'])->name('admin.requests.show');
    Route::put('/requests/{id}/status', [ContactRequestController::class, 'updateStatus'])->name('admin.requests.update-status');
    Route::delete('/requests/{id}', [ContactRequestController::class, 'destroy'])->name('admin.requests.destroy');
    
    // Application management
    Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.applications');
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('admin.applications.show');
    Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('admin.applications.update-status');
    Route::post('/applications/{id}/notes', [ApplicationController::class, 'updateNotes'])->name('admin.applications.update-notes');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
});