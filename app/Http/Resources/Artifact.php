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
        $media = $this->getFirstMedia('gamepacks');

        return [
            'artifact_id' => $this->id,
            'revision' => (int) $this->release->revision,
            'size' => (int) $media->size,
            'links' => [
                'self' => route('api.v2.pack', $this->release),
                'gamepack' => route('gamepack.dl', $this->release),
            ],
        ];
    }

    public function with($request)
    {
        $media = $this->getFirstMedia('gamepacks');

        return [
            'meta' => [
                'checksums' => $media->getCustomProperty('checksums'),
            ],
        ];
    }
}
