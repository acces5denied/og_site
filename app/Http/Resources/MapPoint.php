<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapPoint extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
            [
                'type' => 'Feature',
                'id' => $this->id,
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [ $this->geo_lat,  $this->geo_lon]
                ],
                'properties' => [
                    'clusterCaption' =>  $this->name,
                    'type' => $this->type,
                    'finish' => $this->finish,
                ]
        ];
    }
}
