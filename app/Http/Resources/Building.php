<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Building extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'architects' => $this->architect_names,
            'title' => $this->title,
        ];
    }
}
