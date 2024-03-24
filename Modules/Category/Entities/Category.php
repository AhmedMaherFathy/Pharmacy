<?php

namespace Modules\Category\Entities;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class Category extends Model
{
    use HasFactory, PaginationTrait;

    protected $fillable = ['title'];
    
    public static function newFactory()
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
