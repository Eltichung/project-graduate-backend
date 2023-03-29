<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;
class Bill extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    protected $fillable = ['name','phone','address','total', 'status', 'location', 'method'];
    const BILL_CONFIRM = 1;
    const BILL_SUCCESS = 2;
    const BILL_CANCEL = 3;
    const BILL_OFFLINE = 1;
    const BILL_ONLINE = 2;
    public static function validate($data)
    {
        return Validator::make($data, [
            'total' => 'bail|required|numeric',
            'status' => 'bail|required|min:0|max:5',
            'location' => 'bail|required|numeric',
            'method' => 'bail|required|numeric',
        ]);
    }
    public static function validateCustomer($data)
    {
        return Validator::make($data, [
            'name' => 'bail|required|max:50',
            'phone' => 'bail|required',
            'address' => 'bail|required',
        ]);
    }
    public static function getBill($id_bill)
    {
        return  Bill::where('id', $id_bill)->value('total');
    }

    public static function totalBill($date)
    {
        $startDate =  Carbon::parse($date)->format('Y-m-d 00:00:00');
        $endDate =  Carbon::parse($date)->format('Y-m-d 23:59:59');
        return  [
            'total' => Bill::WhereBetween('created_at', [$startDate,$endDate])->sum('total'),
            'quantity_bill' => Bill::WhereBetween('created_at', [$startDate,$endDate])->count()
        ];
    }

    public static function statBill($startTime, $endTime)
    {
        return self::WhereBetween('created_at', [$startTime,$endTime])
            ->select(DB::raw('DATE(created_at) as date'),DB::raw("SUM(total) as total"))
            ->groupBy(DB::raw('Date(created_at)'))
            ->get();
    }
    public static function getBillMethod($method, $status)
    {
       return Bill::where('method', $method)->where('status', $status)->count();
    }
}
