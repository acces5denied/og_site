<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\MapPointCollection;
use App\Http\Resources\MapContent;

use App\Offer;
use App\Cat;

use App\Repositories\MapOffersFilter;
use App\Repositories\MapCatsFilter;


class MapController extends Controller
{
    public function index(Request $request) {

        return view('frontend.map.index');
        
    }
    
    public function point(Request $request) {
        
        $offers = Offer::whereNull('cat_id');
        $offers = (new MapOffersFilter($offers, $request->all()))->apply()->get();
        
        $cats = Cat::with('offers');
        $cats = (new MapCatsFilter($cats, $request->all()))->apply()->get();
		
        $data = (new MapPointCollection($offers->merge($cats)));

        return $data;
    }
	
	public function ajax(Request $request) {
        
        $data = $request->except(['_token']);
            
        return redirect()->route('frontend.map.point', $data);

    }
    
    
    public function content(Request $request) {
        
        if($request->id < 10000){
            $data_id = Cat::find($request->id);
        }else{
            $data_id = Offer::find($request->id);
        }

        $data = (new MapContent($data_id));
        
        return $data;
    }
}
