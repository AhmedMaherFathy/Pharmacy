<?php

namespace Modules\Product\Http\Controllers\api;

use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Services\ProductService;

class ProductController extends Controller
{
    use HttpResponse;
    protected $productService;
    
    public function __construct(ProductService $product){
        $this->productService = $product;
    }

    public function index()
    {
        $data = Product::paginate(10);
        return $this->successResponse(data:$data);
    }

    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        $created = $this->productService->create($request->validated());
        $check = Category::find($request->category_id);
        if(is_null($check) || !$created){
            DB::rollBack();
            return $this->errorResponse();
        }
        DB::commit();
        return $this->successResponse(message:translate_word('created'));
    }

    public function show($id)
    {
        $data = Product::findOrFail($id);
        return $this->successResponse(data:$data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return $this->successResponse(message:translate_word('deleted'));
    }
}