<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectOfferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v1/students/{id}/subjects', [StudentController::class, 'showSubjects']);
Route::resource('/v1/students', StudentController::class);

Route::resource('/v1/grades', GradeController::class);
Route::resource('/v1/subjects', SubjectController::class);
Route::resource('/v1/subjects-offered', SubjectOfferController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('*', function (Request $request) {
//     $response = [
//         'status' => 'fail',
//         'message' => $request,
//     ];

//     return response($response);
// });
