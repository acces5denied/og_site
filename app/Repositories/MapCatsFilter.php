<?php

namespace App\Repositories;

use App\Offer;
use App\Subway;
use DB;
use Illuminate\Support\Facades\Cache;

class MapCatsFilter
{
    protected $builder;
    
    const DISTRICTS_FIELDS = ['districts'];
	const TYPE_FIELDS = ['type'];
    const FINISH_FIELDS = ['finish'];
    const PRICE_FIELDS = ['price_from', 'price_to'];
    const AREA_FIELDS = ['area_from', 'area_to'];
    const CURRENCY_FIELDS = ['currency'];

    
    public function __construct($builder,  $request)
    {
        
        $this->builder = $builder;
        $this->request = $request;
        
    }
    
    public function apply()
	{
        $this->addDistrictFields();
		$this->addTypeFields();
        $this->addFinishFields();
        $this->addPriceFields();
        $this->addAreaFields();
        
		return $this->builder;

	}
    
    //фильтр по метро, району и адм. округу
    private function addDistrictFields()
	{
		$value = $this->getDistrictFields();

        $this->builder->when($value, function ($query) use ($value) {

            return $query->where(function ($query) use ($value) {
                
                $query->whereHas('subway', function ($query) use ($value) {

                    $query->whereIn('slug_subway', $value)->orWhereIn('slug_district', $value)->orWhereIn('slug_area', $value);
                
                });
                
            });
        });
	}
    private function getDistrictFields(): array
	{
		return array_flatten(array_intersect_key($this->request, array_flip(self::DISTRICTS_FIELDS)));

	}
    //** END **//
	
	//фильтр по типу недвижимости
    private function addTypeFields()
	{
		$value = $this->getTypeFields();
		
		$this->builder->when($value, function ($query) use ($value) {
            
            $query->whereHas('offers', function ($query) use ($value) {
            
                $query->where('type', $value);
                
            });

        });

	}
    private function getTypeFields(): array
	{
		return array_flatten(array_intersect_key($this->request, array_flip(self::TYPE_FIELDS)));

	}
    //** END **//
    
    //фильтр по отделки
    private function addFinishFields()
    {
        $value = $this->getFinishFields();
		
		$this->builder->when($value, function ($query) use ($value) {
            
            $query->whereHas('offers', function ($query) use ($value) {
            
                $query->where('finish', $value);
                
            });

        });
    }
    private function getFinishFields(): array
	{
		return array_flatten(array_intersect_key($this->request, array_flip(self::FINISH_FIELDS)));

	}
    //** END **//
    
    //фильтр по цене
    private function addPriceFields()
    {
            
        $value = $this->getPriceFields();

        $this->builder->when($value, function ($query) use ($value) {
                
            $query->whereHas('offers', function ($query) use ($value) {

                $query->where(function ($query) use ($value) {

                    $query->where('currency', 'RUB')->whereBetween('price', [(int)round($value[0]), (int)round($value[1])]);

                })->orWhere(function ($query) use ($value) {

                    $query->where('currency', 'USD')->whereBetween('price', [(int)round($value[2]), (int)round($value[3])]);

                })->orWhere(function ($query) use ($value) {

                    $query->where('currency', 'EUR')->whereBetween('price', [(int)round($value[4]), (int)round($value[5])]);

                });
                
            });

        });

    }
    private function getPriceFields(): array
	{
        $currency = $this->getCurrencyFields();

        $price = array_intersect_key($this->request, array_flip(self::PRICE_FIELDS));
        
        $currencies = Cache::get('currencies');
        $rateEur = $currencies['EUR']; // курс EUR к RUB
        $rateUsd = $currencies['USD']; // курс USD к RUB
        $rateEurToUsd = $currencies['EUR']/$currencies['USD']; // курс EUR к USD
        
        if(!empty($price)){
            if(!empty($currency) && $currency[0] == 'USD'){
                $valRub = [$price[self::PRICE_FIELDS[0]]*$rateUsd, $price[self::PRICE_FIELDS[1]]*$rateUsd];
                $valUsd = [$price[self::PRICE_FIELDS[0]]*1, $price[self::PRICE_FIELDS[1]]*1];
                $valEur = [$price[self::PRICE_FIELDS[0]]/$rateEurToUsd, $price[self::PRICE_FIELDS[1]]/$rateEurToUsd];
            }elseif(!empty($currency) && $currency[0] == 'EUR'){
                $valRub = [$price[self::PRICE_FIELDS[0]]*$rateEur, $price[self::PRICE_FIELDS[1]]*$rateEur];
                $valUsd = [$price[self::PRICE_FIELDS[0]]*$rateEurToUsd, $price[self::PRICE_FIELDS[1]]*$rateEurToUsd];
                $valEur = [$price[self::PRICE_FIELDS[0]]*1, $price[self::PRICE_FIELDS[1]]*1];
            }else{
                $valRub = [$price[self::PRICE_FIELDS[0]]*1, $price[self::PRICE_FIELDS[1]]*1];
                $valUsd = [$price[self::PRICE_FIELDS[0]]/$rateUsd, $price[self::PRICE_FIELDS[1]]/$rateUsd];
                $valEur = [$price[self::PRICE_FIELDS[0]]/$rateEur, $price[self::PRICE_FIELDS[1]]/$rateEur];
            }
            return array_merge($valRub, $valUsd, $valEur);
        }else{
            return array_intersect_key($this->request, array_flip(self::PRICE_FIELDS));
        }
	}
    private function getCurrencyFields(): array
	{
		return array_flatten(array_intersect_key($this->request, array_flip(self::CURRENCY_FIELDS)));

	}
    //** END **//
    
    //фильтр по площади
    private function addAreaFields()
    {
        $value = $this->getAreaFields();
        
        $this->builder->when($value, function ($query) use ($value) {
            
            $query->whereHas('offers', function ($query) use ($value) {
            
                return $query->whereBetween('area', [$value[self::AREA_FIELDS[0]], $value[self::AREA_FIELDS[1]]]);
                
            });

        });
    }
    private function getAreaFields(): array
	{
		return array_intersect_key($this->request, array_flip(self::AREA_FIELDS));
	}
    //** END **//
    
}
