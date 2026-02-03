<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;  
use App\Http\Controllers\Api\ApiTaskController;
use App\Http\Controllers\Api\AdminTaskController;

Route::prefix('v1')->as('api.')->group(function () {

    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        // 🗑️ Trash Routes (يجب أن تكون قبل apiResource)
        Route::get('/tasks/trash', [ApiTaskController::class, 'trash'])->name('tasks.trash');
        Route::post('/tasks/{id}/restore', [ApiTaskController::class, 'restore'])->name('tasks.restore');
        Route::delete('/tasks/{id}/force', [ApiTaskController::class, 'forceDelete'])->name('tasks.force');
        Route::delete('/tasks/trash/empty', [ApiTaskController::class, 'emptyTrash'])->name('tasks.trash.empty');

        // Tasks CRUD
        Route::apiResource('tasks', ApiTaskController::class);
        Route::patch('/tasks/{task}/toggle', [ApiTaskController::class, 'toggle'])->name('tasks.toggle');
        Route::patch('/tasks/{task}/favorite', [ApiTaskController::class, 'toggleFavorite'])->name('tasks.favorite');

        // Profile
        Route::get('/profile', [App\Http\Controllers\Api\ProfileController::class, 'show']);
        Route::post('/profile', [App\Http\Controllers\Api\ProfileController::class, 'store']);
        Route::post('/profile/avatar', [App\Http\Controllers\Api\ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
        Route::delete('/profile/avatar', [App\Http\Controllers\Api\ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);

        // 👇 Admin Routes (Protected)
        Route::middleware('admin')->prefix('admin')->group(function () {
            // 🗑️ Admin Trash (يجب أن تكون قبل الـ Routes الأخرى)
            Route::get('/tasks/trash', [AdminTaskController::class, 'trash'])->name('admin.tasks.trash');
            Route::post('/tasks/{id}/restore', [AdminTaskController::class, 'restore'])->name('admin.tasks.restore');

            // Admin Tasks
            Route::get('/tasks', [AdminTaskController::class, 'index'])->name('admin.tasks.index');
            Route::get('/statistics', [AdminTaskController::class, 'statistics'])->name('admin.statistics');
            Route::delete('/tasks/{id}', [AdminTaskController::class, 'destroy'])->name('admin.tasks.destroy');
        });
    });
});
