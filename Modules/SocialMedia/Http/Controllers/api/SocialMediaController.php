<?php

namespace Modules\SocialMedia\Http\Controllers\api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SocialMedia\Entities\SocialMediaLinks;
use Modules\SocialMedia\Http\Requests\SocialMediaRequest;
use Modules\SocialMedia\Http\Requests\SocialMediaUpdateRequest;
use Modules\SocialMedia\Services\SocialMediaServices;

class SocialMediaController extends Controller
{
    use HttpResponse;
    protected $SocialMediaServices;
    public function __construct(SocialMediaServices $SocialMediaServices)
    {
        $this->SocialMediaServices = $SocialMediaServices;
    }
    public function  index(){
        $allData = SocialMediaLinks::all();
        return $this->successResponse(data:$allData);
    }
    public function store(SocialMediaRequest $request){
        $created = $this->SocialMediaServices->store($request->validated());
        return $this->successResponse(message:translate_word($created));
    }
    public function show($id){
        $data = SocialMediaLinks::findOrFail($id);
        return $this->successResponse(data:$data);
    }
    public function update(SocialMediaUpdateRequest $request,$id){
        $socialMedia = SocialMediaLinks::findOrFail($id);
        $socialMedia->update($request->validated());
        return $this->successResponse(message:translate_word('updated'));
    }
    public function destroy($id){
        SocialMediaLinks::findOrFail($id)->delete();
        return $this->successResponse(message:translate_word('deleted'));
    }
}
