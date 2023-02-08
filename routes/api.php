<?php

use App\Http\Controllers\Auth\AuthController;
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

/**
 * |------------------------------------------------------------------------
 * | Un Authenticated Routes Defined Here
 * | -----------------------------------------------------------------------
 */
Route::controller(AuthController::class)->group(function () {
    Route::post('auth/v1/register', 'register');                // User Registration
    Route::post('auth/v1/login', 'login');                      // User Login
});

/**
 * |------------------------------------------------------------------------
 * | Authenticated Routes Defined Here
 * | -----------------------------------------------------------------------
 */

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('auth/v1/logout', 'logout');                      // User Logout
        Route::post('auth/v1/change-password', 'changePassword');      // User Change Password
    });
});
