<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SubjectOffer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
     * Add subject to the specified resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addSubject(Request $request, $id)
    {
        $request->merge(['id' => Str::orderedUuid()]);
        $request->merge(['student_id' => $id]);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('subject_offers')->where(function ($query) use ($request) {

                    return $query
                        ->whereStudentId($request->student_id)
                        ->whereSubjectId($request->subject_id);
                }),
            ],
        ]);

        $subject = SubjectOffer::create($request->all());

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $subject,
            ],
        ];

        return response($response);
    }

    /**
     * Remove subject from the specified resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeSubject(Request $request, $id, $subject_id)
    {
        $request->merge(['student_id' => $id]);
        $request->merge(['subject_id' => $subject_id]);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = SubjectOffer::where('student_id', '=', '' . $request->student_id)
            ->where('subject_id', '=', '' . $request->subject_id)->first()->delete();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $subject,
            ],
        ];

        return response($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gender' => 'string|in:male,female,others',
            'admission_number' => 'string|unique:students',
            'date_of_birth' => 'string',
            'first_name' => 'string',
            'last_name' => 'string',
            'grade_id' => 'exists:grades,id',
        ]);

        $student = Student::findOrFail($id)->update($request->all());

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $student
            ]
        ];

        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id)->delete();

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $student
            ]
        ];

        return response($response, 204);
    }
}
