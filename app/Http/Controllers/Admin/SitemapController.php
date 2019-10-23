<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Offer;
use App\Cat;
use App\Post;
use App\Subway;

class SitemapController extends Controller
{
    public function index()
    {
      $offers = Offer::all()->first();
      $posts = Post::all()->first();

      return response()->view('backend.sitemap.index', [
          'offers' => $offers,
          'posts' => $posts,
      ])->header('Content-Type', 'text/xml');
    }
    
    public function offers()
    {
        $offers = Offer::latest()->get();
        return response()->view('backend.sitemap.offers', [
            'offers' => $offers,
        ])->header('Content-Type', 'text/xml');
    }
    
    public function cats()
    {
        $cats = Cat::whereHas('offers')->get();
        return response()->view('backend.sitemap.cats', [
            'cats' => $cats,
        ])->header('Content-Type', 'text/xml');
    }
    
    public function posts()
    {
        $posts = Post::latest()->get();
        return response()->view('backend.sitemap.posts', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }
	
	public function other()
    {
		$offers = Offer::with('subway')->join('subways as subway', 'subway.id', '=', 'offers.subway_id')->get();
		
        return response()->view('backend.sitemap.other', [
            'offers' => $offers,
        ])->header('Content-Type', 'text/xml');
    }

    
}
