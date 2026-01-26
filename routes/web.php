<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TrashController;

// الصفحات العامة بدون حماية
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// كل الصفحات المحمية (يجب تسجيل الدخول)
Route::middleware('auth')->group(function () {
    // Tasks CRUD
    Route::resource('tasks', TaskController::class);

    // Task Actions
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::patch('tasks/{task}/favorite', [TaskController::class, 'favorite'])->name('tasks.favorite');

    // Categories CRUD
    Route::resource('categories', CategoryController::class);

    // Trash Routes
    Route::get('trash', [TrashController::class, 'index'])->name('trash.index');
    Route::patch('trash/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
    Route::delete('trash/{id}/force-delete', [TrashController::class, 'forceDelete'])->name('trash.forceDelete');
    Route::delete('trash/empty', [TrashController::class, 'empty'])->name('trash.empty');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// الصفحة الرئيسية
Route::get('/', function () {
    return redirect()->route('tasks.index');
});
