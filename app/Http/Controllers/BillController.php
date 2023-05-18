<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Detail_Bill;
use App\Models\Discount;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class BillController extends Controller
{

    public function getBillByStatus($status)
    {
        $now = Carbon::now();
        $startDate =  Carbon::parse($now)->format('Y-m-d 00:00:00');
        $endDate =  Carbon::parse($now)->format('Y-m-d 23:59:59');
        $bill = Bill::where('status', $status)->WhereBetween('created_at', [$startDate,$endDate])->orderBy('id','desc')->get();
        return response()->json([
            'data' => $bill
        ]);
    }
    public function filterBill($method)
    {
        $bill = Bill::where('method', $method)->get();
        return response()->json([
            'data' => $bill
        ]);
    }

    public function index()
    {
        $bill = Bill::get();
        return response()->json([
            'data' => $bill
        ]);
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $dataCustomer = $request->only(['name', 'phone', 'address']);
        $data = $request->only(['total', 'status', 'location', 'method']);
        $validator = Bill::validate($data);
        if ($validator->fails()) {
            response()->json(['message' => $validator->errors()]);
        }
        if(!empty($dataCustomer))
        {
            $validatorCustomer = Bill::validate($dataCustomer);
            if ($validatorCustomer->fails()) {
                response()->json(['message' => $validator->errors()]);
            }
            $dataBill = array_merge((array)($data), (array)($dataCustomer));
        }
        else
        {
            $dataBill = $data;
        }

        $bill = Bill::create($dataBill);
        $billId=$bill->id;
        $dataProduct = $request->only(['arr_product']);
        $arrProduct = $dataProduct['arr_product'];
        if(count($dataProduct)<=0)
        {
            return response()->json(['message' =>'Product is not null', 401]);
        }
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
            $product->ib_bill = $billId;
            $product->id_product = $value['id_product'];
            $product->name = $value['name'];
            $product->quantity = $value['quantity'];
            $product->price= $value['price'];
            $product->save();
        }
        return response()->json(['message' =>$arrProduct, 201]);
    }

    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only(['status', 'id']);
        $validator = Validator::make($data, [
            'status' => 'bail|required|numeric',
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $bill = Bill::find($data['id']);
        if (empty($bill)) {
            return response()->json(['message' => 'Err']);
        }
        $bill->status = $data['status'];
        $bill->save();
        return response()->json(['message' => 'we receive your request', 201]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function  statToday($date)
    {

        $data = [];
        $topProduct = ProductOrder::arrProductOrder($date);
        foreach ($topProduct as $item)
        {   $data[] = [
            'id' => $item->id_product,
            'name' => $item['product']->name,
            'imgUrl' => $item['product']->imgUrl,
            'total' => $item->total,
        ];
        }
        return  response()->json([
            'top_product' => $data,
            'quantity_product' => count($data),
            'quantity_bill' => Bill::totalBill($date)['quantity_bill'],
            'total_now' => Bill::totalBill($date)['total'],
            'total_yesterday' => Bill::totalBill(Carbon::parse($date)->subDay(1))['total'],
             201]);
    }

    public function  statByDay($startTime, $endTime)
    {
        $startDate =  Carbon::parse($startTime)->format('Y-m-d 00:00:00');
        $endDate =  Carbon::parse($endTime)->format('Y-m-d 23:59:59');

        return Bill::statBill($startDate, $endDate);
    }
}
