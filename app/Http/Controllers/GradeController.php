<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::all();

        $response = [
            'status' => 'success',
            'data' => [
                'grades' => $grades
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
            'label' => 'required|string|unique:grades',
            'slug' => 'string|unique:grades',
        ]);

        $request['id'] = Str::orderedUuid();

        if (!$request->slug) {
            $request['slug'] = strtolower(str_replace(" ", "-", $request->label));
        }

        $response = [
            'status' => 'success',
            'data' => [
                'grade' => Grade::create($request->all())
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
        $grade = Grade::with('students')->where('id', '=', '' . $id)->orWhere('slug', '=', '' . $id)->get()->firstOrFail();

        if ($grade->isEmpty()) {
            abort(404, 'Could not find grade with id of \'' . $id . '\'');
        }

        $response = [
            'status' => 'success',
            'data' => [
                'grade' => $grade
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
        $request->validate([
            'label' => 'string|unique:grades',
            'slug' => 'string|unique:grades',
        ]);

        $grade = Grade::findOrFail($id)->update($request->all());

        $response = [
            'status' => 'success',
            'data' => [
                'grade' => $grade
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
        $grade = Grade::findOrFail($id)->delete();

        $response = [
            'status' => 'success',
            'data' => [
                'grade' => $grade
            ]
        ];

        return response($response, 201);
    }
}
