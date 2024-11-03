<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PercobaanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'apiRegister']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('/percobaan', [PercobaanController::class, 'index']);
    Route::get('/percobaan/{id}', [PercobaanController::class, 'show']);
    Route::post('/percobaan', [PercobaanController::class, 'store']);
    Route::put('/percobaan/{id}', [PercobaanController::class, 'update']);
    Route::delete('/percobaan/{id}', [PercobaanController::class, 'destroy']);
});
