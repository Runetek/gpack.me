<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Pack extends Resource
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
            'revision' => $this['rev'],
            'url' => $this['url'],
        ];
    }
}
