<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Artifact extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'media' => $this->media->first(),
        ];
    }
}
