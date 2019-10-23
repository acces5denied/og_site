<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Cat;
use App\Subway;
use App\Image;
use App\Repositories\CatsFilter;
use SEO;

class CatsController extends Controller
{
    
    public function get_currencies() {
        $xml = simplexml_load_file('https://www.cbr-xml-daily.ru/daily.xml');
        $currencies = array();
        foreach ($xml->xpath('//Valute') as $valute) {
            $currencies[(string)$valute->CharCode] = (float)str_replace(',', '.', $valute->Value);
        }

        return $currencies;
    }

    public function index(Request $request) {

        $request->flash();

        $types = collect(['eliteflat', 'apartment', 'penthouse', 'townhouse'])->toArray();
        $finishes = collect(['bez-otdelki', 's-otdelkoj'])->toArray();
		$type_data = request()->input('type', null);
		$finish_data = request()->input('finish', null);
		$currency_data = request()->input('currency', null);
		$price_from_data = request()->input('price_from', null);
		$price_to_data = request()->input('price_to', null);
		$area_from_data = request()->input('area_from', null);
		$area_to_data = request()->input('area_to', null);
		$perPage = request()->input('paginate', '20');
		$sort_data = request()->input('sort', 'id');
		$sort_type_data = request()->input('sort_type', 'asc');
    
        $cats = Cat::with('subway', 'offers', 'propertys')->whereHas('offers');
		
		SEO::setTitle('Элитные жилищные комплексы в Москве');
        SEO::setDescription('Элитные жилищные комплексы в Москве');
        
        if ($request->ajax()) {

            $cats  = (new CatsFilter($cats, $request->all()))->apply()->count();

            return $cats ;
        }
		
        $cats = (new CatsFilter($cats, $request->all()))->apply()->paginate($perPage);

        return view('frontend.cats.index', array(

                                'cats'=> $cats,
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

                                ));


    }
    
    public function filter(Request $request) { 
        
        
        $data = $request->except(['_token', 'ajax']);
        
        return redirect()->route('frontend.cats.index', $data);

    }
	
	public function show($slug) {
        
        $cat = Cat::with('subway', 'offers', 'propertys', 'images')->where('slug', $slug)->first();
		
		SEO::setTitle('Продажа элитной недвижимости в ' . $cat->name);
		SEO::setCanonical(route('frontend.cats.index'));
		
		//берем категории того же района что у текущей и исключаем текущую
		$similar = Cat::All()->filter(function($item) use ($cat) { 

								return ($item->subway->slug_district == $cat->subway->slug_district && $item->id != $cat->id && $item->offers->count() != 0); 
												 
							})->take(12);
		
		$text = strip_tags($cat->text);
		
		//разбиваем текст на две части
		if($cat->text){
			$text = $this->getIndexofFirstPart($text, $index = 300);
		}else{
			$text = null;
		}
		
        return view('frontend.cats.show', array(

                                'cat'=> $cat,
								'text' => $text,
								'similar' => $similar,
            
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
    
    public function index1($alias) {
        
        if (!$alias) {
            abort(404);
        }
        
        $cat = Cat::where('alias', strip_tags($alias))->first();


        

            return view('frontend.cats.index', array(

                                    'cat'=> $cat,

                                    ));


    }
    
    
    

}
