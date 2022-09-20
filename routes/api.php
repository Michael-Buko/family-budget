<?php

use App\Http\Controllers\Api\AuthController;
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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logoutUser']);
Route::middleware('auth:sanctum')->get('/auth/user', [AuthController::class, 'getUser']);

Route::get('/blog', [\App\Http\Controllers\Api\BlogController::class, 'index']);
Route::middleware('auth:sanctum')->apiResource('/main', \App\Http\Controllers\Api\MainController::class);
Route::middleware('auth:sanctum')->apiResource('/transactions', \App\Http\Controllers\Api\TransactionsController::class);
