<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Cat;
use App\Repositories\AdminOffersFilter;

class XmlOffersController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list');
         $this->middleware('permission:product-edit', ['only' => ['update']]);
    }
	
	public function index(Request $request)
    {    
		$request->flash();
		
        $offers = Offer::withoutGlobalScopes()->with('cat');
		
		$cats = Cat::all()->pluck('name', 'id')->prepend('Не выбрано', '')->toArray();
        
        $offers = (new AdminOffersFilter($offers, $request->all()))->apply()->paginate(50);

        $data = [
            'title' => 'Выгрузка в Циан и Яндекс',
            'offers' => $offers,
            'cats' => $cats,
        ];

        return view('backend.xml.index', $data);
    }
	
	public function update(Request $request)
    {
		if($request->id){
			
			$offer = Offer::withoutGlobalScopes()->find($request->id);

			$input = $request->except('_token');

			$offer->fill($input);

			if($offer->update()) {  
				return redirect()->back()->with('status', 'Информация обновлена');
			}
		}elseif($request->offers_id){
			
			$input = $request->except('_token');
			
			$offers_id = explode(",", $request->offers_id);
			
			foreach($offers_id as $offer_id){
				
				$offer = Offer::withoutGlobalScopes()->find($offer_id);
				
				$offer->fill($input);
				
				$offer->save();
			}
			
			return redirect()->back()->with('status', 'Информация обновлена');
			
		}else{
			return redirect()->back()->with('status', 'Не выбрано ни одного предложения');
		}
    }

}
