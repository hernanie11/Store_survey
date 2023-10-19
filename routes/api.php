<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleManagementController;

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


Route::group(['middleware' => ['auth:sanctum']], function () {
    //AUTH
    Route::put('auth/reset/{id}', [AuthController::class, 'resetPassword']);
    Route::post('auth/change_password', [AuthController::class, 'changedPassword']);
    Route::post('auth/logout', [AuthController::class, 'Logout']);


    //USER
    // Route::resource('user', UserController::class);
    Route::resource('user', UserController::class);
    Route::put('user-archive-restore/{id}', [UserController::class, 'archive']);
    
    //ROLE MANAGEMENT
    Route::resource('role', RoleManagementController::class);
    Route::put('role-archive-restore/{id}', [RoleManagementController::class, 'archived']);
    

    //Department
    Route::resource('department', DepartmentController::class);

    //Company
    Route::resource('company', CompanyController::class);

    //LOCATION//
    Route::resource('location', LocationController::class);
});


