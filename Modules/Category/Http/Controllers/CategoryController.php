<?php

namespace Modules\Category\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Illuminate\Contracts\Support\Renderable;
use Symfony\Component\HttpFoundation\Response;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Transformers\CategoryResource;

class CategoryController extends Controller
{
    use HttpResponse;
    public function index()
    {
        $data = Category::paginatedCollection();

        return $this->paginatedResponse($data, CategoryResource::class);
        
    }

    public function store(CategoryRequest $request)
    {
        $created = Category::create($request->validated());
        if ($created)
            return $this->successResponse(message:translate_success_message('category','created'),code:Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $data = Category::findOrFail($id);
        return $this->successResponse(data:CategoryResource::make($data));
    }

    public function update(CategoryRequest $request, $id)
    {
        Category::findOrFail($id)->update($request->validated());
        return $this->successResponse(message:translate_success_message('category','updated'));
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return $this->successResponse(message:translate_success_message('category','deleted'));
    }
}