<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Cat;
use App\Offer;

class LandingController extends Controller
{
    
    
    public function index($lot) {
        
        $cat= Cat::with('offers')->find($lot);
        
        $data = [
            'cat' => $cat,
        ];

        return response()->json($data);
    }
}
