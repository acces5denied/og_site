<?php

namespace App\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Offer;
use App\Subway;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
		
		View::composer('frontend.menu', function($view) {
        
            $menu = [];
            $item = array('title'=>'Жилая недвижимость','url'=>route('frontend.offers.index'));
            array_push($menu, $item);
            $item = array('title'=>'Жилищные комплексы','url'=>route('frontend.cats.index'));
            array_push($menu, $item);
            $item = array('title'=>'Новости','url'=>route('frontend.news.index'));
            array_push($menu, $item);
            $item = array('title'=>'Контакты','url'=> '');
            array_push($menu, $item);

            
            $view->with(['menu' => $menu]);

        });
		
		View::composer('frontend.footer', function($view) {
        	
			$offers = Offer::with('subway')->join('subways as subway', 'subway.id', '=', 'offers.subway_id')->get();

            $view->with(['offers' => $offers]);

        });
		
		View::composer('frontend.district', function($view) {
        	
			$subweys = Subway::all();
			
			$district = $subweys->pluck('slug_subway')
						->merge($subweys->pluck('slug_district'))
						->merge($subweys->pluck('slug_area'))->toArray();

			
			$districts_val = request()->input('districts', null);


			if($districts_val){
				
				$district_data = array_intersect($districts_val, $district);
				
			}else if (request()->route()->getName() == 'frontend.offers.slugFilter'){
				
				$val = explode('/', request()->path());

				$district_data = array_intersect($val, $district);

			}else{
				
				$district_data = [];
				
			}


            $view->with(['subweys' => $subweys,
						 'district_data' => $district_data,
						]);

        });
		
		
    }
}
