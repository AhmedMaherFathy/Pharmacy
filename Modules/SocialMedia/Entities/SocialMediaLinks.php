<?php

namespace Modules\SocialMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaLinks extends Model
{
    use HasFactory;

    protected $fillable = ['platform','link'];
    
    // public static function newFactory()
    // {
    //     return \Modules\SocialMedia\Database\factories\SocialMediaLinksFactory::new();
    // }
}
