<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ScoreRecords;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class ScoreRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = ScoreRecords::with(
            'students:id,first_name,last_name,admission_number',
            'grade:id,label',
            'subjectOffers:student_id,subject_id',
            'subjectOffers.subject:id,label'
        )->select(
            'id',
            'student_id',
            'subject_id',
            'session_id',
            'ca_score',
            'exam_score'
        )->get();

        $response = [
            'status' => 'success',
            'data' => [
                'records' => $records,
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
        $request->merge(['id' => Str::orderedUuid()]);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'session_id' => 'required|exists:academic_sessions,id',
            'ca_score' => 'required|integer',
            'exam_score' => 'required|integer',
            'subject_id' => [
                'required',
                'exists:subject_offers,id',
                Rule::unique('score_records')->where(function ($query) use ($request) {

                    return $query
                        ->whereStudentId($request->student_id)
                        ->whereSubjectId($request->subject_id)
                        ->whereSessionId($request->session_id);
                }),
            ],
        ]);

        $record = ScoreRecords::create($request->all());

        $response = [
            'status' => 'success',
            'data' => [
                'student' => $record,
            ],
        ];

        return response($response);
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
