<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

//use http\Env\Request;

class ProductController extends Controller
{

    public function index()
    {
        $product = Product::with('type')->where('isHot',1)->get();
        return response()->json([
            'data' => $product
        ]);
    }
    public function getAllProduct()
    {
        return response()->json([
            'data' => Product::getAllProduct()
        ]);
    }
    public function filter($idType)
    {
        return response()->json([
            'data' => Product::getProductByType($idType)
        ]);
    }
    public function search($name)
    {
        return response()->json([
            'data' => Product::where('name','like', '%'.$name.'%')->get()
        ]);
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'type', 'description', 'price', 'imgUrl']);
        $validator = Product::validate($data);
        $request->file('imgUrl')->store('public/images');
        $nameImg = $request->file('imgUrl')->getClientOriginalName();
        $data['imgUrl'] = URL::asset('storage/images/'.$nameImg);
        if ($validator->fails()) {
             response()->json(['message' => 'Err']);
        }
        Product::create($data);
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
        $product = Product::findBySlug($request->slug);
        if (empty($product)) {
            return response()->json(['message' => 'Err']);
        }
        $data = $request->only(['name', 'type', 'description', 'price', 'imgUrl']);
        $validator = Product::validate($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $image_path = $request->file('imgUrl')->store('image', 'public');
        $data['imgUrl'] = $image_path;
        $product->update($data);
            return response()->json(['message' => 'we receive your request', 201]);
    }
    public function destroy($slug)
    {
        $product = Product::findProductBySlug($slug);
        if (empty($product)) {
            return response()->json(['message' => 'Err']);
        }
        $product->delete();
        return response()->json(['message' => 'we receive your request', 201]);
    }
}
