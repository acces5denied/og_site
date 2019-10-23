<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Banner;
use App\Post;
use SEO;

class IndexController extends Controller
{
    public function index(Request $request) {
        
        $banners = Banner::all();

        $offers = Offer::with('images')->get()->sortByDesc('created_at');
		$news = Post::all()->take(12);

        return view('frontend.index.index', array(
                                'banners' => $banners,
                                'offers' => $offers,
								'news' => $news
                                ));

    }
    
    public function filter(Request $request) {

        $data = $request->except(['_token', 'ajax']);
            
        return redirect()->route('frontend.offers.filter', $data);

    }
}
