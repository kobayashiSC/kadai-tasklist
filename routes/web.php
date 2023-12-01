<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TaskController::class, "index"]);

Route::get('/dashboard', [TaskController::class,"index"]) ->middleware(["auth"]) ->name("dashboard");


require __DIR__.'/auth.php';

Route::resource('tasks', TaskController::class);