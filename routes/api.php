<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Resources\StudentwithGradeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//untuk autentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/create-admin', [AuthController::class, 'createAdmin']);


//group route yang butuh autentikasi
// Route::middleware('auth:api')->group(function () {
//     //Auth
//     Route::get('/me', [AuthController::class, 'me']);
//     Route::post('/logout', [AuthController::class, 'logout']);

//     //untuk CRUD student
//     Route::apiResource('students', StudentController::class);
//     //untuk CRUD course
//     Route::apiResource('courses', CourseController::class);
//     //untuk CRUD grade
//     Route::apiResource('grades', GradeController::class);

//     //untuk mendapatkan grade berdasarkan ID student
//     Route::get('/grades/student/{id}', [GradeController::class, 'getGradesByStudent']);
//     //untuk mendapatkan grade berdasarkan ID course
//     Route::get('/grades/course/{id}', [GradeController::class, 'getGradesByCourse']);
//     //untuk mendapatkan student beserta grades dan courses berdasarkan ID student
//     Route::get('/students/{id}/grades', [StudentController::class, 'getStudentwithGrades']);
// });

Route::middleware(['auth:jwt', 'role:admin'])->group(function () {
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
    Route::delete('/grades/{id}', [GradeController::class, 'destroy']);
    Route::get('/students', [StudentController::class, 'index']);

});

Route::middleware(['auth:jwt', 'role:user'])->group(function () {
    Route::post('/grades', [GradeController::class, 'store']);
    Route::put('/grades/{id}', [GradeController::class, 'update']);
    Route::get('/students', [StudentController::class, 'index']);

});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.jwt');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth.jwt');
