<?php

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
Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('login', [\App\Http\Controllers\UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\UserController::class, 'user']);
    Route::post('todo/add', [\App\Http\Controllers\TodoController::class, 'add']);
    Route::get('todo/get', [\App\Http\Controllers\TodoController::class, 'get']);
    Route::post('todo/update', [\App\Http\Controllers\TodoController::class, 'update']);
    Route::post('todo/delete', [\App\Http\Controllers\TodoController::class, 'delete']);
});
