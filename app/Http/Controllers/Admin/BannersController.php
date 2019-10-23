<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageInt;
use File;
use App\User;

class BannersController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list');
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('block','ASC')->paginate(20);
            $data = [
                'title' => 'Баннеры на главной',
                'banners' => $banners
            ];

            return view('backend.banners.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'title' => 'Новый баннер',
        ];

        return view('backend.banners.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'descript' => 'required|max:255',
            'link' => 'required|max:255',
            'image' => 'required',
        ]);

        if($validator->fails()) {
            return   redirect()->route('banners.create')->withErrors($validator)->withInput();
        }
        
        
        $banner = Banner::create($input);
        
        if($request->file('image')):
            $dir = public_path('img/');
            $file = $request->file('image');
            $name = $banner->id .'-banner.' . $file->getClientOriginalExtension() ?: 'jpg';
            $img = ImageInt::make($file); 
            $img->save($dir . $name);
            $banner->image = $name;
            $banner->save();
        endif;

        if ($banner->save()) {    
            return redirect()->route('banners.edit',['banner'=>$banner->id])->with('status','Баннер добавлен');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $old = $banner->toArray();
        
        //если файл записан в БД
        if($banner->image){
            $dir = public_path('img/');
            
            if(file_exists($dir . $banner->image)):
                $preLoadImg = [
                    "name" => $banner->image,
                    "size" => filesize($dir . $banner->image),
                    "file" => '/img/' . $banner->image,
                    "data" => array(
                        "thumbnail" => '/img/' . $banner->image,
                    ),
                ];
            endif;
            
            $preLoadImg = isset($preLoadImg) ? json_encode($preLoadImg) : null;

        }else{
            $preLoadImg = null;
        }

        $data = [
            'title' => 'Редактирование баннера - '.$old['name'],
            'preLoadImg' => $preLoadImg,
            'data' => $old,
        ];

        return view('backend.banners.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'descript' => 'required|max:255',
            'link' => 'required|max:255',
        ]);

        if($validator->fails()) {
            return   redirect()->route('banners.edit',['banner'=>$banner->id])->withErrors($validator)->withInput();
        }

        if($request->file('image')):
            $dir = public_path('img/');
            
            if($banner->image):   
                File::delete($dir . $banner->image);
            endif;
        
            $file = $request->file('image');
            $name = $banner->id .'-banner.' . $file->getClientOriginalExtension() ?: 'jpg';
            $img = ImageInt::make($file); 
            $img->save($dir . $name);
            $banner->image = $name;
         endif;
        
         $banner->fill($input);
        
        
        
        if ($banner->save()) {    
            return redirect()->route('banners.edit',['banner'=>$banner->id])->with('status','Баннер обновлен');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $dir = public_path('img/');
        File::delete($dir . $banner->image);
        $banner->delete();

        return redirect()->route('banners.index')->with('status','Баннер удален');
    }
}
