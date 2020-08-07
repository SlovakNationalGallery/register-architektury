<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Architect extends JsonResource
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
            'name' => $this->full_name,
        ];
    }
}
