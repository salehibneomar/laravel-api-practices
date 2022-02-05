<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public const AVAILABLE   = 'available';
    public const UNAVAILABLE = 'unavailable';
    public const IMAGE_PATH  = 'images/products/'; 

    protected $fillable = 
    [
        'name', 
        'description',
        'quantity',
        'price',
        'status',
        'image',
        'image_path',
        'category_id',
        'seller_id',
    ];

    protected $hidden = ['image_path', 'image'];

    protected $appends = ['picture'];

    protected static function booted()
    {
        static::updated(function($product){
            $product = Product::find($product->id);
            if($product->isAvailable() && !$product->inStock()){
                $product->status = Product::UNAVAILABLE;
                $product->save();
            }
        });
    }

    public function isAvailable(){
        return $this->status == Product::AVAILABLE;
    }

    public function inStock(){
        return $this->quantity > 0 ? true : false;
    }

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'product_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getPictureAttribute()
    {
        $picture = $this->image;

        if(!is_null($picture)){
            $picture = url($this->image_path.$picture);
        }

        return $picture;
    }

}
