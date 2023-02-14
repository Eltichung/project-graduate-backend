<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductOrder extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    protected $fillable = ['ib_bill', 'id_product', 'quantity', 'price', 'name'];

    public static function getProductInBill($id_bill)
    {
        return ProductOrder::where('ib_bill', '=', $id_bill)->get();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public static function arrProductOrder($date)
    {
        $startDate =  Carbon::parse($date)->format('Y-m-d 00:00:00');
        $endDate =  Carbon::parse($date)->format('Y-m-d 23:59:59');
        return self::with('product')
            ->WhereBetween('created_at', [$startDate,$endDate])
            ->select(DB::raw("id_product,SUM(quantity) as total"))
            ->groupBy('id_product')
            ->orderBy('total','desc')
            ->limit(5)
            ->get();
    }
}
