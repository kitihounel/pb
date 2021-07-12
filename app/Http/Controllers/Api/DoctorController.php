<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->query('page');
        if ($page && !preg_match('/^[1-9][\d]*$/', $page))
            abort(404);

        $doctors = Doctor::orderBy('name')->simplePaginate();

        // This avoids navigation to invalid pages.
        if ($page && intval($page) > $doctors->lastPage())
            abort(404);

        return toCamelKeys($doctors->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreDoctorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::create($data);

        return response($doctor, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        return $doctor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreDoctorRequest  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();
        $doctor->update($data);

        return response($doctor, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return response()->setStatusCode(204);
    }
}
