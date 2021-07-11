<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::create($data);

        return response($doctor, 201);
    }

    public function show(int $id)
    {
        return Doctor::findOrFail($id);
    }

    public function update(StoreDoctorRequest $request, int $id)
    {
        $doctor = Doctor::findOrFail($id);
        $data = $request->validated();
        $doctor->update($data);

        return response($doctor, 202);
    }

    public function destroy(int $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->setStatusCode(204);
    }
}
