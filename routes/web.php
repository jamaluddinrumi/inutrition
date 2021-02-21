<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NutritionController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//     ]);
// });

Route::post('/lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware('auth:sanctum', 'verified')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('welcome');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');

    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition');
});
