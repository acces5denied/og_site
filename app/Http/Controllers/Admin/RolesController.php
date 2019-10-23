<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RolesController extends Controller
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
        $roles = Role::orderBy('id','ASC')->paginate(20);
        
        $data = [
            'title' => 'Роли',
            'roles' => $roles,
        ];
        
        return view('backend.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        
        $data = [
            'title' => 'Новая роль',
            'permission' => $permission,
        ];
        
        return view('backend.roles.create', $data);
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if($validator->fails()) {
            return   redirect()->route('roles.create')->withErrors($validator)->withInput();
        }


        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        if ($role->save()) {    
            return redirect()->route('roles.edit', $role->id)->with('status','Роль добавленна');
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
        
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        $old = $role->toArray();

        $data = [
            'title' => 'Редактирование роли - '.$old['name'],
            'permission' => $permission,
            'rolePermissions' => $rolePermissions,
            'role' => $role,
        ];

        return view('backend.roles.edit', $data);
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
            'permission' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->route('roles.edit', $id)->withErrors($validator)->withInput();
        }

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        
        if ($role->update()) {    
            return redirect()->route('roles.edit', $id)->with('status','Роль обнавлена');
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
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')->with('status','Роль удалена');
    }
}
