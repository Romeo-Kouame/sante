<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('specialties', SpecialtyController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::post('auth/logout', [AuthController::class, 'logout']);
});

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
