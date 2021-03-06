<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDrugToSaleRequest;
use App\Http\Requests\RemoveDrugFromSaleRequest;
use App\Http\Requests\SalesReviewRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Drug;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
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
        $validated = $request->validated();
        $sale = null;

        try {
            DB::transaction(function() use (&$validated, &$sale) {
                $sale = Sale::create(Arr::except($validated, 'drug'));
                $sale->drugs()->attach($validated['drug']['id'], [
                    'quantity' => $validated['drug']['quantity']
                ]);
            });
        } catch (\Throwable $th) {
            $sale = null;
        }

        if ($sale) {
            $location = route('sales.show', ['sale' => $sale->id]);
            return response($sale, 201)->header('Location', $location);
        }
        
        return response('', 500);
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
            array('drugs' => $drugs)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateSaleRequest  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $this->checkSaleCanBeUpdated($sale);
        $sale->update($request->validated());

        return response($sale, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $this->checkSaleCanBeUpdated($sale);
        $done = false;
        try {
            DB::transaction(function() use (&$sale) {
                $sale->delete();
            });
            $done = true;
        } catch (\Throwable $th) {
            // Don't care...
        }

        return response('', $done ? 204: 500);
    }

    /**
     * Add a given drug to a sale.
     *
     * @param  App\Http\Requests\AddDrugToSaleRequest  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function addItem(AddDrugToSaleRequest $request, Sale $sale)
    {
        $validated = $request->validated();
        $drug = Drug::findOrFail($validated['drug_id']);
        $sale->addDrug($drug, $validated['quantity']);

        return response('', 204);
    }

    /**
     * Remove a given drug from a sale.
     *
     * @param  App\Http\Requests\RemoveDrugFromSaleRequest  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function removeItem(RemoveDrugFromSaleRequest $request, Sale $sale)
    {
        $validated = $request->validated();
        $drug = $sale->drugs()->find($validated['drug_id']);
        if (!$drug)
            abort(404, 'The given drug is not on the sale.');
        $sale->removeDrug($drug);

        return response()->json(null, 204);
    }

    /**
     * Return sales review for a given period.
     *
     * @param  App\Http\Requests\SalesReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function salesReview(SalesReviewRequest $request)
    {
        $validated = $request->validated();
        $query = DB::table('drugs')
            ->join('drug_sale', 'drugs.id', '=', 'drug_sale.drug_id')
            ->join('sales', 'drug_sale.sale_id', '=', 'sales.id')
            ->whereBetween(
                'sales.transaction_date',
                 [$validated['start_date'], $validated['end_date']]
            )
            ->select(
                'drugs.id',
                'drugs.name',
                'drugs.inn',
                'drugs.price',
                'drugs.presentation',
                DB::raw('sum(drug_sale.quantity) as total')
            )
            ->groupBy(
                'drugs.id',
                'drugs.name',
                'drugs.inn',
                'drugs.price',
                'drugs.presentation'
            )
            ->orderBy(
                'drugs.name'
        );
        
        if (Arr::has($validated, 'drug_id')) {
            $query->where(
                'drugs.id', '=', $validated['drug_id']
            );
        }

        return response($query->get());
    }

    /**
     * Check that a sale can be updated.
     * A sale can be updated if it has been created within 30 days.
     * 
     * @param Sale  $sale The sale to check
     */
    private function checkSaleCanBeUpdated(Sale $sale)
    {
        $today = Carbon::today();
        $diff = $today->diffInDays($sale->created_at);
        if ($diff > 30)
            abort(409, 'Cannot update or delete a sale created more than 30 days ago.');
    }
}
