<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RouteGraphResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        foreach ($this->resource as $item) {
            $distanceItems = [];
            foreach ($item['distances'] as $distance) {
                $distanceItems[$distance['route']['name']] = $distance['distance'];
            }

            $data[$item['name']] = $distanceItems;
        }

        return $data;
    }
}
