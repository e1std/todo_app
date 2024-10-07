<?php

use App\Http\Controllers\RegiseredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Route to display the list of todos
Route::get('/', [TodoController::class, 'index']);

// Route to display trashed todos
Route::get('/todos/trashed', [TodoController::class, 'trashed']);

// Route to show the form for creating a new todo
Route::get('/todos/create', [TodoController::class, 'create']);

// Route to show the form for editing an existing todo
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit']);

// Route to mark a todo as done
Route::get('/todos/{todo}/done', [TodoController::class, 'done']);

// Route to restore a trashed todo
Route::get('/todos/{todo}/restore', [TodoController::class, 'restore']);

// Route to store a new todo
Route::post('/todos', [TodoController::class, 'store']);

// Route to display a specific todo
Route::get('/todos/{todo}', [TodoController::class, 'show']);

// Route to delete a specific todo
Route::delete('/todos/{todo}', [TodoController::class, 'delete'])->name('todos.delete');

// Route to update a specific todo
Route::patch('/todos/{todo}', [TodoController::class, 'update']);

// Route to show the registration form
Route::get('/register', [RegiseredUserController::class, 'create']);

// Route to handle the registration form submission
Route::post('/register', [RegiseredUserController::class, 'store']);

// Route to show the login form
Route::get('/login', [SessionController::class, 'create']);

// Route to handle the login form submission
Route::post('/login', [SessionController::class, 'store']);

// Route to handle user logout
Route::post('/logout', [SessionController::class, 'destroy']);
