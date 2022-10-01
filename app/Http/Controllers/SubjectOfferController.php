<?php

namespace App\Http\Controllers;

use App\Models\SubjectOffer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubjectOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjectsOffered = SubjectOffer::with('student|subject')->get();

        $response = [
            'status' => 'success',
            'data' => [
                'classes' => $subjectsOffered
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
        // 'required|unique:TableName,column_1,' . $this->id . ',id,colum_2,' . $this->column_2

        $request->validate([
            'student_id' => 'required|exists:students,id|unique:subject_offers,student_id',
            'subject_id' => 'required|exists:subjects,id|unique:subject_offers,subject_id',
        ]);

        $request['id'] = Str::orderedUuid();

        $response = [
            'status' => 'success',
            'data' => [
                'classes' => SubjectOffer::create($request->all())
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
        // $subject = Subject::findOrFail($id);

        // $response = [
        //     'status' => 'success',
        //     'data' => [
        //         'subject' => $subject
        //     ]
        // ];

        // return response($response, 200);
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
        // $request->validate([
        //     'label' => 'string|unique:subjects',
        // ]);

        // $subject = Subject::findOrFail($id)->update($request->all());

        // $response = [
        //     'status' => 'success',
        //     'data' => [
        //         'subje$subject' => $subject
        //     ]
        // ];

        // return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $subject = Subject::findOrFail($id)->delete();

        // $response = [
        //     'status' => 'success',
        //     'data' => [
        //         'subject' => $subject
        //     ]
        // ];

        // return response($response, 201);
    }
}
