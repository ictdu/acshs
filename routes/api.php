<?php

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Resources\Student as StudentResource;



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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/studentresource', function () {
    return StudentResource::collection(Student::all());
});

Route::get('/studentsections', 'Student\GradeController@studentSections')->name('student.sections');