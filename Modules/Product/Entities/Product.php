<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\Category;
use Modules\Sales\Entities\Sales;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','buy_price','sell_price','quantity','category_id'];
    
    // public static function newFactory()
    // {
    //     return \Modules\Product\Database\factories\ProductFactory::new();
    // }

    public function category(){
        return  $this->belongsTo(Category::class);
    }
    public function sales(){
        return $this->belongsToMany(Sales::class,'product_sales');
    }
}
