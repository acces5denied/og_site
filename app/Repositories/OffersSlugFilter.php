<?php

namespace App\Repositories;

use App\Subway;
use App\Offer;


class OffersSlugFilter
{
    protected $builder;
    
    const ORDER_FIELDS = ['sort', 'sort_type'];
    
    public function __construct($builder, $request, $val1, $val2,  $val3)
    {
        
        $this->builder = $builder;  
        $this->request = $request;
        $this->val1 = $val1;
        $this->val2 = $val2;
        $this->val3 = $val3;
        $this->district = null;
        $this->type = null;
        $this->finish = null;
        $this->arrayUrl = array($val1, $val2, $val3);
        $subways = Subway::all();
        $city_subways = $subways->pluck('slug_subway');
        $city_districts = $subways->pluck('slug_district');
        $city_areas = $subways->pluck('slug_area');
        $this->districts = $city_subways->merge($city_districts)->merge($city_areas);
        $this->types = collect(['eliteflat', 'apartment', 'penthouse', 'townhouse']);
        $this->finishes = collect(['bez-otdelki', 's-otdelkoj']);

    }
    
    public function apply()
    {
        
        foreach ($this->urls() as $url){
            if($this->districts->contains($url)){
                $this->district = $this->val1;
                $this->district($url);
            }
            if($this->types->contains($url)){
                if(is_null($this->district)){
                    $this->type = $this->val1;    
                }else{
                    $this->type = $this->val2;
                }
                $this->type($url);
            }
            if($this->finishes->contains($url)){
                if(is_null($this->district) && is_null($this->type)){
                    $this->finish = $this->val1;
                }elseif(!is_null($this->district) && !is_null($this->type)){
                    $this->finish = $this->val3;
                }else{
                    $this->finish = $this->val2;
                }
                $this->finish($url);
            }
        }
        
        $this->addOrderFields();
		
		return $this->builder->orderBy('id', 'desc');
    }

    //сортировка
    private function addOrderFields()
	{
		$orderFields = $this->getOrderFields();
        
        $sortItems = [
            'price_in_rub',
            'area',
            'rating',
            'id'
        ];

		if (isset($orderFields[self::ORDER_FIELDS[0]]) && in_array($orderFields[self::ORDER_FIELDS[0]], $sortItems)) {
			$this->builder->orderBy(
                    $orderFields[self::ORDER_FIELDS[0]],
                    $orderFields[self::ORDER_FIELDS[1]] ?? 'asc'
                );
        } 
        
	}
    private function getOrderFields(): array
	{
		return array_intersect_key($this->request, array_flip(self::ORDER_FIELDS));
	}
    
    public function district($value)
    {
        $this->builder->when($value, function ($query) use ($value) {

            $query->whereHas('subway', function ($query) use ($value) {
                $query->where('slug_subway', $value)->orWhere('slug_district', $value)->orWhere('slug_area', $value);
            });
            
        });
    }
    
    public function type($value)
    {
       $this->builder->when($value, function ($query) use ($value) {
            $query->where('type', $value);
        });
        
    }
    
    public function finish($value)
    {
        $this->builder->when($value, function ($query) use ($value) { 
            $query->where('finish', $value);
        });
        
    }
    
    public function urls()
    {
        return $this->arrayUrl;
    }
}
