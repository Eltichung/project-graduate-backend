<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['ib_bill', 'id_product', 'quantity', 'price','name'];

    public static function getProductInBill($id_bill)
    {
        return ProductOrder::where('ib_bill','=',$id_bill)->get();
    }
}
