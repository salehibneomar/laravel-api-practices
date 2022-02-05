<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('/student/register', [StudentController::class, 'register'])->name('student.register');
Route::post('/student/login', [StudentController::class, 'login'])->name('student.login');

Route::prefix('student')
->name('student.')
->middleware('auth:jwt')
->group(function(){

    Route::get('/profile', [StudentController::class, 'show'])->name('profile');
    Route::post('/logout', [StudentController::class, 'logout'])->name('logout');

});
