<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;

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
            'size' => (int) $this->size,
            'builtAt' => $this->when($this->getBuiltAt(), $this->getBuiltAt()),
            'numClasses' => $this->getCustomProperty('num_classes'),
        ];
    }

    private function getBuiltAt()
    {
        $pack = $this;
        if (!$pack->hasCustomProperty('built_at')) {
            return;
        }

        $dt = Carbon::createFromTimestamp($pack->getCustomProperty('built_at'));

        return [
            'datetime' => $dt->toIso8601String(),
            'timestamp' => $dt->getTimestamp(),
        ];
    }
}
