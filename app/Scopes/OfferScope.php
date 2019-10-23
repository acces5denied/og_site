<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use DB;
use Illuminate\Support\Facades\Cache;

class OfferScope implements Scope
{
    
    public function get_currencies() {
        $xml = simplexml_load_file('https://www.cbr-xml-daily.ru/daily.xml');
        $currencies = array();
        foreach ($xml->xpath('//Valute') as $valute) {
            $currencies[(string)$valute->CharCode] = (float)str_replace(',', '.', $valute->Value);
        }

        return $currencies;
    }
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $currencies = Cache::remember('currencies', 3600, function () {
            return $this->get_currencies();
        });
  
        $currencies = Cache::get('currencies');
        
        $rateEur = $currencies['EUR']; // курс EUR к RUB
        $rateUsd = $currencies['USD']; // курс USD к RUB
        $rateEurToUsd = $currencies['EUR']/$currencies['USD']; // курс EUR к USD
        
        return $builder->where('status', 'active')->select("*",
                DB::raw('(CASE 
                            WHEN currency = "RUB" then price
                            WHEN currency = "USD" then FLOOR(price * '.$rateUsd.')
                            WHEN currency = "EUR" then FLOOR(price * '.$rateEur.') 
                        END) AS price_in_rub'),
                DB::raw('(CASE 
                            WHEN currency = "RUB" then FLOOR(price / '.$rateUsd.')
                            WHEN currency = "USD" then price 
                            WHEN currency = "EUR" then FLOOR(price * '.$rateEurToUsd.') 
                        END) AS price_in_usd'),
                DB::raw('(CASE 
                            WHEN currency = "RUB" then FLOOR(price / '.$rateEur.')
                            WHEN currency = "USD" then FLOOR(price / '.$rateEurToUsd.')
                            WHEN currency = "EUR" then price  
                        END) AS price_in_eur'));
    }
}