<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::get('users', [UserController::class, 'index']);
    
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::get('users/{id}/edit', [UserController::class, 'edit']);
    Route::put('users/{id}/edit', [UserController::class, 'update']);
    Route::delete('users/{id}/delete', [UserController::class, 'destroy']);
    
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::get('posts/{id}/edit', [PostController::class, 'edit']);
    Route::put('posts/{id}/edit', [PostController::class, 'update']);
    Route::delete('posts/{id}/delete', [PostController::class, 'destroy']); 
});

Route::post('users', [UserController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
