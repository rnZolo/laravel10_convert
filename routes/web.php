<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

// Route::get('/', [EventsController::class, 'show']);
Route::middleware(['auth'])->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::get('/create', [StudentController::class, 'create']);
        Route::post('/store', [StudentController::class, 'store']);
        Route::get('/edit/{id}', [StudentController::class, 'edit']);
        Route::put('/update', [StudentController::class, 'update']);
        Route::delete('/destroy', [StudentController::class, 'destroy']);
        Route::delete('/multi_destroy', [StudentController::class, 'multiDestroy']);
        Route::post('/logout', [UserController::class, 'logout']);
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'index'])->name('login');
    Route::post('/login_auth', [UserController::class, 'login']);
});

