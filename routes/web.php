<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', [Dashboard::class, 'index'])->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/profile', [Profile::class, 'index'])->name('profile.index');
