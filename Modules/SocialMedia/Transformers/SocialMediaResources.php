<?php

namespace Modules\SocialMedia\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'link'=> $this->link,
        ];
    }
}
