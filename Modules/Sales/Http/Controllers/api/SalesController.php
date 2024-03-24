<?php

namespace Modules\Sales\Http\Controllers\api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Modules\Sales\Entities\Sales;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Sales\Services\SalesService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Http\Requests\SalesRequest;
use Modules\Sales\Transformers\SalesResource;

class SalesController extends Controller
{
    use HttpResponse;
    protected $salesService;

    public function __construct(SalesService $SalesService){
        $this->salesService = $SalesService;
    }
    public function index()
    {
        $data = Sales::paginate(10);
        
        return $this->successResponse(data:SalesResource::collection($data));
    }

    public function store(SalesRequest $request)
    {
        $validated = $request->validated();
        $created = $this->salesService->store($validated);
        if(is_null($created))
            return $this->successResponse(message:translate_word('created'));
        return $this->errorResponse(message:$created);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
