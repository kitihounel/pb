<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        $validated = $request->validated();
        $doctor = Doctor::create($validated);

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
     * @param  App\Http\Requests\UpdateDoctorRequest  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $validated = $request->validated();

        if (count($validated) == 0) {
            return response()->json([
                'message' => 'You must provide at least one field.'
            ], 422);
        }

        $doctor->update($validated);

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

        return response()->json(null, 204);
    }
}
