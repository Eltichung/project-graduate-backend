<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\NotiController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => 'v1/', "as" => "product."], function () {
    Route::post('/admin/login', [UserController::class, 'loginUser']);
    Route::get('/noti', [NotiController::class, 'noti']);
    //productsx
    Route::get('/getProduct', [ProductController::class, 'index']);
    Route::get('/getAllProduct', [ProductController::class, 'getAllProduct']);
    Route::get('/getProduct/{type}', [ProductController::class, 'filter']);
    Route::get('/product/{name}', [ProductController::class, 'search']);
    //type
    Route::get('/getType', [TypeController::class, 'index']);
    //Bill
    Route::post('/createBill', [BillController::class, 'store']);
});
Route::group(["prefix" => 'v1/', "as" => "product.", 'middleware' => ['auth:sanctum']], function () {
    //products
    Route::post('admin/createProduct', [ProductController::class, 'store']);
    Route::post('admin/updateProduct', [ProductController::class, 'update']);
    Route::delete('admin/deleteProduct/{slug}', [ProductController::class, 'destroy']);
    //type
    Route::post('admin/createType', [TypeController::class, 'store']);
    Route::post('admin/updateType', [TypeController::class, 'update']);
    Route::delete('admin/deleteType/{id}', [TypeController::class, 'destroy']);
    //Bill
    Route::get('admin/getBill', [BillController::class, 'index']);
    Route::get('admin/discount', [DiscountController::class, 'index']);
    Route::post('admin/updateDiscount', [DiscountController::class, 'update']);
    Route::get('admin/filterStatusBill/status={status}', [BillController::class, 'getBillByStatus']);
    Route::get('admin/filterBill/method={method}', [BillController::class, 'filterBill']);
    Route::get('admin/detailBill/id_bill={id_bill}', [ProductOrderController::class, 'getProduct']);
    Route::post('admin/createBill', [BillController::class, 'store']);
    Route::post('admin/detailBill', [ProductOrderController::class, 'store']);
    Route::post('admin/updateStatus', [BillController::class, 'updateStatus']);
    Route::get('admin/statToday/{date}', [BillController::class, 'statToday']);
    Route::get('admin/statByDate/startTime={startTime}&&endTime={endTime}', [BillController::class, 'statByDay']);
});
