<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

//Route::apiResource('users', UserController::class);


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KehadiranController;
use App\Http\Controllers\Api\PerizinanController;



Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/perizinan', [PerizinanController::class, 'store']);
    Route::post('/absen/masuk', [KehadiranController::class, 'absenMasuk']);
    // Route::post('/absen/pulang', [KehadiranController::class, 'absenPulang']);
});
