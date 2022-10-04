<?php


namespace App\Http\Controllers;

use App\Models\SubjectOffer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjectsOffered = SubjectOffer::with('student:id,first_name,last_name', 'subject:id,label')->get();

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
            'subject_id' => [
                'required',
                Rule::unique('subject_offers')->where(function ($query) use ($request) {

                    return $query
                        ->whereStudentId($request->student_id)
                        ->whereSubjectId($request->subject_id);
                }),
            ],
        ]);

        $request->merge(['id' => Str::orderedUuid()]);

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
        $subject = SubjectOffer::findOrFail($id);

        $response = [
            'status' => 'success',
            'data' => [
                'subject' => $subject
            ]
        ];

        return response($response, 200);
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
        $response = [
            'status' => 'fail',
            'message' => 'Route not implemented!'
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
        $subject = SubjectOffer::findOrFail($id)->delete();

        $response = [
            'status' => 'success',
            'data' => [
                'subject' => $subject
            ]
        ];

        return response($response, 201);
    }
}
