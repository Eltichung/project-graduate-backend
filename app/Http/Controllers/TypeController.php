<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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
        $data = $request->only(['name', 'imgUrl']);
        $validator = Type::validate($data);
        $request->file('imgUrl')->store('public/images');
        $nameImg = $request->file('imgUrl')->getClientOriginalName();
        $data['imgUrl'] = URL::asset('storage/images/'.$nameImg);
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

    public function update(Request $request)
    {
        $type = Type::find($request->id);
        if (empty($type)) {
            return response()->json(['message' => 'Err']);
        }
        $data = $request->only(['name', 'imgUrl']);
        $validator = Type::validate($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        if (file_exists($request->file('imgUrl')))
        {
            $request->file('imgUrl')->store('public/images');
            $nameImg = $request->file('imgUrl')->getClientOriginalName();
            $data['imgUrl'] = URL::asset('storage/images/'.$nameImg);
        }
        $type->update($data);
        return response()->json(['message' => 'we receive your request', 201]);
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        if (!isset($type)) {
            return response()->json(['message' => 'Err']);
        }
        $product = Product::getProductByType($id);
        if (count($product) > 0) {
            return response()->json(['message' => 'You cant delete type because product exit belong it'], 405);
        }
        $type->delete();
        return response()->json(['message' => 'we receive your request', 201]);
    }
}
