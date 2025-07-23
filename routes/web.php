<?php

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'home'])->name('home');


Route::get('/inventory', [HomeController::class, 'inventory'])->name('inventory');

Route::get('/detalis', [HomeController::class, 'detalis'])->name('detalis');

Route::get('/car_finder', [HomeController::class, 'car_finder'])->name('car_finder');

Route::get('/apply_online', [HomeController::class, 'apply_online'])->name('apply_online');

Route::get('/about_us', [HomeController::class, 'about_us'])->name('about_us');

Route::get('/contact_us', [HomeController::class, 'contact_us'])->name('contact_us');

Route::get('/admin/admin', [HomeController::class, 'admin'])->name('admin');

Route::get('/inventory/{id}', [App\Http\Controllers\Home\HomeController::class, 'carDetails'])->name('inventory.details');

Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Home\AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [App\Http\Controllers\Home\AdminController::class, 'users'])->name('admin.users');
    Route::get('/cars', [App\Http\Controllers\Home\AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/requests', [App\Http\Controllers\Home\AdminController::class, 'requests'])->name('admin.requests');
    Route::get('/stats', [App\Http\Controllers\Home\AdminController::class, 'stats'])->name('admin.stats');
    Route::get('/settings', [App\Http\Controllers\Home\AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/cars/create', [App\Http\Controllers\Home\AdminController::class, 'carCreate'])->name('admin.cars.create');
    Route::post('/cars', [App\Http\Controllers\Home\AdminController::class, 'carStore'])->name('admin.cars.store');
    Route::get('/cars/{id}/edit', [App\Http\Controllers\Home\AdminController::class, 'carEdit'])->name('admin.cars.edit');
    Route::put('/cars/{id}', [App\Http\Controllers\Home\AdminController::class, 'carUpdate'])->name('admin.cars.update');
    Route::delete('/cars/{id}', [App\Http\Controllers\Home\AdminController::class, 'carDelete'])->name('admin.cars.delete');
});