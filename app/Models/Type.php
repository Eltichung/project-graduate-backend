<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Type extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];
    public static function validate($data)
    {
        return Validator::make($data, [
            'name' => 'bail|required|max:500',
        ]);
    }
}
