<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Bill extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['ib_bill', 'id_product', 'quantity', 'price'];
}
