<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Subway;


class Ahunter
{
    protected $builder;
    
    //URL-команды
    const URI = 'https://ahunter.ru/site/cleanse/address';
    
    //API-токен пользователя из личного кабинета
	const USER = 'tsyganokvugFIOHt9AhQvbwjSJvWD9';
    
    //json или xml - формат, в котором требуется вернуть результат обработки.
    //ageo - включает в ответ сервиса географические координаты обработанного почтового адреса
    //apretty - включает в ответ сервиса строку с "красивым" и правильным написанием адреса.
    //aareas - при использовании данной опции для успешно обработанного адреса сервис будет возвращать информацию о принадлежности адреса району и административному округу города, а также окружной кольцевой дороге.
    //astations - при использовании данного параметра для успешно обработанного адреса сервис возвращает ближайшие станции метро и станции скоростного легкорельсового транспорта.
    const OUTPUT = 'json|ageo|apretty|aareas|astations';
    
    public function __construct($request)
    {

        $this->request = $request;
        
    }
    
    
    public function apply() {

        $address = new \GuzzleHttp\Client();

//        $query=urlencode('воронежская ул 38/43');

        $response = $address->request('POST', self::URI, [
                                                            'query'=>[
                                                                'user'=>self::USER,
                                                                'output'=>self::OUTPUT,
                                                                'query'=>$this->request,
                                                                'afilter'=>'Москва',
                                                            ]
                                                        ]
        );
		
		
        
        $subways = Subway::all();
        
        $response = json_decode($response->getBody()->getContents());
        
        if(!isset($response->check_info->status)):
            
            $response = $response->addresses[0];

            $subway_name = $response->stations[0]->name;
        
            $subway_dist = $response->stations[0]->dist;

            $data = [
                'city_subway' => $subway_name,
                'city_district' => $response->areas->admin_area->name,
                'city_area' => $response->areas->admin_okrug->name,
            ];

            if(!$subways->contains('city_subway', $subway_name) && isset($subway_name)):

                $subway = Subway::create($data);

            elseif(isset($subway_name)):
                foreach ($subways as $sub){
                    if($sub->city_subway == $subway_name): 
                       $subway = $sub;
                    endif;
                }
            else:
                $subway = NULL;
                $subway_dist = NULL;
            endif;

            $data_address = [
                'address' => str_replace('г Москва, ','',$response->pretty),
                'geo_lat' => $response->geo_data->mid->lat,
                'geo_lon' => $response->geo_data->mid->lon,
                'subway' => $subway,
                'subway_dist' => $subway_dist,
            ];

            return $data_address;

        endif;

    }
 
   
}
