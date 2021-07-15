<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return apiControllerIndex($request, Sale::class, [
            'sort' => [ 'name' => 'asc' ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreSaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        $validated = toSnakeKeys($request->validated());
        $sale = null;
        $done = false;

        try {
            DB::transaction(function() use (&$validated, &$sale) {
                $sale = Sale::create(Arr::except($validated, [
                    'drug_id', 'quantity'
                ]));
                $sale->drugs()->attach($validated['drug_id'], [
                    'quantity' => $validated['quantity']
                ]);
            });
            $done = true;
        } catch (\Throwable $th) {
            $sale = null;
        }

        return response()->json($sale, $done ? 201: 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $drugs = [];
        foreach ($sale->drugs as $drug) {
            $drugs[] = [
                'id' => $drug->id,
                'name' => $drug->name,
                'quantity' => (int) $drug->pivot->quantity
            ];
        }

        return array_merge(
            $sale->attributesToArray(),
            ['drugs' => $drugs]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
