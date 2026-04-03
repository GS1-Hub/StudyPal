<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;

Route::get('/login', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegister']); 
Route::post('/register', [AuthController::class, 'register']);

Route::get('/calendar', [CalendarController::class, 'showCalendar']);

