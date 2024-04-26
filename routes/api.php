<?php

use App\Http\Controllers\Api\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/all-users', [UsersController::class, 'getAllUsers']);
    Route::post('/create-user', [UsersController::class, 'createUser']);
    Route::post('/update-user/{id}', [UsersController::class, 'updateUser']);
    Route::post('/delete-user/{id}', [UsersController::class, 'destroyUser']);
});
