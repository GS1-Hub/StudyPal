<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UCController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/calendar', [CalendarController::class, 'showCalendar']);

Route::middleware('auth')->group(function () {
    Route::get('/uc', [UCController::class, 'index'])->name('ucs.index');
    Route::post('/uc', [UCController::class, 'store'])->name('ucs.store');
    Route::get('/uc/{id}', [UCController::class, 'show'])->name('ucs.show');
});

Route::middleware('auth')->group(function () {
    Route::post('/task', [TaskController::class, 'store'])->name('tasks.store');
});

Route::get('/calendar', [CalendarController::class, 'index'])->middleware('auth')->name('calendar');
Route::middleware('auth')->group(function () {
    Route::get('/tasks/unscheduled', [TaskController::class, 'unscheduled'])->name('tasks.unscheduled');
    Route::put('/task/{id}/date', [TaskController::class, 'updateDate'])->name('tasks.updateDate');
});
