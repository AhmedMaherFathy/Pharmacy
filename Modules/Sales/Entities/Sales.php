<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = ['profit','sale_time'];
    
    // public static function newFactory()
    // {
    //     return \Modules\Sales\Database\factories\SalesFactory::new();
    // }

    public function products(){
        return $this->belongsToMany(Product::class , 'product_sales');
    }
}
