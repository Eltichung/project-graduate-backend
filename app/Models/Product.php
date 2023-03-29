<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Models\Type;
/**
 * @method static get()
 */
class Product extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'price', 'type', 'imgUrl'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function type()
    {
        return $this->belongsTo(Type::class,'type','id');
    }
    public static function validate($data)
    {
        return Validator::make($data, [
            'name' => 'bail|required',
            'type' => 'bail|required|max:500',
            'description' => 'bail|required|max:500',
            'price' => 'bail|required|numeric',
            'imgUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
    public static function getAllProduct()
    {
        return self::with('type')->get();

    }
    public static function findProductBySlug($slug)
    {
        return Product::where('slug', $slug)->first();
    }
    public static  function  getProductByType($idType)
    {
        return Product::with('type')->where('type',$idType)->get();
    }
}

