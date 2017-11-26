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
            'builtAt' => $this->when($this->built_at, function () {
                return [
                    'datetime' => $this->built_at->toIso8601String(),
                    'timestamp' => $this->built_at->getTimestamp(),
                ];
            }),
            'links' => [
                'self' => route('api.v2.pack', $this),
                'gamepack' => route('gamepack.dl', $this),
            ],
        ];
    }

    public function with($request)
    {
        $media = $this->gamepack;
        $dt = $this->built_at;

        return [
            'meta' => [
                'checksums' => $media->getCustomProperty('checksums'),
            ],
        ];
    }
}
