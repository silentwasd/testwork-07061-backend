<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\BoardController;
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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/register', [RegistrationController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/board/create', [BoardController::class, 'create'])
        ->middleware('ability:board-item:create');

    Route::post('/board/item/{item}/update', [BoardController::class, 'update'])
        ->middleware('ability:board-item:update-owns');

    Route::post('/board/item/{item}/remove', [BoardController::class, 'remove'])
        ->middleware('ability:board-item:remove-owns');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/board/items', [BoardController::class, 'items']);
Route::get('/board/item/{item}', [BoardController::class, 'item'])->middleware('auth-sanctum-hook');
Route::post('/board/item/{item}/click', [BoardController::class, 'click'])->middleware('auth-sanctum-hook');
