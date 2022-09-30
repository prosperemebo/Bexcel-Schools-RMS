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

    // {
    //     "id": 97629,
    //     "grade_id": 976296,
    //     "gender": "male",
    //     "admission_number": "16/AD/BC/024",
    //     "date_of_birth": "2006-10-11",
    //     "first_name": "Prosper",
    //     "last_name": "Castle",
    //     "other_name": "Chima",
    //     "created_at": "2022-09-30T00:35:06.000000Z",
    //     "updated_at": "2022-09-30T00:35:06.000000Z",
    //     "grade": {
    //         "id": 976296,
    //         "label": "JSS1"
    //     }
    // },
    // {
    //     "id": 9762,
    //     "grade_id": 976296,
    //     "gender": "female",
    //     "admission_number": "16/AD/BC/027",
    //     "date_of_birth": "2006-10-11",
    //     "first_name": "Goodness",
    //     "last_name": "Simon",
    //     "other_name": "Grace",
    //     "created_at": "2022-09-30T00:48:29.000000Z",
    //     "updated_at": "2022-09-30T00:48:29.000000Z",
    //     "grade": {
    //         "id": 976296,
    //         "label": "JSS1"
    //     }
    // }

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
        //
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
