<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with(
            'grade:id,label'
        )->select(
            'id',
            'grade_id',
            'first_name',
            'last_name',
            'admission_number',
        )->get();

        $response = [
            'status' => 'success',
            'data' => [
                'students' => $students,
            ],
        ];

        return response($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'gender' => 'required|string|in:male,female,others',
            'admission_number' => 'required|string|unique:students',
            'date_of_birth' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'grade_id' => 'required|exists:grades,id',
        ]);

        $request['id'] = Str::orderedUuid();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => Student::create($request->all()),
            ],
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::with('grade:id,label')->get()->firstOrFail();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $student,
            ],
        ];

        return response($response);
    }

    /**
     * Display the specified resource with subjects.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSubjects($id)
    {
        $student = Student::with(
            'grade:id,label',
            'subjectOffers:student_id,subject_id',
            'subjectOffers.subject:id,label'
        )->select(
            'id',
            'grade_id',
            'first_name',
            'last_name',
            'admission_number',
        )->get()->firstOrFail();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $student,
            ],
        ];

        return response($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
