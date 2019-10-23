<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapContent extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($this->images->where('tag', 'general')->first()){
            $image = 'img/' . $this->images->where('tag', 'general')->first()->url;
        }else{
            $image = NULL;
        }
        
        $data = [
                'object' => $this,
                'image' => $image
            ];
        
        if($this->id < 10000){

            return [
                'balloonContent' => view('frontend.map.tpl_cat', $data)->render()
            ];
            
        }else{
            
            return [
                'balloonContent' => view('frontend.map.tpl_offer', $data)->render()
            ];
            
        }
        
        
        
    }
}
