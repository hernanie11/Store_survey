<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;

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

Route::post('/auth/login', [AuthController::class, 'Login']);
Route::resource('user', UserController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //AUTH
    Route::put('auth/reset/{id}', [AuthController::class, 'resetPassword']);
    Route::post('auth/change_password', [AuthController::class, 'changedPassword']);
    Route::post('auth/logout', [AuthController::class, 'Logout']);


    //USER
    // Route::resource('user', UserController::class);
    Route::put('user-archive-restore/{id}', [UserController::class, 'archive']);
});


