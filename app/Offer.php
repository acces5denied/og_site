<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Scopes\OfferScope;

class Offer extends Model
{
    
    const TYPE = ['eliteflat' => 'Квартира', 
                  'apartment' => 'Апартаменты', 
                  'penthouse' => 'Пентхаус', 
                  'townhouse' => 'Таунхаус'];
    
    const FINISH = ['bez-otdelki' => 'Без отделки', 
                    's-otdelkoj' => 'С отделкой'];
	
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
	
	const SECURITY = ['yes' => 'Да',
					 'no' => 'Нет'];
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OfferScope);
    }
        
    protected $fillable = [
        'name', 'status', 'rating', 'price', 'currency', 'area', 'floor', 'rooms', 'bedroom', 'bathroom', 'text', 'quote', 'address', 'geo_lat', 'geo_lon', 'finish', 'type', 'material_type', 'parking', 'sale_type', 'repair_type', 'windows_view', 'slug', 'seo_title', 'seo_descr', 'src_site', 'src_lot', 'src_tel', 'src_link', 'src_notice', 'publish_terms', 'is_export', 'is_export_ya', 'text_cian', 'bet'
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
            'slug' => [
                'source' => 'sluglot'
            ]
        ];
    }
    
    public function getTypeNameAttribute()
    {
        return self::TYPE[$this->type];
    }
    
    public function getFinishNameAttribute()
    {
        return self::FINISH[$this->finish];
    }
	
	public function getMaterialTypeNameAttribute()
    {
        return self::MATERIAL_TYPE[$this->material_type ];
    }
    
    public function getParkingNameAttribute()
    {
        return self::PARKING[$this->parking];
    }
	
	public function getSecurityNameAttribute()
    {
        return self::SECURITY[$this->security];
    }
    
    public function getSluglotAttribute() {
        return $this->name .' lot '. $this->id;
    }

    public function subway() {
        
        return $this->belongsTo('App\Subway');
        
    }
    public function cat() {
        
        return $this->belongsTo('App\Cat');
        
    }
    public function images(){
        
        return $this->morphMany('App\Image', 'imageable');
        
    }
    public function propertys(){
        
        return $this->morphToMany('App\Property', 'propertyable')->withPivot('property_value');
        
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
