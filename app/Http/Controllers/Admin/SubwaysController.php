<?php

namespace App\Http\Controllers\Admin;

use App\Subway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\AdminOffersFilter;

class SubwaysController extends Controller
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
    public function index(Request $request)
    {
        $old_data = $request->flash();
        
        $subways = Subway::orderBy('city_subway','ASC');
        
        $city_district = $subways->pluck('city_district', 'city_district')->prepend('Не выбрано', '')->toArray();
        
        $subways = (new AdminOffersFilter($subways, $request->all()))->apply()->paginate(20);
        
        $data = [
            'title' => 'Инфраструктура',
            'subways' => $subways,
            'city_district' => $city_district,
            'old_data' => $old_data
        ];
        
        return view('backend.subways.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subway  $subway
     * @return \Illuminate\Http\Response
     */
    public function edit(Subway $subway)
    {
        $old = $subway->toArray();

        $data = [
            'title' => 'Редактирование - '.$old['city_subway'],
            'subway' => $subway,
            'data' => $old
        ];

        return view('backend.subways.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subway  $subway
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subway $subway)
    {
        $input = $request->except('_token');
        
        $subway->fill($input);
        if($subway->update()) {  
            return redirect()->route('subways.edit',['subway' => $input['id']])->with('status', 'Информация обновлена');
        }
    }

}
