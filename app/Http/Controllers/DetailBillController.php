<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $dataProduct = $request->only(['arr_product']);
        $arrProduct = $dataProduct['arr_product'];
//        dd($arrProduct);
        foreach ($arrProduct as $value)
        {
            $validate = Validator::make($value, [
                'ib_bill' => 'bail|required|numeric',
                'id_product' => 'bail|required',
                'name' => 'bail|required',
                'quantity' => 'bail|required|numeric',
                'price' => 'bail|required|numeric',
            ]);
            if ($validate->fails()) {
                response()->json(['message' => $validate->errors()]);
            }

            $product= new Detail_Bill();
            $product->ib_bill = 1;
            $product->id_product = $value['id_product'];
            $product->name = $value['name'];
            $product->quantity = $value['quantity'];
            $product->price= $value['price'];

            $product->save();

//            Detail_Bill::create($value);
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