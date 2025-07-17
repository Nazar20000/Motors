<?php

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'home'])->name('home');


Route::get('/inventory', [HomeController::class, 'inventory'])->name('inventory');
