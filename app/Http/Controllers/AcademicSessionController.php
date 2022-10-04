<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AcademicSession;

class AcademicSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = AcademicSession::orderBy('created_at', 'DESC')->get();

        $response = [
            'status' => 'success',
            'data' => [
                'sessions' => $sessions,
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
            'label' => 'required|string|unique:academic_sessions,label',
            'code' => 'required|string',
            'session_year' => 'required|string',
            'next_session_begins' => 'date'
        ]);

        $request->merge(['id' => Str::orderedUuid()]);

        $response = [
            'status' => 'success',
            'data' => [
                'session' => AcademicSession::create($request->all()),
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
        $session = AcademicSession::findOrFail($id)->get()->firstOrFail();

        $response = [
            'status' => 'success',
            'data' => [
                'session' => $session,
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
        $session = AcademicSession::findOrFail($id)->update($request->all());

        $response = [
            'status' => 'success',
            'data' => [
                'session' => $session,
            ],
        ];

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session = AcademicSession::findOrFail($id)->delete();

        $response = [
            'status' => 'success',
            'data' => [
                'session' => $session
            ]
        ];

        return response($response, 204);
    }
}
