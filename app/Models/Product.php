<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
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

    public static function validate($data)
    {
        return Validator::make($data, [
            'name' => 'bail|required',
            'type' => 'bail|required|max:500',
            'description' => 'bail|required|max:500',
            'price' => 'bail|required|numeric',
            'imgUrl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
    public static function findProductBySlug($slug)
    {
        return Product::where('slug', $slug)->first();
    }
}

