<?php

namespace App\Http\Controllers;

use App\Events\Noti;
use Illuminate\Http\Request;

class NotiController extends Controller
{
    public function noti(Request $request)
    {
       
        return  event(new Noti('hello world'));
    }
}
