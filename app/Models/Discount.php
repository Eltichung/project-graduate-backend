<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['value'];
    protected $table = 'discount';
    public static function getDiscount()
    {
        return self::where('id',1)->pluck('value')[0];
    }
    public static function updateDiscount($value)
    {
        return self::where('id',1)->update(['value'=>$value]);
    }
}
