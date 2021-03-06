<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\JavaArtifact;
use Carbon\Carbon;

class Release extends Resource
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
            'revision' => (int) $this->revision,
            'gamepack' => JavaArtifact::make($this->gamepack),
            'links' => [
                'self' => route('api.v2.pack', $this),
                'gamepack' => route('gamepack.dl', $this),
            ],
        ];
    }

    public function with($request)
    {
        $media = $this->gamepack;

        return [
            'meta' => [
                'checksums' => $media->getCustomProperty('checksums'),
            ],
        ];
    }
}
