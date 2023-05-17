<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Detail_Bill;
use App\Models\ProductOrder;
use App\Http\Requests\StoreProductOrderRequest;
use App\Http\Requests\UpdateProductOrderRequest;
use Validator;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $bill = ProductOrder::get();
        return response()->json([
            'data' => $bill
        ]);
    }
    public function getProduct($id_bill)
    {
        return response()->json([
            'data' => ProductOrder::getProductInBill($id_bill),
            'customer' => Bill::getBillById($id_bill),
            'id_bill' => $id_bill,
            'total' => Bill::getBill($id_bill)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $bill = ProductOrder::get();
        return response()->json([
            'data' => $bill
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataProduct = $request->only(['arr_product']);
        $arrProduct = $dataProduct;
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

            $product= new ProductOrder();
            $product->ib_bill = 1;
            $product->id_product = $value['id_product'];
            $product->name = $value['name'];
            $product->quantity = $value['quantity'];
            $product->price= $value['price'];
            $product->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductOrderRequest  $request
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductOrderRequest $request, ProductOrder $productOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOrder $productOrder)
    {
        //
    }
}
