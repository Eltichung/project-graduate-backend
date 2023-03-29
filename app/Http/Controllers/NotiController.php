<?php

namespace App\Http\Controllers;

use App\Events\Noti;
use App\Models\Bill;
use Illuminate\Http\Request;

class NotiController extends Controller
{
    public function noti(Request $request)
    {
        return  event(new Noti(Bill::getBillMethod(Bill::BILL_ONLINE, Bill::BILL_CONFIRM)));
//        return  event(new Noti('New Bill'));
    }
}
