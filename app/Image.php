<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'url', 'tag', 'imageable_id', 'imageable_type'
    ];

    public function imageable(){
        
        return $this->morphTo();
        
    }

}
