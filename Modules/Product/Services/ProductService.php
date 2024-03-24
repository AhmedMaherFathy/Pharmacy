<?php
namespace Modules\Product\Services;

use Modules\Product\Entities\Product;

class ProductService{
    public function create($validated){
        $created = Product::create($validated);
        if($created)
            return true;
        return false;
    }
}