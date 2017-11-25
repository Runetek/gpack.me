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
        $media = $this->media->first();

        return [
            'id' => $this->id,
            'size' => $media->size,
            'url' => $media->getFullUrl(),
            'checksums' => $media->getCustomProperty('checksums'),
        ];
    }
}
