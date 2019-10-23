<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Repositories\NewsFilter;
use SEO;

class NewsController extends Controller
{
	
     public function index(Request $request) {

        $request->flash();
		$perPage = request()->input('paginate', '20');
		$sort_data = request()->input('sort', 'id');
		$sort_type_data = request()->input('sort_type', 'asc');
    
        $news = Post::where('status', 'published');
		 
		$news_count = (new NewsFilter($news, $request->all()))->apply();
		
		$news = $news_count->paginate($perPage);
		 



        return view('frontend.news.index', array(

                                'news'=> $news,
								'paginate_data' => $perPage,
								'sort_data' => $sort_data,
								'sort_type_data' => $sort_type_data,
								'news_count'=> $news_count

                                ));
    }
	
	public function show($slug) {
        
        $news = Post::where('slug', $slug)->first();
		
		SEO::setTitle('Продажа элитной недвижимости в ' . $news->name);
        SEO::setDescription('Элитные жилищные комплексы в Москве');
		
		$similar = Post::all()->except($news->id)->take(12);

		
        return view('frontend.news.show', array(

                                'news'=> $news,
								'similar' => $similar,
            
                                ));
            

    }
	
	
	
}
