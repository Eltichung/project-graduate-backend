<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;
class Bill extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    protected $fillable = ['name','phone','address','total', 'status', 'location', 'method'];

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
}
