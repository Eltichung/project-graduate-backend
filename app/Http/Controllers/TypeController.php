<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Type;
use Illuminate\Http\Request;
//use http\Env\Request;

class TypeController extends Controller
{

    public function index()
    {
        $product = Type::get();
        return response()->json([
            'data' => $product
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->only(['name']);
        $validator = Type::validate($data);
        if ($validator->fails()) {
            response()->json(['message' => 'Err']);
        }
        Type::create($data);
        return response()->json(['message' => 'we receive your request', 201]);
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $type = Type::find($id);
        if (empty($type)) {
            return response()->json(['message' => 'Err']);
        }
        $data = $request->only(['name']);
        $validator = Type::validate($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $type->update($data);
        return response()->json(['message' => 'we receive your request', 201]);
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        if (empty($type)) {
            return response()->json(['message' => 'Err']);
        }
        $type->delete();
        return response()->json(['message' => 'we receive your request', 201]);
    }
}
