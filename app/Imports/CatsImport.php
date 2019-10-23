<?php

namespace App\Imports;

use App\Cat;
use App\Subway;
use App\Property;
use App\Repositories\Ahunter;
use Intervention\Image\Facades\Image as ImageInt;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CatsImport implements ToCollection, WithHeadingRow
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
			
			$cat = Cat::create($row->toArray());
                
            $property_cat = [
                'number_of_floors' => 1,
				'year_house' => 2,
                'serial_house' => 3,
				'ceiling_height_house' => 4,
                'passenger_elevators' => 5,
                'freight_elevators' => 6,
                'dist_metro_house' => 7,
            ];
            
            
            foreach($property_cat as $k=>$prop){
                if(!is_null($row[$k])):
                    $cat->propertys()->attach($prop, ['property_value' => $row[$k]]);
                endif;
            }
                
            $response = (new Ahunter($row['address']))->apply();
            if(isset($response)):
                $cat->address = $response['address'];
                $cat->geo_lat = $response['geo_lat'];
                $cat->geo_lon = $response['geo_lon'];
                $subway = $response['subway'];
                $cat->subway()->associate($subway->id);
            endif;
            
            if(!is_null($row['general_img'])):
                $image = $row['general_img'];
                $cat->images()->create(['tag' => 'general', 'url' => $image]);
            endif;
            
            if(!is_null($row['other_img'])):
                $images= explode(';',$row['other_img']);
                foreach($images as $image){
                    
                    $cat->images()->create(['tag' => 'other', 'url' => $image]);
                    
                }
            endif;
			
			//очищяем текст описания от тегов
			if(!is_null($row['text'])):
				$cat->text = strip_tags($row['text']);
			endif;
			
			if(!is_null($row['quote'])):
				$cat->quote = strip_tags($row['quote']);
			else:
				//если нет короткого описания, генерируем его из полного
				if(!is_null($row['text'])):
					$cat->quote = $this->getIndexofFirstPart($cat->text, $index = 200);
				endif;
			endif;
			
			$cat->slug = null;
            
            $cat->save();
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
