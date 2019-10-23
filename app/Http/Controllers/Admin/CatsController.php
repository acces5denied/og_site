<?php

namespace App\Http\Controllers\Admin;

use App\Cat;
use App\Offer;
use App\Subway;
use App\Image;
use App\Property;
use App\District;
use App\Rules\ValidAddress;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageInt;
//use Fomvasss\Dadata\Facades\DadataClean;


use App\Repositories\Ahunter;

class CatsController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:product-list');
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cats = Cat::with('subway')->paginate(50);
            $data = [
                'title' => 'Надобъекты',
                'cats' => $cats
            ];

            return view('backend.cats.index', $data);
    }

    public function create()
    {
        $catpropertys = Property::all()->where('type', 'cat')->pluck('name', 'id')->toArray();

        $data = [
            'title' => 'Новый объект',
            'catpropertys' => $catpropertys,

        ];
        return view('backend.cats.create',$data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'address' => 'required',
        ]);

        if($validator->fails()) {
            return   redirect()->route('cats.create')->withErrors($validator)->withInput();
        }
        
        $cat = Cat::create($input);
        
        //определяем по адресу метро, район и АО, если метро новое - запись+связь с категорией, иначе - связь
        if($request->input('address')):
            $response = (new Ahunter($request->address))->apply();
            if(isset($response)):
                $input['address'] = $response['address'];
                $cat->geo_lat = $response['geo_lat'];
                $cat->geo_lon = $response['geo_lon'];
                $subway = $response['subway'];
                if(!is_null($subway)):
                    $cat->subway()->associate($subway->id);
                    $cat->propertys()->attach(7, ['property_value' => $response['subway_dist']]);
                endif;
            endif;
        endif;
		
        //свойства 
        foreach ($input as $k=>$value){
            if(preg_match('/cat-prop-\d+/', $k)){
                preg_match('/\d+/', $k, $prop_id);
                if(!is_null($value)):
                    $cat->propertys()->attach($prop_id, ['property_value' => $value]);
                endif;
            }
        }
		
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
        
        //фото
        $dir = public_path('img/');
        if($request->file()):
            $files = $request->file();
            foreach($files as $tag => $array){
                foreach($array as $file){
                    $name = $cat->id .'-'. str_random(5) .'.' . $file->getClientOriginalExtension() ?: 'jpg';
                    $img = ImageInt::make($file);
                    $img->save($dir . $name);
                    $cat->images()->create(['tag' => $tag, 'url' => $name]);
                }
            }
        endif;
		
		$cat->fill($input);

        if ($cat->save()) {   
            return redirect()->route('cats.index')->with('status','Объект добавлен');
        }
    }

    public function edit(Cat $cat)
    {
        $images = $cat->images;
        $old = $cat->toArray();
        $old_propertys = $cat->propertys->pluck('pivot')->pluck('property_value', 'property_id')->toArray();
        $catpropertys = Property::all()->where('type', 'cat')->pluck('name', 'id')->toArray();
        
        if($cat->images){
            $images = $cat->images;
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
        }else{
            $preLoadImg = null;
        }

        $data = [
            'title' => 'Редактирование объекта - '.$old['name'],
            'data' => $old,
            'cat' => $cat,
            'images' => $images,
            'catpropertys' => $catpropertys,
            'old_propertys' => $old_propertys,
            'preLoadImg' => $preLoadImg,
        ];

        return view('backend.cats.edit',$data);
    }

    public function update(Request $request, Cat $cat)
    {
        $input = $request->except('_token');
        $offers = Offer::where('cat_id', $cat->id);
        
        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'address' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->route('cats.edit',['cat' => $input['id']])->withErrors($validator)->withInput();
        }
        
        //свойства Категории
        foreach ($input as $k=>$value){
            if(preg_match('/cat-prop-\d+/', $k)){
                preg_match('/\d+/', $k, $prop_id);
                $cat->propertys()->detach($prop_id);
                if(!is_null($value)):
                    $cat->propertys()->attach($prop_id, ['property_value' => $value]);
                endif;
            }
        }

        //определяем по адресу метро, район и АО, если метро новое - запись+связь с категорией, иначе - связь
        if($request->input('address')):
            $response = (new Ahunter($request->address))->apply();
            if(isset($response)):
                $input['address'] = $response['address'];
                $cat->geo_lat = $response['geo_lat'];
                $cat->geo_lon = $response['geo_lon'];
                $offers->update(['address' => $response['address']]);
                $offers->update(['geo_lat' => $response['geo_lat']]);
                $offers->update(['geo_lon' => $response['geo_lon']]);
                $subway = $response['subway'];
                $cat->subway()->dissociate();
                $cat->propertys()->detach(7);
                if(!is_null($subway)):
                    $cat->subway()->associate($subway->id);
                    $cat->propertys()->attach(7, ['property_value' => $response['subway_dist']]);
                    $offers->update(['subway_id' => $subway->id]);
                else:
                    $offers->update(['subway_id' => null]);
                endif;
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

        //работа с фото
        $dir = public_path('img/');
        
        $imgs = [];
        $general = json_decode($request->general_photo, true);
        array_push($imgs, $general);
        $other = json_decode($request->other_photo, true);
        array_push($imgs, $other);

        $imgsPreload = array_flatten($imgs);
        $imgsOrig = $cat->images->pluck('url', 'id')->toArray();
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
                    $name = $cat->id .'-'. str_random(5) .'.' . $file->getClientOriginalExtension() ?: 'jpg';
                    $img = ImageInt::make($file);
                    $img->save($dir . $name);
                    $cat->images()->create(['tag' => $tag, 'url' => $name]);
                }
            }
        endif;

        $cat->fill($input);
        
        if($cat->update()) {
            return redirect()->route('cats.index')->with('status', 'Информация обновлена');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cat $cat)
    {
        
        $images = $cat->images->pluck('url', 'id')->toArray();
        $dir = public_path('img/');
        foreach($images as $k => $img){
            
            File::delete($dir . $img);
            Image::find($k)->delete();
            
        }
        $cat->propertys()->detach();
        $cat->delete();
        return redirect()->route('cats.index')->with('status','Объект удален');
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
