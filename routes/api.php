<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//untuk autentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//group route yang butuh autentikasi
Route::middleware('auth:api')->group(function () {
    //Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //untuk CRUD student
    Route::apiResource('students', StudentController::class);
    //untuk CRUD course
    Route::apiResource('courses', CourseController::class);
    //untuk CRUD grade
    Route::apiResource('grades', GradeController::class);
    
    //untuk mendapatkan grade berdasarkan ID student
    Route::get('/grades/student/{id}', [GradeController::class, 'getGradesByStudent']);
    //untuk mendapatkan grade berdasarkan ID course
    Route::get('/grades/course/{id}', [GradeController::class, 'getGradesByCourse']);
    
});
