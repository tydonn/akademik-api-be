<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//untuk CRUD student dan course
Route::apiResource('students', StudentController::class);
Route::apiResource('courses', CourseController::class);

//untuk membuat grade
Route::post('/grades', [GradeController::class, 'store']);
//untuk mendapatkan semua grade
Route::get('/grades', [GradeController::class, 'index']);
//untuk mendapatkan grade berdasarkan ID student
Route::get('/grades/student/{id}', [GradeController::class, 'getGradesByStudent']);
//untuk mendapatkan grade berdasarkan ID course
Route::get('/grades/course/{id}', [GradeController::class, 'getGradesByCourse']);
//untuk update grade berdasarkan ID student
Route::put('/grades/{id}', [GradeController::class, 'update']);
//untuk delete grade berdasarkan ID student
Route::delete('/grades/{id}', [GradeController::class, 'destroy']);
