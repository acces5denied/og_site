<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'descript', 'link', 'image', 'block'
    ];
}
