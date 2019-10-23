<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageInt;
use File;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;


class UsersController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:role-list');
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id','ASC')->paginate(20);
        
        $data = [
            'title' => 'Пользователи',
            'users' => $users,
        ];
        
        return view('backend.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','id')->prepend('Не выбрано', '')->toArray();
        
        $data = [
            'title' => 'Новый пользователь',
            'roles' => $roles,
        ];
        
        return view('backend.users.create', $data);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        if($validator->fails()) {
            return   redirect()->route('users.create')->withErrors($validator)->withInput();
        }

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        
        if($request->file('photo')):
            $dir = public_path('img/');
            $file = $request->file('photo');
            $name = $user->id .'-user.' . $file->getClientOriginalExtension() ?: 'jpg';
            $img = ImageInt::make($file); 
            $img->save($dir . $name);
            $user->photo = $name;
            $user->save();
        endif;   
        
        if ($user->save()) {    
            return redirect()->route('users.edit', $user->id)->with('status','Пользователь добавлен');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $old = $user->toArray();
        
        //если файл записан в БД
        if($user->photo){
            $dir = public_path('img/');
            
            if(file_exists($dir . $user->photo)):
                $preLoadImg = [
                    "name" => $user->photo,
                    "size" => filesize($dir . $user->photo),
                    "file" => '/img/' . $user->photo,
                    "data" => array(
                        "thumbnail" => '/img/' . $user->photo,
                    ),
                ];
            endif;
            
            $preLoadImg = isset($preLoadImg) ? json_encode($preLoadImg) : null;

        }else{
            $preLoadImg = null;
        }

        $data = [
            'title' => 'Редактирование пользователя - '.$old['name'],
            'user' => $user,
            'userRole' => $userRole,
            'roles' => $roles,
            'preLoadImg' => $preLoadImg,
        ];

        return view('backend.users.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token');
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->route('users.edit', $id)->withErrors($validator)->withInput();
        }

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));
        
        //работа с фото
        $dir = public_path('img/');

        $general_photo = json_decode($request->general_photo, true);
        
        if(empty($general_photo) && $user->photo){

            File::delete($dir . $user->photo);
            $user->photo = null;
            $user->save();
            
        }
        
        if($request->file('photo')):
         
            if($user->photo):   
                File::delete($dir . $user->photo);
            endif;
        
            $file = $request->file('photo');
            $name = $user->id .'-user.' . $file->getClientOriginalExtension() ?: 'jpg';
            $img = ImageInt::make($file);
            $img->save($dir . $name);
            $user->photo = $name;
            $user->save();

        endif;  

        
        if ($user->update()) {    
            return redirect()->route('users.edit', $id)->with('status','Пользователь обнавлен');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $dir = public_path('img/');
        File::delete($dir . $user->photo);
        $user->delete();

        return redirect()->route('users.index')->with('status','Пользователь удален');

    }

}
