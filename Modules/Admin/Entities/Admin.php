<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class admin extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    // public static function newFactory()
    // {
    //     return \Modules\Admin\Database\factories\AdminFactory::new();
    // }
}
