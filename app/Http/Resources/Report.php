<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Report extends Resource
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
            'fqcn' => $this->reportType->fqcn,
        ];
    }
}
