<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiTaskController;

// أضفنا as('api.') لحل مشكلة الأسماء المتكررة في القائمة
Route::prefix('v1')->as('api.')->group(function () {
    
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('tasks', ApiTaskController::class);
        Route::patch('/tasks/{task}/toggle', [ApiTaskController::class, 'toggle'])->name('tasks.toggle');
        Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'store']);
    });


});