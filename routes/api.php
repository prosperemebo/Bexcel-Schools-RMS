<?php

use App\Http\Controllers\AcademicSessionController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ScoreRecordController;
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
Route::post('/v1/students/{id}/add-subject', [StudentController::class, 'addSubject']);
Route::delete('/v1/students/{id}/remove-subject/{subject_id}', [StudentController::class, 'removeSubject']);
Route::resource('/v1/students', StudentController::class);

Route::get('/v1/grades/{id}/promote/{grade_id}', [GradeController::class, 'promote']);
Route::resource('/v1/grades', GradeController::class);

Route::resource('/v1/sessions', AcademicSessionController::class);
Route::resource('/v1/subjects', SubjectController::class);
Route::resource('/v1/subjects-offered', SubjectOfferController::class);

Route::resource('/v1/scores', ScoreRecordController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
