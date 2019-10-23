<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'propertys';
    
    public $timestamps = false;
    
    public function offers(){
        
        return $this->morphedByMany('App\Offer', 'propertyable');
        
    }
    
    public function cats(){
        
        return $this->morphedByMany('App\Cat', 'propertyable');
        
    }
}
