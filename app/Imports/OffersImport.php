<?php

namespace App\Imports;

use App\Offer;
use App\Cat;
use App\Subway;
use App\Property;
use App\Repositories\Ahunter;
use Intervention\Image\Facades\Image as ImageInt;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class OffersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {

            $offer = Offer::create($row->toArray());
 
            $property_cat = [
                'number_of_floors' => 1,
				'year_house' => 2,
                'serial_house' => 3,
				'ceiling_height_house' => 4,
                'passenger_elevators' => 5,
                'freight_elevators' => 6,
                'dist_metro_house' => 7,
            ];
            
            $property_offer = [
                'area_rooms_offer' => 8,
                'living_area_offer' => 9,
                'kitchen_area_offer' => 10,
                'loggias_offer' => 11,
                'balconies_offer' => 12,
				'separate_bathrooms_offer' => 13,
				'shared_bathrooms_offer' => 14,
				'ceiling_height_offer' => 15,
            ];
            
            foreach($property_offer as $k=>$prop){
                if(!is_null($row[$k])):
                    $offer->propertys()->attach($prop, ['property_value' => $row[$k]]);
                endif;
            }
            
            if(!is_null($row['cat_id'])):
                
                $offer->cat()->associate($row['cat_id']);
                $offer->address = $offer->cat->address;
                $offer->geo_lat = $offer->cat->geo_lat;
                $offer->geo_lon = $offer->cat->geo_lon;
                $offer->subway()->associate($offer->cat->subway_id);
				$offer->parking = $offer->cat->parking;
				$offer->material_type = $offer->cat->material_type;
            
            else:
			
				$offer->parking = $row['parking'];
				$offer->material_type = $row['material_type'];
                
                foreach($property_cat as $k=>$prop){
                    if(!is_null($row[$k])):
                        $offer->propertys()->attach($prop, ['property_value' => $row[$k]]);
                    endif;
                }
                
                $response = (new Ahunter($row['address']))->apply();
                if(isset($response)):
                    $offer->address = $response['address'];
                    $offer->geo_lat = $response['geo_lat'];
                    $offer->geo_lon = $response['geo_lon'];
                    $subway = $response['subway'];
                    $offer->subway()->associate($subway->id);
                endif;

            endif;
			
			//генерируем название
			if($row['type'] == 'eliteflat'):
				if(!is_null($row['cat_id'])):
					$offer->name = $row['rooms'].'-комн. квартира, '.$row['area'].'м² в '.$offer->cat->name;
				else:
					$offer->name = $row['rooms'].'-комн. квартира, '.$row['area'].'м²'. (!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			elseif($row['type'] == 'apartment'):
				if(!is_null($row['cat_id'])):
					$offer->name = 'Апартаменты, '.$row['area'].'м² в '.$offer->cat->name;
				else:
					$offer->name = 'Апартаменты, '.$row['area'].'м²'. (!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			elseif($row['type'] == 'penthouse'):
				if(!is_null($row['cat_id'])):
					$offer->name = 'Пентхаус, '.$row['area'].'м² в '.$offer->cat->name;
				else:
					$offer->name = 'Пентхаус, '.$row['area'].'м²'. (!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			elseif($row['type'] == 'townhouse'):
				if(!is_null($row['cat_id'])):
					$offer->name = 'Таунхаус, '.$row['area'].'м² в '.$offer->cat->name;
				else:
					$offer->name = 'Таунхаус, '.$row['area'].'м²'. (!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			endif;
            
            if(!is_null($row['general_img'])):
                $image = $row['general_img'];
                $offer->images()->create(['tag' => 'general', 'url' => $image]);
            endif;
            
            if(!is_null($row['other_img'])):
                $images= explode(';',$row['other_img']);
                foreach($images as $image){
                    
                    $offer->images()->create(['tag' => 'other', 'url' => $image]);
                    
                }
            endif;
            
            if(!is_null($row['plan_img'])):
                $images= explode(';',$row['plan_img']);
                foreach($images as $image){
                    
                    $offer->images()->create(['tag' => 'plan', 'url' => $image]);
                    
                }
            endif;
			
			//очищяем текст описания от тегов
			if(!is_null($row['text'])):
				$offer->text = strip_tags($row['text']);
			endif;
			
			if(!is_null($row['quote'])):
				$offer->quote = strip_tags($row['quote']);
			else:
				//если нет короткого описания, генерируем его из полного
				if(!is_null($row['text'])):
					$offer->quote = $this->getIndexofFirstPart($offer->text, $index = 200);
				endif;
			endif;
			
			$offer->slug = null;
            
            $offer->save();

        }
        
    }
	
	private function getText($text, $index) {
		
		$text = mb_substr($text, 0, $index);
		
		return $text;
		
	} 
	
	private function getIndexofFirstPart($text, $index) {
		//массив на проверку заглавной буквы
		$alph = ['А','Б','В','Г','Д','Е','Ё','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'];
		
		//если длинна текста больше разбиваемого куска
		if(mb_strwidth($text) > $index){
			//определяем индекс первого символа вхождения
			$index = mb_strpos($text, '. ', $index)+2;
			//определяем символ вхождения
			$letter = mb_substr($text, $index, 1);

			//сравниваем символ с массивом заглавных букв
			if(in_array($letter, $alph)){
				//если буква заглавная возвращаем ее индекс в тексте
				return $this->getText($text, $index);
			}else{
				return $this->getIndexofFirstPart($text, $index);
			}
		}else{
			return $this->getText($text, $index);
		} 
    }

}
