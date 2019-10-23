<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Offer;
use Intervention\Image\Facades\Image as ImageInt;

class CianController extends Controller
{
    private
    $_curl = null,
    $_dictionaries = array();
    
    public function index() {
        
        $offers = Offer::All()->where('is_export', 1);

        $feedXML = new \SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><feed></feed>");
        $feedXML->addChild('feed_version', '2');

        foreach($offers as $offer){
            
            $data = $this->getDataFlatSale($offer);
            
            $object = $feedXML->addChild('object');
            
            $this->getChild($data, $object);
            
        }

        Header('Content-type: text/xml');

        $feedXML->asXML(public_path('export_xml/') . 'cian.xml');


    }
    
    public function getChild($data, $object) {

        foreach ($data as $k=>$value) {
            if (is_array($value)){
                        
                if(is_int($k)){
                    $this->getChild($value, $object);
                } else {
                    $this->getChild($value, $object->addChild($k));    
                }
                    
            } 
            else{
                $object->addChild($k, $value);
            }
        }
        
    }

    
    public function getDataFlatSale(Offer $offer) {

        //Категория объявления
        $data['Category'] = 'flatSale';
        //Условия размещения объявления
            //free — Бесплатное 
            //highlight — Выделение цветом 
            //paid — Платное 
            //premium — Премиум-объявление 
            //top3 — Топ 3
        $data['Terms']['PublishTermSchema']['Services']['ServicesEnum'] = $offer->publish_terms;
        //Заголовок объявления. Отображается только для объявлений Премиум и ТОП3. Максимальная длина - 33 символа. Минимальная - 8 символов без знаков препинания и пробелов. (String)
        if(($offer->publish_terms == 'premium' || $offer->publish_terms == 'top3') && $offer->text_cian){
            $data['Title'] = $offer->text_cian;
        }
        //Ставка на объявление в аукционе (Double)
        if($offer->bet){
            $data['Action']['Bet'] = $offer->bet;
        }

        //Внешний Id объявления (String)
        $data['ExternalId'] = $offer->id;
        //Текст объявления (String)
        $data['Description'] = htmlspecialchars($offer->text);
        //Адрес объявления (String)
        $data['Address'] = $offer->address;
        //Широта (Double)
        $data['Coordinates']['Lat'] = $offer->geo_lat;
        //Долгота (Double)
        $data['Coordinates']['Lng'] = $offer->geo_lon;
        //Код страны (String)
        $data['Phones']['PhoneSchema']['CountryCode'] = '+7';
        //Телефон Номер (String)
        $data['Phones']['PhoneSchema']['Number'] = '4951101020';

        //Метро ID
        if($offer->subway->city_subway){
            $data['Undergrounds']['UndergroundInfoSchema']['Id'] = $this->getDictionary($offer->subway->city_subway);
        }

        //Изображения
        if($offer->images){
            $images = $offer->images;
            $dir = 'http://'.$_SERVER['SERVER_NAME'].'/images/large/';
            
            foreach ($images as $image) {
                if($image->tag == 'plan'){
                    //Планировка
                    $data['LayoutPhoto']['FullUrl'] = $dir . $image->url;
                    $data['LayoutPhoto']['IsDefault'] = 'false';
                }elseif($image->tag == 'general'){
                    $data['Photos'][] = array('PhotoSchema' => array(
                        'FullUrl'   => $dir . $image->url,
                        'IsDefault' => 'true',
                    ));
                }elseif($image->tag == 'other'){
                    $data['Photos'][] = array('PhotoSchema' => array(
                        'FullUrl'   => $dir . $image->url,
                        'IsDefault' => 'false',
                    ));
                }
            }
        }
        
        //Количество комнат  (Int32)
        if ($v = $offer->rooms) {
            if ($v > 5){
                $v = 6;
            };
          $data['FlatRoomsCount'] = $v;
        }
        //Апартаменты (Boolean)
        if ($offer->type == 'apartment') {
          $data['IsApartments'] = 'true';
        }
        //Пентхаус (Boolean)
        if ($offer->type == 'penthouse') {
          $data['IsPenthouse'] = 'true';
        }
        //Общая площадь, м² (Double)
        $data['TotalArea'] = $offer->area;
        //Этаж (Int64)
        if(!is_null($offer->floor)){
            $data['FloorNumber'] = $offer->floor;
        }
        
        //Информация о здании
        if($offer->cat){
            
            //Название (String)
            $data['Building']['Name'] = htmlspecialchars($offer->cat->name);
            //Количество этажей в здании (Int64)
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 1)->first())){
                $data['Building']['FloorsCount'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value;
            }
            //Год постройки (Int64)
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 2)->first())){
                $data['Building']['BuildYear'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value;
            }
            //Тип дома: 
                //aerocreteBlock — Газобетонный блок 
                //block — Блочный 
                //boards — Щитовой 
                //brick — Кирпичный 
                //foamConcreteBlock — Пенобетонный блок 
                //gasSilicateBlock — Газосиликатный блок 
                //monolith — Монолитный 
                //monolithBrick — Монолитно-кирпичный 
                //old — Старый фонд 
                //panel — Панельный 
                //stalin — Сталинский 
                //wireframe — Каркасный 
                //wood — Деревянный
            if($offer->cat->material_type){
                $data['Building']['MaterialType'] = $offer->cat->material_type;
            }
            //Серия дома (String)
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 3)->first())){
                $data['Building']['Series'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 3)->first()->property_value;
            }
            //Высота потолков, м (Double)
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 4)->first())){
                $data['Building']['CeilingHeight'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value;
            }
            //Количество пассажирских лифтов (Int64)
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 5)->first())){
                $data['Building']['PassengerLiftsCount'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 5)->first()->property_value;
            }
            //Количество грузовых лифтов (Int64)
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 6)->first())){
                $data['Building']['CargoLiftsCount'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 6)->first()->property_value;
            }
            //Парковка
            //Type	Тип парковки: 
                //ground — Наземная 
                //multilevel — Многоуровневая 
                //open — Открытая 
                //roof — На крыше 
                //underground — Подземная 
            if($offer->cat->parking){
                $data['Building']['Parking']['Type'] = $offer->cat->parking;
            }
            
            //ЖК
            //Название ЖК (String)
            $jk_name = isset($data['Building']['Name']) ? $data['Building']['Name'] : null;

            //ID ЖК в базе CIAN (обязательно для квартир в новостройке) (Int32)
            if (!empty($jk_name) && ($v = $this->getJKId($jk_name))) {
              $data['JKSchema']['Name'] = $data['Building']['Name'];
              $data['JKSchema']['Id'] = $v;

            }
            
        }else{
           
            //Количество этажей в здании (Int64)
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 1)->first())){
                $data['Building']['FloorsCount'] = $offer->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value;
            }
            //Год постройки (Int64)
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 2)->first())){
                $data['Building']['BuildYear'] = $offer->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value;
            }
            //Тип дома: 
                //aerocreteBlock — Газобетонный блок 
                //block — Блочный 
                //boards — Щитовой 
                //brick — Кирпичный 
                //foamConcreteBlock — Пенобетонный блок 
                //gasSilicateBlock — Газосиликатный блок 
                //monolith — Монолитный 
                //monolithBrick — Монолитно-кирпичный 
                //old — Старый фонд 
                //panel — Панельный 
                //stalin — Сталинский 
                //wireframe — Каркасный 
                //wood — Деревянный
            if($offer->material_type){
                $data['Building']['MaterialType'] = $offer->material_type;
            }
            //Серия дома (String)
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 3)->first())){
                $data['Building']['Series'] = $offer->propertys->pluck('pivot')->where('property_id', 3)->first()->property_value;
            }
            //Высота потолков, м (Double)
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 4)->first())){
                $data['Building']['CeilingHeight'] = $offer->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value;
            }
            //Количество пассажирских лифтов (Int64)
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 5)->first())){
                $data['Building']['PassengerLiftsCount'] = $offer->propertys->pluck('pivot')->where('property_id', 5)->first()->property_value;
            }
            //Количество грузовых лифтов (Int64)
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 6)->first())){
                $data['Building']['CargoLiftsCount'] = $offer->propertys->pluck('pivot')->where('property_id', 6)->first()->property_value;
            }
            //Парковка
            //Type	Тип парковки: 
                //ground — Наземная 
                //multilevel — Многоуровневая 
                //open — Открытая 
                //roof — На крыше 
                //underground — Подземная 
            if($offer->parking){
                $data['Building']['Parking']['Type'] = $offer->parking;
            }
            
        }
        
        //Площадь комнат, м². + для обозначения смежных комнат, - для раздельных комнат. (String)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 8)->first())){
            $data['AllRoomsArea'] = $offer->propertys->pluck('pivot')->where('property_id', 8)->first()->property_value;
        }
        //Жилая площадь, м² (Double)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 9)->first())){
            $data['LivingArea'] = $offer->propertys->pluck('pivot')->where('property_id', 9)->first()->property_value;
        }
        //Площадь кухни, м² (Double)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 10)->first())){
            $data['KitchenArea'] = $offer->propertys->pluck('pivot')->where('property_id', 10)->first()->property_value;
        }
        //Количество лоджий (Int64)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 11)->first())){
            $data['LoggiasCount'] = $offer->propertys->pluck('pivot')->where('property_id', 11)->first()->property_value;
        }
        //Количество балконов (Int64)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 12)->first())){
            $data['BalconiesCount'] = $offer->propertys->pluck('pivot')->where('property_id', 12)->first()->property_value;
        }
        //Куда выходят окна: 
            //street — На улицу 
            //yard — Во двор 
            //yardAndStreet — На улицу и двор
        if($offer->windows_view){
            $data['WindowsViewType'] = $offer->windows_view;
        }
        //Количество раздельных санузлов (Int64)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 13)->first())){
            $data['SeparateWcsCount'] = $offer->propertys->pluck('pivot')->where('property_id', 13)->first()->property_value;
        }
        //Количество совместных санузлов (Int64)
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 14)->first())){
            $data['CombinedWcsCount'] = $offer->propertys->pluck('pivot')->where('property_id', 14)->first()->property_value;
        }
        //Тип ремонта: 
            //cosmetic — Косметический 
            //design — Дизайнерский 
            //euro — Евроремонт 
            //no — Без ремонта
        if($offer->repair_type){
            $data['RepairType'] = $offer->repair_type;
        }
        
        
        //Условия сделки
        //Цена (Double)
        $data['BargainTerms']['Price'] = $offer->price;
        //Валюта: 
            //eur — Евро 
            //rur — Рубль (по умолчанию) 
            //usd — Доллар
        if($offer->currency == 'RUB'){
            $data['BargainTerms']['Currency'] = 'rur';
        }else{
            $data['BargainTerms']['Currency'] = $offer->currency;
        }
        //Тип продажи: 
            //alternative — Альтернатива 
            //free — Свободная продажа
        $data['BargainTerms']['SaleType'] = $offer->sale_type;
        
        return ($data);
    }
    
    private function getJKId($name)
    {
        $name = mb_strtolower($name);
        
        if (!isset($this->_dictionaries['jk'])) {
            $this->_dictionaries['jk'] = include sprintf('%s/export_xml/jk.php', public_path('/'));
        }

        if (array_key_exists($name, $this->_dictionaries['jk'])) {
            return $this->_dictionaries['jk'][$name];
        }


        $url  = 'https://www.cian.ru/addform/v2/jks/?term='.urlencode($name);
		
        $curl = $this->getCurl();
        curl_setopt($curl, CURLOPT_URL, $url);

        $response = curl_exec($curl);

        $data = json_decode($response, true);
        foreach ($data['data']['jks'] as $v) {
          if ($v['geo']['cityName'] == 'Москва') {
            $this->_dictionaries['jk'][mb_strtolower($v['name'])] = $v['id'];
          }
        }
        if (array_key_exists($name, $this->_dictionaries['jk'])) {
          return $this->_dictionaries['jk'][$name];
        }
        elseif (count($data['data']['jks']) == 1) {
          $this->_dictionaries['jk'][$name] = $data['data']['jks'][0]['id'];
          return $this->_dictionaries['jk'][$name];
        }
        elseif (array_key_exists(sprintf('жк «%s»', $name), $this->_dictionaries['jk'])) {
          $this->_dictionaries['jk'][$name] = $this->_dictionaries['jk'][sprintf('жк «%s»', $name)];
          return $this->_dictionaries['jk'][$name];
        }
        else {
          $this->_dictionaries['jk'][$name] = null;
        }

        return null;
    }
    
    private function getCurl()
    {
        if (is_null($this->_curl)) {
          $this->_curl = curl_init();
          curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, true);
        }

        return $this->_curl;
    } 
    
    private function getDictionary($dictionary)
    {

        if (!isset($this->_dictionaries[$dictionary])) {

              $url  = sprintf('https://www.cian.ru/metros-moscow.xml');
              $curl = $this->getCurl();
              curl_setopt($curl, CURLOPT_URL, $url);
              if (!$response = curl_exec($curl)) {
                throw new Exception(sprintf('curl response fail: "%s"', $url));
              }

              $xml = simplexml_load_string($response);

              foreach ($xml as $e) {
                if($dictionary == $e->__toString()){
                    $this->_dictionaries[$dictionary][mb_strtolower($e->__toString())] = (integer) $e['id'];
                }
                
              }
        }
        
        return current($this->_dictionaries[$dictionary]);
    }

}
