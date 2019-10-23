<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Subway extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'city_subway', 'city_district', 'city_area', 'education', 'infr', 'culture', 'sport', 'medical', 'advantages'
    ];
    
    use Sluggable;
    
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug_subway' => [
                'source' => 'slugsubways',
                'unique' => false
            ],
            'slug_district' => [
                'source' => 'slugdistricts',
                'unique' => false
            ],
            'slug_area' => [
                'source' => 'slugareas',
                'unique' => false
            ]
        ];
    }
    
    public function getSlugsubwaysAttribute() {
        return 'metro-'.$this->city_subway;
    }
    public function getSlugdistrictsAttribute() {
        return 'rajon-'.$this->city_district;
    }
    public function getSlugareasAttribute() {
        return $this->city_area.'-okrug';
    }
    
    public function offers(){
        return $this->hasMany('App\Offer');
    }
    
    public function cat(){
        return $this->hasMany('App\Cat');
    }
}
