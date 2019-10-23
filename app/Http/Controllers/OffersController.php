<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Cat;
use App\Subway;
use App\Image;
use App\Repositories\OffersFilter;
use App\Repositories\OffersSlugFilter;
use SEO;

class OffersController extends Controller
{
	const SEO = ['' => '',
				  'eliteflat' => 'элитных квартир ', 
                  'apartment' => 'апартаментов ', 
                  'penthouse' => 'пентхаусов ', 
                  'townhouse' => 'таунхаусов ',
				  'bez-otdelki' => 'без отделки ', 
                  's-otdelkoj' => 'с отделкой ',
				  'yuzhnyy-okrug' => 'в ЮАО',
				  'centralnyy-okrug' => 'в ЦАО',
				  'severnyy-okrug' => 'в САО',
				  'severo-zapadnyy-okrug' => 'в СЗАО',
				  'zapadnyy-okrug' => 'в ЗАО'];
	
    public function get_currencies() {
        $xml = simplexml_load_file('https://www.cbr-xml-daily.ru/daily.xml');
        $currencies = array();
        foreach ($xml->xpath('//Valute') as $valute) {
            $currencies[(string)$valute->CharCode] = (float)str_replace(',', '.', $valute->Value);
        }

        return $currencies;
    }
    
    public function index(Request $request, $val1 = null, $val2 = null,  $val3 = null) {

        
        $valUrl = NULL;
        $request->flash();
		
		$types = collect(['eliteflat', 'apartment', 'penthouse', 'townhouse'])->toArray();
        $finishes = collect(['bez-otdelki', 's-otdelkoj'])->toArray();

		$currency_data = request()->input('currency', null);
		$price_from_data = request()->input('price_from', null);
		$price_to_data = request()->input('price_to', null);
		$area_from_data = request()->input('area_from', null);
		$area_to_data = request()->input('area_to', null);
		$perPage = request()->input('paginate', '20');
		$sort_data = request()->input('sort', 'id');
		$sort_type_data = request()->input('sort_type', 'asc');
		$district_data = NULL;

        $offers = Offer::with('subway', 'cat', 'propertys', 'images');

        if(!is_null($val1)){
			
			$subweys = Subway::all();
			
			$district = $subweys->pluck('slug_subway')
						->merge($subweys->pluck('slug_district'))
						->merge($subweys->pluck('slug_area'))->toArray();

            $offers = (new OffersSlugFilter($offers, $request->all(), $val1, $val2,  $val3))->apply()->paginate($perPage);

			$val = array_diff(array($val1, $val2, $val3), array(0, null));
            $type_data = current(array_intersect($val, $types));
			$finish_data = current(array_intersect($val, $finishes));
			$district_data = current(array_intersect($val, $district));
			
			if (strpos($district_data, 'metro') !== false) {
			   $district_data = 'у метро ' . Subway::where('slug_subway', $district_data)->first()->city_subway;
			}else if (strpos($district_data, 'rajon') !== false) {
			   $district_data = 'в районе ' . Subway::where('slug_district', $district_data)->first()->city_district;
			}else if (strpos($district_data, 'okrug') !== false) {
			   $district_data = self::SEO[$district_data];
			}

        }else{
			
			$offers = (new OffersFilter($offers, $request->all()))->apply()->paginate($perPage);
			
            $type_data = request()->input('type', null);
			$finish_data = request()->input('finish', null);
			
        }

		
		$title = 'Продажа ' . (!empty($type_data) ? self::SEO[$type_data] : 'элитной недвижимости ') . (!is_null($district_data) ? $district_data : '');
		
		SEO::setTitle($title);
		SEO::setCanonical(route('frontend.offers.index'));

        return view('frontend.offers.index', array(

                                'offers'=> $offers,
								'type_data' => $type_data,
            					'finish_data' => $finish_data,
								'currency_data' => $currency_data,
								'price_from_data' => $price_from_data,
								'price_to_data' => $price_to_data,
								'area_from_data' => $area_from_data,
								'area_to_data' => $area_to_data,
								'paginate_data' => $perPage,
								'sort_data' => $sort_data,
								'sort_type_data' => $sort_type_data,
								'title' => $title
                                ));

    }
	
	public function count(Request $request) {
		
		if ($request->ajax()) {
			
			$offers = Offer::with('subway', 'cat');

            $offers = (new OffersFilter($offers, $request->all()))->apply()->count();

            return $offers;
        }

    }
    
    public function ajax(Request $request) {
        
        $data = $request->except(['_token']);
            
        return redirect()->route('frontend.offers.count', $data);

    }
    
    public function filter(Request $request) {       
        
        $val1 = NULL;
        $val2 = NULL;
        $val3 = NULL;  
        $i = NULL;
        
        $offers = Offer::All();
        
        //определяем вводились ли значения
        if ((int)$request->price_from != 0 ||
            (int)$request->price_to != 10000000000 ||
            (int)$request->area_from != 0 ||
            (int)$request->area_to != 20000 ||
            $request->currency != 'RUB') {
            
                $i = 1;

        }

        if ($request->has('districts')) {
            
            if(count($request->districts)==1){
            
               $val1 =  implode(',',$request->districts);

            }else{
            //если в запросе присутствует более одного значения city_district устанавливаем метку, которую будем использовать в качестве проверки при выборе маршрута переадресации

                $i = 1;

            }
        }
        
        if ($request->has('type')) {
            if(isset($val1)){
                $val2 = $request->type;
            }else{
                $val1 = $request->type;
            }
        }
        if ($request->has('finish')) {
            if(isset($val2)){
                $val3 = $request->finish;
            }elseif(isset($val1)){
                $val2 = $request->finish;
            }else{
                $val1 = $request->finish;
            }
        }
        
        //если метка установлена переадресуем на страницу общего фильтра, если нет то на ЧПУ
        if ($i > 0) {
            
            $data = $request->except(['_token', 'ajax']);

            
            return redirect()->route('frontend.offers.index', $data);

        }else{
            
            return redirect()->route('frontend.offers.slugFilter', array(
            
                                    'val1'=> $val1,
                                    'val2'=> $val2,
                                    'val3'=> $val3,    

                                    ));
            
        }

    }
    
    
    public function show($slug) {
        
        $offer = Offer::where('slug', $slug)->first();
		
		if($offer->cat_id){
			
			$similar = $offer->cat->offers->except($offer->id)->take(12);
			
		}else{
						
			$similar = $offer->subway->offers->except($offer->id)->take(12);
		}
		
		$text = $offer->text;
		
		//разбиваем текст на две части
		if($offer->text){
			$text = $this->getIndexofFirstPart($text, $index = 300);
		}else{
			$text = null;
		}
		
        return view('frontend.offers.show', array(

                                'offer'=> $offer,
								'similar' => $similar,
								'text' => $text
            
                                ));
            

    }
	
	private function getText($text, $index) {
		
		$text = [ 0 => mb_substr($text, 0, $index),
				  1 => mb_substr($text, $index)
				];
		
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
    
    public function pdf($id) {
        
        $offer = Offer::find($id);
            
        $pdf = PDF::loadView('frontend.offers.pdf', ['offer' => $offer])
                ->setOptions(['dpi' => 96, 'defaultFont' => 'dejavu serif'])
                ->setPaper('a4', 'landscape');

        $fileName = $offer->name;

        return $pdf->stream($fileName . '.pdf');

    }
    
}

