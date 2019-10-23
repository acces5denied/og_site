<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\Cat;
use App\Subway;
use App\Image;
use App\Property;
use App\User;
use File;
//use App\Rules\ValidAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageInt;
//use Fomvasss\Dadata\Facades\DadataClean;

use App\Repositories\AdminOffersFilter;
use App\Repositories\Ahunter;

class OffersController extends Controller
{
	
	const NAME = ['apartment' => 'Апартаменты', 
                  'penthouse' => 'Пентхаус', 
                  'townhouse' => 'Таунхаус'];
    
    function __construct()
    {
         $this->middleware('permission:product-list');
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {    
		$request->flash();
        
        $offers = Offer::withoutGlobalScopes()->with('cat');

        $cats = Cat::all()->pluck('name', 'id')->prepend('Не выбрано', '')->toArray();
        
        $offers = (new AdminOffersFilter($offers, $request->all()))->apply()->paginate(50);

        $data = [
            'title' => 'Объекты',
            'offers' => $offers,
            'cats' => $cats,
        ];

        return view('backend.offers.index', $data);
    }


    public function create()
    {
        $cats = Cat::all()->pluck('name', 'id')->prepend('Не выбрано', '')->toArray();
        $catpropertys = Property::all()->where('type', 'cat')->pluck('name', 'id')->toArray();
        $offerpropertys = Property::all()->where('type', 'offer')->pluck('name', 'id')->toArray();

        $data = [
            'title' => 'Новый объект',
            'category' => $cats,
            'catpropertys' => $catpropertys,
            'offerpropertys' => $offerpropertys,
        ];

        return view('backend.offers.create',$data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'price' => 'required|integer',
            'area' => 'required|integer',
            'rooms' => 'required|integer',
			'type' => 'required',
			'finish' => 'required',
			'address' => 'required_without:cat_id',
        ]);

        if($validator->fails()) {
            return   redirect()->route('offers.create')->withErrors($validator)->withInput();
        }

        $offer = Offer::create($input);

        if($request->input('cat_id')):
            $offer->cat()->associate($request->cat_id);
            $offer->subway()->associate($offer->cat->subway);
            $input['address'] = $offer->cat->address;
            $offer->geo_lat = $offer->cat->geo_lat;
            $offer->geo_lon = $offer->cat->geo_lon;
            $input['material_type'] = $offer->cat->material_type;
            $input['parking'] = $offer->cat->parking;
        else:
            //определяем по адресу метро, район и АО, если метро новое - запись+связь с офером, иначе - связь
            if($request->input('address')):
                $response = (new Ahunter($request->address))->apply();
                if(isset($response)):
                    $input['address'] = $response['address'];
                    $offer->geo_lat = $response['geo_lat'];
                    $offer->geo_lon = $response['geo_lon'];
                    $subway = $response['subway'];
                    if(!is_null($subway)):
                        $offer->subway()->associate($subway->id);
                        $offer->propertys()->attach(7, ['property_value' => $response['subway_dist']]);
                    endif;
                endif;
            endif;
            //свойства Категории
            foreach ($input as $k=>$value){
                if(preg_match('/cat-prop-\d+/', $k)){
                    preg_match('/\d+/', $k, $prop_id);
                    if(!is_null($value)):
                        $offer->propertys()->attach($prop_id, ['property_value' => $value]);
                    endif;
                }
            }
        endif;
		
		//очищяем текст описания от тегов
		if($request->input('text')):
			$input['text'] = strip_tags($request->input('text'));
		endif;
		
		if($request->input('quote')):
			$input['quote'] = strip_tags($request->input('quote'));
		else:
			//если нет короткого описания, генерируем его из полного
			if($request->input('text')):
				$input['quote'] = $this->getIndexofFirstPart($input['text'], $index = 200);
			endif;
		endif;
		
		//генерируем название
		if(!$request->input('name')):
			if($input['type'] == 'eliteflat'):
				if($request->input('cat_id')):
					$input['name'] = $input['rooms'].'-комн. квартира, '.$input['area'].'м² в '.$offer->cat->name;
				else:
					$input['name'] = $input['rooms'].'-комн. квартира, '.$input['area'].'м²'. (!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			else:
				if($request->input('cat_id')):
					$input['name'] = self::NAME[$input['type']].', '.$input['area'].'м² в '.$offer->cat->name;
				else:
					$input['name'] = self::NAME[$input['type']].', '.$input['area'].'м²'.(!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			endif;
		endif;
        
        //свойства Offer
        foreach ($input as $k=>$value){
            if(preg_match('/offer-prop-\d+/', $k)){
                preg_match('/\d+/', $k, $prop_id);
                if(!is_null($value)):
                    $offer->propertys()->attach($prop_id, ['property_value' => $value]);
                endif;
            }
        }
        //фото
        $dir = public_path('img/');
        if($request->file()):
            $files = $request->file();
            foreach($files as $tag => $array){
                foreach($array as $file){
                    $name = $offer->id .'-'. str_random(5) .'.' . $file->getClientOriginalExtension() ?: 'jpg';
                    $img = ImageInt::make($file);
                    $img->save($dir . $name);
                    $offer->images()->create(['tag' => $tag, 'url' => $name]);
                }
            }
        endif;
        
        $offer->fill($input);
        $offer->user()->associate($user);

        if ($offer->save()) {    
            return redirect()->route('offers.index')->with('status','Объект добавлен');
        }
    }

    public function edit($offer)
    {
        $offer = Offer::withoutGlobalScopes()->find($offer);

        $user = auth()->user();

        if($user->hasRole('admin', 'manager') || $user->id === $offer->user_id){

            $old = $offer->toArray();
            
            if($offer->cat):
                $prop_cat = $offer->cat->propertys->pluck('pivot')->pluck('property_value', 'property_id')->toArray();
                $prop_offer = $offer->propertys->pluck('pivot')->pluck('property_value', 'property_id')->toArray();
                $old_propertys = $prop_cat + $prop_offer;
            else:
                $old_propertys = $offer->propertys->pluck('pivot')->pluck('property_value', 'property_id')->toArray();
            endif;
            
            $cats = Cat::all()->pluck('name', 'id')->prepend('Не выбрано', '')->toArray();
            $catpropertys = Property::all()->where('type', 'cat')->pluck('name', 'id')->toArray();
            $offerpropertys = Property::all()->where('type', 'offer')->pluck('name', 'id')->toArray();


            if($offer->images){
                $images = $offer->images;
                $dir = public_path('img/');

                foreach ($images as $image){ 

                    if(file_exists($dir . $image->url)):
                        //${$image->tag} - general, other, plan
                        ${$image->tag}[] = [
                            "name" => $image->url,
                            "size" => filesize($dir . $image->url),
                            "file" => $image->url,
                            "data" => array(
                                "thumbnail" => '/img/' . $image->url,
                            ),
                        ];
                    endif;
                }

                $preLoadImg = [];
                $general = isset($general) ? json_encode($general) : null;
                array_push($preLoadImg, $general);
                $other = isset($other) ? json_encode($other) : null;
                array_push($preLoadImg, $other);
                $plan = isset($plan) ? json_encode($plan) : null;
                array_push($preLoadImg, $plan);
            }else{
                $preLoadImg = null;
            }


            $data = [
                'title' => 'Редактирование объекта - '.$old['name'],
                'category' => $cats,
                'data' => $old,
                'offer' => $offer,
                'catpropertys' => $catpropertys,
                'offerpropertys' => $offerpropertys,
                'old_propertys' => $old_propertys,
                'preLoadImg' => $preLoadImg,
            ];


            return view('backend.offers.edit',$data);

        }else{
            return   redirect()->route('offers.index')->withErrors('У вас нет прав на редактирование этого объекта');
        }       

    }

    public function update(Request $request, $offer)
    {
        $offer = Offer::withoutGlobalScopes()->find($offer);
        
        $input = $request->except('_token');
        
        $validator = Validator::make($input, [
            'price' => 'required|integer',
            'area' => 'required|integer',
            'rooms' => 'required|integer',
			'type' => 'required',
			'finish' => 'required',
			'address' => 'required_without:cat_id',
        ]);

        if($validator->fails()) {
            return redirect()->route('offers.edit',['offer' => $input['id']])->withErrors($validator)->withInput();
        }

        if($request->input('cat_id')):
            //добавляем связь с Категорией
            $offer->cat()->associate($request->cat_id);
            //переопределяем связь с Метро связью из Категории
            $offer->subway()->associate($offer->cat->subway);
            //удаляем все свойства из offer о Категории
            $offer->propertys()->where('type', 'cat')->detach();
            $input['address'] = $offer->cat->address;
            $offer->geo_lat = $offer->cat->geo_lat;
            $offer->geo_lon = $offer->cat->geo_lon;
            $input['material_type'] = $offer->cat->material_type;
            $input['parking'] = $offer->cat->parking;
        else :
            //свойства Категории
            foreach ($input as $k=>$value){
                if(preg_match('/cat-prop-\d+/', $k)){
                    preg_match('/\d+/', $k, $prop_id);
                    $offer->propertys()->detach($prop_id);
                    if(!is_null($value)):
                        $offer->propertys()->attach($prop_id, ['property_value' => $value]);
                    endif;
                }
            }
            $offer->cat()->dissociate();
            //определяем по адресу метро, район и АО, если метро новое - запись+связь с офером, иначе - связь
            if($request->input('address')):
                $response = (new Ahunter($request->address))->apply();
                if(isset($response)):
                    $input['address'] = $response['address'];
                    $offer->geo_lat = $response['geo_lat'];
                    $offer->geo_lon = $response['geo_lon'];
                    $subway = $response['subway'];
                    $offer->subway()->dissociate();
                    $offer->propertys()->detach(7);
                    if(!is_null($subway)):
                        $offer->subway()->associate($subway->id);
                        $offer->propertys()->attach(7, ['property_value' => $response['subway_dist']]);
                    endif;
                endif;
            else:
                $offer->subway()->dissociate();
                $offer->propertys()->detach(7);
                $offer->geo_lat = NULL;
                $offer->geo_lon = NULL;
            endif;
        endif;
		
		//очищяем текст описания от тегов
		if($request->input('text')):
			$input['text'] = strip_tags($request->input('text'));
		endif;
		
		if($request->input('quote')):
			$input['quote'] = strip_tags($request->input('quote'));
		else:
			//если нет короткого описания, генерируем его из полного
			if($request->input('text')):
				$input['quote'] = $this->getIndexofFirstPart($input['text'], $index = 200);
			endif;
		endif;
		
		//генерируем название
		if(!$request->input('name')):
			if($input['type'] == 'eliteflat'):
				if($request->input('cat_id')):
					$input['name'] = $input['rooms'].'-комн. квартира, '.$input['area'].'м² в '.$offer->cat->name;
				else:
					$input['name'] = $input['rooms'].'-комн. квартира, '.$input['area'].'м²'. (!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			else:
				if($request->input('cat_id')):
					$input['name'] = self::NAME[$input['type']].', '.$input['area'].'м² в '.$offer->cat->name;
				else:
					$input['name'] = self::NAME[$input['type']].', '.$input['area'].'м²'.(!empty($subway->city_subway) ? ', м. '.$subway->city_subway : '');
				endif;
			endif;
		endif;
        
        //свойства Offer
        foreach ($input as $k=>$value){
            if(preg_match('/offer-prop-\d+/', $k)){
                preg_match('/\d+/', $k, $prop_id);
                $offer->propertys()->detach($prop_id);
                if(!is_null($value)):
                    $offer->propertys()->attach($prop_id, ['property_value' => $value]);
                endif;
            }
        }
        
        
        //работа с фото
        $dir = public_path('img/');
        
        $imgs = [];
        $general = json_decode($request->general_photo, true);
        array_push($imgs, $general);
        $other = json_decode($request->other_photo, true);
        array_push($imgs, $other);
        $plan = json_decode($request->plan_photo, true);
        array_push($imgs, $plan);

        $imgsPreload = array_flatten($imgs);
        $imgsOrig = $offer->images->pluck('url', 'id')->toArray();
        $imgsDell = array_diff($imgsOrig, $imgsPreload);
        //сравнивается входной массив изображений с исходным для удаления изображений
        foreach($imgsDell as $k => $img){
            
            File::delete($dir . $img);
            Image::find($k)->delete();
            
        }

        if($request->file()):
            $files = $request->file();
            foreach($files as $tag => $array){
                foreach($array as $file){
                    $name = $offer->id .'-'. str_random(5) .'.' . $file->getClientOriginalExtension() ?: 'jpg';
                    $img = ImageInt::make($file);
                    $img->save($dir . $name);
                    $offer->images()->create(['tag' => $tag, 'url' => $name]);
                }
            }
        endif;

        $offer->fill($input);
        
        if($offer->update()) {  
            return redirect()->route('offers.index')->with('status', 'Информация обновлена');
        }
    }

    public function destroy(Offer $offer)
    {
        $images = $offer->images->pluck('url', 'id')->toArray();
        $dir = public_path('img/');
        foreach($images as $k => $img){
            
            File::delete($dir . $img);
            Image::find($k)->delete();
            
        }
        $offer->propertys()->detach();
        $offer->delete();
        return redirect()->route('offers.index')->with('status','Объект удален');
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
