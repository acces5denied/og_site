<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageInt;
use File;

class PostsController extends Controller
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
        $posts = Post::orderBy('updated_at','ASC')->paginate(20);
            $data = [
                'title' => 'Статьи',
                'posts' => $posts
            ];

            return view('backend.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Новая статья',
        ];

        return view('backend.posts.create',$data);
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
            'text' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()) {
            return   redirect()->route('posts.create')->withErrors($validator)->withInput();
        }
        
        
        $post = Post::create($input);
        
        if($request->file('image')):
            $dir = public_path('img/');
            $file = $request->file('image');
            $name = $post->id .'-post.' . $file->getClientOriginalExtension() ?: 'jpg';
            $img = ImageInt::make($file); 
            $img->save($dir . $name);
            $post->image = $name;
            $post->save();
        endif;
        
        if ($post->save()) {    
            return redirect()->route('posts.edit',['post'=>$post->id])->with('status','Статья добавлена');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $old = $post->toArray();
        
        //если файл записан в БД
        if($post->image){
            $dir = public_path('img/');
            
            if(file_exists($dir . $post->image)):
                $preLoadImg = [
                    "name" => $post->image,
                    "size" => filesize($dir . $post->image),
                    "file" => '/img/' . $post->image,
                    "data" => array(
                        "thumbnail" => '/img/' . $post->image,
                    ),
                ];
            endif;
            
            $preLoadImg = isset($preLoadImg) ? json_encode($preLoadImg) : null;

        }else{
            $preLoadImg = null;
        }

        $data = [
            'title' => 'Редактирование статьи - '.$old['name'],
            'preLoadImg' => $preLoadImg,
            'data' => $old,
        ];

        return view('backend.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'text' => 'required',
        ]);

        if($validator->fails()) {
            return   redirect()->route('posts.edit',['post'=>$post->id])->withErrors($validator)->withInput();
        }

        if($request->file('image')):
            $dir = public_path('img/');
            
            if($post->image):   
                File::delete($dir . $post->image);
            endif;
        
            $file = $request->file('image');
            $name = $post->id .'-post.' . $file->getClientOriginalExtension() ?: 'jpg';
            $img = ImageInt::make($file); 
            $img->save($dir . $name);
            $post->image = $name;
         endif;
        
         $post->fill($input);
        
        
        
        if ($post->save()) {    
            return redirect()->route('posts.edit',['post'=>$post->id])->with('status','Статья обновлена');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $dir = public_path('img/');
        File::delete($dir . $post->image);
        $post->delete();

        return redirect()->route('posts.index')->with('status','Статья удалена');
    }
}
