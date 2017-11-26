<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class JavaArtifact extends Resource
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
            'name' => $this->name,
            // 'collection' => $this->collection_name,
            'size' => (int) $this->size,
        ];
    }
}
