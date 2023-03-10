<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use Illuminate\Http\Request;
use Validator;

class BillController extends Controller
{

    public function getBillByStatus($status)
    {
        $bill = Bill::where('status', $status)->get();
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
        dd($request->total);
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
        Bill::create($dataBill);
        return response()->json(['message' => 'we receive your request', 201]);
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

    public function updateStatus(Request $request, $id)
    {
        $bill = Bill::find($id);
        if (empty($bill)) {
            return response()->json(['message' => 'Err']);
        }
        $data = $request->only(['status']);
        $validator = Validator::make($data, [
            'status' => 'bail|required|numeric',
        ]);;
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
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
}
