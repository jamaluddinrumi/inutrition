<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\NutritionController;
use App\Http\Controllers\UserController;
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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group([], function () {
Route::middleware('auth:sanctum', 'verified')->group(function () {

    Route::apiResource('/user', UserController::class);

    Route::apiResource('/customer', CustomerController::class);

    Route::apiResource('/nutrition', NutritionController::class);
});
