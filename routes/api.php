<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\DesignationController;
use App\Http\Controllers\Masters\MasterController;
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

    // Level Masters
    Route::controller(MasterController::class)->group(function () {
        Route::post('masters/v1/level-lists', 'levelLists');           // Get All Level Lists
    });

    // Designation Controller
    Route::controller(DesignationController::class)->group(function () {
        Route::post('masters/v1/post-designation', 'postDesignation');  // Add New Designation
        Route::post('masters/v1/edit-designation', 'editDesignation');  // Update Designation
        Route::post('masters/v1/get-designation-by-id', 'getDesigById'); // Get Designation by Id
        Route::post('masters/v1/designation-lists', 'designationLists');    // Designation Lists
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::post('masters/category/v1/post-category', 'postCategory');
    });
});
