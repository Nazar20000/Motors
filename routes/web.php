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