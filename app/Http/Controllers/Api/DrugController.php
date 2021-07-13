<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrugRequest;
use App\Http\Requests\UpdateDrugRequest;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
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

        $drugs = Drug::orderBy('name')->simplePaginate();

        // This avoids navigation to invalid pages.
        if ($page && intval($page) > $drugs->lastPage())
            abort(404);

        return toCamelKeys($drugs->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreDrugRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDrugRequest $request)
    {
        $validated = toSnakeKeys($request->validated());
        $drug = Drug::create($validated);

        return response($drug, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function show(Drug $drug)
    {
        return $drug;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateDrugRequest  $request
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDrugRequest $request, Drug $drug)
    {
        $validated = toSnakeKeys($request->validated());
        $drug->update($validated);

        return response($drug, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();

        return response()->json(null, 204);
    }
}
