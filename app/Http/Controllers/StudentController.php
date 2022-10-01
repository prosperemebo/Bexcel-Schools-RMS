<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('grade:id,label')->get();

        $response = [
            'status' => 'success',
            'data' => [
                'students' => $students
            ]
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
            'grade_id' => 'required|exists:grades,id'
        ]);

        $request['id'] = Str::orderedUuid();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => Student::create($request->all())
            ]
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
        $student = Student::with('grade:id,label')->get();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $student
            ]
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
