<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });


Route::get('/', [TaskController::class, 'index'])->name('todo.index');
Route::post('/tasks/post', [TaskController::class, 'store'])->name('todo.add'); 
Route::post('/tasks/checklist/{id}', [TaskController::class, 'Checklist'])->name('todo.checklist');

Route::post('/tasks/edit/{id}', [TaskController::class, 'edit'])->name('todo.edit');
Route::put('/tasks/update/{id}', [TaskController::class, 'update'])->name('todo.update');

Route::delete('/tasks/delete/{id}', [TaskController::class, 'destroy'])->name('todo.delete');

Route::post('/todo/delete-all', [TaskController::class, 'deleteAll'])->name('todo.deleteAll');
