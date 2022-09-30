<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
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

Route::resource('/v1/students', StudentController::class);
Route::resource('/v1/grades', GradeController::class);

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