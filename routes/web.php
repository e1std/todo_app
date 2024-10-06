<?php

use App\Http\Controllers\RegiseredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index']);
Route::get('/todos/trashed', [TodoController::class, 'trashed']);
Route::get('/todos/create', [TodoController::class, 'create']);
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit']);
Route::get('/todos/{todo}/done', [TodoController::class, 'done']);
Route::get('/todos/{todo}/restore', [TodoController::class, 'restore']);
Route::post('/todos', [TodoController::class, 'store']);
Route::get('/todos/{todo}', [TodoController::class, 'show']);
Route::delete('/todos/{todo}', [TodoController::class, 'delete'])->name('todos.delete');
Route::patch('/todos/{todo}', [TodoController::class, 'update']);

Route::get('/register', [RegiseredUserController::class, 'create']);
Route::post('/register', [RegiseredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);

Route::post('/logout', [SessionController::class, 'destroy']);
