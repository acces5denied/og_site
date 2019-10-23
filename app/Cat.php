<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Cat extends Model
{
    protected $table = 'cats';
    
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'name_alt', 'subway_id', 'rating', 'address', 'geo_lat', 'geo_lon', 'text', 'quote', 'material_type', 'parking', 'security', 'is_complete', 'quarter', 'deadline_year', 'slug', 'seo_title', 'seo_descr'
    ];
    
    use Sluggable;
	
	const MATERIAL_TYPE = ['block' => 'Блочный',
						   'boards' => 'Щитовой',
						   'brick' => 'Кирпичный',
						   'monolith' => 'Монолитный',
						   'monolithBrick' => 'Монолитно-кирпичный',
						   'panel' => ' Панельный',
						   'stalin' => 'Сталинский',
						   'wireframe' => 'Каркасный'];
	
	const PARKING = ['ground' => 'Наземная',
					 'multilevel' => 'Многоуровневая',
					 'open' => 'Открытая',
					 'roof' => 'На крыше',
					 'underground' => 'Подземная'];
	
	const QUARTER = ['first' => '1',
					 'second' => '2',
					 'third' => '3',
					 'fourth' => '4'];
	
	const SECURITY = ['yes' => 'Да',
					 'no' => 'Нет'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slugName'
            ]
        ];
    }
	
	public function getMaterialTypeNameAttribute()
    {
        return self::MATERIAL_TYPE[$this->material_type ];
    }
    
    public function getParkingNameAttribute()
    {
        return self::PARKING[$this->parking];
    }
	
	public function getQuarterNameAttribute()
    {
        return self::QUARTER[$this->quarter];
    }
	
	public function getSecurityNameAttribute()
    {
        return self::SECURITY[$this->security];
    }
    
    public function getSlugNameAttribute() {
        return 'zhiloj-kompleks-'.$this->name;
    }
    
    public function offers(){
        return $this->hasMany('App\Offer');
    }
    public function subway() {
        
        return $this->belongsTo('App\Subway');
        
    }
    public function images(){
        
        return $this->morphMany('App\Image', 'imageable');
        
    }
    public function propertys(){
        
        return $this->morphToMany('App\Property', 'propertyable')->withPivot('property_value');
        
    }
    
}
