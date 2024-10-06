<?php

namespace Modules\Product\Http\Controllers\api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Category\Entities\Category;
use Illuminate\Contracts\Support\Renderable;
use Modules\Product\Transformers\ProductResource;
use Modules\Product\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Modules\Product\Http\Requests\ProductRequest;

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
        // return $this->successResponse(data:$data);
        return $this->paginatedResponse($data ,ProductResource::class);
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
        return $this->successResponse(message:translate_word('created'),code:Response::HTTP_CREATED);
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