<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\NutritionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->apiResource('/user', UserController::class);
// Route::apiResource('/user', UserController::class);

Route::middleware('auth:sanctum')->apiResource('/customer', CustomerController::class);
// Route::apiResource('/customer', CustomerController::class);

Route::middleware('auth:sanctum')->apiResource('/nutrition', NutritionController::class);
// Route::apiResource('/nutrition', NutritionController::class);
