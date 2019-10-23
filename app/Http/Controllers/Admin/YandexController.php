<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Offer;
use Intervention\Image\Facades\Image as ImageInt;


class YandexController extends Controller
{
    const DATE_FORMAT   = 'Y-m-d\TH:i:s+03:00';

    
    public function index() {
        
        $offers = Offer::All()->where('is_export_ya', 1);

        $feedXML = new \SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><realty-feed></realty-feed>");
        $feedXML->addAttribute('xmlns', 'http://webmaster.yandex.ru/schemas/feed/realty/2010-06');
        $feedXML->addChild('generation-date', date(self::DATE_FORMAT));

        foreach($offers as $offer){
            
            $data = $this->getDataFlatSale($offer);

            $object = $feedXML->addChild('offer');
            
            $this->getChild($data, $object);
            
            $object->addAttribute('internal-id', $offer->id);
            
        }

        Header('Content-type: text/xml');

        $feedXML->asXML(public_path('export_xml/') . 'yandex.xml');


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

        //Тип сделки
        $data['type'] = 'продажа';
        //Тип недвижимости
        $data['property-type'] = 'жилая';
        //Категория объекта 
        $data['category'] = 'квартира';
        //URL страницы с объявлением
        $data['url'] = route('frontend.offers.show', array($offer->slug));
        //Дата создания объявления, указывается в формате YYYY-MM-DDTHH:mm:ss+00:00
        $data['creation-date'] = self::getLotCreationDate($offer);
        //Страна, в которой расположен объект 
        $data['location']['country'] = 'Россия';
        //Название субъекта РФ, необязательный элемент для объектов в Москве и Санкт-Петербурге
        $data['location']['region'] = 'Москва';
        //Название населенного пункта 
        $data['location']['locality-name'] = 'Москва';
        //Район населенного пункта
        $data['location']['sub-locality-name'] = $offer->subway->city_district;
        //Адрес объекта (улица и номер здания) 
        $data['location']['address'] = mb_substr($offer->address, mb_strpos($offer->address, 'ул'));
        //Географическая широта 
        $data['location']['latitude'] = $offer->geo_lat;
        //Географическая долгота    
        $data['location']['longitude'] = $offer->geo_lon;
        //Название станции метро 
        $data['metro']['name'] = $offer->subway->city_subway;
         
        //Информация о продавце 
        //Для агентств недвижимости обязательно должны быть указаны прямые номера агентов
        $data['sales-agent']['phone'] = '+74951234567';
        //Тип продавца или арендодателя 
        $data['sales-agent']['category'] = 'агентство';
        //Название организации 
        $data['sales-agent']['organization'] = 'OGHome';
        //Сайт агентства или застройщика 
        $data['sales-agent']['url'] = url('/');
        //Ссылка на фотографию агента или логотип компании 
        $data['sales-agent']['photo'] = url('/assets/images/logo.png');
         
        //Информация об условиях сделки
        $data['price']['value'] = $offer->price;
        $data['price']['currency'] = $offer->currency;
        //Тип сделки
        if($offer->cat){
            $data['deal-status'] = $offer->cat->deadline_year ? 'первичная продажа' : 'первичная продажа вторички';
        }else{
            $data['deal-status'] = 'первичная продажа вторички';
        }
        //Пометка «Просьба агентам не звонить» 
        $data['not-for-agents'] = 'true';
         
        //Информация об объекте
        $data['area']['value'] = $offer->area;
        //Единица площади помещения
        $data['area']['unit'] = 'кв. м';
        //Жилая площадь 
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 9)->first())){
            $data['living-space']['value'] = $offer->propertys->pluck('pivot')->where('property_id', 9)->first()->property_value;
            $data['living-space']['unit'] = 'кв. м';
        }
        //Площадь кухни 
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 10)->first())){
            $data['kitchen-space']['value'] = $offer->propertys->pluck('pivot')->where('property_id', 10)->first()->property_value;
            $data['kitchen-space']['unit'] = 'кв. м';
        }
        //Фотографии планировок следует передавать первым тегом image
        if($offer->images){
            $images = $offer->images->reverse();

            $dir = url('/images/large/');
            
            foreach ($images as $image) {

                $data[] = array('image' => $dir .'/'. $image->url);

            }
        }
        //Тип ремонта: 
        if($offer->repair_type == 'cosmetic'){
            $data['renovation'] = 'частичный ремонт';
        }elseif($offer->repair_type == 'design'){
            $data['renovation'] = 'дизайнерский';
        }elseif($offer->repair_type == 'euro'){
            $data['renovation'] = 'евро';
        }elseif($offer->repair_type == 'no'){
            $data['renovation'] = 'требует ремонта';
        }
        //Дополнительная информация
        if($offer->text){
            $data['description'] = htmlspecialchars($offer->text);
        } 
         
        //Описание жилого помещения
        //Общее количество комнат в квартире
        $data['rooms'] = $offer->rooms;
        //Количество комнат, участвующих в сделке
        $data['rooms-offered'] = $offer->rooms;
        //Этаж
		if(!is_null($offer->floor)){
            $data['floor'] = $offer->floor;
        }
        //Апартаменты
        if ($offer->type == 'apartment') {
          $data['apartments'] = 'true';
        } 
        //Вид из окон
        if($offer->windows_view == 'street'){
            $data['window-view'] = 'на улицу';
        }elseif($offer->windows_view == 'yard'){
            $data['window-view'] = 'во двор';
        }
        //тип балкона (рекомендуемые значения — «балкон», «лоджия», «2 балкона», «2 лоджии»)
        if ($v = self::getLotBalconies($offer)) {
            $data['balcony'] = $v;
        }
         
        //Описание здания
        //Информация о здании
        if($offer->cat){
            
            //Название ЖК
            $data['building-name'] = htmlspecialchars($offer->cat->name);
            //Количество этажей в здании
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 1)->first())){
                $data['floors-total'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value;
            }
            //Год постройки
            if($offer->cat->deadline_year){
                $data['built-year'] = $offer->cat->deadline_year;
            }elseif(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 2)->first())){
                $data['built-year'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value;
            }
            //Тип дома: 
            if($offer->cat->material_type == 'block'){
                $data['building-type'] = 'блочный';
            }elseif($offer->cat->material_type == 'brick'){
                $data['building-type'] = 'кирпичный';
            }elseif($offer->cat->material_type == 'monolithBrick'){
                $data['building-type'] = 'кирпично-монолитный';
            }elseif($offer->cat->material_type == 'monolith'){
                $data['building-type'] = 'монолит';
            }elseif($offer->cat->material_type == 'panel'){
                $data['building-type'] = 'панельный';
            }
            //Высота потолков, м
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 4)->first())){
                $data['ceiling-height'] = $offer->cat->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value;
            }
            //Лифт
            if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 5)->first()) 
               || !is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 6)->first())){
                $data['lift'] = 'true';
            }
            //Наличие охраняемой парковки
            if($offer->cat->parking != 'open'){
                $data['parking'] = 'true';
            }
            //Элитная недвижимость
            $data['is-elite'] = 'true';
            
        }else{
            
            //Количество этажей в здании
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 1)->first())){
                $data['floors-total'] = $offer->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value;
            }
            //Год постройки
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 2)->first())){
                $data['built-year'] = $offer->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value;
            }
            //Тип дома: 
            if($offer->material_type == 'block'){
                $data['building-type'] = 'блочный';
            }elseif($offer->material_type == 'brick'){
                $data['building-type'] = 'кирпичный';
            }elseif($offer->material_type == 'monolithBrick'){
                $data['building-type'] = 'кирпично-монолитный';
            }elseif($offer->material_type == 'monolith'){
                $data['building-type'] = 'монолит';
            }elseif($offer->material_type == 'panel'){
                $data['building-type'] = 'панельный';
            }
            //Высота потолков, м
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 4)->first())){
                $data['ceiling-height'] = $offer->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value;
            }
            //Лифт
            if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 5)->first()) 
               || !is_null($offer->propertys->pluck('pivot')->where('property_id', 6)->first())){
                $data['lift'] = 'true';
            }
            //Наличие охраняемой парковки
            if($offer->parking != 'open'){
                $data['parking'] = 'true';
            }
            //Элитная недвижимость
            $data['is-elite'] = 'true';
            
        }
        
         
        return ($data);
         
     }
    
    protected static function getLotCreationDate(Offer $offer)
    {
        $date = strtotime($offer->created_at) > 0 ? strtotime($offer->created_at) : strtotime('yesterday');
        return date(static::DATE_FORMAT, $date);
    }
    
    protected static function getLotBalconies(Offer $offer)
    {
        $data = array();
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 12)->first())){
            if (($v = $offer->propertys->pluck('pivot')->where('property_id', 12)->first()->property_value)) {
              $data[] = ($v > 1) ? $v.' балкона' : 'балкон'; 
            }
        }
        if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 11)->first())){
            if (($v = $offer->propertys->pluck('pivot')->where('property_id', 11)->first()->property_value)) {
              $data[] = ($v > 1) ? $v.' лоджии' : 'лоджия';
            }
        }

        return !empty($data) ? implode(' и ', $data) : null;
    }
    

}
