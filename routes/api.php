<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('/test', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/validate-token', [AuthController::class, 'validateToken']);
    Route::get('/infrastructures', [InfrastructureController::class, 'indexApi'])->name('infrastructures.index.api'); 
    Route::get('/reservations', [ReservationController::class, 'indexApi'])->name('reservations.index.api');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
