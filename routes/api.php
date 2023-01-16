<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => 'v1/', "as" => "product."], function () {
    //products
    Route::get('/getProduct', [ProductController::class, 'index']);
    Route::get('/getProduct/{type}', [ProductController::class, 'filter']);
    Route::post('/createProduct', [ProductController::class, 'store']);
    Route::put('/updateProduct/{slug}', [ProductController::class, 'update']);
    Route::delete('/deleteProduct/{slug}', [ProductController::class, 'destroy']);
    //type
    Route::get('/getType', [TypeController::class, 'index']);
    Route::post('/createType', [TypeController::class, 'store']);
    Route::put('/updateType/{id}', [TypeController::class, 'update']);
    Route::delete('/deleteType/{id}', [TypeController::class, 'destroy']);
    //Bill
    Route::get('/getBill', [BillController::class, 'index']);
    Route::get('/filterStatusBill/status={status}', [BillController::class, 'getBillByStatus']);
    Route::get('/filterBill/method={method}', [BillController::class, 'filterBill']);
    Route::post('/createBill', [BillController::class, 'store']);
    Route::post('/updateStatus/idBill={id}', [BillController::class, 'updateStatus']);
});

