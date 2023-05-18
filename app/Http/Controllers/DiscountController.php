<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function index()
    {
        dd(Discount::getDiscount());
        return response()->json([
            'data' => Discount::getDiscount()
        ]);
    }
    public function update(Request $request)
    {
        $data = $request->only('value');
        $validator =  Validator::make($data, [
            'value' => 'numeric|required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        Discount::updateDiscount($data['value']);
        return response()->json(['message' => 'we receive your request', 201]);
    }
}
