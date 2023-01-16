<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Detail_Bill;
use App\Http\Requests\StoreDetail_BillRequest;
use App\Http\Requests\UpdateDetail_BillRequest;

class DetailBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDetail_BillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($arrProduct)
    {
        foreach ($arrProduct as $value)
        {
            $validate = Validator::make($value, [
                'ib_bill' => 'bail|required|numeric',
                'id_product' => 'bail|required',
                'quantity' => 'bail|required|numeric',
                'price' => 'bail|required|numeric',
            ]);
            if ($validate->fails()) {
                response()->json(['message' => $validate->errors()]);
            }
            Detail_Bill::create($value);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detail_Bill  $detail_Bill
     * @return \Illuminate\Http\Response
     */
    public function show(Detail_Bill $detail_Bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detail_Bill  $detail_Bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail_Bill $detail_Bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetail_BillRequest  $request
     * @param  \App\Models\Detail_Bill  $detail_Bill
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetail_BillRequest $request, Detail_Bill $detail_Bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail_Bill  $detail_Bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_Bill $detail_Bill)
    {
        //
    }
}
