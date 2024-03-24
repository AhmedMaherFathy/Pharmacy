<?php

namespace Modules\SocialMedia\Services;

use Modules\SocialMedia\Entities\SocialMediaLinks;

class SocialMediaServices{
    public function store($validated){
        $created = SocialMediaLinks::create($validated);
        if($created) $message = 'created';
        return $message;
    }
}