<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

#### Auth Routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout',[AuthController::class,'logout'])->name('logout')
    ->middleware('auth:sanctum');

#### tasks Routes
Route::middleware('auth:sanctum')->prefix('/tasks')->group(function () {
    Route::get('', [TaskController::class, 'index'])->name('task.list');
    Route::get('mytasks', [TaskController::class, 'mytasks'])->name('mytask.list');
    Route::get('{id}', [TaskController::class, 'show'])->name('task.get');
    Route::post('', [TaskController::class, 'store'])->name('task.store');
    Route::put('{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('{id}', [TaskController::class, 'destroy'])->name('task.delete');
});

#### comments Routes
Route::middleware('auth:sanctum')->prefix('/comments')->group(function () {
    Route::get('{id}', [CommentController::class, 'show'])->name('comment.get');
    Route::post('', [CommentController::class, 'store'])->name('comment.store');
    Route::put('{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('{id}', [CommentController::class, 'destroy'])->name('comment.delete');
});

