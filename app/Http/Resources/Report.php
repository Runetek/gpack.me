<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Support\Facades\Storage;

class Report extends Resource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->s3 = Storage::disk('reports');
    }

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
            'url' => $this->s3->url(
                sprintf('%d/%s.txt', $this->revision, $this->reportType->fqcn)
            ),
        ];
    }
}
