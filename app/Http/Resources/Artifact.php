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
            'revision' => (int) $this->release->revision,
            'url' => $media->getFullUrl(),
            'meta' => [
                'size' => (int) $media->size,
                'checksums' => $media->getCustomProperty('checksums'),
            ],
        ];
    }
}
