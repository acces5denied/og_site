<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
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
	
    protected $fillable = [
        'name', 'status', 'image', 'text', 'quote', 'slug', 'is_top', 'seo_title', 'seo_descr'
    ];
	
	public function getSluglotAttribute() {
        return $this->name .'-news-'.$this->id;
    }
	

}
