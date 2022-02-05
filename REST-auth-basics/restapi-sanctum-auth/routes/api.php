<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/student/register', [StudentController::class, 'register'])->name('student.register');
Route::post('/student/login', [StudentController::class, 'login'])->name('student.login');


Route::prefix('student')
->name('student.')
->middleware('auth:api_student')
->group(function(){

    Route::get('/profile', [StudentController::class, 'show'])->name('profile');
    Route::post('/logout', [StudentController::class, 'logout'])->name('logout');

    Route::controller(ProjectController::class)
    ->prefix('project')
    ->name('project.')
    ->group(function(){

        Route::get('/all', 'index')->name('all');
        Route::get('/single/{id}', 'show')->name('single');
        Route::post('/create', 'create')->name('create');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
        
    });

});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


