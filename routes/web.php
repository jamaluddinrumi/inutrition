<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('welcome');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');

    Route::post('/lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
});
